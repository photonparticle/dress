<?php

namespace App\Http\Controllers;

use App\Client\Model_Main;
use App\Http\Controllers\BaseControllerClient;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use View;

class Cart extends BaseControllerClient
{
	private $active_module = 'homepage';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('homepage', $modules))
		{
			$this->active_module = 'homepage';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	public function cart()
	{
//		session()->flush();
		$customCSS = [

		];
		$customJS  = [
		];

		$response         = [
			'blade_custom_css' => $customCSS,
			'blade_custom_js'  => $customJS,
		];
		$response['cart'] = session()->get('cart');
		$response['total'] = session()->get('total');

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

		return Theme::view('checkout.cart', $response);
	}

	public function add()
	{
		//If have product to add
		if (
			! empty(($product_id = Input::get('product_id'))) &&
			! empty(($size = Input::get('size'))) &&
			! empty(($quantity = Input::get('quantity'))) &&
			! empty(($price = Input::get('price')))
		)
		{
			//Get cart from session
			$cart = session()->pull('cart');
			$total = session()->pull('total');
			if(empty($total)) {
				$total = 0;
			}

			if (empty($cart))
			{
				$cart = [];
			}

			//Get product
			$product = [
				'product_id' => $product_id,
				'size'       => $size,
				'quantity'   => $quantity,
				'price'      => $price,
				'subtotal'   => floatval($price) * intval($quantity),
			];

			//If product have discount
			if (
				! empty(($active_discount = Input::get('active_discount'))) &&
				! empty(($discount_price = Input::get('discount_price'))) &&
				! empty(($discount = Input::get('discount')))
			)
			{
				$product['active_discount'] = TRUE;
				$product['discount_price']  = $discount_price;
				$product['discount']        = $discount;
				$product['subtotal'] = floatval($discount_price) * intval($quantity);
			}

			if(!empty($product['subtotal'])) {
				$total = $total + $product['subtotal'];
			}

			//Unset old product with that id
			if ( ! empty($cart[$product_id.'-'.$size]))
			{
				unset($cart[$product_id.'-'.$size]);
			}

			//Add product to cart
			$cart[$product_id.'-'.$size] = $product;

			//Set cart at session
			session()->put(['cart' => $cart, 'count_items' => count($cart), 'total' => $total]);
			session()->migrate();

			return response()->json(['success' => TRUE]);
		}
		else
		{
			return response()->json(['success' => FALSE]);
		}
	}

	public function remove()
	{
		$success = FALSE;
		if ( ! empty(($key = Input::get('key'))))
		{
			$cart = session()->pull('cart');
			$total = session()->pull('count_items');

			if ( ! empty($cart[$key]))
			{
				if(!empty($cart[$key]['subtotal'])) {
					$total = $total - $cart[$key]['subtotal'];
				}

				unset($cart[$key]);
				$success = TRUE;
			}

			session()->put(['cart' => $cart, 'count_items' => count($cart), 'total' => $total]);
			session()->migrate();
		}

		return response()->json(['success' => $success]);
	}

	/**
	 * Prepare products for response
	 *
	 * @param $products
	 *
	 * @return array
	 */
	private function prepareProductsForResponse($products)
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
