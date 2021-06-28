<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use App\Mail\InviteManager;
use App\Models\Company;
use App\Models\CompanyManager;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ManagerController extends Controller
{
     public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json([
            'token'=>$this->respondWithToken($token),
            'manager'=> Auth::user()->load('company')
        ]);
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
    public function register(Request $request)
    {
        $manager = new Manager();
        $manager->email = $request->input('email');
        $manager->password = bcrypt($request->input('password'));
        $manager->save();
        $token = auth()->attempt(['email'=>$manager->email,'password'=>$request->input('password')]);
        return $this->respondWithToken($token);
    }
    public function me(){
        return  Auth::user()->load('company');

    }
    public function edit(Request $request)
    {
        $manager = Manager::findOrFail(Auth::user()->id);
        if($request->input('first_name'))$manager->first_name = $request->input('first_name');
        if($request->input('last_name'))$manager->last_name = $request->input('first_name');
        if($request->input('email'))$manager->email = $request->input('email');
        $manager->save();
        return $manager;
    }


    public function changeRole(Request $request,$user_id){
       $manager= Manager::findOrFail($user_id);
         $manager->role = $request->input('role');
         $manager->save();
         return $manager;
     }
 
    public function inviteManager(Request $request){
        $company_id = Auth::user()->company_id;
        $company= Company::findOrFail($company_id);
        $role = $request->input('manager_role');
        $email = $request->input('manager_email');
        $password = substr(strtoupper(Str::random(12)),0,-1);
        $manager = new Manager();
        $manager->username = 'Manager-'.substr(strtoupper(Str::random(4)),0,-1);
        $manager->email = $email;
        $manager->public_address = "";
        $manager->role = $role;
        $manager->password = bcrypt($password);
        $manager->save();
        $details = [
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'company' => $company->name,
        ];
        $cm = new CompanyManager();
        $cm->company_id = $company_id;
        $cm->manager_id = $manager->id;
        $cm->save();
        Mail::to($email)->send(new inviteManager($details));
        return $manager;
    }

}
