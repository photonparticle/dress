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

	public static function getProductsWithSize($size_name) {
		$products = DB::table('product_to_size')
					  ->select('product_id')
					  ->where('size', '=', $size_name)
					  ->get();
		$response = [];

		if(!empty($products) && is_array($products)) {
			foreach($products as $data) {
				$response[] = $data['product_id'];
			}
		}

		return $response;
	}

	public static function getProductsWithMaterial($material_id) {
		$products = DB::table('product_to_material')
					  ->select('product_id')
					  ->where('material_id', '=', $material_id)
					  ->get();
		$response = [];

		if(!empty($products) && is_array($products)) {
			foreach($products as $data) {
				$response[] = $data['product_id'];
			}
		}

		return $response;
	}

	public static function getProductsWithColor($color_id) {
		$products = DB::table('product_to_color')
					  ->select('product_id')
					  ->where('color_id', '=', $color_id)
					  ->get();
		$response = [];

		if(!empty($products) && is_array($products)) {
			foreach($products as $data) {
				$response[] = $data['product_id'];
			}
		}

		return $response;
	}

}