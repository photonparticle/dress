<?php

namespace App\Client;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Client extends Model
{

	/**
	 * @param $slug
	 *
	 * @return bool
	 */
	public static function getSlug($slug)
	{
		$response = DB::table('seo_url')->where('slug', '=', $slug)->get();

		if ( ! empty($response[0]))
		{
			return $response[0];
		}
		else
		{
			return FALSE;
		}
	}

	public static function getURL($object, $type)
	{
		if (in_array($type, ['category', 'product', 'page']) &&
			is_numeric($object) || is_array($object)
		)
		{
			$urls = DB::table('seo_url')
					  ->select(['object', 'slug'])
					  ->where('type', '=', $type);

			if (is_numeric($object))
			{
				$urls = $urls->where('object', '=', $object);
			}
			else
			{
				$urls = $urls->whereIn('object', $object);
			}

			$urls = $urls->get();

			return $urls;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param $product_id
	 *
	 * @return array
	 */
	public static function getCategoryProducts($id)
	{
		$response = [];
		$result   = DB::table('product_to_category');

		if (is_array($id))
		{
			$result = $result->whereIn('category_id', $id);
		}
		elseif (is_string($id) || is_int($id))
		{
			$result = $result->where('category_id', '=', $id);
		}

		$result = $result->get();

		if ( ! empty($result) && is_array($result))
		{
			foreach ($result as $key => $value)
			{
				if ( ! empty($value['product_id']))
				{
					$response[] = $value['product_id'];
				}
			}
		}

		return $response;
	}

	/**
	 *  Get all available sizes
	 * @return array
	 */
	public static function getSizes()
	{
		$sizes = DB::table('sizes');

		$sizes = $sizes->select(['name'])
					   ->groupBy('name');

		$response = [];

		$sizes = $sizes
			->orderBy('position', 'ASC')
			->get();

		if ( ! empty($sizes) && is_array($sizes))
		{
			foreach ($sizes as $key => $size)
			{
				if ( ! empty($size) && is_array($size) && ! empty($size['name']))
				{
					$response[] = $size['name'];
				}
			}
		}

		return $response;
	}

	/**
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function getColors($id = FALSE)
	{
		$colors   = DB::table('colors')
					  ->select(['id', 'title']);
		$response = [];

		if ($id != FALSE && intval($id) > 0)
		{
			$colors = $colors->where('id', '=', $id);
		}

		$colors = $colors
			->orderBy('title', 'ASC')
			->get();

		if ( ! empty($colors) && is_array($colors))
		{
			foreach ($colors as $color)
			{
				$response[$color['id']] = $color['title'];
			}
		}

		return $response;
	}

	/**
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function getMaterials($id = FALSE)
	{
		$materials = DB::table('materials')
					   ->select(['id', 'title']);
		$response  = [];

		if ($id != FALSE && intval($id) > 0)
		{
			$materials = $materials->where('id', '=', $id);
		}

		$materials = $materials
			->orderBy('title', 'ASC')
			->get();

		if ( ! empty($materials) && is_array($materials))
		{
			foreach ($materials as $material)
			{
				$response[$material['id']] = $material['title'];
			}
		}

		return $response;
	}

	public static function getProductsWithSize($size_name)
	{
		$products = DB::table('product_to_size')
					  ->select('product_id')
					  ->where('size', '=', $size_name)
					  ->get();
		$response = [];

		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $data)
			{
				$response[] = $data['product_id'];
			}
		}

		return $response;
	}

	public static function getProductsWithMaterial($material_id)
	{
		$products = DB::table('product_to_material')
					  ->select('product_id')
					  ->where('material_id', '=', $material_id)
					  ->get();
		$response = [];

		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $data)
			{
				$response[] = $data['product_id'];
			}
		}

		return $response;
	}

	public static function getProductsWithPrice($min, $max)
	{
		$products = DB::table('products')
					  ->select('id')
					  ->where('price', '>=', $min)
					  ->where('price', '<=', $max)
					  ->get();
		$response = [];

		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $data)
			{
				$response[] = $data['id'];
			}
		}

		return $response;
	}

	public static function getProductsWithColor($color_id)
	{
		$products = DB::table('product_to_color')
					  ->select('product_id')
					  ->where('color_id', '=', $color_id)
					  ->get();
		$response = [];

		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $data)
			{
				$response[] = $data['product_id'];
			}
		}

		return $response;
	}

	/**
	 * @param bool $id
	 * @param bool $email
	 * @param bool $phone
	 *a
	 *
	 * @return mixed
	 */
	public static function getOrders($id = FALSE, $email = FALSE, $phone = FALSE)
	{
		$for_list = TRUE;

		$order = DB::table('orders');

		if ($for_list === TRUE)
		{
			$order = $order->select(['id', 'name', 'last_name', 'email', 'address', 'phone', 'status', 'created_at', 'updated_at']);
		}

		if ($id != FALSE && intval($id) > 0)
		{
			$order = $order->where('user_id', '=', $id);
		}

		if ($email != FALSE && ! empty($email))
		{
			$order = $order->orWhere('email', '=', $email);
		}

		if ($phone != FALSE && ! empty($phone))
		{
			$order = $order->orWhere('phone', '=', $phone);
		}

		$order = $order->orderBy('created_at', 'DESC')->get();

		return $order;
	}

	public static function getUpcomingProduct()
	{
		$now    = date('Y:m:d H:m:s');
		$result = DB::table('upcoming_product')
					->select(['title', 'product_id', 'date'])
					->where('id', 1)
					->where('active', 1)
					->where('date', '>', $now)
					->get();

		if ( ! empty($result[0]))
		{
			return $result[0];
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param $needable
	 *
	 * @return array
	 */
	public static function searchProduct($needable)
	{
		$id_results = DB::table('products')
						->select(['id'])
						->where('id', $needable)
						->where('active', '=', '1')
						->orderBy('available', 'DESC')
						->orderBy('created_at', 'DESC')
						->orderBy('position', 'ASC')
						->get();

		$title_results = DB::table('products_data')
						   ->select('product_id')
						   ->where('object', '=', 'title')
						   ->where('string', 'like', '%'.$needable.'%')
						   ->get();

		$response = [];

		if ( ! empty($id_results) && is_array($id_results))
		{
			foreach ($id_results as $val)
			{
				$response[$val['id']] = $val['id'];
			}
		}
		if ( ! empty($title_results) && is_array($title_results))
		{
			foreach ($title_results as $val)
			{
				$response[$val['product_id']] = $val['product_id'];
			}
		}

		return $response;
	}

	/**
	 * @param $needable
	 *
	 * @return array
	 */
	public static function searchProductByTag($needable)
	{
		$tags     = [];
		$response = [];

		$tag_id = DB::table('tags')
					->select('id')
					->where('title', $needable)
					->get();

		if ( ! empty($tag_id) && is_array($tag_id))
		{
			foreach ($tag_id as $tag)
			{
				$tags[] = $tag['id'];
			}
		}

		if ( ! empty($tags) && is_array($tags))
		{
			$id_results = DB::table('product_to_tag')
							->select(['product_id'])
							->whereIn('tag_id', $tags)
							->get();
		}

		if ( ! empty($id_results) && is_array($id_results))
		{
			foreach ($id_results as $result)
			{
				$response[] = $result['product_id'];
			}
		}

		return $response;
	}

}