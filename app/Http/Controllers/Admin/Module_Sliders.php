<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Categories;
use App\Admin\Model_Sliders;
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

class Module_Sliders extends BaseController
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
	 * Display a listing of tables
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('tables.tables');

		$response['tables'] = Model_Tables::getTables();
		$response['images_dir'] = Config::get('system_settings.tables_upload_path');
		$response['public_images_dir'] = Config::get('system_settings.tables_public_path');

		$response['blade_custom_css'] = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];
		$response['blade_custom_js'] = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		return Theme::view('tables.list_tables', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$response['pageTitle'] = trans('sliders.create');

		$response['blade_custom_css'] = [
			'global/plugins/dropzone/css/dropzone',
			'global/plugins/select2/select2',
		];

		$response['blade_custom_js'] = [
			'global/plugins/dropzone/dropzone',
			'admin/pages/scripts/form-dropzone',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'admin/pages/scripts/components-dropdowns',
		];

		$response['image_name'] = uniqid('table_');
		$response['images_dir'] = Config::get('system_settings.tables_upload_path');
		$response['public_images_dir'] = Config::get('system_settings.tables_public_path');
		$response['categories']        = Model_Categories::getCategory(FALSE, ['title']);

		return Theme::view('sliders.create_edit_slider', $response);
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
	 * Display the specified resource.
	 *
	 * @param bool|int $id
	 * @param $object
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getShow($object = FALSE, $id = FALSE)
	{
		$response['blade_standalone'] = TRUE;

		if ($object == 'row' || $object == 'col')
		{
			//Table load
			if ($id !== FALSE)
			{
				$response['table'] = Model_Tables::getTables($id, FALSE, $object);
			}

			if ($object == 'row')
			{
				return Theme::view('tables.show_table_rows_partial', $response);
			}
			if ($object == 'col')
			{
				return Theme::view('tables.show_table_cols_partial', $response);
			}
		}
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
		$response['pageTitle'] = trans('tables.edit_table');

		$response['blade_custom_css'] = [
			'global/plugins/dropzone/css/dropzone',
		];

		$response['blade_custom_js'] = [
			'global/plugins/dropzone/dropzone',
			'admin/pages/scripts/form-dropzone',
		];
		$response['images_dir'] = Config::get('system_settings.tables_upload_path');
		$response['public_images_dir'] = Config::get('system_settings.tables_public_path');

		if(!empty($id)) {
			$result = Model_Tables::getTables($id, FALSE);
			if(!empty($result) && !empty($result[0])) {
				if(!empty($result[0]['cols']))
				{
					$result[0]['cols'] = json_decode($result[0]['cols'], TRUE);
				}
				if(!empty($result[0]['rows']))
				{
					$result[0]['rows'] = json_decode($result[0]['rows'], TRUE);
				}
				$response['table'] = $result[0];
			}
		}

		return Theme::view('tables.create_edit_table', $response);
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
