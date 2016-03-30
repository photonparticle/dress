<?php

namespace App\Client;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Main extends Model
{

	/**
	 * @param bool $category_id - int|array - FALSE for to get all categories
	 * @param array $objects
	 *
	 * @return array
	 */
	public static function getCategory($category_id = FALSE, $objects = [])
	{
		$categories = DB::table('categories')
						->select('id')
						->orderBy('id', 'asc');
		$response   = [];

		if (is_array($category_id))
		{
			$categories = $categories->whereIn('id', $category_id);
		}
		elseif (is_string($category_id) || is_int($category_id))
		{
			$categories = $categories->where('id', '=', $category_id);
		}

		$categories = $categories->where('active', '=', 1)
								 ->get();

		if ( ! empty($categories) && is_array($categories))
		{
			foreach ($categories as $key => $category)
			{
				if ( ! empty($category) && is_array($category))
				{
					$response[$category['id']] = $category;
				}
			}
		}

		if (is_array(($category_objects = self::getCategoryObjects($category_id, $objects))))
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

	private static function getNewestProducts($limit = 20)
	{
		$response = [];
		$products = DB::table('products')
					  ->select('id')
					  ->orderBy('created_at', 'desc')
					  ->orderBy('position', 'desc')
					  ->where('active', '=', 1)
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

	private static function getDiscountedProducts($limit = 20)
	{
		$response = [];
		$products = DB::table('products')
					  ->select('id')
					  ->where('discount_price', '>', 0)
					  ->where('active', '=', 1)
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

	public static function getCarousels($type, $target = FALSE)
	{
		if ( ! empty($type) && in_array($type, ['homepage', 'categories', 'pages']))
		{
			$now       = date('Y-m-d H:i:s');
			$carousels = DB::table('carousels')
						   ->where('type', '=', $type)
						   ->where('active_from', '<=', $now)
						   ->orWhere('active_from', '<=', '')
						   ->where('active_to', '>=', $now)
						   ->orWhere('active_to', '<=', '');

			if ( ! empty($target) && is_numeric($target))
			{
				$carousels = $carousels->where('target', '=', $target)->orWhere('target', '=', '');
			}

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
	 * Returns array of all products
	 *
	 * @param bool $product_id - int or array - FALSE for none
	 * @param array $objects
	 *
	 * @return array
	 */
	public static function getProducts($product_id = FALSE, $objects = [], $for_list = FALSE, $skip = 0, $limit = 0)
	{
		$products = DB::table('products')
					  ->orderBy('id', 'DESC');

		if($skip > 0 && $limit > 0) {
			$products = $products->skip($skip)->take($limit);
		}

		$response = [];

		if($for_list === TRUE) {
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

		$products = $products->get();

		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $key => $product)
			{
				if ( ! empty($product) && is_array($product))
				{
					$response[$product['id']] = $product;
				}
			}
		}

		if ($objects != 'none' && is_array(($product_objects = self::getProductObjects($product_id, $objects))))
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

		return $response;
	}

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
}