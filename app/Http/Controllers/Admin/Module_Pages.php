<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Pages;
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

class Module_Pages extends BaseController
{
	private $active_module = '';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('modules', $modules))
		{
			$this->active_module = 'pages';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	/**
	 * Display a listing of tables
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('global.pages');

		$response['blade_custom_css'] = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];
		$response['blade_custom_js'] = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		return Theme::view('pages.list_pages', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$response['pageTitle'] = trans('pages.create_page');

		$response['blade_custom_css'] = [
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote',
		];

		$response['blade_custom_js'] = [
			'global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0',
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote.min',
		];

		return Theme::view('pages.create_edit_page', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 * @return \Illuminate\Http\Response
	 */
	public function postStore()
	{
		$response['status']  = 'error';
		$response['message'] = trans('tables.not_saved');

		if ( ! empty($_POST))
		{
			$error = FALSE;

			if (empty(trim(Input::get('title'))))
			{
				$response['message'] = trans('tables.title_required');
				$error               = TRUE;
			}

			if ($error === FALSE)
			{
				$data = [
					'title'      => trim(Input::get('title')),
					'cols'	=> Input::get('cols'),
					'rows'	=> Input::get('rows'),
					'image'	=> Input::get('image_name')
				];

				if(empty(Input::get('id'))) {
					if (($table_id = Model_Tables::insertTable($data)) != FALSE)
					{
						$response['status']  = 'success';
						$response['message'] = trans('tables.saved');
						$response['id'] = $table_id;
					}
				} elseif(($id = intval(Input::get('id'))) > 0) {
					if (Model_Tables::updateTable($id, $data) != FALSE)
					{
						$response['status']  = 'success';
						$response['message'] = trans('tables.saved');
					}
				}
			}
		}

		return response()->json($response);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getEdit($id)
	{
		$response['pageTitle'] = trans('pages.edit_page');

		$response['blade_custom_css'] = [
		];

		$response['blade_custom_js'] = [
		];

		return Theme::view('pages.create_edit_page', $response);
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
		$response['message'] = trans('tables.not_removed');

		if ( ! empty($id) && intval($id) > 0)
		{
			if (Model_Tables::removeTable($id) === TRUE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('tables.removed');
			}
		}

		return response()->json($response);
	}
}
