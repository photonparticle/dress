<?php

namespace App\Http\Controllers\API;

use App\Client\Model_API;
use App\Http\Controllers\BaseControllerClient;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Config;
use View;

class API extends BaseControllerClient
{
	private $active_module = '';

	public function __construct(Request $request)
	{

	}

	public function getCategories()
	{
		$categories = Model_API::getCategory(FALSE, ['title']);

		dd($categories);
	}
}
