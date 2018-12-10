<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use App\Mail\SendMailable;
use App\FileUploader\FileUploader;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required',
			'mobileno'=> 'required'
        ]);
        if ($validator->fails()) {
			$response['code'] = 400;
			$response['status'] = 'Failure';
			$response['error'] = 'Validation error';
			$response['produces'] = 'application/json';
			$response['errors'] = $validator->errors();			
            return response()->json(compact('response'));
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
			'mobileno' => $request->get('mobileno'),
            'password' => bcrypt($request->get('password')),
        ]);
		$token = JWTAuth::fromUser($user);
		Mail::to($request->get('email'))->send(new SendMailable(url('localhost:8000/login/'.$token)));
		$response['code'] = 200;
		$response['status'] = 'Success';
		$response['description'] = 'User registered successfully';
		$response['produces'] = 'application/json';
		$response['mail'] = 'Email sent successfully';
		$response['user'] = $user; 
		return Response()->json(compact('response'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password'=> 'required',
			'mobileno'=> 'required',
			'email' => 'required|string|email|max:255',
        ]);
        if ($validator->fails()) {
			$response['status'] = 'ok';
			$response['message'] = 'failure';
			$response['error'] = 'Validation error';
			$response['produces'] = 'application/json';
			$response['errors'] = $validator->errors();			
            return response()->json(compact('response'));
        }
		$user_update = User::where('email',$request->get('email'))->update(['name'=>$request->get('name'),'mobileno'=>$request->get('mobileno'),'password'=>$request->get('password')]);
		$user = User::where('email',$request->get('email'))->get();
		$response['code'] = 200;
		$response['status'] = 'Success';
		$response['description'] = 'User updated successfully';
		$response['produces'] = 'application/json';
		$response['user'] = $user; 
		return Response()->json(compact('response'));
    }
	
    public function imageupload(Request $request)
    {
        $path = FileUploader::make($request->file)->upload();		
        return Response::json(compact('token','path'));
    }

    public function profileimg(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'image' => 'mimes:jpeg,bmp,png',
			'email' => 'required|string|email|max:255',
        ]);		
        if ($validator->fails()) {
			$response['status'] = 'ok';
			$response['message'] = 'failure';
			$response['error'] = 'Validation error';
			$response['produces'] = 'application/json';
			$response['errors'] = $validator->errors();			
            return response()->json(compact('response'));
        }		
		$val = $request->all();
		$file = $request->file('image');
		$new = $file->move('uploads', $file->getClientOriginalName());
		
		$user_update = User::where('email',$request->get('email'))->update(['image'=>$request->get('image'),'image_name'=>$file->getClientOriginalName()]);
		$user = User::where('email',$request->get('email'))->get();
		$response['code'] = 200;
		$response['status'] = 'Success';
		$response['description'] = 'User profile picture updated successfully';
		$response['produces'] = 'application/json';
		$response['user'] = $user; 
		return Response()->json(compact('response'));
    }	
}
