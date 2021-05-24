<?php

namespace App\Http\Controllers;

use App\Mail\InviteManager;
use App\Models\Company;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ManagerController extends Controller
{
    public function show()
    {
        $id = '0x03Rcd5gluv8lVQoxgp6pfJS1qbevtWRJYJYtP0qm';
        return Manager::with('company.company')->findOrFail($id);
    }
    public function changeRole(Request $request,$user_id){
        $manager= Manager::findOrFail($user_id);
        $manager->role = $request->input('role');
        $manager->save();
        return $manager;
    }

    public function inviteManager(Request $request,$id){
        $company= Company::findOrFail($id);
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
