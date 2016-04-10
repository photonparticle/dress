<?php

namespace App\Http\Controllers;

use App\Client\Model_Main;
use App\Http\Controllers\BaseControllerClient;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Config;
use View;

class Homepage extends BaseControllerClient
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

	public function homepage()
	{
		$customCSS = [

		];
		$customJS  = [
		];

		$response = [
			'blade_custom_css' => $customCSS,
			'blade_custom_js'  => $customJS,
		];

		$response['thumbs_path'] = Config::get('system_settings.product_public_path');
		$response['icon_size']   = Config::get('images.sm_icon_size');
		$response['sliders_path'] = Config::get('system_settings.sliders_public_path');

		$products = [];

		/* Load Carousels */
		$response['carousels'] = Model_Main::getCarousels($this->active_module);

		if(!empty($response['carousels']) && is_array($response['carousels'])) {
			foreach($response['carousels'] as $key => $carousel) {
				if(!empty($carousel['products'])) {
					$response['carousels'][$key]['products'] = explode(', ', $carousel['products']);
					$products = array_merge($products, $response['carousels'][$key]['products']);
				}
			}
		}

		/* Get Products */
		$products = Model_Main::getProducts($products, ['title', 'images']);

		//Prepare products for response
		if(!empty($products) && is_array($products)) {
			foreach($products as $id => $product) {
				if(!empty($product['images']) && is_array($image = json_decode($product['images'], TRUE))) {
					reset($image);
					$products[$id]['image'] = key($image);
					unset($products[$id]['images']);

					if(!is_float($product['price']))
					{
						$product['price'] = intval($product['price']);
					}
					if(!is_float($product['discount_price']))
					{
						$product['discount_price'] = intval($product['discount_price']);
					}
				}
			}
		}

		/* Send products to response */
		$response['products'] = $products;
		unset($products);

		/* Get Sliders */
		$sliders = Model_Main::getSliders('homepage');

		if(!empty($sliders) && is_array($sliders)) {
			foreach($sliders as $key => $slider) {
				if(!empty($slider['slides']) && !empty($slider['slides_positions'])) {
					$slider['slides'] = json_decode($slider['slides'], TRUE);
					$slider['slides_positions'] = json_decode($slider['slides_positions'], TRUE);

					//Sort by position
					if ( ! empty($slider['slides_positions']) && is_array($slider['slides_positions']))
					{
						uasort($slider['slides_positions'], function ($a, $b)
						{
							if ($a == $b)
							{
								return 0;
							}

							return ($a < $b) ? -1 : 1;
						});
					}

					$response['sliders'][$key] = $slider;
				}
			}
		}

//		dd($response['sliders']);

		return Theme::view('homepage.homepage', $response);
	}
}
