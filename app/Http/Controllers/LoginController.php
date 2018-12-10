<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTFactory;
use JWTAuth;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
			$response['code'] = 400;
			$response['status'] = 'Error';
			$response['description'] = 'Validation error';
			$response['produces'] = 'application/json';
			$response['errors'] = $validator->errors();			
            return response()->json(compact('response'));
        }
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
		
		$response['code'] = 200;
		$response['status'] = 'Success';
		$response['description'] = 'User login successfully';
		$response['produces'] = 'application/json';
		$response['user_token'] = $token; 
		return Response()->json(compact('response'));
    }
}
