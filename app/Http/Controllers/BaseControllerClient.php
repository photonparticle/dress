<?php

namespace App\Http\Controllers;

use App\Client\Model_API;
use App\Client\Model_Client;
use App\Client\Model_Main;
use DebugBar\DebugBar;
use View;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Redirect;

class BaseControllerClient extends Controller
{
	protected $request;
	protected $user = FALSE;
	public $cart = [];

	protected $routes = [
		'/admin/auth/login',
		'/admin/auth/loginRequest',
	];

	protected $categories = [];

	protected $log;
	public $system;

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
		Theme::setActive('dressplace');

		//Check user is logged in
		if (Sentinel::guest())
		{
			if ( ! in_array($request->getPathInfo(), $this->routes))
			{
//				return Redirect::to('/admin/auth/login')->send();
			}
		}
		else
		{
			$this->user = Sentinel::getUser();
//			$this->globalViewData();
		}

		//Init system
		$this->systemInit();

		//Load navigation
		$this->getCategories();
	}

	private function getActiveUser()
	{
		$user_data = Model_Users::getUserFullInfo($this->user->id);

		//Do not pass sensitive data to view
		$remove = ['password', 'remember_token', 'updated_at'];

		foreach ($remove as $key => $object)
		{
			if ( ! empty($user_data[$key]))
			{
				unset($user_data[$key]);
			}
		}

		View::share('current_user', $user_data);
	}

	private function getCategories()
	{
		if (($categories = Model_Main::getCategory(FALSE, ['title'])))
		{
			$categories_ids          = [];
			$main_categories         = [];
			$second_level_categories = [];
			$third_level_categories  = [];

			if ( ! empty($categories) && is_array($categories))
			{
				//Loop and get ID's
				foreach ($categories as $key => $category)
				{
					$categories_ids[] = $category['id'];
				}

				//Get urls
				if (($urls = Model_Client::getURL($categories_ids, 'category')))
				{
					if ( ! empty($urls) && is_array($urls))
					{
						foreach ($urls as $url)
						{
							$categories[$url['object']]['slug'] = $url['slug'];
						}
					}
				}

				foreach ($categories as $key => $category)
				{
					if (($category['level']) == 0)
					{
						$main_categories[$category['id']] = [
							'id'    => $category['id'],
							'slug'  => ! empty($category['slug']) ? $category['slug'] : '',
							'title' => $category['title'],
						];
					}
					elseif ($category['level'] == 1)
					{
						$second_level_categories[$category['parent_id']][] = [
							'id'     => $category['id'],
							'slug'   => ! empty($category['slug']) ? $category['slug'] : '',
							'title'  => $category['title'],
							'parent' => $category['parent_id'],
						];
					}
					elseif ($category['level'] == 2)
					{
						$third_level_categories[$category['parent_id']][] = [
							'id'     => $category['id'],
							'slug'   => ! empty($category['slug']) ? $category['slug'] : '',
							'title'  => $category['title'],
							'parent' => $category['parent_id'],
						];
					}
				}
			}

			$this->categories['all']    = $categories;

			View::share('main_categories', $main_categories);
			View::share('second_level_categories', $second_level_categories);
			View::share('third_level_categories', $third_level_categories);
		}
		else
		{
			return FALSE;
		}
	}

	private function systemInit()
	{
		$this->system = Model_Main::getSetting(FALSE, FALSE, TRUE);
		View::share('sys', $this->system);

		//Init cart
		self::initCart();
	}

	private function initCart() {
		$this->cart = session()->get('cart');
	}
}
