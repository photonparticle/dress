<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Orders;
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
use View;

class Module_Orders extends BaseController
{
	private $active_module = '';
	private $states = [
		'blagoevgrad',
		'burgas',
		'varna',
		'veliko_tyrnovo',
		'vidin',
		'vraca',
		'gabrovo',
		'dobrich',
		'kyrdjali',
		'kiustendil',
		'lovech',
		'montana',
		'pazardjik',
		'pernik',
		'pleven',
		'plovdiv',
		'razgrad',
		'ruse',
		'silistra',
		'sliven',
		'smolyan',
		'sofia',
		'stara_zagora',
		'tyrgovishte',
		'haskovo',
		'shumen',
		'yambol',
	];

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('users', $modules))
		{
			$this->active_module = 'orders';
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
		$response['pageTitle'] = trans('orders.orders_list');

		$response['orders'] = Model_Orders::getOrders(FALSE, true);

		if(!empty($response['orders']) && is_array($response['orders'])) {
			foreach($response['orders'] as $key => $order) {
				switch ($order['status'])
				{
					case 'pending':
						$response['orders'][$key]['status_color'] = 'bg-green-jungle';
						break;
					case 'confirmed':
						$response['orders'][$key]['status_color'] = 'bg-yellow-casablanca';
						break;
					case 'completed':
						$response['orders'][$key]['status_color'] = 'bg-blue-madison';
						break;
					case 'canceled':
						$response['orders'][$key]['status_color'] = 'bg-red-thunderbird';
						break;
				}
			}
		}

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

//		dd($response);

		return Theme::view('orders.list_orders', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{

		$customCSS                    = [
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
			'global/plugins/bootstrap-summernote/summernote',
			'global/plugins/select2/select2',
			'global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch',
			'global/plugins/bootstrap-modal/css/bootstrap-modal',
		];
		$customJS                     = [
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
			'global/plugins/bootstrap-summernote/summernote.min',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'global/plugins/bootstrap-modal/js/bootstrap-modalmanager',
			'global/plugins/bootstrap-modal/js/bootstrap-modal',
		];
		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		$response['method'] = 'unlocked';
		foreach ($this->states as $state)
		{
			$response['states'][$state] = trans('orders.'.$state);
		}

		$response['current_time'] = date('Y.m.d H:i');

		$response['pageTitle'] = trans('global.create_order');

		return Theme::view('orders.create_edit_order', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param bool $id
	 * @param bool $method
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postStore($id = FALSE, $method = FALSE)
	{
		$response['status']  = 'error';
		$response['message'] = trans('orders.not_saved');

		if ( ! empty($_POST))
		{
			if ($method == FALSE)
			{
				$error = FALSE;

				if (empty(trim(Input::get('city'))))
				{
					$response['message'] = trans('orders.city_required');
					$error               = TRUE;
				}
				if (empty(trim(Input::get('address'))))
				{
					$response['message'] = trans('orders.address_required');
					$error               = TRUE;
				}
				if (empty(trim(Input::get('phone'))))
				{
					$response['message'] = trans('orders.phone_required');
					$error               = TRUE;
				}
				if (empty(trim(Input::get('last_name'))))
				{
					$response['message'] = trans('orders.last_name_required');
					$error               = TRUE;
				}
				if (empty(trim(Input::get('name'))))
				{
					$response['message'] = trans('orders.name_required');
					$error               = TRUE;
				}
				if (empty(trim(Input::get('delivery_type'))))
				{
					$response['message'] = trans('orders.delivery_type_required');
					$error               = TRUE;
				}
				if (empty(trim(Input::get('status'))))
				{
					$response['message'] = trans('orders.status_required');
					$error               = TRUE;
				}

				if ($error === FALSE)
				{
					$data = [
						'user_id'       => Input::get('user_id'),
						'name'          => trim(Input::get('name')),
						'last_name'     => trim(Input::get('last_name')),
						'email'         => trim(Input::get('email')),
						'phone'         => trim(Input::get('phone')),
						'address'       => trim(Input::get('address')),
						'city'          => trim(Input::get('city')),
						'state'         => trim(Input::get('state')),
						'post_code'     => trim(Input::get('post_code')),
						'comment'       => trim(Input::get('comment')),
						'status'        => Input::get('status'),
						'delivery_type' => Input::get('delivery_type'),
						'created_at'    => Input::get('created_at'),
					];

					if ($id == FALSE)
					{
						if (($id = Model_Orders::insertOrder($data)) > 0)
						{
							$response['status']  = 'success';
							$response['message'] = trans('orders.saved');
							$response['id']      = $id;
						}
					}
					elseif (is_numeric($id))
					{
						if (Model_Orders::updateOrder($id, $data))
						{
							$response['status']  = 'success';
							$response['message'] = trans('orders.saved');
						}
					}
				}
			}
			elseif ($method == 'product')
			{
				$response['message'] = trans('orders.product_not_saved');
				$error               = FALSE;

				if (empty(($order_id = intval(trim(Input::get('order_id'))))))
				{
					$error = TRUE;
				}
				if (empty(($size = trim(Input::get('size')))))
				{
					$error = TRUE;
				}
				if (empty(($quantity = intval(trim(Input::get('quantity'))))))
				{
					$error = TRUE;
				}
				if (empty(($product_id = intval(trim(Input::get('product_id'))))))
				{
					$error = TRUE;
				}

				if ($error === FALSE)
				{
					$product = Model_Products::getProducts($product_id, ['sizes']);

					if ( ! empty($product[$product_id]) && is_array($product[$product_id]))
					{
						$product = $product[$product_id];
					}

					$data = [
						'order_id'       => $order_id,
						'product_id'     => $product_id,
						'size'           => $size,
						'quantity'       => $quantity,
						'original_price' => $product['original_price'],
					];

					//If size doesn't have price, get products one
					if (empty(($price = trim(Input::get('price')))))
					{
						$data['price'] = floatval($product['price']);
					}
					else
					{
						$data['price'] = floatval($price);
					}

					$data['total'] = $data['price'];

					//Discount
					$discount_start = strtotime($product['discount_start']);
					$discount_end   = strtotime($product['discount_end']);
					$now            = time();

					//If currently the product have discount
					if ($now > $discount_start && $now < $discount_end)
					{
						//If size doesn't have discount, get products one
						if (empty(($discount = trim(Input::get('discount')))))
						{
							$data['discount'] = floatval($product['discount_price']);
						}
						else
						{
							$data['discount'] = floatval($discount);
						}

						$data['total'] = $data['discount'];
					}

					//If quantity more then one
					if (intval($quantity) > 1)
					{
						$data['total'] = intval($quantity) * $data['total'];
					}

					if (Model_Orders::insertProduct($data) === TRUE)
					{

						//Discard product sizes
						if ( ! empty($product['sizes']))
						{
							$product['sizes'] = json_decode($product['sizes'], TRUE);
						}

						foreach($product['sizes'] as $size_name => $product_size) {
							if($product_size['name'] == $size && intval($quantity) > 0) {
								$product['sizes'][$size_name]['quantity'] = $product_size['quantity'] - $quantity;
							}
						}

						$sizes = json_encode($product['sizes']);

						if(intval($quantity) > 0) {
							$product['quantity'] = intval($product['quantity']) - intval($quantity);
						}

						Model_Orders::discountProduct($product['id'], $sizes, $product['quantity']);

						$response['status']  = 'success';
						$response['message'] = trans('orders.product_saved');
					}
				}
			}
		}

		return response()->json($response);
	}

	/**
	 * Used to display partials or do ajax requests
	 *
	 * @param id
	 * @param $request
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 */
	public function getShow($id = FALSE, $request = FALSE, $form_method = FALSE)
	{
		if ($request == 'add_product')
		{
			$response['blade_standalone'] = TRUE;
			$response['products']         = Model_Products::getProducts(FALSE, ['title']);

			return Theme::View('orders.add_product_partial', $response);
		}
		elseif ($request == 'add_product_info' && is_numeric($id))
		{
			if (($product = Model_Products::getProducts($id, ['sizes'])))
			{
				$response['blade_standalone'] = TRUE;
				$response['total_quantity'] = 0;

				if ( ! empty($product[$id]) && is_array($product[$id]))
				{
					$product = $product[$id];
				}

				//Sizes
				if ( ! empty($product['sizes']) && is_array(($sizes = json_decode($product['sizes'], TRUE))))
				{
					$response['sizes'] = $sizes;
					foreach($sizes as $key => $size) {
						if(!empty($size['quantity'])) {
							$response['total_quantity'] = $response['total_quantity'] + intval($size['quantity']);
						}
					}
				}

				$response['product_id'] = $id;

				return Theme::View('orders.add_product_info_partial', $response);
			}
			else
			{
				return FALSE;
			}
		}
		elseif ($request == 'products_table' && is_numeric($id))
		{
			$response                     = [];
			$response['blade_standalone'] = TRUE;

			if (($order_products = Model_Orders::getOrderProducts($id)))
			{
				$products_list           = [];
				$products_images         = [];
				$response['thumbs_path'] = Config::get('system_settings.product_public_path');
				$response['icon_size']   = Config::get('images.sm_icon_size');
				$upload_path             = Config::get('system_settings.product_upload_path');

				if ( ! empty($order_products) && is_array($order_products))
				{
					foreach ($order_products as $product)
					{
						if ( ! in_array($product['product_id'], $products_list))
						{
							$products_list[] = $product['product_id'];
						}
					}
				}

				//Fetch images
				if ( ! empty($products_list) && is_array($products_list))
				{
					if ($products = Model_Products::getProducts($products_list, ['title', 'images']))
					{
						foreach ($products as $key => $product)
						{
							if ( ! empty($product['images']))
							{
								$product['images'] = json_decode($product['images'], TRUE);

								if (is_array($product['images']))
								{
									uasort($product['images'], function ($a, $b)
									{
										if ($a == $b)
										{
											return 0;
										}

										return ($a < $b) ? -1 : 1;
									});

									reset($product['images']);
									$product['images'] = key($product['images']);
									if (file_exists(iconv("UTF-8", "WINDOWS-1251", $upload_path.$product['id'].DIRECTORY_SEPARATOR.$response['icon_size'].DIRECTORY_SEPARATOR.$product['images'])))
									{
										$products_images[$product['id']] = $product['images'];
									}
								}
							}
						}

						foreach ($order_products as $key => $product)
						{
							if (array_key_exists($product['product_id'], $products_images))
							{
								$order_products[$key]['image'] = $products_images[$product['product_id']];

								if ( ! empty($products[$product['product_id']]['title']))
								{
									$order_products[$key]['title'] = $products[$product['product_id']]['title'];
								}
							}
						}

						$response['products'] = $order_products;
					}
				}
			}

			$response['method'] = $form_method;

			return Theme::View('orders.products_list_partial', $response);

		} elseif(is_numeric($id) && $request == FALSE) {
			$response['method'] = 'locked';

			$order = Model_Orders::getOrders($id, FALSE);
			if ( ! empty($order[0]) && is_array($order[0]))
			{
				$response['order'] = $order[0];

				switch ($response['order']['status'])
				{
					case 'pending':
						$response['order']['status_color'] = 'bg-green-jungle';
						break;
					case 'confirmed':
						$response['order']['status_color'] = 'bg-yellow-casablanca';
						break;
					case 'completed':
						$response['order']['status_color'] = 'bg-blue-madison';
						break;
					case 'canceled':
						$response['order']['status_color'] = 'bg-red-thunderbird';
						break;
				}
			}
			foreach ($this->states as $state)
			{
				$response['states'][$state] = trans('orders.'.$state);
			}

			$response['pageTitle'] = trans('orders.preview_order');

			return Theme::view('orders.create_edit_order', $response);
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
	public
	function getEdit($id)
	{
		$customCSS                    = [
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
			'global/plugins/bootstrap-summernote/summernote',
			'global/plugins/select2/select2',
			'global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch',
			'global/plugins/bootstrap-modal/css/bootstrap-modal',
		];
		$customJS                     = [
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
			'global/plugins/bootbox/bootbox.min',
			'global/plugins/bootstrap-summernote/summernote.min',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'global/plugins/bootstrap-modal/js/bootstrap-modalmanager',
			'global/plugins/bootstrap-modal/js/bootstrap-modal',
		];
		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		$response['method'] = 'unlocked';
		foreach ($this->states as $state)
		{
			$response['states'][$state] = trans('orders.'.$state);
		}

		$order = Model_Orders::getOrders($id, FALSE);
		if ( ! empty($order[0]) && is_array($order[0]))
		{
			$response['order'] = $order[0];
		}

		$response['pageTitle'] = trans('orders.edit_order');

		return Theme::view('orders.create_edit_order', $response);
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
	public
	function postUpdate(Request $request, $id)
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
	 * @return \Illuminate\Http\Response
	 */
	public
	function postDestroy()
	{
		$response = [];

		if ( ! empty($_POST) && !empty($_POST['method']))
		{
			//Remove product
			if($_POST['method'] == 'product' && !empty($_POST['record_id']) && is_numeric($_POST['record_id'])) {
				$response['status']  = 'error';
				$response['message'] = trans('orders.product_not_removed');

				if(Model_Orders::removeOrderProducts(Input::get('record_id')) === TRUE) {
					$response['status']  = 'success';
					$response['message'] = trans('orders.product_removed');
				}
			}

			//Remove order
			if($_POST['method'] == 'order' && !empty($_POST['order_id'])) {
				if (Model_Orders::removeOrder($_POST['order_id']) === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('orders.removed');
				}
			}
		}

		return response()->json($response);
	}
}
