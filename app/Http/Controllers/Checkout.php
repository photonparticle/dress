<?php

namespace App\Http\Controllers;

use App\Client\Model_Main;
use App\Http\Controllers\BaseControllerClient;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Config;
use View;

class Checkout extends BaseControllerClient
{
	private $active_module = 'homepage';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('checkout', $modules))
		{
			$this->active_module = 'checkout';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	public function checkoutCompleted()
	{
		$response['blade_custom_css'] = [
			'checkout'
		];

		return Theme::view('checkout.completed', $response);
	}
}
