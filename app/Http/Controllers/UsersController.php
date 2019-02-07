<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
class UsersController extends Controller
{
    public function store(Request $request){
        if ($request->has('name') && $request->has('lastname') && $request->has('address') && $request->has('email') && $request->has('password')) {
            $user = User::create([
            'name' => $request['name'],
            'lastname' => $request['lastname'],
            'address' => $request['address'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            ]);
            $ret = "The new user ID is ".$user->id;
            return response()->json($ret, 201);
        }
       return "Does not meet the parameters";
    }

    public function update(Request $request, $id)
    {
    	$user = User::findOrFail($id);
        if ($user != NULL) {
            $user->update([
            'address' => $request['address'],
            'password' => Hash::make($request['password'])
             ]);

            $ret = "1# Update successful from ".$id." ";
            return response()->json($ret, 200);
        }else{
            $ret = "0# Update fail from ".$id." ";
            return $ret;
        }
    	
    }
}

