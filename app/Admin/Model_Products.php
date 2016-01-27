<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class Model_Products extends Model
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
	 * Returns array of all products
	 * @return array
	 */
	public static function getAllProducts()
	{
		$products = DB::table('products')
						->orderBy('created_at', 'ASC')
						->get();

		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $key => $product)
			{
				if ( ! empty($product) && is_array($product))
				{
					if (is_array(($product_objects = self::getCategoryObjects($product['id']))))
					{
						$products[$key] = array_merge($product, $product_objects);
					}
				}
			}
		}

		return $products;
	}

	public static function getCategory($category_id)
	{
		$category = DB::table('categories')
					  ->where('id', '=', $category_id)
					  ->get();

		if ( ! empty($category) && is_array($category))
		{
			foreach ($category as $key => $category_data)
			{
				if ( ! empty($category_data) && is_array($category_data))
				{
					if (is_array(($category_objects = self::getCategoryObjects($category_data['id']))))
					{
						$category[$key] = array_merge($category, $category_objects);
					}
				}
			}
		}

		return $category;
	}

	/*
	 * Returns categories by type
	 */

	public static function getCategoriesIDs($level = FALSE, $parent = FALSE)
	{
		$categories = DB::table('categories')
						->select(['id', 'level', 'parent_id']);

		if (isset($level) && in_array($level, [0, 1, 2]))
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

			return TRUE;
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

	public static function getCategoryObjects($category_id)
	{
		if ( ! empty($category_id))
		{
			$response = [];
			$result   = DB::table('categories_data')
						  ->where('category_id', '=', $category_id)
						  ->get();

			if ( ! empty($result) && is_array($result))
			{
				foreach ($result as $key => $value)
				{
					if ( ! empty($value['object']) && ! empty($value['type']) && ! empty($value[$value['type']]))
					{
						$response[$value['object']] = $value[$value['type']];
					}
				}
			}

			return $response;
		}
		else
		{
			return FALSE;
		}
	}

	public static function removeCategory($category_id) {
		if(!empty($category_id)) {
			DB::table('categories')
			  ->where('id', '=', $category_id)
			  ->delete();
			DB::table('categories_data')
			  ->where('category_id', '=', $category_id)
			  ->delete();

			return TRUE;
		} else {
			return FALSE;
		}
	}
}