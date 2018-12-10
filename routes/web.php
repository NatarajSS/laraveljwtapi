<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('register','RegisterController@register');
Route::post('login', 'LoginController@login');
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('users', function(Request $request) {
		$response['code'] = 200;
		$response['status'] = 'Success';
		$response['description'] = 'User List';
		$response['produces'] = 'application/json';
		$response['user'] = App\User::all(); 		
		return response()->json(compact('response'));
	});
	Route::post('update', 'RegisterController@update');
	Route::post('avatar', 'RegisterController@imageupload');
	Route::post('profilepic', 'RegisterController@profileimg');
});