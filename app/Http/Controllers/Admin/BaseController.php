<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Users;
use DebugBar\DebugBar;
use View;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Redirect;

class BaseController extends Controller
{
	protected $request;
	protected $user = FALSE;

	protected $routes = [
		'/admin/auth/login',
		'/admin/auth/loginRequest',
	];

	protected $log;

	/**
	 * BaseController constructor.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		//Get current request
		$this->request = $request;

		//Set active theme
		Theme::setActive('administration');

		//Check user is logged in
		if (Sentinel::guest())
		{
			if ( ! in_array($request->getPathInfo(), $this->routes))
			{
				return Redirect::to('/admin/auth/login')->send();
			}
		}
		else
		{
			$this->user = Sentinel::getUser();
			$this->globalViewData();
		}
	}

	/**
	 * Dumps any variable
	 *
	 * @param $param - mixed
	 */
	public function d($param)
	{
		print '<pre>';
		print_r($param);
	}

	/**
	 * Dumps any variable and exit
	 *
	 * @param $param - mixed
	 */
	public function dd($param)
	{
		$this->d($param);
		exit;
	}

	/**
	 * Dumps the last executed query
	 */
	public function dsql()
	{
//		$this->d(Database::instance()->last_query);
	}

	public function redirectTo($url) {
		if(!empty($url)) {
			return Redirect::to($url)->send();
		}
	}

	private function globalViewData() {
		$user_data = Model_Users::getUserFullInfo($this->user->id);

		//Do not pass sensitive data to view
		$remove = ['password', 'remember_token', 'updated_at'];

		foreach ($remove as $key => $object)
		{
			unset($user_data[$key]);
		}

		View::share('current_user', $user_data);
	}
}
