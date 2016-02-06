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

class Module_Products extends BaseController
{
	private $active_module = '';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if(in_array('users', $modules)) {
			$this->active_module = 'products';
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
		$response['pageTitle'] = trans('global.products');

		$response['products'] = Model_Products::getProducts(FALSE, ['title']);

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

		return Theme::view('products.list_products', $response);
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
			'global/plugins/bootstrap-switch/css/bootstrap-switch.min',
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
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
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
		];
		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		$response['pageTitle'] = trans('global.create_product');

		$response['categories'] = Model_Categories::getCategory(FALSE, ['title']);
		$response['groups'] = Model_Sizes::getSizes(TRUE);

		return Theme::view('products.create_product', $response);
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
					'sizes'			 => Input::get('sizes')
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
	 * Used to display partials
	 *
	 * @param $partial
	 * @param $param
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 */
	public function getShow($partial, $param)
	{
		$response['blade_standalone'] = TRUE;

		if(!empty($partial) && !empty($param)) {
			if($partial == 'sizes') {
				$response['sizes'] = Model_Sizes::getSizes(FALSE, $param);
			}
		}

		return Theme::View('products_partials.product_sizes_form', $response);
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
			'global/plugins/bootstrap-switch/css/bootstrap-switch.min',
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
            'global/plugins/dropzone/css/dropzone',
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
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
            'global/plugins/dropzone/dropzone',
            'admin/pages/scripts/form-dropzone',
		];
		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		$response['categories'] = Model_Categories::getCategory(FALSE, ['title']);
		$response['related_categories'] = Model_Products::getProductToCategory($id);
		$response['groups'] = Model_Sizes::getSizes(TRUE);

		$product = Model_Products::getProducts($id);
		if ( ! empty($product[$id]))
		{
			$response['product'] = $product[$id];
			if(!empty($product[$id]['sizes'])) {
				$response['sizes'] = json_decode($product[$id]['sizes'], TRUE);
			}
		}
		$response['pageTitle'] = trans('products.edit');

		return Theme::view('products.edit_product', $response);
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
		$response['message'] = trans('products.not_updated');

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
					'sizes'			 => Input::get('sizes')
				];

				if (Model_Products::updateProduct($id, $data) === TRUE)
				{
					try
					{
						//Manage relations
						if(!empty($_POST['categories']) && is_array($_POST['categories'])) {
							Model_Products::setProductToCategory($id, $_POST['categories']);
						}

						$response['status']  = 'success';
						$response['message'] = trans('products.updated');
					} catch (Exception $e)
					{
						$response['message'] = $e;
					}
				}
				else
				{
					$response['message'] = trans('products.not_updated');
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
		$response['message'] = trans('products.not_removed');

		if ( ! empty($id) && intval($id) > 0)
		{
			if (Model_Products::removeProduct($id) === TRUE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('products.removed');
			}
		}

		return response()->json($response);
	}
}
