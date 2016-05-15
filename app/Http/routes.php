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
		Route::controller('/reports', 'Module_Reports');
		Route::controller('/system/settings', 'Module_System_Settings');

		//Modules routes
		Route::controller('/modules', 'Modules');
		Route::controller('/module/sizes', 'Module_Sizes');
		Route::controller('/module/manufacturers', 'Module_Manufacturers');
		Route::controller('/module/colors', 'Module_Colors');
		Route::controller('/module/materials', 'Module_Materials');
        Route::controller('/module/tags', 'Module_Tags');
        Route::controller('/module/tables', 'Module_Tables');
        Route::controller('/module/sliders', 'Module_Sliders');
        Route::controller('/module/carousels', 'Module_Carousels');
        Route::controller('/module/upcoming-product', 'Module_UpcomingProduct');
	}
);

Route::group(
	[
		'namespace' => 'API',
		'prefix'    => 'api',
	],
	function ()
	{
		Route::get('/get_categories', 'API@getCategories');
	}
);

//Image upload
Route::post('upload', ['as' => 'upload-post', 'uses' =>'ImageController@postUpload']);


//Client routes
Route::get('/', 'Homepage@homepage');
Route::get('/404', 'Homepage@notFound');
Route::get('/contact', 'Homepage@contact');
Route::post('/contact', 'Homepage@doContact');
Route::get('/sitemap', 'Homepage@sitemap');
Route::get('/login', 'Homepage@login');
Route::post('/login', 'Homepage@doLogin');
Route::get('/logout', 'Homepage@logout');
Route::get('/register', 'Homepage@register');
Route::post('/register', 'Homepage@doRegister');
Route::get('/my-profile', 'Homepage@account');
Route::post('/my-profile/{id}/{action}', 'Homepage@updateAccount');
Route::get('/my-orders', 'Homepage@orders');
Route::get('/search/ajax', 'Homepage@searchAjax');
Route::get('/search/{needable}', 'Homepage@search');
Route::get('/search/{needable}/{tag}', 'Homepage@search');

Route::get('/cart', 'Cart@cart');
Route::get('/cart/added/{id}', 'Cart@added');
Route::get('/cart/drop', 'Cart@drop');
Route::post('/cart/add', 'Cart@add');
Route::post('/cart/update', 'Cart@update');
Route::post('/cart/delivery_type', 'Cart@changeDeliveryType');
Route::post('/cart/remove', 'Cart@remove');

Route::get('/checkout', 'Checkout@checkout');
Route::post('/checkout/create', 'Checkout@postStore');
Route::get('/checkout/completed', 'Checkout@checkoutCompleted');
Route::get('/checkout/completed/{id}', 'Checkout@checkoutCompleted');

Route::get('/{slug}', 'Client@route');
Route::post('/{slug}', 'Client@route');
Route::get('/{slug}/{page}', 'Client@route');