<?php

namespace App\Http\Controllers;

use App\Admin\Model_Users;
use App\Client\Model_Client;
use App\Client\Model_Main;
use App\Http\Controllers\BaseControllerClient;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use View;

class Homepage extends BaseControllerClient
{
	private $active_module = 'homepage';
	private $states = [
		'blagoevgrad',
		'burgas',
		'varna',
		'veliko_tyrnovo',
		'vidin',
		'vraca',
		'gabrovo',
		'dobrich',
		'kyrdjali',
		'kiustendil',
		'lovech',
		'montana',
		'pazardjik',
		'pernik',
		'pleven',
		'plovdiv',
		'razgrad',
		'ruse',
		'silistra',
		'sliven',
		'smolyan',
		'sofia',
		'stara_zagora',
		'tyrgovishte',
		'haskovo',
		'shumen',
		'yambol',
	];

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('homepage', $modules))
		{
			$this->active_module = 'homepage';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	public function homepage()
	{
		$customCSS = [

		];
		$customJS  = [
		];

		$response = [
			'blade_custom_css' => $customCSS,
			'blade_custom_js'  => $customJS,
		];

		$response['thumbs_path']  = Config::get('system_settings.product_public_path');
		$response['icon_size']    = Config::get('images.sm_icon_size');
		$response['sliders_path'] = Config::get('system_settings.sliders_public_path');

		$products = [];

		/* Load Carousels */
		$response['carousels'] = Model_Main::getCarousels($this->active_module);

		if ( ! empty($response['carousels']) && is_array($response['carousels']))
		{
			foreach ($response['carousels'] as $key => $carousel)
			{
				if ( ! empty($carousel['products']))
				{
					$response['carousels'][$key]['products'] = is_array(json_decode(',', $carousel['products'], TRUE)) ? json_decode(',', $carousel['products'], TRUE) : explode(',', $carousel['products']);
					$products                                = array_merge($products, $response['carousels'][$key]['products']);
				}
			}
		}

		// Get products data
		$response['products'] = Model_Main::getProducts($products, ['title', 'images', 'sizes']);

		// Send products to response
		$response['products'] = self::prepareProductsForResponse($response['products']);
		unset($products);

		/* Get Sliders */
		$sliders = Model_Main::getSliders('homepage');

		if ( ! empty($sliders) && is_array($sliders))
		{
			foreach ($sliders as $key => $slider)
			{
				if ( ! empty($slider['slides']) && ! empty($slider['slides_positions']))
				{
					$slider['slides']           = json_decode($slider['slides'], TRUE);
					$slider['slides_positions'] = json_decode($slider['slides_positions'], TRUE);

					//Sort by position
					if ( ! empty($slider['slides_positions']) && is_array($slider['slides_positions']))
					{
						uasort($slider['slides_positions'], function ($a, $b)
						{
							if ($a == $b)
							{
								return 0;
							}

							return ($a < $b) ? -1 : 1;
						});
					}

					$response['sliders'][$key] = $slider;
				}
			}
		}

		return Theme::view('homepage.homepage', $response);
	}

	public function search($needable, $tag = FALSE)
	{
		if ($needable == 'tag')
		{
			$response['needable'] = $tag;

			$response['tag'] = TRUE;
			//Get products
			$response['products_to_render'] = Model_Client::searchProductByTag($tag);
		}
		else
		{
			$response['needable'] = $needable;

			//Get products
			$response['products_to_render'] = Model_Client::searchProduct($needable);
		}

		if ( ! empty($response['products_to_render']) && is_array($response['products_to_render']))
		{
			// Get products data
			$response['products'] = Model_Main::getProducts($response['products_to_render'], ['title', 'images', 'sizes']);

			// Send products to response
			$response['products'] = self::prepareProductsForResponse($response['products']);
		}

		$response['thumbs_path']       = Config::get('system_settings.product_public_path');
		$response['icon_size']         = Config::get('images.sm_icon_size');
		$response['render_for_search'] = TRUE;

		return Theme::view('search.search', $response);
	}

	public
	function searchAjax(Request $request)
	{
		if ($request->ajax())
		{
			if ( ! empty($_GET))
			{
				$needable = Input::get('search');
				//Get products
				$response['products_to_render'] = Model_Client::searchProduct($needable);
			}

			if ( ! empty($response['products_to_render']) && is_array($response['products_to_render']))
			{
				// Get products data
				$response['products'] = Model_Main::getProducts($response['products_to_render'], ['title']);

				// Send products to response
				$response['products'] = self::prepareProductsForResponse($response['products']);
			}
			$response['blade_standalone'] = TRUE;

			return Theme::view('search.search_ajax', $response);
		}
		else
		{
			return Redirect::to('/')->send();
		}
	}

	public
	function login(Request $request)
	{
		//If user is not logged in
		if ($this->user == FALSE)
		{
			$customCSS = [

			];
			$customJS  = [
			];

			$response = [
				'blade_custom_css' => $customCSS,
				'blade_custom_js'  => $customJS,
			];

			if ($request->ajax())
			{
				$response['blade_standalone'] = TRUE;
				$response['ajax']             = TRUE;
			}

			return Theme::view('homepage.login', $response);
		}
		else
		{
			//If user is logged in - make redirect
			return Redirect::to('/')->send();
		}
	}

	public
	function doLogin()
	{
		$response['status']  = 'error';
		$response['title']   = trans('users.check_login_details');
		$response['message'] = trans('users.auth_not_successful');

		if ( ! empty($_POST) && ! empty(Input::get('email')) && ! empty(Input::get('password')))
		{
			//User data and Authentication
			$credentials = [
				'email'    => Input::get('email'),
				'password' => Input::get('password'),
			];

			$user = Sentinel::authenticate($credentials);

			//If Authentication was successful
			if ( ! empty($user))
			{
				//Login and remember
				if ( ! empty(Input::get('remember')))
				{
					Sentinel::loginAndRemember($user);
				}
				else
				{
					//Login without remember
					Sentinel::login($user);
				}

				$response['status']  = 'success';
				$response['title']   = trans('global.redirecting').'...';
				$response['message'] = trans('users.auth_successful');
			}
		}

		echo json_encode($response);
	}

	public
	function logout()
	{
		Sentinel::logout();

		return Redirect::to('/')->send();
	}

	public
	function register(Request $request)
	{
		//If user is not logged in
		if ($this->user == FALSE)
		{
			$customCSS = [

			];
			$customJS  = [
			];

			$response = [
				'blade_custom_css' => $customCSS,
				'blade_custom_js'  => $customJS,
			];

			if ($request->ajax())
			{
				$response['blade_standalone'] = TRUE;
				$response['ajax']             = TRUE;
			}

			return Theme::view('homepage.register', $response);
		}
		else
		{
			//If user is logged in - make redirect
			return Redirect::to('/')->send();
		}
	}

	public
	function doRegister()
	{
		if ( ! empty(($request['email'] = Input::get('email'))) &&
			! empty(($request['password'] = Input::get('password')))
		)
		{

			if ( ! Sentinel::findByCredentials($request))
			{
				if ( ! filter_var($request['email'], FILTER_VALIDATE_EMAIL))
				{
					$response['status']  = 'warning';
					$response['message'] = trans('user_notifications.invalid_email');
				}
				else
				{
					if (mb_strlen(Input::get('password')) < 8)
					{
						$response['status']  = 'warning';
						$response['message'] = trans('user_notifications.password_length');
					}
					else
					{
						if (Sentinel::registerAndActivate($request))
						{
							$user = Sentinel::authenticate($request);

							//If Authentication was successful
							if ( ! empty($user))
							{
								Sentinel::loginAndRemember($user);
							}

							$response['status']  = 'success';
							$response['message'] = trans('user_notifications.user_created');
						}
						else
						{
							$response['status']  = 'error';
							$response['message'] = trans('user_notifications.user_not_created');
						}
					}
				}
			}
			else
			{
				$response['status']  = 'error';
				$response['message'] = trans('user_notifications.user_exists');
			}
		}
		else
		{
			$response['status']  = 'warning';
			$response['message'] = trans('global.all_fields_required');
		}

		echo json_encode($response);
	}

	public
	function account(Request $request)
	{
		//If user is logged in
		if ( ! $this->user == FALSE)
		{
			$customCSS = [

			];
			$customJS  = [
			];

			$response = [
				'blade_custom_css' => $customCSS,
				'blade_custom_js'  => $customJS,
			];

			if ($request->ajax())
			{
				$response['blade_standalone'] = TRUE;
				$response['ajax']             = TRUE;
			}

			foreach ($this->states as $state)
			{
				$response['states'][$state] = trans('orders.'.$state);
			}

			return Theme::view('homepage.my_profile', $response);
		}
		else
		{
			//If user is not logged in - make redirect
			return Redirect::to('/login')->send();
		}
	}

	public
	function updateAccount(Request $request, $id = FALSE, $action = FALSE)
	{
		$response['status']  = 'error';
		$response['message'] = trans('user_notifications.user_info_not_updated');

		if ( ! empty(($request)) && ! empty($id) && ! empty($action))
		{
			if ($action == 'personal_info')
			{
				$user_data['first_name'] = ( ! empty(Input::get('first_name'))) ? Input::get('first_name') : '';
				$user_data['last_name']  = ( ! empty(Input::get('last_name'))) ? Input::get('last_name') : '';
				$user_data['phone']      = ( ! empty(Input::get('phone'))) ? Input::get('phone') : '';
				$user_data['address']    = ( ! empty(Input::get('address'))) ? Input::get('address') : '';
				$user_data['city']       = ( ! empty(Input::get('city'))) ? Input::get('city') : '';
				$user_data['state']      = ( ! empty(Input::get('state'))) ? Input::get('state') : '';
				$user_data['post_code']  = ( ! empty(Input::get('postcode'))) ? Input::get('postcode') : '';
//				$user_data['country']    = ( ! empty(Input::get('country'))) ? Input::get('country') : '';

				if (Model_Users::updateUserInfo($id, $user_data) === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('user_notifications.personal_info_updated');
				}
				else
				{
					$response['message'] = trans('user_notifications.personal_info_not_updated');
				}
			}
			elseif ($action == 'change_password')
			{
				$user_data['password']        = ( ! empty(Input::get('password'))) ? Input::get('password') : '';
				$user_data['new_password']    = ( ! empty(Input::get('new_password'))) ? Input::get('new_password') : '';
				$user_data['re_new_password'] = ( ! empty(Input::get('re_new_password'))) ? Input::get('re_new_password') : '';

				if ( ! empty($user_data['password']) && ! empty($user_data['new_password']) && ! empty($user_data['re_new_password']))
				{
					$user   = Model_Users::getSentinelUserByID($id);
					$hasher = Sentinel::getHasher();

					if ( ! Sentinel::validateCredentials($user, ['email' => $user->email, 'password' => $user_data['password']]))
					{
						$response['message'] = trans('user_notifications.old_password_do_not_match');
					}
					elseif (
						$hasher->check($user_data['password'], $user_data['new_password']) ||
						$user_data['new_password'] != $user_data['re_new_password']
					)
					{
						$response['message'] = trans('user_notifications.new_passwords_do_not_match');
					}
					elseif (
						mb_strlen($user_data['new_password']) < 8
					)
					{
						$response['status']  = 'warning';
						$response['message'] = trans('user_notifications.password_length');
					}
					else
					{
						if (Sentinel::update($user, ['password' => $user_data['new_password']]))
						{
							$response['status']  = 'success';
							$response['message'] = trans('user_notifications.password_changed');
						}
					}
				}
			}
		}

		echo json_encode($response);
	}

	public
	function orders(Request $request)
	{
		//If user is logged in
		if ( ! $this->user == FALSE)
		{
			$customCSS = [
				'datatables/dataTables.bootstrap',
			];
			$customJS  = [
				'datatables/jquery.dataTables.min',
				'datatables/dataTables.bootstrap',
			];

			$response = [
				'blade_custom_css' => $customCSS,
				'blade_custom_js'  => $customJS,
			];

			if ($request->ajax())
			{
				$response['blade_standalone'] = TRUE;
				$response['ajax']             = TRUE;
			}
			$user_data = $this->user_data;

			$response['orders'] = Model_Client::getOrders($user_data['id'], $user_data['email'], $user_data['phone']);

			return Theme::view('homepage.my_orders', $response);
		}
		else
		{
			//If user is not logged in - make redirect
			return Redirect::to('/login')->send();
		}
	}

	public
	static function contact()
	{
		$customCSS = [
		];
		$customJS  = [
		];

		$response = [
			'blade_custom_css' => $customCSS,
			'blade_custom_js'  => $customJS,
		];

		return Theme::view('homepage.contact', $response);
	}

	public
	static function doContact()
	{
		header('Location: /contact');
		exit;
	}

	public
	function notFound()
	{
		$customCSS = [
		];
		$customJS  = [
		];

		$response = [
			'blade_custom_css' => $customCSS,
			'blade_custom_js'  => $customJS,
		];

		return Theme::view('homepage.404', $response);
	}

	/**
	 * Prepare products for response
	 *
	 * @param $products
	 *
	 * @return array
	 */
	private
	function prepareProductsForResponse($products)
	{
		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $id => $product)
			{
				//Images
				if ( ! empty($product['images']) && is_array($image = json_decode($product['images'], TRUE)))
				{
					reset($image);
					$products[$id]['image'] = key($image);
					unset($products[$id]['images']);

					if ( ! is_float($product['price']))
					{
						$products[$id]['price'] = intval($product['price']);
					}
					if ( ! is_float($product['discount_price']))
					{
						$products[$id]['discount_price'] = intval($product['discount_price']);
					}
				}

				if ( ! empty($product['discount_price']))
				{
					//Calculate is discount active
					$now = time();

					if ($product['discount_start'] == '0000.00.00 00:00:00' || strtotime($product['discount_start']) <= $now)
					{
						$allow_start = TRUE;
					}
					else
					{
						$allow_start = FALSE;
					}

					if ($product['discount_end'] == '0000.00.00 00:00:00' || strtotime($product['discount_end']) <= $now)
					{
						$allow_end = TRUE;
					}
					else
					{
						$allow_end = FALSE;
					}

					if ($allow_start === TRUE && $allow_end === TRUE)
					{
						$products[$id]['active_discount'] = TRUE;
					}

					if ( ! empty($products[$id]['active_discount']))
					{
						$products[$id]['discount'] = intval(
							(floatval($products[$id]['price']) -
								floatval($products[$id]['discount_price'])) / floatval($products[$id]['price']) * 100
						);
					}
				}

				//Sizes
				if ( ! empty ($products[$id]['sizes']) && is_array(($products[$id]['sizes'] = json_decode($products[$id]['sizes'], TRUE))))
				{
					foreach ($products[$id]['sizes'] as $key => $size)
					{
						if (empty($size['name']) || empty($size['quantity']))
						{
							if (isset($products[$id]['sizes'][$key]))
							{
								unset($products[$id]['sizes'][$key]);
							}
						}
					}
				}

				if ( ! empty($products[$id]['sizes']) && is_array($products[$id]['sizes']))
				{
					$sizes = [];
					foreach ($products[$id]['sizes'] as $key => $size)
					{
						if ( ! empty($size['quantity']))
						{
							$sizes[] = $key;
						}
					}

					if ( ! empty($sizes) && is_array($sizes))
					{
						$products[$id]['available_sizes'] = implode(', ', $sizes);
					}
				}
			}
		}

		return $products;
	}
}
