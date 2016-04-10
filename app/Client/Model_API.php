<?php

namespace App\Client;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_API extends Model
{

	/**
	 * @param bool $category_id - int|array - FALSE for to get all categories
	 * @param array $objects
	 *
	 * @return array
	 */
	public static function getCategory($category_id = FALSE, $objects = [])
	{
		$categories     = DB::table('categories')
							->select('id', 'level', 'parent_id', 'menu_visibility')
							->orderBy('id', 'asc');
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

		$categories = $categories->where('active', '=', 1)
								 ->get();

		if ( ! empty($categories) && is_array($categories))
		{
			foreach ($categories as $key => $category)
			{
				if ( ! empty($category) && is_array($category))
				{
					$response[$category['id']] = $category;
					$categories_ids[]          = $category['id'];
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

}