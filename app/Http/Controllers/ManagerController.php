<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function show()
    {
        $id = '0x03Rcd5gluv8lVQoxgp6pfJS1qbevtWRJYJYtP0qm';
        return Manager::with('company.company')->findOrFail($id);
    }
    public function changeRole(Request $request,$id,$user_id){
       $manager= Manager::findOrFail($user_id);
        $manager->role = $request->input('role');
        $manager->save();
        return $manager;
    }

}
