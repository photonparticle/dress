<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Categories;
use App\Admin\Model_Carousels;
use App\Admin\Model_Products;
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

class Module_Carousels extends BaseController
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
	 * Display a listing of sliders
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('carousels.carousels');

		$response['carousels'] = Model_Carousels::getCarousels(FALSE, TRUE, ['id', 'title', 'type', 'active_from', 'active_to', 'created_at']);

		$response['blade_custom_css'] = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];

		$response['blade_custom_js'] = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		return Theme::view('carousels.list_carousels', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$response['pageTitle'] = trans('carousels.create');

		$response['blade_custom_css'] = [
			'global/plugins/select2/select2',
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
		];

		$response['blade_custom_js'] = [
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'admin/pages/scripts/components-dropdowns',
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
		];

		$response['categories'] = Model_Categories::getCategory(FALSE, ['title']);

		$response['products'] = Model_Products::getProducts(FALSE, ['title']);

		return Theme::view('carousels.create_edit_carousel', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param bool $slides
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postStore($slides = FALSE)
	{
		$response['status']  = 'error';
		$response['message'] = trans('carousels.not_saved');

		if ( ! empty($_POST))
		{
//				Save carousel
			$error = FALSE;

			if(!empty(Input::get('products')) && Input::get('products') == 'newest' || Input::get('products') == 'discounted') {
				$slider_type = Input::get('products');
			} else {
				$slider_type = 'others';
			}

			if (empty(trim(Input::get('title'))))
			{
				$response['message'] = trans('carousels.title_required');
				$error               = TRUE;
			}
			if (empty(Input::get('type')))
			{
				$response['message'] = trans('carousels.type_required');
				$error               = TRUE;
			}
			if (
				empty($slider_type) ||
				(!empty($slider_type) && $slider_type == 'others' && is_array(Input::get('products')) !== TRUE)
			)
			{
				$response['message'] = trans('carousels.slider_type_required');
				$error               = TRUE;
			}

			if ($error === FALSE)
			{
				$data = [
					'title'        => trim(Input::get('title')),
					'position'     => trim(Input::get('position')),
					'type'         => Input::get('type'),
					'target'       => Input::get('target'),
					'active_from'  => Input::get('active_from'),
					'active_to'    => Input::get('active_to'),
					'max_products' => Input::get('max_products'),
				];

				if ( ! empty($_POST['products']) && is_array($_POST['products']))
				{
					$data['products'] = json_encode($_POST['products']);
				}
				else
				{
					$data['products'] = Input::get('products');
				}

				if (empty(Input::get('id')))
				{
					if (($carousel_id = Model_Carousels::insertCarousel($data)) != FALSE)
					{
						$response['status']   = 'success';
						$response['message']  = trans('carousels.saved');
						$response['id']       = $carousel_id;
						$response['redirect'] = TRUE;
					}
				}
				elseif (($id = intval(Input::get('id'))) > 0)
				{
					if (Model_Carousels::updateCarousel($id, $data) != FALSE)
					{
						$response['status']  = 'success';
						$response['message'] = trans('carousels.saved');
						$response['id']      = $id;
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
		$response['pageTitle'] = trans('carousels.edit');

		$response['blade_custom_css'] = [
			'global/plugins/select2/select2',
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
		];

		$response['blade_custom_js'] = [
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'admin/pages/scripts/components-dropdowns',
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
		];

		$response['categories'] = Model_Categories::getCategory(FALSE, ['title']);
		$response['products']   = Model_Products::getProducts(FALSE, ['title']);
		$response['carousel']   = Model_Carousels::getCarousels($id, FALSE);

		if ( ! empty($response['carousel']) && ! empty($response['carousel'][0]))
		{
			$response['carousel'] = $response['carousel'][0];
		}

		if(!empty($response['carousel']['products']) && $response['carousel']['products'] == 'newest' || $response['carousel']['products'] == 'discounted') {
			$response['carousel']['slider_type'] = $response['carousel']['products'];
		} else {
			$response['carousel']['slider_type'] = 'others';
		}

		if ( ! empty($response['carousel']['products']) && $response['carousel']['slider_type'] == 'others')
		{
			$response['carousel']['products'] = json_decode($response['carousel']['products'], TRUE);
		}

		return Theme::view('carousels.create_edit_carousel', $response);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param bool $method
	 * @param bool|int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postDestroy($id = FALSE)
	{
		$response['status']  = 'error';
		$response['message'] = trans('carousels.not_removed');

		if ( ! empty($id) && intval($id) > 0)
		{
			$dir = Config::get('system_settings.carousels_upload_path');
			if (Model_Carousels::removeCarousel($id, $dir) === TRUE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('carousels.removed');
			}
		}

		return response()->json($response);
	}
}