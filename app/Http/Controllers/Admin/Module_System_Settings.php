<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_System_Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use Caffeinated\Themes\Facades\Theme;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Symfony\Component\DomCrawler\Form;
use View;

class Module_System_Settings extends BaseController
{
	private $active_module = '';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('modules', $modules))
		{
			$this->active_module = 'modules';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	/**
	 * Display a listing of colors
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('system_settings.system_settings');

		$response['blade_custom_css'] = [
			'global/plugins/bootstrap-summernote/summernote',
		];

		$response['blade_custom_js'] = [
			'global/plugins/fuelux/js/spinner.min',
			'global/plugins/bootstrap-summernote/summernote.min',
		];

		$response['system_settings'] = Model_System_Settings::getSetting(FALSE, FALSE, TRUE);

		return Theme::view('system_settings.system_settings', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 * @return \Illuminate\Http\Response
	 */
	public function postStore()
	{
		$response['status']  = 'error';
		$response['message'] = trans('system_settings.not_saved');

		if ( ! empty($_POST))
		{
			$data = [
				'title'                  => trim(Input::get('title')),
				'email'                  => trim(Input::get('email')),
				'phone'                  => trim(Input::get('phone')),
				'work_time'              => trim(Input::get('work_time')),
				'quantity'               => trim(Input::get('quantity')),
				'page_title'             => trim(Input::get('page_title')),
				'meta_description'       => trim(Input::get('meta_description')),
				'meta_keywords'          => trim(Input::get('meta_keywords')),
				'delivery_to_office'     => trim(Input::get('delivery_to_office')),
				'delivery_to_address'    => trim(Input::get('delivery_to_address')),
				'delivery_free_delivery' => trim(Input::get('delivery_free_delivery')),
				'social_blog'            => trim(Input::get('social_blog')),
				'social_facebook'        => trim(Input::get('social_facebook')),
				'social_twitter'         => trim(Input::get('social_twitter')),
				'social_google_plus'     => trim(Input::get('social_google_plus')),
				'social_youtube'         => trim(Input::get('social_youtube')),
				'social_pinterest'       => trim(Input::get('social_pinterest')),
			];

			if (Model_System_Settings::saveSettings($data) != FALSE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('system_settings.saved');
			}
		}

		return response()->json($response);
	}
}
