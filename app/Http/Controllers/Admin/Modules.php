<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Config;
use View;

class Modules extends BaseController
{
	private $active_module = '';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('users', $modules))
		{
			$this->active_module = 'modules';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	public function getIndex()
	{
		$response['pageTitle'] = trans('modules.active_modules');
		$modules = Config::get('system_settings.plug-ins');

		if(!empty($modules) && is_array($modules)) {
			foreach($modules as $name => $data) {
				if(!empty($data['title'])) {
					$data['title'] = trans('modules.'.$data['title']);

					$response['modules'][$name] = $data;
				}
			}
		}

		return Theme::view('modules.list_modules', $response);
	}
}