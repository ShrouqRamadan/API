<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class Authcontroller extends Controller
{
    public function register(Request $request){
$data=   $request->validate([
    'name'=>'required|string',
    "email"=>"required|string|unique:users,email",
    "password"=>"required|string|confirmed",


]);
$user=User::create([
    'name' => $data['name'],
    'email' => $data['email'],
    'password' => bcrypt($data['password'])
]);
$token =$user->createToken('myToken')->plainTextToken;
 $response=[
     'user'=>$user,
     'token'=>$token

 ];
  return response($response , 201);

}
public function login(Request $request){
    $data=   $request->validate([

        "email"=>"required|string",
        "password"=>"required|string",


    ]);
  $user=User::where('email',$data['email'])->first();
  if(!$user|| !Hash::check($data['password'], $user->password)){
      return [
          "message"=>"try again"
      ];
  }
    $token =$user->createToken('myToken')->plainTextToken;
     $response=[
         'user'=>$user,
         'token'=>$token

     ];
      return response($response , 201);

    }
public function logout(Request $request){
auth()->user()->tokens()->delete();
return['message'=>"logged out"];
}
}
