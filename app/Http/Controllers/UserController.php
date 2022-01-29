<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request,User $user)
    {
        if ( $this->validateForm($request)) {
            if ($result=$user->add($request)) {
               return response()->json(['message'=>'Success','status'=>200,['user'=>['name'=>$result->name,'email'=>$result->email]]]);
            }return response()->json(['message'=>'error','status'=>500]);
        }
    
    }

    public function validateForm($request)
    {
        return $request->validate([
            'name'=>['required'],
            'email'=>['required'],
            'password'=>['required'],
            'phone_number'=>['required']
        ]);
    }
}
