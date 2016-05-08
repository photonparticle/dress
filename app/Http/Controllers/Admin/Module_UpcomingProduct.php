<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Products;
use App\Admin\Model_UpcomingProduct;
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

class Module_UpcomingProduct extends BaseController
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
	 * Display form
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('upcoming_product.upcoming_product');

		$data = Model_UpcomingProduct::getUpcomingProduct();

		if ( ! empty($data[0]) && is_array($data[0]))
		{
			foreach ($data[0] as $key => $val)
			{
				$response[$key] = $val;
			}
		}

		$response['blade_custom_css'] = [
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2',
			'global/plugins/jquery-multi-select/css/multi-select',
			'global/plugins/bootstrap-switch/css/bootstrap-switch.min',
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
		];

		$response['blade_custom_js'] = [
			'global/plugins/bootstrap-switch/js/bootstrap-switch.min',
			'admin/pages/scripts/components-dropdowns',
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'global/plugins/jquery-multi-select/js/jquery.multi-select',
		];

		$response['products']           = Model_Products::getProducts(FALSE, ['title'], FALSE, 0, 0, TRUE);

		return Theme::view('upcoming_product.upcoming_product', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 * @return \Illuminate\Http\Response
	 */
	public function postStore()
	{
		$response['status']  = 'error';
		$response['message'] = trans('upcoming_product.not_saved');

		if ( ! empty($_POST))
		{
			$error = FALSE;

			if (empty(trim(Input::get('title'))))
			{
				$response['message'] = trans('upcoming_product.title_required');
				$error               = TRUE;
			}

			if (empty(trim(Input::get('product_id'))))
			{
				$response['message'] = trans('upcoming_product.product_required');
				$error               = TRUE;
			}

			if ($error === FALSE)
			{
				$data = [
					'title'      => trim(Input::get('title')),
					'product_id'      => trim(Input::get('product_id')),
					'date'   => Input::get('date'),
					'active' => Input::get('active'),
				];

				if (Model_UpcomingProduct::saveUpcomingProduct($data) != FALSE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('upcoming_product.saved');
				}
			}
		}

		return response()->json($response);
	}
}
