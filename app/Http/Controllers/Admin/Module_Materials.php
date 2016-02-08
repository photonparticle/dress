<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Materials;
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

class Module_Materials extends BaseController
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
	 * Display a listing of materials
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('materials.materials');

		$response['materials'] = Model_Materials::getMaterials();

		$response['blade_custom_js'] = [
			'global/plugins/bootbox/bootbox.min',
		];

		return Theme::view('materials.list', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 * @return \Illuminate\Http\Response
	 */
	public function postStore()
	{
		$response['status']  = 'error';
		$response['message'] = trans('materials.not_saved');

		if ( ! empty($_POST))
		{
			$error = FALSE;

			if (empty(trim(Input::get('title'))))
			{
				$response['message'] = trans('materials.title_required');
				$error               = TRUE;
			}
			elseif ( ! empty(trim(Input::get('title'))) && Model_Materials::checkTitleExists(trim(Input::get('title'))) > 0)
			{
				$response['message'] = trans('materials.exists');
				$error               = TRUE;
			}

			if ($error === FALSE)
			{
				$data = [
					'title'      => trim(Input::get('title')),
					'position'   => Input::get('position'),
					'created_at' => time(),
				];

				if (Model_Materials::insertMaterial($data) != FALSE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('materials.saved');
				}
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

		//Material load
		if ($id !== FALSE)
		{
			$response['material'] = Model_Materials::getMaterials($id);
		}

		return Theme::view('materials.material_partial', $response);
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
		$response['message'] = trans('materials.not_saved');

		if ( ! empty($_POST))
		{
			$error = FALSE;
			if (empty(Input::get('title')))
			{
				$error               = TRUE;
				$response['message'] = trans('materials.title_required');
			}

			if ($error == FALSE)
			{
				$data = [
					'title'      => Input::get('title'),
					'position'   => Input::get('position'),
					'updated_at' => time(),
				];

				$result = Model_Materials::updateMaterial(Input::get('id'), $data);

				if ($result === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('materials.saved');
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
		$response['message'] = trans('materials.not_removed');

		if ( ! empty($id) && intval($id) > 0)
		{
			if (Model_Materials::removeMaterial($id) === TRUE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('materials.removed');
			}
		}

		return response()->json($response);
	}
}
