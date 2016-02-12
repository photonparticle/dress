<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Categories;
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
use View;

class Module_Categories extends BaseController
{
	private $active_module = '';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('users', $modules))
		{
			$this->active_module = 'categories';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	/**
	 * Display a listing of categories
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('global.categories');

		$response['categories'] = Model_Categories::getCategory(FALSE, ['title']);

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

		return Theme::view('categories.list_categories', $response);
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
			'global/plugins/jquery-slugify/speakingurl',
			'global/plugins/jquery-slugify/slugify.min',
		];
		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		$response['categories'] = Model_Categories::getCategory(FALSE, ['title']);
		$response['pageTitle']  = trans('global.create_category');

		return Theme::view('categories.create_category', $response);
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
					'title'            => trim(Input::get('title')),
					'description'      => Input::get('description'),
					'level'            => $category_level,
					'parent'           => $parent,
					'position'         => Input::get('position'),
					'visible'          => Input::get('visible'),
					'active'           => Input::get('active'),
					'meta_description' => Input::get('meta_description'),
					'meta_keywords'    => Input::get('meta_keywords'),
				];

				if (($id = Model_Categories::createCategory($data)) > 0)
				{
					try
					{
						//Manage Friendly URL
						Model_Categories::setURL($id, Input::get('friendly_url'));

						$response['status']      = 'success';
						$response['message']     = trans('categories.created');
						$response['category_id'] = $id;
					} catch (Exception $e)
					{
						$response['message'] = $e;
					}
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
	 * Used to display partials or do ajax requests
	 *
	 * @param $request
	 * @param $param
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 */
	public function getShow($request, $param)
	{
		if ( ! empty($request) && ! empty($param))
		{

			if ($request == 'check_url')
			{
				if (Model_Categories::checkURL($param))
				{
					$response['status']  = 'error';
					$response['title']   = trans('global.warning');
					$response['message'] = trans('products.url_exists');

					return response()->json($response);
				}
				else
				{
					return 'available';
				}
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
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
			'global/plugins/jquery-slugify/speakingurl',
			'global/plugins/jquery-slugify/slugify.min',
		];
		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		$response['categories'] = Model_Categories::getCategory(FALSE, ['title']);
		$response['pageTitle']  = trans('categories.edit_category');

		$category_data        = Model_Categories::getCategory($id);
		$response['category'] = $category_data[$id];
		unset($response['categories'][$id]);

		//SEO Tab
		if (($slug = Model_Categories::getURL($id)) != FALSE)
		{
			$response['seo']['friendly_url'] = $slug;
		}

		if ( ! empty($response['category']['meta_description']))
		{
			$response['seo']['meta_description'] = $response['category']['meta_description'];
			unset($response['category']['meta_description']);
		}
		if ( ! empty($response['category']['meta_keywords']))
		{
			$response['seo']['meta_keywords'] = $response['category']['meta_keywords'];
			unset($response['product']['meta_keywords']);
		}

		return Theme::view('categories.edit_category', $response);
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
	{
		$response['status']  = 'error';
		$response['message'] = trans('categories.not_updated');

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
					'meta_description' => Input::get('meta_description'),
					'meta_keywords'    => Input::get('meta_keywords'),
				];

				if (Model_Categories::updateCategory($id, $data) === TRUE)
				{
					try
					{
						//Manage Friendly URL
						Model_Categories::setURL($id, Input::get('friendly_url'));

						$response['status']  = 'success';
						$response['message'] = trans('categories.updated');
					} catch (Exception $e)
					{
						$response['message'] = $e;
					}
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
