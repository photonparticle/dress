<?php

namespace App\Client;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Main extends Model
{
	/**
	 * Fetch system settings
	 *
	 * @param bool $object - int|array - FALSE for to get all pages
	 * @param array $objects
	 * @param bool $for_list
	 *
	 * @return array
	 */
	public static function getSetting($object = FALSE, $objects = [], $for_list = FALSE)
	{
		$settings = DB::table('system_settings')
					  ->orderBy('object', 'ASC');

		if ( ! empty($objects) && is_array($objects))
		{
			$settings = $settings->select($objects);
		}

		if (is_array($object))
		{
			$settings = $settings->whereIn('id', $object);
		}
		elseif (is_string($object) || is_int($object))
		{
			$settings = $settings->where('id', '=', $object);
		}

		$settings = $settings->get();

		//Rebuild array
		$response = [];

		if ( ! empty($settings) && is_array($settings))
		{
			foreach ($settings as $setting)
			{
				$response[$setting['object']] = [
					'value' => $setting[$setting['type']],
					'type'  => $setting['type'],
				];
			}
		}

		if ($for_list === TRUE)
		{
			if ( ! empty($response) && is_array($response))
			{
				foreach ($response as $name => $setting)
				{
					unset($response[$name]);
					$response[$name] = $setting['value'];
				}
			}
		}

		return $response;
	}

	/**
	 * @param bool $category_id - int|array - FALSE for to get all categories
	 * @param array $objects
	 *
	 * @return array
	 */
	public static function getCategory($category_id = FALSE, $objects = [], $menu_visibility = FALSE)
	{
		$categories     = DB::table('categories')
							->orderBy('position', 'ASC');
		$response       = [];
		$categories_ids = [];

		if (is_array($category_id))
		{
			$categories = $categories->whereIn('id', $category_id);
		}
		elseif (is_string($category_id) || is_int($category_id))
		{
			$categories = $categories->where('id', '=', $category_id);
		}

		if ( ! empty($menu_visibility))
		{
			$categories = $categories->where('menu_visibility', '=', 1);
		}

		$categories = $categories->where('active', 1)
								 ->get();

		if ( ! empty($categories) && is_array($categories))
		{
			foreach ($categories as $key => $category)
			{
				if ( ! empty($category) && is_array($category))
				{
					$categories_ids[]          = $category['id'];
					$response[$category['id']] = $category;
				}
			}
		}

		if (is_array(($category_objects = self::getCategoryObjects($categories_ids, $objects))))
		{
			foreach ($category_objects as $key => $objects)
			{
				if ( ! empty($objects) && is_array($objects))
				{
					foreach ($objects as $obj_key => $object)
					{
						$response[$key][$obj_key] = $object;
					}
				}
			}
		}

		return $response;
	}

	/**
	 * @param $category_id
	 * @param array $objects
	 *
	 * @return array
	 */
	private static function getCategoryObjects($category_id, $objects = array())
	{
		$response = [];
		$result   = DB::table('categories_data');

		if (is_array($category_id))
		{
			$result = $result->whereIn('category_id', $category_id);
		}
		elseif (is_string($category_id) || is_int($category_id))
		{
			$result = $result->where('category_id', '=', $category_id);
		}

		if ( ! empty($objects) && is_array($objects))
		{
			$result = $result->whereIn('object', $objects);
		}

		$result = $result->get();

		if ( ! empty($result) && is_array($result))
		{
			foreach ($result as $key => $value)
			{
				if ( ! empty($value['object']) && ! empty($value['type']) && ! empty($value[$value['type']]))
				{
					$response[$value['category_id']][$value['object']] = $value[$value['type']];
				}
			}
		}

		return $response;
	}

	/**
	 * @param int $limit
	 *
	 * @return array
	 */
	public static function getNewestProducts($limit = 20, $skip_product = FALSE, $available = FALSE)
	{
		$response = [];
		$products = DB::table('products')
					  ->select('id')
					  ->orderBy('created_at', 'desc')
					  ->orderBy('position', 'desc')
					  ->where('available', '=', 1)
					  ->where('active', '=', 1);

		if ( ! empty($available))
		{
			$products = $products->where('quantity', '>', 0);
		}

		if ( ! empty($skip_product) && is_numeric($skip_product))
		{
			$products = $products->where('id', '!=', $skip_product);
		}

		$products = $products
			->skip(0)->take($limit)->get();

		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $product)
			{
				if ( ! empty($product['id']))
				{
					$response[] = $product['id'];
				}
			}
		}

		return $response;
	}

	/**
	 * @param int $limit
	 *
	 * @return array
	 */
	public static function getDiscountedProducts($limit = 20)
	{
		$response = [];
		$products = DB::table('products')
					  ->select('id')
					  ->where('discount_price', '>', 0)
					  ->where('active', '=', 1)
					  ->where('available', '=', 1)
					  ->orderBy('created_at', 'desc')
					  ->orderBy('position', 'desc')
					  ->skip(0)->take($limit)->get();

		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $product)
			{
				if ( ! empty($product['id']))
				{
					$response[] = $product['id'];
				}
			}
		}

		return $response;
	}

	/**
	 * Returns array of all products
	 *
	 * @param bool $product_id - int or array - FALSE for none
	 * @param array $objects
	 *
	 * @return array
	 */
	public static function getProducts($product_id = FALSE, $objects = [], $for_list = FALSE, $skip = 0, $limit = 0, $order_by = FALSE)
	{
		$products = DB::table('products');

		$response        = [];
		$loaded_products = [];

		if ($for_list === TRUE)
		{
			$products = $products->select(['id']);
		}

		if (is_array($product_id))
		{
			$products = $products->whereIn('id', $product_id);
		}
		elseif (is_string($product_id) || is_int($product_id))
		{
			$products = $products->where('id', '=', $product_id);
		}

		if ($limit > 0)
		{
			$products = $products->skip($skip)->take($limit);
		}

		$products = $products->where('active', '=', '1')
							 ->orderBy('available', 'DESC');

		if ($order_by == 'discounted')
		{
			$products = $products->orderBy('discount_price', 'DESC');
		}
		elseif ($order_by == 'price_asc')
		{
			$products = $products->orderBy('price', 'ASC');
		}
		elseif ($order_by == 'price_desc')
		{
			$products = $products->orderBy('price', 'DESC');
		}

		if (empty($order_by) || (!empty($order_by) && $order_by == 'newest'))
		{
			$products = $products->orderBy('created_at', 'DESC')
								 ->orderBy('position', 'ASC')
								 ->get();
		}
		else
		{
			$products = $products->get();
		}

		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $key => $product)
			{
				if ( ! empty($product) && is_array($product))
				{
					$response[$product['id']] = $product;
					$loaded_products[]        = $product['id'];
				}
			}
		}

		if ($objects != 'none' && is_array(($product_objects = self::getProductObjects($loaded_products, $objects))))
		{
			foreach ($product_objects as $key => $objects)
			{
				if ( ! empty($objects) && is_array($objects))
				{
					foreach ($objects as $obj_key => $object)
					{

						$response[$key][$obj_key] = $object;
					}
				}
			}
		}

		if ( ! empty($loaded_products) && is_array($loaded_products))
		{
			$slugs = self::getProductsSlug($loaded_products);

			if ( ! empty($slugs) && is_array($slugs))
			{
				foreach ($slugs as $product_id => $slug)
				{
					$response[$product_id]['slug'] = $slug;
				}
			}
		}

		return $response;
	}

	private static function getProductsSlug($ids)
	{
		$slugs    = DB::table('seo_url')
					  ->select(['slug', 'object'])
					  ->where('type', '=', 'product')
					  ->whereIn('object', $ids)
					  ->get();
		$response = [];

		if ( ! empty($slugs) && is_array($slugs))
		{
			foreach ($slugs as $data)
			{
				$response[$data['object']] = $data['slug'];
			}
		}

		return $response;
	}

	/**
	 * @param $product_id
	 * @param array $objects
	 *
	 * @return array
	 */
	private static function getProductObjects($product_id, $objects = array())
	{
		$response = [];
		$result   = DB::table('products_data');

		if (is_array($product_id))
		{
			$result = $result->whereIn('product_id', $product_id);
		}
		elseif (is_string($product_id) || is_int($product_id))
		{
			$result = $result->where('product_id', '=', $product_id);
		}

		if ( ! empty($objects) && is_array($objects))
		{
			$result = $result->whereIn('object', $objects);
		}

		$result = $result->get();

		if ( ! empty($result) && is_array($result))
		{
			foreach ($result as $key => $value)
			{
				if ( ! empty($value['object']) && ! empty($value['type']) && ! empty($value[$value['type']]))
				{
					$response[$value['product_id']][$value['object']] = $value[$value['type']];
				}
			}
		}

		return $response;
	}

	/**
	 * @param $category_id
	 * @param $page
	 * @param int $products_per_page
	 * @param bool $order_by
	 *
	 * @return array
	 */
	public static function getProductsToCategoryPage($category_id, $page, $products_per_page = 16, $order_by = FALSE)
	{
		$products             = DB::table('product_to_category')
								  ->select('product_id')
								  ->where('category_id', '=', $category_id)
								  ->orderBy('product_id', 'DESC')
								  ->get();
		$response             = [];
		$products_to_load     = [];
		$products_to_category = [];

		//Calculate skipped results
		if ( ! empty($page) && $page > 1)
		{
			$skip = ($page - 1) * $products_per_page;
		}
		else
		{
			$skip = 0;
		}

		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $result)
			{
				$products_to_category[] = $result['product_id'];
			}
		}

		if ( ! empty($products_to_category) && is_array($products_to_category))
		{
			$products_to_load = self::getProducts($products_to_category, 'none', TRUE, $skip, $products_per_page, $order_by);
		}

		if ( ! empty($products_to_load) && is_array($products_to_load))
		{
			foreach ($products_to_load as $product)
			{
				$response[] = $product['id'];
			}
		}

		return $response;
	}

	public static function getProductsToCategoryId($category_id)
	{
		$ids      = DB::table('product_to_category')
					  ->join('products', 'product_to_category.product_id', '=', 'products.id')
					  ->select('products.id')
					  ->where('product_to_category.category_id', '=', $category_id)
					  ->where('products.active', '=', 1)
					  ->get();
		$response = [];

		if ( ! empty($ids) && is_array($ids))
		{
			foreach ($ids as $data)
			{
				$response[] = $data['id'];
			}
		}

		return $response;
	}

	/**
	 * @param bool $type
	 * @param bool $target
	 *
	 * @return array
	 */
	public static function getSliders($type, $target = FALSE)
	{
		if ( ! empty($type) && in_array($type, ['homepage', 'categories', 'pages']))
		{
			$sliders = DB::table('sliders')
						 ->select(['slides', 'slides_positions', 'dir', 'position']);

			if ($type != FALSE && in_array($type, ['homepage', 'categories', 'pages']))
			{
				$sliders = $sliders->where('type', '=', $type);
			}

			if ($target != FALSE && intval($target) > 0)
			{
				$sliders = $sliders->where(function ($query) use ($target)
				{
					$query->where('target', '=', intval($target))->orWhere('target', '=', '');
				});
			}

			$sliders = $sliders->where(function ($query)
			{
				$now = date('Y-m-d H:i:s');
				$query->where('active_from', '<=', $now)->orWhere('active_from', '=', '')->orWhere('active_from', '=', '0000-00-00 00:00:00');
			});

			$sliders = $sliders->where(function ($query)
			{
				$now = date('Y-m-d H:i:s');
				$query->where('active_to', '>=', $now)->orWhere('active_to', '=', '')->orWhere('active_to', '=', '0000-00-00 00:00:00');
			});

			$sliders = $sliders
				->orderBy('position', 'ASC')
				->get();

			return $sliders;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param $type
	 * @param bool $target
	 *
	 * @return array|bool
	 */
	public static function getCarousels($type, $target = FALSE)
	{
		if ( ! empty($type) && in_array($type, ['homepage', 'categories', 'pages']))
		{
			$now       = date('Y-m-d H:i:s');
			$carousels = DB::table('carousels')
						   ->where('type', '=', $type);

			if ($target != FALSE && intval($target) > 0)
			{
				$carousels = $carousels->where(function ($query) use ($target)
				{
					$query->where('target', '=', intval($target))->orWhere('target', '=', '');
				});
			}

			$carousels = $carousels->where(function ($query)
			{
				$now = date('Y-m-d H:i:s');
				$query->where('active_from', '<=', $now)->orWhere('active_from', '=', '')->orWhere('active_from', '=', '0000-00-00 00:00:00');
			});

			$carousels = $carousels->where(function ($query)
			{
				$now = date('Y-m-d H:i:s');
				$query->where('active_to', '>=', $now)->orWhere('active_to', '=', '')->orWhere('active_to', '=', '0000-00-00 00:00:00');
			});

			$carousels = $carousels->orderBy('position', 'ASC')
								   ->get();

			if ( ! empty($carousels) && is_array($carousels))
			{
				foreach ($carousels as $key => $carousel)
				{
					//If type is newest or discounted fetch products ID's
					if ($carousel['products'] == 'newest')
					{
						$carousels[$key]['products'] = implode(', ', self::getNewestProducts($carousel['max_products']));
					}
					elseif ($carousel['products'] == 'discounted')
					{
						$carousels[$key]['products'] = implode(', ', self::getDiscountedProducts($carousel['max_products']));
					}
				}
			}

			return $carousels;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param $product_id
	 *
	 * @return bool
	 */
	public static function getTags($product_id)
	{
		if ( ! empty($product_id))
		{
			$tags = DB::table('product_to_tag')
					  ->select(['tags.title'])
					  ->join('tags', 'product_to_tag.tag_id', '=', 'tags.id')
					  ->where('product_to_tag.product_id', '=', $product_id)
					  ->orderBy('product_to_tag.id', 'ASC')
					  ->get();

			if ( ! empty($tags) && is_array($tags))
			{
				foreach ($tags as $key => $value)
				{
					$response[] = $value['title'];
				}

				return $response;
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
	 * @param $product_id
	 *
	 * @return bool
	 */
	public static function getManufacturer($product_id)
	{
		if ( ! empty($product_id))
		{
			$response = DB::table('product_to_manufacturer')
						  ->select(['manufacturers.title'])
						  ->join('manufacturers', 'product_to_manufacturer.manufacturer_id', '=', 'manufacturers.id')
						  ->where('product_to_manufacturer.product_id', '=', $product_id)
						  ->get();

			if ($response)
			{
				return $response[0]['title'];
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
	 * @param $product_id
	 *
	 * @return bool
	 */
	public static function getMaterial($product_id)
	{
		if ( ! empty($product_id) && $product_id > 0)
		{
			$query = DB::table('product_to_material')
					   ->select('product_to_material.material_id')
					   ->where('product_to_material.product_id', '=', $product_id)
					   ->orderBy('product_to_material.id', 'ASC')
					   ->get();

			if ($query && is_array($query))
			{
				$response = [];
				foreach ($query as $key => $value)
				{
					$response[] = $value['material_id'];
				}

				return $response;
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
	 * @param $product_id
	 *
	 * @return bool
	 */
	public static function getColor($product_id)
	{
		if ( ! empty($product_id) && $product_id > 0)
		{
			$query = DB::table('product_to_color')
					   ->select('colors.title')
					   ->join('colors', 'product_to_color.color_id', '=', 'colors.id')
					   ->where('product_to_color.product_id', '=', $product_id)
					   ->orderBy('product_to_color.id', 'ASC')
					   ->get();

			if ($query && is_array($query))
			{
				$response = [];
				foreach ($query as $key => $value)
				{
					$response[] = $value['title'];
				}

				return $response;
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
	 * @param $category_id
	 *
	 * @return array
	 */
	public static function getSimilarProducts($category_id)
	{
		$results = DB::table('product_to_category')
					 ->select('product_id')
					 ->where('category_id', '=', $category_id)
					 ->orderBy('id', 'DESC')
					 ->skip(0)->take(8)->get();

		$products = [];

		if ( ! empty($results) && is_array($results))
		{
			foreach ($results as $result)
			{
				$products[] = $result['product_id'];
			}
		}

		return $products;
	}

	public static function getFooterPages()
	{
		return DB::table('pages')
				 ->select(['pages.title', 'seo_url.slug'])
				 ->join('seo_url', 'seo_url.object', '=', 'pages.id')
				 ->where('pages.show_footer', '=', 1)
				 ->where('pages.active', '=', 1)
				 ->where('seo_url.type', '=', 'page')
				 ->orderBy('pages.footer_position', 'ASC')
				 ->get();
	}

	public static function getNavPages()
	{
		return DB::table('pages')
				 ->select(['pages.title', 'seo_url.slug'])
				 ->join('seo_url', 'seo_url.object', '=', 'pages.id')
				 ->where('pages.show_navigation', '=', 1)
				 ->where('pages.active', '=', 1)
				 ->where('seo_url.type', '=', 'page')
				 ->orderBy('pages.navigation_position', 'ASC')
				 ->get();
	}

	public static function getSitemapPages()
	{
		return DB::table('pages')
				 ->select(['pages.title', 'pages.updated_at' ,'seo_url.slug'])
				 ->join('seo_url', 'seo_url.object', '=', 'pages.id')
				 ->where('pages.active', '=', 1)
				 ->where('seo_url.type', '=', 'page')
				 ->orderBy('pages.navigation_position', 'ASC')
				 ->get();
	}
}