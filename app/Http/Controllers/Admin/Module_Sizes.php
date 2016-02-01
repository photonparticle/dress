<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Products;
use App\Admin\Model_Categories;
use App\Admin\Model_Sizes;
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

class Module_Sizes extends BaseController
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

	/**
	 * Display a listing of products
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('sizes.group_list');

		$response['groups'] = Model_Sizes::getSizes();

		$customCSS = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];

		$customJS = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		return Theme::view('sizes.list_sizes', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$response['pageTitle'] = trans('sizes.add');

		$customCSS = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];

		$customJS = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		return Theme::view('sizes.show_group', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 * @return \Illuminate\Http\Response
	 */
	public function postStore()
	{
		$response['status']  = 'error';
		$response['message'] = trans('products.not_created');

		if ( ! empty($_POST))
		{
			$error = FALSE;

			if (empty(trim(Input::get('title'))))
			{
				$response['message'] = trans('products.title_required');
				$error               = TRUE;
			}

			if ($error === FALSE)
			{
				$data = [
					'title'          => trim(Input::get('title')),
					'description'    => Input::get('description'),
					'quantity'       => Input::get('quantity'),
					'position'       => Input::get('position'),
					'active'         => Input::get('active'),
					'original_price' => Input::get('original_price'),
					'price'          => Input::get('price'),
					'discount_price' => Input::get('discount_price'),
					'discount_start' => Input::get('discount_start'),
					'discount_end'   => Input::get('discount_end'),
					'created_at'     => Input::get('created_at'),
				];

				if (Model_Products::createProduct($data) === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('products.created');
				}
				else
				{
					$response['message'] = trans('products.not_created');
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
	public function getShow($id)
	{
		$response['pageTitle'] = trans('sizes.edit_group');

		$customCSS = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];

		$customJS = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		//Sizes load
		$response['sizes'] = Model_Sizes::getSizes(FALSE, $id);
		$response['group'] = $id;

		return Theme::view('sizes.show_group', $response);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getEdit($id = FALSE)
	{
		$response['related_categories'] = Model_Products::getProductToCategory($id);
		$response['blade_standalone']   = TRUE;

		//Sizes load
		$response['size'] = Model_Sizes::getSizes(FALSE, $id);

		return Theme::view('sizes.show_size_partial', $response);
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
		$response['message'] = trans('sizes.not_saved');

		if ( ! empty($_POST))
		{
			if ( ! empty(Input::get('group')))
			{
				$group = Input::get('group');
			}
			else
			{
				$group = Input::get('new_group_name');
			}
			if ( ! empty($group))
			{
				$result    = FALSE;
				$sizes     = [];
				$new_sizes = [];
				if ( ! empty($_POST['sizes']) &&
					is_array($_POST['sizes'])
				)
				{
					$sizes = $_POST['sizes'];
				}
				if ( ! empty($_POST['new_sizes']) &&
					is_array($_POST['new_sizes'])
				)
				{
					$new_sizes = $_POST['new_sizes'];
				}
				if (empty(Input::get('new_group_name')) &&
					Model_Sizes::saveSizes($group, $sizes, '', $new_sizes)
				)
				{
					$result = TRUE;
				}
				elseif ( ! empty(Input::get('new_group_name')) &&
					is_string(Input::get('new_group_name')) &&
					Model_Sizes::saveSizes($group, $sizes, $_POST['new_group_name'], $new_sizes)
				)
				{
					$result = TRUE;
				}

				if ($result === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('sizes.saved');
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
	public function postDestroy($id = FALSE, $group = FALSE)
	{
		$response['status']  = 'error';
		$response['message'] = trans('sizes.not_removed');

		if ( ! empty($id) && intval($id) > 0)
		{
			if (Model_Sizes::removeSize(FALSE, '', $id) === TRUE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('sizes.removed');
			}
		}

		if(!empty($group)) {
			if(Model_Sizes::removeSize(TRUE, $group) === TRUE) {
				$response['status']  = 'success';
				$response['message'] = trans('sizes.group_removed');
			}
		}

		return response()->json($response);
	}
}
