<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;

class AuthController extends BaseController
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return $this->sendError('Error Validation', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User created Successfully');
    }
    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $authUser = Auth::user();
            $success['token'] = $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['name'] = $authUser->name;

            return $this->sendResponse($success, 'User Login Successfully!');
        }
        else{
            return $this->sendError('Unauthorized', ['error' => 'Email and password Doesnot match']);
        }
    }
    public function ram(Request $request){
        return $this->sendResponse('ram', 'ram');
    }
}
