<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Products;
use App\Admin\Model_Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use Caffeinated\Themes\Facades\Theme;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Input;

class Module_Products extends BaseController
{
	/**
	 * Display a listing of categories
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('global.products');

		$response['categories']           = Model_Categories::getAllCategories();

		$customCSS = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];

		$customJS = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min'
		];

		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		return Theme::view('categories.categories_list', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$customCSS                    = [
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2',
			'global/plugins/jquery-multi-select/css/multi-select',
			'/global/plugins/bootstrap-switch/css/bootstrap-switch.min',
		];
		$customJS                     = [
			'global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0',
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote.min',
			'admin/pages/scripts/components-dropdowns',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'global/plugins/jquery-multi-select/js/jquery.multi-select',
			'global/plugins/fuelux/js/spinner.min',
			'global/plugins/bootstrap-switch/js/bootstrap-switch.min',
		];
		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		$response['pageTitle'] = trans('global.create_product');

		$response['categories'] = Model_Categories::getCategory();

		return Theme::view('products.create_product', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 * @return \Illuminate\Http\Response
	 */
	public function postStore()
	{
		$response['status']  = 'error';
		$response['message'] = trans('categories.not_created');

		if ( ! empty($_POST))
		{
			$error = FALSE;

			if (empty(trim(Input::get('title'))))
			{
				$response['message'] = trans('categories.title_required');
				$error               = TRUE;
			}

			$category_level = Input::get('level');
			$parent         = Input::get('parent');
			if ( ! empty($category_level) && in_array($category_level, ['1', '2']))
			{
				if (empty($parent))
				{
					$response['message'] = trans('categories.parent_required');
					$error               = TRUE;
				}
			}

			if ($error === FALSE)
			{
				$data = [
					'title'       => trim(Input::get('title')),
					'description' => Input::get('description'),
					'level'       => $category_level,
					'parent'      => $parent,
					'position'    => Input::get('position'),
					'visible'     => Input::get('visible'),
					'active'      => Input::get('active'),
				];

				if (Model_Categories::createCategory($data) === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('categories.created');
				}
				else
				{
					$response['message'] = trans('categories.not_created');
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
		$customCSS                    = [
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2',
			'global/plugins/jquery-multi-select/css/multi-select',
			'/global/plugins/bootstrap-switch/css/bootstrap-switch.min',
		];
		$customJS                     = [
			'global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0',
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote.min',
			'admin/pages/scripts/components-dropdowns',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'global/plugins/jquery-multi-select/js/jquery.multi-select',
			'global/plugins/fuelux/js/spinner.min',
			'global/plugins/bootstrap-switch/js/bootstrap-switch.min',
		];
		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		$response['categories'] = Model_Categories::getAllCategories();
		$response['pageTitle'] = trans('categories.edit_category');

		if(!empty($response['categories']) && is_array($response['categories'])) {
			foreach($response['categories'] as $category) {
				if(!empty($category['id']) && $category['id'] == $id) {
					$response['category'] = $category;
				}
			}
		}

		return Theme::view('categories.categories_edit', $response);
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
	public function postUpdate(Request $request, $id)
	{$response['status']  = 'error';
		$response['message'] = trans('categories.not_created');

		if ( ! empty($_POST))
		{
			$error = FALSE;

			if (empty(trim(Input::get('title'))))
			{
				$response['message'] = trans('categories.title_required');
				$error               = TRUE;
			}

			$category_level = Input::get('level');
			$parent         = Input::get('parent');

			if ( ! empty($category_level) && in_array($category_level, ['1', '2']))
			{
				if (empty($parent))
				{
					$response['message'] = trans('categories.parent_required');
					$error               = TRUE;
				}
			}

			if ($error === FALSE)
			{
				$data = [
					'title'       => trim(Input::get('title')),
					'description' => Input::get('description'),
					'level'       => $category_level,
					'parent'      => $parent,
					'position'    => Input::get('position'),
					'visible'     => Input::get('visible'),
					'active'      => Input::get('active'),
				];

				if (Model_Categories::updateCategory($id, $data) === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('categories.updated');
				}
				else
				{
					$response['message'] = trans('categories.not_updated');
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
	public function postDestroy($id)
	{
		$response['status']  = 'error';
		$response['message'] = trans('categories.not_removed');

		if ( ! empty($id) && intval($id) > 0)
		{
			if (Model_Categories::removeCategory($id) === TRUE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('categories.removed');
			}
		}

		return response()->json($response);
	}
}
