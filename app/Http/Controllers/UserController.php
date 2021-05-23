<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
     public function index()
    {
        return User::orderBy('score','desc')->paginate(10);
    }

    public function show($user_id)
    {
        return User::findOrFail($user_id);
    }

    public function store(Request $request)
    {
        $user = new User();
        if($request->input('public_address')) $user->public_address = $request->input('public_address');
      if($request->input('username')) $user->username = $request->input('username');
      if($request->input('email')) $user->email = $request->input('email');
      if($request->input('country')) $user->country = $request->input('country');
        if($request->file('avatar')) $user->avatar = $request->file('avatar')->storeAs('users', $request->avatar->getClientOriginalName(), 'public');
     
        $user->save();
        return $user;
    }

    public function update(Request $request,$user_id)
    {
        $user = User::findOrFail($user_id);
           if($request->input('public_address')) $user->public_address = $request->input('public_address');
      if($request->input('username')) $user->username = $request->input('username');
      if($request->input('email')) $user->email = $request->input('email');
      if($request->input('country')) $user->country = $request->input('country');
        if($request->file('avatar')) $user->avatar = $request->file('avatar')->storeAs('users', $request->avatar->getClientOriginalName(), 'public');
     
        $user->save();
        return $user;
    }
    public function destroy($user_id)
    {
        $user = User::findOrfail($user_id);
        if($user->delete()) return  true;
        return "Error while deleting";
    }
    public function ban($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->state = !$user->state;
        $user->save();
        return $user;
    }
}
