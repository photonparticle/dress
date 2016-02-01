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
			'admin/pages/css/tasks'
		];
		$customJS = [
			'global/plugins/jqvmap/jqvmap/jquery.vmap',
			'global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia',
			'global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world',
			'global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world',
			'global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe',
			'global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany',
			'global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa',
			'global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata',
			'global/plugins/flot/jquery.flot.min',
			'global/plugins/flot/jquery.flot.resize.min',
			'global/plugins/flot/jquery.flot.categories.min',
			'global/plugins/jquery.pulsate.min',
			'global/plugins/bootstrap-daterangepicker/moment.min',
			'global/plugins/bootstrap-daterangepicker/daterangepicker',
			'global/plugins/fullcalendar/fullcalendar.min',
			'global/plugins/jquery-easypiechart/jquery.easypiechart.min',
			'global/plugins/jquery.sparkline.min',
			'admin/pages/scripts/tasks',
			'admin/pages/scripts/index',
		];

		$data = [
			'blade_custom_css'	=> $customCSS,
			'blade_custom_js'	=> $customJS
		];
        return Theme::view('dashboard.index', $data);
    }
}
