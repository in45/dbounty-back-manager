<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
     public function index()
    {
        return Admin::paginate(10);
    }

    public function show($user_id)
    {
        return Admin::findOrFail($user_id);
    }

    public function store(Request $request)
    {
      $admin = new Admin();
      $admin->email = $request->input('email');
      $admin->password = bcrypt($request->input('password'));
      if($request->input('public_address')) $admin->public_address = $request->input('public_address');
      if($request->input('username')) $admin->username = $request->input('username');
      if($request->input('role')) $admin->role = $request->input('role');
      $admin->save();
      $token = auth()->attempt(['email'=>$admin->email,'password'=>$request->input('password')]);
        return response()->json([
            'token'=>$this->respondWithToken($token),
            'admin'=> $admin
        ]);
    }

    public function update(Request $request,$user_id)
    {
        $admin = Admin::findOrFail($user_id);
      if($request->input('public_address')) $admin->public_address = $request->input('public_address');
      if($request->input('username')) $admin->username = $request->input('username');
      if($request->input('email')) $admin->email = $request->input('email');
      if($request->input('role')) $admin->role = $request->input('role');
        $admin->save();
        return $admin;
    }
    public function destroy($user_id)
    {
        $admin = Admin::findOrfail($user_id);
        if($admin->delete()) return  true;
        return "Error while deleting";
    }
}
