<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use App\Mail\InviteManager;
use App\Models\Company;
use Illuminate\Support\Facades\Mail;


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
        return  Auth::user();

    }


    public function changeRole(Request $request,$user_id){
       $manager= Manager::findOrFail($user_id);
         $manager->role = $request->input('role');
         $manager->save();
         return $manager;
     }
 
    public function inviteManager(Request $request){
        $company= Company::findOrFail(Auth::user()->company_id);
        $role = $request->input('manager_role');
        $email = $request->input('manager_email');
        $company = $company->makeVisible(['alpha_code', 'beta_code']);
        $code = '';
        if($role == 'sysalpha')  $code = $company->alpha_code;
        if($role == 'sysbeta')  $code = $company->beta_code;
        $url = url('/companies/'.$company->id.'?email='.$email.',code='.$code);
        $details = [
            'user' => 'inas hasnaoui',
            'role' => $role,
            'company' => $company->name,
            'url'=>$url
        ];
        Mail::to($email)->send(new inviteManager($details));
        return true;
    }

}
