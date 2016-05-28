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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Watson\Sitemap\Facades\Sitemap;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use View;
use URL;

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
					uasort($image, function ($a, $b)
					{
						if ($a == $b)
						{
							return 0;
						}

						return ($a < $b) ? -1 : 1;
					});

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
		$category = Model_Main::getCategory($id);

		//If category not found - maybe it's disabled but still gotta stay hidden
		if (empty($category[$id]))
		{
			abort(404);
		}
		else
		{
			$response['category'] = $category[$id];
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
		$filter_size = (Input::get('size')) ? Input::get('size') : '';
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
			$products_with_size = Model_Client::getProductsWithSize($filter_size);
//			dd($products_with_size);
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
		if ( ! empty($response['category']['size_group']) && is_array(json_decode($response['category']['size_group'], TRUE)))
		{
			$response['sizes'] = Model_Client::getSizes(json_decode($response['category']['size_group'], TRUE));
		}

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
			}
			else
			{
				if ( ! empty($response['product']['title']))
				{
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
		if ( ! empty($response['product']['related_colors']) && is_array($response['product']['related_colors']))
		{
			$response['product']['related_colors_count'] = count($response['product']['related_colors']);
		}
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

	public function sitemap()
	{
		Sitemap::addSitemap(url('/sitemap/categories'), date('Y-m-d H:i:s'));
		Sitemap::addSitemap(url('/sitemap/products'), date('Y-m-d H:i:s'));
		Sitemap::addSitemap(url('/sitemap/pages'), date('Y-m-d H:i:s'));

		// Return the sitemap to the client.
		return Sitemap::renderSitemapIndex();
	}

	public function sitemapCategories()
	{
		$categories = Model_Main::getCategory(FALSE, ['title']);

		if ( ! empty($categories) && is_array($categories))
		{//Loop and get ID's
			foreach ($categories as $key => $category)
			{
				$categories_ids[] = $category['id'];
			}

			//Get urls
			if (($urls = Model_Client::getURL($categories_ids, 'category')))
			{
				if ( ! empty($urls) && is_array($urls))
				{
					foreach ($urls as $url)
					{
						$categories[$url['object']]['slug'] = $url['slug'];
					}
				}
			}

			foreach ($categories as $id => $data)
			{
				Sitemap::addTag(url('/'.$data['slug']), $data['updated_at']);
			}
		}

		// Return the sitemap to the client.
		return Sitemap::render();
	}

	public static function sitemapProducts()
	{
		$products = Model_Main::getProducts(FALSE, 'none', FALSE, 0, 0);

		if(!empty($products) && is_array($products))
		{
			foreach ($products as $key => $product)
			{
				Sitemap::addTag(url('/'.$product['slug']), $product['updated_at']);
			}
		}

		// Return the sitemap to the client.
		return Sitemap::render();
	}

	public static function sitemapPages()
	{
		$pages = Model_Main::getSitemapPages();

		if(!empty($pages) && is_array($pages)) {
			foreach ($pages as $key => $page) {
				Sitemap::addTag(url('/'.$page['slug']), $page['updated_at']);
			}
		}

		// Return the sitemap to the client.
		return Sitemap::render();
	}

	public function rss() {
		// create new feed
		$feed = App::make("feed");

		// cache the feed for 60 minutes (second parameter is optional)
		$feed->setCache(30, 'laravelFeedKey');// check if there is cached feed and build new only if is not

		if (!$feed->isCached())
		{
			// creating rss feed with our most recent 20 posts
			$products = Model_Main::getProducts(FALSE, ['title', 'description', 'meta_description', 'images'], FALSE, 0, 20);

			$products_copy = $products;
			$pubdate = reset($products_copy);
			$pubdate = isset($pubdate['created_at']) ? $pubdate['created_at'] : date('Y.m.d H:i:s');
			unset($products_copy);

			// set your feed's title, description, link, pubdate and language
			$feed->title = $this->system['title'];
			$feed->description = $this->system['meta_description'];
			$feed->logo = url('/images/logo.png');
			$feed->link = url('rss');
			$feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
			$feed->pubdate = $pubdate; //$posts[0]->created_at;
			$feed->lang = Lang::locale();
			$feed->setShortening(true); // true or false
			$feed->setTextLimit(255); // maximum length of description text
			$feed->ctype = "text/xml";

			$public_path = Config::get('system_settings.product_public_path');
			$full_size   = Config::get('images.full_size');

//			Loop trough products
			foreach ($products as $key => $product)
			{
				$product['meta_description'] = isset($product['meta_description']) ? $product['meta_description'] : '';
				$product['description'] = isset($product['description']) ? strip_tags($product['description']) : '';
				$product['description'] = trim(preg_replace('/\s\s+/', ' ', $product['description']));

				//Fetch images
				if(!empty($product['images']) && is_array(json_decode($product['images'], TRUE))) {
					$products[$key]['images'] = json_decode($product['images'], TRUE);

					//Order images
					uasort($products[$key]['images'], function ($a, $b)
					{
						if ($a == $b)
						{
							return 0;
						}

						return ($a < $b) ? -1 : 1;
					});

					$enclosure = [];

					//Add to feed
					foreach($products[$key]['images'] as $image => $position) {
						$enclosure[] = [
							'url' => url($public_path . $product['id'] . '/' .  $full_size . '/' . $image),
							'type' => 'image/jpeg'
						];
					}
				}
				$enclosure = reset($enclosure);

				// set item's title, author, url, pubdate, description, content, enclosure (optional)*
				$feed->add($product['title'], $this->system['title'], URL::to('/' . $product['slug']), $product['created_at'], $product['meta_description'], $product['description'], $enclosure);
			}

		}

		// first param is the feed format
		// optional: second param is cache duration (value of 0 turns off caching)
		// optional: you can set custom cache key with 3rd param as string
		return $feed->render('rss', 1, 'laravelFeedKey');
	}
}
