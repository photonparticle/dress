<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function ()
{
	return view('welcome');
});

Route::group(
	[
		'namespace' => 'Admin',
		'prefix'    => 'admin',
	],
	function ()
	{
		//Routes
		Route::get('/', 'Admin@index');
		Route::get('/auth/login', 'AdminAuth@login');
		Route::get('/auth/logout', 'AdminAuth@logout');
		Route::get('/auth/loginRequest', 'AdminAuth@loginRequest');
		Route::post('/auth/loginRequest', 'AdminAuth@loginRequest');


		Route::controller('/users', 'Module_Users');
		Route::resource('/categories', 'Module_Categories');
		//Resources
//		Route::resource('/users', 'Module_Users');
	}
);