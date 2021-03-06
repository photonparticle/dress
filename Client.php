<?php

namespace App\Http\Controllers;

use App\Admin\Model_Pages;
use App\Client\Model_Client;
use App\Client\Model_Main;
use App\Http\Controllers\BaseControllerClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use View;

class Client extends BaseControllerClient
{
	private $active_module = 'categories';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('category', $modules))
		{
			$this->active_module = 'category';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	public function route($slug, $page = FALSE)
	{
		//Get object for load
		$object = Model_Client::getSlug($slug);

		if ($object['type'] == 'product')
		{

			/* PRODUCTS */

			$response         = self::loadProduct($object['object']);
			$response['slug'] = $slug;

			if ( ! empty($_GET['frame']) && $_GET['frame'] == TRUE)
			{
				$response['blade_standalone'] = TRUE;
				$response['frame']            = TRUE;
			}

			return Theme::view('products.product', $response);
		}
		elseif ($object['type'] == 'category')
		{

			/* CATEGORIES */

			// Get category and it's products
			$response           = self::loadCategory($object['object'], $page);
			$response['slug']   = $slug;
			$response['system'] = $this->system;

			return Theme::view('categories.category', $response);

		}
		elseif ($object['type'] == 'page')
		{

			/* PAGES */
			$response           = self::loadPage($object['object']);
			$response['system'] = $this->system;

			return Theme::view('homepage.page', $response);
		}
		else
		{
			/* 404 NOT FOUND */
			abort(404);
		}
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
				//Images
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
						$products[$id]['active_discount'] = TRUE;
					}

					if ( ! empty($products[$id]['active_discount']))
					{
						$products[$id]['discount'] = intval(
							(floatval($products[$id]['price']) -
								floatval($products[$id]['discount_price'])) / floatval($products[$id]['price']) * 100
						);
					}
				}

				//Sizes
				if ( ! empty ($products[$id]['sizes']) && is_array(($products[$id]['sizes'] = json_decode($products[$id]['sizes'], TRUE))))
				{
					foreach ($products[$id]['sizes'] as $key => $size)
					{
						if (empty($size['name']) || empty($size['quantity']))
						{
							if (isset($products[$id]['sizes'][$key]))
							{
								unset($products[$id]['sizes'][$key]);
							}
						}
					}
				}

				if ( ! empty($products[$id]['sizes']) && is_array($products[$id]['sizes']))
				{
					$sizes = [];
					foreach ($products[$id]['sizes'] as $key => $size)
					{
						if ( ! empty($size['quantity']))
						{
							$sizes[] = $key;
						}
					}

					if ( ! empty($sizes) && is_array($sizes))
					{
						$products[$id]['available_sizes'] = implode(', ', $sizes);
					}
				}
			}
		}

		return $products;
	}

	private function prepareSliders($sliders)
	{
		if ( ! empty($sliders) && is_array($sliders))
		{
			foreach ($sliders as $key => $slider)
			{
				if ( ! empty($slider['slides']) && ! empty($slider['slides_positions']))
				{
					$slider['slides']           = json_decode($slider['slides'], TRUE);
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

					$sliders[$key] = $slider;
				}
			}

			return $sliders;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param int $id
	 * @param $page
	 *
	 * @return array
	 */
	private function loadCategory($id, $page)
	{
		$response = [];

		//Get category
		$category                   = Model_Main::getCategory($id);

		//If category not found - maybe it's disabled but still gotta stay hidden
		if(empty($category[$id])) {
			abort(404);
		} else {
			$response['category']       = $category[$id];
		}


		$response['all_categories'] = $this->categories['all'];
		$response['breadcrumbs']    = self::generateCategoryBreadcrumbs($category[$id]);

		//SEO
		if ( ! empty($category[$id]['title']))
		{
			View::share('page_title', $category[$id]['title']);
		}
		if ( ! empty($category[$id]['meta_description']))
		{
			View::share('page_meta_description', $category[$id]['meta_description']);
		}
		if ( ! empty($category[$id]['meta_keywords']))
		{
			View::share('page_meta_keywords', $category[$id]['meta_keywords']);
		}

		// Order category products
		if ( ! empty(Input::get('order_by')))
		{
			$order_by = Input::get('order_by');
		}
		else
		{
			$order_by = FALSE;
		}

		if ( ! empty($order_by) && in_array($order_by, ['newest', 'discounted', 'price_asc', 'price_desc']))
		{
			$order_by             = Input::get('order_by');
			$response['order_by'] = $order_by;
			session(['order_by' => $order_by]);
		}
		else
		{
			if ( ! empty(session('order_by')))
			{
				$order_by             = session('order_by');
				$response['order_by'] = $order_by;
			}
		}

		//Get products
		$response['products'] = Model_Main::getProductsToCategoryPage($id, $page, $this->system['quantity'], $order_by);
		$products_to_category = Model_Main::getProductsToCategoryId($id);
		$total_products       = count($products_to_category);
		//Filters

		//Get submitted filters
		$filter_size      = (Input::get('size')) ? Input::get('size') : '';
//		$filter_material  = (Input::get('material')) ? Input::get('material') : '';
		$filter_color     = (Input::get('color')) ? Input::get('color') : '';
		$filter_price_min = (Input::get('price_min')) ? Input::get('price_min') : '';
		$filter_price_max = (Input::get('price_max')) ? Input::get('price_max') : '';

		//If there are no submitted filters - try find them in SESSION
		if (empty($_POST))
		{
			if ( ! empty(session('filter_size')))
			{
				$filter_size = session('filter_size');
			}

//			if ( ! empty(session('filter_material')))
//			{
//				$filter_material = session('filter_material');
//			}

			if ( ! empty(session('filter_color')))
			{
				$filter_color = session('filter_color');
			}

			if ( ! empty(session('price_min')))
			{
				$filter_price_min = session('price_min');
			}

			if ( ! empty(session('price_max')))
			{
				$filter_price_max = session('price_max');
			}
		}

		//Store filters inside session
		session(['filter_size' => $filter_size]);
//		session(['filter_material' => $filter_material]);
		session(['filter_color' => $filter_color]);
		session(['price_min' => $filter_price_min]);
		session(['price_max' => $filter_price_max]);

		if ( ! empty($filter_size))
		{
			$products_with_size         = Model_Client::getProductsWithSize($filter_size);
			$products_without_size      = array_diff($response['products'], $products_with_size);
			$response['products']       = array_diff($response['products'], $products_without_size);
			$total_products             = count($response['products']) - count($products_without_size);
			$response['filter']['size'] = $filter_size;
		}

//		if ( ! empty($filter_material))
//		{
//			$products_with_material         = Model_Client::getProductsWithMaterial($filter_material);
//			$products_without_material      = array_diff($response['products'], $products_with_material);
//			$response['products']           = array_diff($response['products'], $products_without_material);
//			$total_products                 = count($response['products']) - count($products_without_material);
//			$response['filter']['material'] = $filter_material;
//		}

		if ( ! empty($filter_color))
		{
			$products_with_color         = Model_Client::getProductsWithColor($filter_color);
			$products_without_color      = array_diff($response['products'], $products_with_color);
			$response['products']        = array_diff($response['products'], $products_without_color);
			$total_products              = count(array_diff($response['products'], $products_without_color));
			$response['filter']['color'] = $filter_color;
		}

		if ( ! empty($filter_price_min) && ! empty($filter_price_max) && (intval($filter_price_min) > 1 || intval($filter_price_max) < 100))
		{
			$products_in_price               = Model_Client::getProductsWithPrice($filter_price_min, $filter_price_max);
			$products_outside_price          = array_diff($response['products'], $products_in_price);
			$response['products']            = array_diff($response['products'], $products_outside_price);
			$total_products                  = count($response['products']) - count($products_outside_price);
			$response['filter']['price_min'] = $filter_price_min;
			$response['filter']['price_max'] = $filter_price_max;
		}

		//Products to render
		$response['products_to_render'] = $response['products'];
		// Get Carousels
		$response['carousels'] = Model_Main::getCarousels($this->active_module, $id);

		//Send carousels to response and add products to fetch queue
		if ( ! empty($response['carousels']) && is_array($response['carousels']))
		{
			foreach ($response['carousels'] as $key => $carousel)
			{
				if ( ! empty($carousel['products']))
				{
					$response['carousels'][$key]['products'] = explode(', ', $carousel['products']);
					$response['products']                    = array_merge($response['products'], $response['carousels'][$key]['products']);
				}
			}
		}

		//Get upcoming product
		$response['upcoming'] = Model_Client::getUpcomingProduct();
		if ( ! empty($response['upcoming']['product_id']))
		{
			if ( ! array_search($response['upcoming']['product_id'], $response['products']))
			{
				$response['products'][] = $response['upcoming']['product_id'];
			}

			if ( ! empty($response['upcoming']['date']))
			{
				$response['upcoming']['date'] = date('Y/m/d', strtotime($response['upcoming']['date']));
			}
		}

		// Get products data
		$response['products'] = Model_Main::getProducts($response['products'], ['title', 'images', 'sizes', 'description']);

		// Send products to response
		$response['products'] = self::prepareProductsForResponse($response['products']);

		// Get Sliders
		$response['sliders'] = Model_Main::getSliders($this->active_module, $id);

		// Send sliders to response
		$response['sliders'] = self::prepareSliders($response['sliders']);

		// Get Sizes
		$response['sizes'] = Model_Client::getSizes();

		// Get Colors
		$response['colors'] = Model_Client::getColors();

		// Get Materials
//		$response['materials'] = Model_Client::getMaterials();

		// Define other needable variables
		$response['thumbs_path']  = Config::get('system_settings.product_public_path');
		$response['icon_size']    = Config::get('images.sm_icon_size');
		$response['sliders_path'] = Config::get('system_settings.sliders_public_path');

		//Get current page
		if (empty($page) or $page < 1)
		{
			$response['current_page'] = 1;
		}
		else
		{
			$response['current_page'] = $page;
		}

		//Calculate total pages
		$response['total_pages'] = intval($total_products / $this->system['quantity']) + 1;
dd($response);

		return $response;

	}

	private function generateCategoryBreadcrumbs($category)
	{
		$id       = $category['id'];
		$lvl      = $category['level'];
		$parent   = $category['parent_id'];
		$response = [];

		if ($lvl == 0)
		{
			$response[] = $id;
		}
		elseif ($lvl == 1)
		{
			$response[] = $parent;
			$response[] = $id;
		}
		elseif ($lvl == 2)
		{
			if ( ! empty($this->categories['all']) && is_array($this->categories['all']))
			{
				foreach ($this->categories['all'] as $category)
				{
					if ($category['id'] == $parent)
					{
						$response[] = $category['parent_id'];
					}
				}
			}

			$response[] = $parent;
			$response[] = $id;
		}

		return $response;
	}

	private function loadProduct($id)
	{
		$response = [];
		$product  = Model_Main::getProducts($id);

		//Breadcrumbs
		$response['all_categories'] = $this->categories['all'];
		if ( ! empty($product[$id]['main_category']) && $this->categories['all'][$product[$id]['main_category']])
		{
			$response['breadcrumbs'] = self::generateCategoryBreadcrumbs($this->categories['all'][$product[$id]['main_category']]);
		}

		//Prepare product for response
		if ( ! empty($product[$id]))
		{
			$response['product'] = $product[$id];

			if ( ! empty($response['product']['page_title']))
			{
				View::share('page_title', $response['product']['page_title']);
			} else {
				if(!empty($response['product']['title'])) {
					View::share('page_title', $response['product']['title']);
				}
			}
			if ( ! empty($response['product']['meta_description']))
			{
				View::share('page_meta_description', $response['product']['meta_description']);
			}
			if ( ! empty($response['product']['meta_keywords']))
			{
				View::share('page_meta_keywords', $response['product']['meta_keywords']);
			}

			if ( ! empty($response['product']['discount_price']))
			{
				//Calculate is discount active
				$now = time();

				if ($response['product']['discount_start'] == '0000.00.00 00:00:00' || strtotime($response['product']['discount_start']) <= $now)
				{
					$allow_start = TRUE;
				}
				else
				{
					$allow_start = FALSE;
				}

				if ($response['product']['discount_end'] == '0000.00.00 00:00:00' || strtotime($response['product']['discount_end']) <= $now)
				{
					$allow_end = TRUE;
				}
				else
				{
					$allow_end = FALSE;
				}

				if ($allow_start === TRUE && $allow_end === TRUE)
				{
					$response['product']['active_discount'] = TRUE;
				}
			}

			if ( ! empty ($response['product']['sizes']) && is_array(($response['product']['sizes'] = json_decode($response['product']['sizes'], TRUE))))
			{
				foreach ($response['product']['sizes'] as $key => $size)
				{
					if (empty($size['name']) || empty($size['quantity']))
					{
						if (isset($response['product']['sizes'][$key]))
						{
							unset($response['product']['sizes'][$key]);
						}
					}
				}
			}
		}

		//Product discount percentage
		if ( ! empty($response['product']['active_discount']))
		{
			$response['product']['discount'] = intval(
				(floatval($response['product']['price']) -
					floatval($response['product']['discount_price'])) / floatval($response['product']['price']) * 100
			);
		}

		//Images
		if ( ! empty($response['product']['images']))
		{
			$response['product']['images'] = json_decode($response['product']['images'], TRUE);

			if (is_array($response['product']['images']))
			{
				$response['product_thumbs_path'] = Config::get('system_settings.product_public_path').$id.'/'.Config::get('images.sm_icon_size').'/';
				$response['images_path']         = Config::get('system_settings.product_public_path').$id.'/'.Config::get('images.full_size').'/';
				$response['md_path']             = Config::get('system_settings.product_public_path').$id.'/'.Config::get('images.md_icon_size').'/';
				uasort($response['product']['images'], function ($a, $b)
				{
					if ($a == $b)
					{
						return 0;
					}

					return ($a < $b) ? -1 : 1;
				});
			}
		}

		//Tags
		$response['product']['tags'] = Model_Main::getTags($id);

		//Manufacturer
		$response['product']['manufacturer'] = Model_Main::getManufacturer($id);

		//Material
		$response['product']['material'] = Model_Main::getMaterial($id);
		if ( ! empty($response['product']['material'][0]))
		{
			$response['product']['material'] = $response['product']['material'][0];
		}

		//Color
		$response['product']['related_colors'] = Model_Main::getColor($id);
		if ( ! empty($response['product']['related_colors']))
		{
			$response['product']['related_colors'] = implode(', ', $response['product']['related_colors']);
		}

		//Related products
		if ( ! empty($response['product']['related_products']) && is_array(json_decode($response['product']['related_products'], TRUE)))
		{
			$response['carousel']['products'] = json_decode($response['product']['related_products'], TRUE);
		}
		else
		{
			if ( ! empty($response['product']['main_category']))
			{
				$response['carousel']['products'] = Model_Main::getSimilarProducts($response['product']['main_category']);
			}
		}

		if ( ! empty($response['carousel']['products']))
		{
			$response['products'] = $response['carousel']['products'];
		}

		//Get upcoming product
		$response['upcoming'] = Model_Client::getUpcomingProduct();
		if ( ! empty($response['upcoming']['product_id']))
		{
			$response['products'][] = $response['upcoming']['product_id'];

			if ( ! empty($response['upcoming']['date']))
			{
				$response['upcoming']['date'] = date('Y/m/d', strtotime($response['upcoming']['date']));
			}
		}
		$recent = Model_Main::getNewestProducts(3, $id, TRUE);

		if ( ! empty($recent))
		{
			$response['recent'] = $recent;
			array_merge($response['products'], $recent);
		}

		$response['icon_size']   = Config::get('images.sm_icon_size');
		$response['thumbs_path'] = Config::get('system_settings.product_public_path');

		$response['carousel']['title'] = trans('client.similar_products');

		// Get products data
		$response['products'] = Model_Main::getProducts($response['products'], ['title', 'images', 'sizes', 'description']);

		// Send products to response
		$response['products'] = self::prepareProductsForResponse($response['products']);

		//Check dimensions table
		if ( ! empty($response['product']['dimensions_table']))
		{
			$response['product']['dimensions_table'] = trim($response['product']['dimensions_table']);
		}

		return $response;
	}

	private function loadPage($id)
	{
		$response = Model_Pages::getPage($id);

		if ( ! empty($response[0]))
		{
			$response = $response[0];
		}

		//SEO
		if ( ! empty($response['title']))
		{
			View::share('page_title', $response['title']);
		}
		if ( ! empty($response['meta_description']))
		{
			View::share('page_meta_description', $response['meta_description']);
		}
		if ( ! empty($response['meta_keywords']))
		{
			View::share('page_meta_keywords', $response['meta_keywords']);
		}

		return $response;
	}
}
