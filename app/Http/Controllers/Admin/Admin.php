<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Config;
use View;

class Admin extends BaseController
{
	private $active_module = '';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if(in_array('users', $modules)) {
			$this->active_module = 'dashboard';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

    public function index() {
		$customCSS = [
            
		];
		$customJS = [
            
            'admin/pages/scripts/ecommerce-index',
            
		];

		$data = [
			'blade_custom_css'	=> $customCSS,
			'blade_custom_js'	=> $customJS
		];
        return Theme::view('dashboard.index', $data);
    }
}
