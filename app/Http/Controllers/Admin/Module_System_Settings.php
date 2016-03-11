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

		$response['blade_custom_js'] = [
			'global/plugins/fuelux/js/spinner.min',
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
				'title'      => trim(Input::get('title')),
				'email'      => trim(Input::get('email')),
				'phone'      => trim(Input::get('phone')),
				'quantity'      => trim(Input::get('quantity')),
				'page_title'      => trim(Input::get('page_title')),
				'meta_description'      => trim(Input::get('meta_description')),
				'meta_keywords'      => trim(Input::get('meta_keywords')),
				'delivery_to_office'      => trim(Input::get('delivery_to_office')),
				'delivery_to_address'      => trim(Input::get('delivery_to_address')),
				'delivery_free_delivery'      => trim(Input::get('delivery_free_delivery')),
			];

			if (Model_System_Settings::saveSettings($data) != FALSE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('system_settings.saved');
			}
		}

		return response()->json($response);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getShow($id = FALSE)
	{
		$response['blade_standalone'] = TRUE;

		//Color load
		if ($id !== FALSE)
		{
			$response['color'] = Model_Colors::getColors($id);
		}

		return Theme::view('colors.color_partial', $response);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @param  int $action
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postUpdate(Request $request)
	{
		$response['status']  = 'error';
		$response['message'] = trans('colors.not_saved');

		if ( ! empty($_POST))
		{
			$error = FALSE;
			if (empty(Input::get('title')))
			{
				$error               = TRUE;
				$response['message'] = trans('colors.title_required');
			}

			if ($error == FALSE)
			{
				$data = [
					'title'      => Input::get('title'),
					'position'   => Input::get('position'),
					'updated_at' => time(),
				];

				$result = Model_Colors::updateColor(Input::get('id'), $data);

				if ($result === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('colors.saved');
				}
			}
		}

		return response()->json($response);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postDestroy($id = FALSE)
	{
		$response['status']  = 'error';
		$response['message'] = trans('colors.not_removed');

		if ( ! empty($id) && intval($id) > 0)
		{
			if (Model_Colors::removeColor($id) === TRUE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('colors.removed');
			}
		}

		return response()->json($response);
	}
}
