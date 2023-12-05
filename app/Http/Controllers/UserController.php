<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function getAllUsers(){
        $users=User::all();

        return ['users'=>$users];
    }
    public function getUser(User $user){
        $user=User::where('id',$user->id)->first();

        return ['user'=>$user];
    }
    public function login(Request $resquest){
         
        $email = $resquest->email;
        $password = $resquest->password;
    	$user = User::where(['email'=>$email])->first();
        if($user){
           if(Hash::check($password, $user->password)){
            $user->makeHidden(['password']);
            $responce =$user ;
           }else{
            $responce = ['Error'=>'Wrong Password!'];
           }
          
        }else{
          $responce = ['Error'=>'No user Exist!']; 
        }
        

        return $responce;
    }
    public function createUser(Request $resquest){
        
        $data = $resquest->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'password'=>'required|string',
            'age'=>'required',
            'email'=>'required|email:rfc,dns',
            'avatar'=>'nullable',
            'gender'=>'required',
        ]);

        $res =User::create([
            'first_name'=>$data['first_name'],
            'last_name'=>$data['last_name'],
            'password'=>Hash::make($data['password']),
            'age'=>$data['age'],
            'email'=>$data['email'],
            'avatar'=>$data['avatar'],
            'gender'=>$data['gender'],
        ]);

        // Hide the password attribute from the JSON response
        $res->makeHidden(['password']);
        return response()->json($res);
    }
    public function updateUser(User $user,Request $resquest){
        
        $data = $resquest->validate([
            'first_name'=>'string',
            'last_name'=>'string',
            'password'=>'string',
            'age'=>'integer',
            'avatar'=>'nullabe|string',
            'gender'=>'boolean',
        ]);
        $user->update($data);


        return ['updated'=>'true'];
    }
    public function deleteUser(User $user){
        $user->delete();

        return 'User deleted';
    }
}
