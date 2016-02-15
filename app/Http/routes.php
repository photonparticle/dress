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
		Route::controller('/categories', 'Module_Categories');
		Route::controller('/products', 'Module_Products');
        Route::controller('/orders', 'Module_Orders');
		Route::controller('/pages', 'Module_Pages');

		//Modules routes
		Route::controller('/modules', 'Modules');
		Route::controller('/module/sizes', 'Module_Sizes');
		Route::controller('/module/manufacturers', 'Module_Manufacturers');
		Route::controller('/module/colors', 'Module_Colors');
		Route::controller('/module/materials', 'Module_Materials');
        Route::controller('/module/tags', 'Module_Tags');
        Route::controller('/module/tables', 'Module_Tables');
        Route::controller('/module/sliders', 'Module_Sliders');
	}
);

//Image upload
Route::post('upload', ['as' => 'upload-post', 'uses' =>'ImageController@postUpload']);