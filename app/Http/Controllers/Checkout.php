<?php

namespace App\Http\Controllers;

use App\Admin\Model_Orders;
use App\Client\Model_Main;
use App\Http\Controllers\BaseControllerClient;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use View;

class Checkout extends BaseControllerClient
{
	private $active_module = 'homepage';
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
		if (in_array('checkout', $modules))
		{
			$this->active_module = 'checkout';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	public function checkoutCompleted($id = FALSE)
	{
		$customCSS = [

		];
		$customJS  = [
		];

		$response = [
			'blade_custom_css' => $customCSS,
			'blade_custom_js'  => $customJS,
			'cart_preview'     => TRUE,
			'cart_locked'      => TRUE,
		];

		//Try to catch order id
		if (empty($id))
		{
			$id = session()->get('order_id', FALSE);

			if ( ! empty($id))
			{
				$response['new'] = TRUE;
				session()->forget('order_id');
			}
		}

		//If no order
		if (empty($id))
		{
			return redirect('/');
		}

		$order_data = Model_Orders::getOrders($id, FALSE);

		if ( ! empty(($order_data = $order_data[0])) && is_array($order_data))
		{
			$response['cart']  = ! empty($order_data['cart']) ? json_decode($order_data['cart'], TRUE) : [];
			$response['total'] = ! empty($response['cart']['total']) ? $response['cart']['total'] : 0;
			if (isset($order_data['total']))
			{
				unset($order_data['total']);
			}
			if (isset($order_data['cart']))
			{
				unset($order_data['cart']);
			}
			if (isset($response['cart']['total']))
			{
				unset($response['cart']['total']);
			}
			$response['order'] = $order_data;
		}

		foreach ($this->states as $state)
		{
			$response['states'][$state] = trans('orders.'.$state);
		}

		$response['delivery_type'] = $order_data['delivery_type'];

		if ( ! empty($response['delivery_type']))
		{

		}

		$products_to_cart = [];

		//Get product id's
		if ( ! empty($response['cart']) && is_array($response['cart']))
		{
			foreach ($response['cart'] as $key => $item)
			{
				$products_to_cart[] = $item['product_id'];
			}
		}

		// Get products data
		$response['products'] = Model_Main::getProducts($products_to_cart, ['title', 'images', 'sizes']);

		//Loop trough products data
		if ( ! empty($response['products']) && is_array($response['products']))
		{
			foreach ($response['products'] as $id => $product)
			{
				if ( ! empty($product['discount_price']))
				{
					//Calculate is discount active
					$now = time();

					if ($product['discount_start'] == '0000.00.00 00:00:00' || strtotime($product['discount_start']) <= $now)
					{
						$allow_start = TRUE;
					}
					else
					{
						$allow_start = FALSE;
					}

					if ($product['discount_end'] == '0000.00.00 00:00:00' || strtotime($product['discount_end']) <= $now)
					{
						$allow_end = TRUE;
					}
					else
					{
						$allow_end = FALSE;
					}

					if ($allow_start === TRUE && $allow_end === TRUE)
					{
						$response['products'][$id]['active_discount'] = TRUE;
					}

					if ( ! empty($response['products'][$id]['active_discount']))
					{
						$response['products'][$id]['discount'] = intval(
							(floatval($response['products'][$id]['price']) -
								floatval($response['products'][$id]['discount_price'])) / floatval($response['products'][$id]['price']) * 100
						);
					}
				}

				if ( ! empty ($response['products'][$id]['sizes']) && is_array(($response['products'][$id]['sizes'] = json_decode($response['products'][$id]['sizes'], TRUE))))
				{
					foreach ($response['products'][$id]['sizes'] as $key => $size)
					{
						if (empty($size['name']) || empty($size['quantity']))
						{
							if (isset($response['products'][$id]['sizes'][$key]))
							{
								unset($response['products'][$id]['sizes'][$key]);
							}
						}

						//Set quantity to cart items
						if ( ! empty($response['cart'][$id.'-'.$key]) && is_array($response['cart'][$id.'-'.$key]))
						{
							if ( ! empty($size['quantity']) && is_numeric($size['quantity']))
							{
								$response['cart'][$id.'-'.$key]['available_quantity'] = intval($size['quantity']);
							}
							else
							{
								$response['cart'][$id.'-'.$key]['available_quantity'] = 0;
							}
						}
					}
				}
			}
		}

		// Send products to response
		$response['products'] = self::prepareProductsForResponse($response['products']);

		$response['thumbs_path']  = Config::get('system_settings.product_public_path');
		$response['icon_size']    = Config::get('images.sm_icon_size');
		$response['sliders_path'] = Config::get('system_settings.sliders_public_path');

		return Theme::view('checkout.completed', $response);
	}

	public function checkout()
	{
		$customCSS = [

		];
		$customJS  = [
		];

		$response = [
			'blade_custom_css' => $customCSS,
			'blade_custom_js'  => $customJS,
			'cart_preview'     => TRUE,
		];

		foreach ($this->states as $state)
		{
			$response['states'][$state] = trans('orders.'.$state);
		}

		$response['cart']          = session()->get('cart');
		$response['total']         = session()->get('total');
		$response['delivery_type'] = session()->get('delivery_type');

		$products_to_cart = [];

		//Get product id's
		if ( ! empty($response['cart']) && is_array($response['cart']))
		{
			foreach ($response['cart'] as $key => $item)
			{
				$products_to_cart[] = $item['product_id'];
			}
		}

		// Get products data
		$response['products'] = Model_Main::getProducts($products_to_cart, ['title', 'images', 'sizes']);

		//Loop trough products data
		if ( ! empty($response['products']) && is_array($response['products']))
		{
			foreach ($response['products'] as $id => $product)
			{
				if ( ! empty($product['discount_price']))
				{
					//Calculate is discount active
					$now = time();

					if ($product['discount_start'] == '0000.00.00 00:00:00' || strtotime($product['discount_start']) <= $now)
					{
						$allow_start = TRUE;
					}
					else
					{
						$allow_start = FALSE;
					}

					if ($product['discount_end'] == '0000.00.00 00:00:00' || strtotime($product['discount_end']) <= $now)
					{
						$allow_end = TRUE;
					}
					else
					{
						$allow_end = FALSE;
					}

					if ($allow_start === TRUE && $allow_end === TRUE)
					{
						$response['products'][$id]['active_discount'] = TRUE;
					}

					if ( ! empty($response['products'][$id]['active_discount']))
					{
						$response['products'][$id]['discount'] = intval(
							(floatval($response['products'][$id]['price']) -
								floatval($response['products'][$id]['discount_price'])) / floatval($response['products'][$id]['price']) * 100
						);
					}
				}

				if ( ! empty ($response['products'][$id]['sizes']) && is_array(($response['products'][$id]['sizes'] = json_decode($response['products'][$id]['sizes'], TRUE))))
				{
					foreach ($response['products'][$id]['sizes'] as $key => $size)
					{
						if (empty($size['name']) || empty($size['quantity']))
						{
							if (isset($response['products'][$id]['sizes'][$key]))
							{
								unset($response['products'][$id]['sizes'][$key]);
							}
						}

						//Set quantity to cart items
						if ( ! empty($response['cart'][$id.'-'.$key]) && is_array($response['cart'][$id.'-'.$key]))
						{
							if ( ! empty($size['quantity']) && is_numeric($size['quantity']))
							{
								$response['cart'][$id.'-'.$key]['available_quantity'] = intval($size['quantity']);
							}
							else
							{
								$response['cart'][$id.'-'.$key]['available_quantity'] = 0;
							}
						}
					}
				}
			}
		}

		// Send products to response
		$response['products'] = self::prepareProductsForResponse($response['products']);

		$response['thumbs_path']  = Config::get('system_settings.product_public_path');
		$response['icon_size']    = Config::get('images.sm_icon_size');
		$response['sliders_path'] = Config::get('system_settings.sliders_public_path');

		return Theme::view('checkout.checkout', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param bool $id
	 * @param bool $method
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postStore()
	{
		$response['status']  = 'error';
		$response['message'] = trans('orders.not_saved');

		$cart = session()->get('cart');

		if ( ! empty($_POST) && ! empty($cart))
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

			if ($error === FALSE)
			{
				$total = floatval(0);
				if ( ! empty($cart) && is_array($cart))
				{
					foreach ($cart as $key => $item)
					{
						$total = floatval($total + floatval($item['subtotal']));
					}
				}
				$cart['total'] = $total;

				$data = [
					'name'          => trim(Input::get('name')),
					'last_name'     => trim(Input::get('last_name')),
					'email'         => trim(Input::get('email')),
					'phone'         => trim(Input::get('phone')),
					'address'       => trim(Input::get('address')),
					'city'          => trim(Input::get('city')),
					'state'         => trim(Input::get('state')),
					'post_code'     => trim(Input::get('post_code')),
					'comment'       => trim(Input::get('comment')),
					'status'        => 'pending',
					'delivery_type' => Input::get('delivery_type'),
					'created_at'    => date('Y-m-d H:i:s'),
					'cart'          => json_encode($cart),
				];

				unset($cart['total']);

				if (($id = Model_Orders::insertOrder($data)) > 0)
				{
					if ( ! empty($cart) && is_array($cart))
					{
						$product_ids = [];
						foreach ($cart as $key => $item)
						{
							$product_ids[] = $item['product_id'];
						}

						$orig_prices = Model_Orders::getOrigPrices($product_ids);

						foreach ($cart as $key => $item)
						{
							$data = [
								'order_id'       => $id,
								'product_id'     => $item['product_id'],
								'size'           => $item['size'],
								'quantity'       => intval($item['quantity']),
								'original_price' => ! empty($orig_prices[$item['product_id']]) ? floatval($orig_prices[$item['product_id']]) : 0,
								'price'          => floatval($item['price']),
								'total'          => floatval($item['subtotal']),
							];

							//Discount
							if ( ! empty($item['active_discount']) && $item['active_discount'] == TRUE)
							{
								$data['discount'] = $item['discount_price'];
								$data['total']    = $item['discount_price'];
							}

							//If quantity more then one
							if (intval($data['quantity']) > 1)
							{
								$data['total'] = $data['quantity'] * $data['total'];
							}

							if (Model_Orders::insertProduct($data) === TRUE)
							{
								$product = Model_Main::getProducts($item['product_id'], ['sizes']);

								if ( ! empty($product[$item['product_id']]) && is_array($product[$item['product_id']]))
								{
									$product = $product[$item['product_id']];
								}

								//Discard product sizes
								if ( ! empty($product['sizes']))
								{
									$product['sizes'] = json_decode($product['sizes'], TRUE);
								}

								foreach ($product['sizes'] as $size_name => $product_size)
								{
									if ($product_size['name'] == $item['size'] && intval($item['quantity']) > 0)
									{
										$product['sizes'][$size_name]['quantity'] = $product_size['quantity'] - $item['quantity'];
									}
								}

								$sizes = json_encode($product['sizes']);

								if (intval($item['quantity']) > 0)
								{
									$product['quantity'] = intval($product['quantity']) - intval($item['quantity']);
								}

								Model_Orders::discountProduct($product['id'], $sizes, $product['quantity']);

								session()->forget('cart');
								session()->forget('total');
								session()->forget('items_count');
								session()->put('order_id', $id);

								$response['status']  = 'success';
								$response['message'] = trans('orders.saved');
								$response['id']      = $id;
							}
						}
					}
				}
			}
		}

		return response()->json($response);
	}

	/**
	 * Prepare products for response
	 *
	 * @param $products
	 *
	 * @return array
	 */
	private
	function prepareProductsForResponse($products)
	{
		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $id => $product)
			{
				if ( ! empty($product['images']) && is_array($image = json_decode($product['images'], TRUE)))
				{
					reset($image);
					$products[$id]['image'] = key($image);
					unset($products[$id]['images']);

					if ( ! is_float($product['price']))
					{
						$products[$id]['price'] = intval($product['price']);
					}
					if ( ! is_float($product['discount_price']))
					{
						$products[$id]['discount_price'] = intval($product['discount_price']);
					}
				}
			}
		}

		return $products;
	}
}
