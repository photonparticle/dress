<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class Model_Categories extends Model
{
	private $category_objects = [
		'number',
		'bool',
		'string',
		'text',
		'dateTime',
		'json',
	];

	/**
	 * @param bool $category_id - int|array - FALSE for to get all categories
	 * @param array $objects
	 *
	 * @return array
	 */
	public static function getCategory($category_id = FALSE, $objects = [])
	{
		$categories = DB::table('categories')
						->orderBy('created_at', 'DESC');
		$response   = [];

		if (is_array($category_id))
		{
			$categories = $categories->whereIn('id', $category_id);
		}
		elseif (is_string($category_id) || is_int($category_id))
		{
			$categories = $categories->where('id', '=', $category_id);
		}

		$categories = $categories->get();

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

	/*
	 * Returns categories by type
	 */

	public static function getCategoriesIDs($level = FALSE, $parent = FALSE)
	{
		$select = ['id'];
		if (isset($level) && in_array($level, [0, 1, 2]) && $level !== FALSE)
		{
			$select[] = 'level';
		}
		if ( ! empty($parent))
		{
			$select[] = 'parent';
		}

		$categories = DB::table('categories')
							->select($select);

		if (isset($level) && in_array($level, [0, 1, 2]) && $level !== FALSE)
		{
			$categories = $categories->where('level', '=', $level);
		}

		if ( ! empty($parent))
		{
			$categories = $categories->where('parent', '=', $parent);
		}

		return $categories->get();
	}

	public static function createCategory($data)
	{
		if ( ! empty($data))
		{


			//Set defaults
			if (empty($data['level']))
			{
				$data['level'] = 0;
			}
			if (empty($data['parent']))
			{
				$data['parent'] = 0;
			}
			if (empty($data['position']))
			{
				$data['position'] = 0;
			}
			if (empty($data['visible']))
			{
				$data['visible'] = 0;
			}
			else
			{
				$data['visible'] = 1;
			}
			if (empty($data['active']))
			{
				$data['active'] = 0;
			}
			else
			{
				$data['active'] = 1;
			}

			$category_id = DB::table('categories')
							 ->insertGetId([
											   'active'          => $data['active'],
											   'menu_visibility' => $data['visible'],
											   'level'           => $data['level'],
											   'parent_id'       => $data['parent'],
											   'position'        => $data['position'],
											   'created_at'      => date('Y-m-d H:i:s'),
											   'updated_at'      => date('Y-m-d H:i:s'),
										   ]);

			if ( ! empty($category_id) && ! empty($data) && is_array($data))
			{
				self::setCategoryObjects($data, $category_id);
			}

			return $category_id;
		}
		else
		{
			return FALSE;
		}
	}

	public static function updateCategory($category_id, $data)
	{
		if ( ! empty($data))
		{

			//Set defaults
			if (empty($data['level']))
			{
				$data['level'] = 0;
			}
			if (empty($data['parent']))
			{
				$data['parent'] = 0;
			}
			if (empty($data['position']))
			{
				$data['position'] = 0;
			}
			if (empty($data['visible']))
			{
				$data['visible'] = 0;
			}
			else
			{
				$data['visible'] = 1;
			}
			if (empty($data['active']))
			{
				$data['active'] = 0;
			}
			else
			{
				$data['active'] = 1;
			}

			DB::table('categories')
			  ->where('id', '=', $category_id)
			  ->update([
						   'active'          => $data['active'],
						   'menu_visibility' => $data['visible'],
						   'level'           => $data['level'],
						   'parent_id'       => $data['parent'],
						   'position'        => $data['position'],
						   'updated_at'      => date('Y-m-d H:i:s'),
					   ]);

			if ( ! empty($category_id) && ! empty($data) && is_array($data))
			{
				self::setCategoryObjects($data, $category_id);
			}

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public static function setCategoryObjects($data, $category_id)
	{
		if ( ! empty($data) && ! empty($category_id))
		{
			$objects         = [];
			$current_objects = self::getCategoryObjects($category_id);
			$update_objects  = [];
			$insert_objects  = [];

			//Collect objects
			if ( ! empty($data['title']))
			{
				$objects['title'] = [
					'value' => $data['title'],
					'type'  => 'string',
				];
			}
			if ( ! empty($data['description']))
			{
				$objects['description'] = [
					'value' => $data['description'],
					'type'  => 'text',
				];
			}

			if ( ! empty($data['page_title']))
			{
				$objects['page_title'] = [
					'value' => $data['page_title'],
					'type'  => 'text',
				];
			}

			if ( ! empty($data['meta_description']))
			{
				$objects['meta_description'] = [
					'value' => $data['meta_description'],
					'type'  => 'text',
				];
			}

			if ( ! empty($data['meta_keywords']))
			{
				$objects['meta_keywords'] = [
					'value' => $data['meta_keywords'],
					'type'  => 'text',
				];
			}

			//Determine update and insert objects
			foreach ($objects as $name => $object)
			{
				if (is_array($current_objects))
				{
					if (array_key_exists($name, $current_objects))
					{
						$update_objects[$name] = $object;
					}
					else
					{
						$insert_objects[$name] = $object;
					}
				}
				else
				{
					$insert_objects[$name] = $object;
				}
			}

			//Process update objects
			if (is_array($update_objects))
			{
				foreach ($update_objects as $name => $object)
				{
					if ( ! empty($object['value']) && ! empty($object['type']))
					{
						DB::table('categories_data')
						  ->where('object', '=', $name)
						  ->where('category_id', '=', $category_id)
						  ->update([
									   'type'          => $object['type'],
									   $object['type'] => $object['value'],
								   ]);
					}
				}
			}

			//Process insert objects
			if (is_array($insert_objects))
			{
				foreach ($insert_objects as $name => $object)
				{
					if ( ! empty($object['value']) && ! empty($object['type']))
					{
						DB::table('categories_data')
						  ->insert([
									   'category_id'   => $category_id,
									   'object'        => $name,
									   'type'          => $object['type'],
									   $object['type'] => $object['value'],
								   ]);
					}
				}
			}

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public static function getCategoryObjects($category_id, $objects = array())
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

	public static function removeCategory($category_id)
	{
		if ( ! empty($category_id))
		{
			DB::table('categories')
			  ->where('id', '=', $category_id)
			  ->delete();
			DB::table('categories_data')
			  ->where('category_id', '=', $category_id)
			  ->delete();
			DB::table('seo_url')
			  ->where('type', '=', 'category')
			  ->where('object', '=', $category_id)
			  ->delete();

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param array $category_id
	 */
	public static function getCategoryTree($category_id = FALSE)
	{
		if ( ! empty($category_id))
		{
			$categories = self::getCategory();
		}
		else
		{
			$categories = self::getCategory($category_id);
		}
		$response = [];
		$first_level = [];
		$second_level = [];
		$third_level = [];

		if ( ! empty($categories) && is_array($categories))
		{
			foreach ($categories as $key => $category)
			{
				//If main category
				if ($category['level'] == 0)
				{
					$first_level[$category['id']] = $category;
				}
				elseif (in_array($category['level'], [1, 2]))
				{
					//If second level
					if ($category['level'] == 1)
					{
						$second_level[$category['id']] = $category;
					}
					elseif ($category['level'] == 2)
					{
						$third_level[$category['id']]= $category;
					}
				}
			}
		}

		//If first level level
		foreach($first_level as $cat_id => $category) {
			$response[$cat_id] = $category;
		}

		//If second level level
		foreach($second_level as $cat_id => $category) {
			if ( ! empty($response[$category['parent_id']]))
			{
				$response[$category['parent_id']]['children'][$category['id']] = $category;
			}
		}

		//If third level level
		foreach($third_level as $category) {
			if ( ! empty($response) && is_array($response))
			{
				foreach ($response as $cat_id => $response_cat)
				{
					$children = ! empty($response_cat['children'][$category['parent_id']]) ? $response_cat['children'][$category['parent_id']] : '';
					if (
						! empty($children) &&
						is_array($children)
					)
					{
						if ($child['id'] = $category['parent_id'])
						{
							$response[$cat_id]['children'][$category['parent_id']]['children'][$category['id']] = $category;
						}
					}
				}
			}
		}

		return $response;

	}

	/**
	 * @param $url
	 *
	 * @return bool
	 */
	public static function checkURL($url)
	{
		if (DB::table('seo_url')->select('slug', 'type')->where('slug', '=', $url)->count() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param $category_id
	 *
	 * @return bool
	 */
	public static function getURL($category_id)
	{
		$response = DB::table('seo_url')->where('type', '=', 'category')->where('object', '=', $category_id)->get();

		if ( ! empty($response[0]['slug']))
		{
			return $response[0]['slug'];
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param $category_id
	 * @param $url
	 */
	public static function setURL($category_id, $url)
	{
		if ( ! empty($category_id) && ! empty($url))
		{
			$have_url = DB::table('seo_url')->select('type', 'object')->where('type', '=', 'category')->where('object', '=', $category_id)->count();

			if ($have_url)
			{
				$response = DB::table('seo_url')
							  ->where('type', '=', 'category')
							  ->where('object', '=', $category_id)
							  ->update([
										   'slug' => $url,
									   ]);
			}
			else
			{
				$response = DB::table('seo_url')
							  ->insert([
										   'slug'   => $url,
										   'type'   => 'category',
										   'object' => $category_id,
									   ]);
			}

			if($response) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
}