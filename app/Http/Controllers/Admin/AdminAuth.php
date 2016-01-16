<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class AdminAuth extends BaseController
{

	public function index()
	{

	}

	public function login()
	{
		//If user is not logged in
		if ($this->user == FALSE)
		{
			$customCSS = [
				'admin/pages/css/login',
			];
			$customJS  = [
				'global/plugins/jquery-validation/js/jquery.validate.min',
				'admin/pages/scripts/login',
			];

			$data = [
				'blade_hide_header'  => TRUE,
				'blade_hide_sidebar' => TRUE,
				'blade_hide_footer'  => TRUE,
				'blade_standalone'   => TRUE,
				'blade_custom_css'   => $customCSS,
				'blade_custom_js'    => $customJS,
			];

			return Theme::view('auth.login', $data);
		} else {
		//If user is logged in - make redirect
			return Redirect::to('/admin')->send();
		}
	}

	public function loginRequest()
	{
		$response['status'] = 'error';
		$response['title'] = trans('users.check_login_details');
		$response['message'] = trans('users.auth_not_successful');

		if ( ! empty($_POST) && ! empty($_POST['email']) && ! empty($_POST['password']))
		{
			//User data and Authentication
			$credentials = [
				'email'    => Input::get('email'),
				'password' => Input::get('password'),
			];

			$user = Sentinel::authenticate($credentials);

			//If Authentication was successful
			if(!empty($user)) {
				//Login and remember
				if ( ! empty($_POST['remember']))
				{
					Sentinel::login($user);
				}
				else
				{
				//Login without remember
					Sentinel::loginAndRemember($user);
				}

				$response['status'] = 'success';
				$response['title'] = trans('global.redirecting') . '...';
				$response['message'] = trans('users.auth_successful');
			}
		}

		echo json_encode($response);
	}

	public function logout() {
		Sentinel::logout();
		return Redirect::to('/admin')->send();
	}
}
