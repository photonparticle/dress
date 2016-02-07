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
	 *
	 * @param bool $product_id - int or array - FALSE for none
	 * @param array $objects
	 *
	 * @return array
	 */
	public static function getProducts($product_id = FALSE, $objects = [])
	{
		$products = DB::table('products')
					  ->orderBy('created_at', 'DESC');
		$response = [];

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

		if (is_array(($product_objects = self::getProductObjects($product_id, $objects))))
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

	public static function createProduct($data)
	{
		if ( ! empty($data))
		{

			//Set defaults
			if (empty($data['position']))
			{
				$data['position'] = 0;
			}
			if (empty($data['active']))
			{
				$data['active'] = 0;
			}
			else
			{
				$data['active'] = 1;
			}
			if (empty($data['quantity']))
			{
				$data['quantity'] = 0;
			}
			if (empty($data['created_at']))
			{
				$data['created_at'] = date('Y-m-d H:i:s');
			}
			if (empty($data['discount_price']))
			{
				$data['discount_price'] = 0;
			}
			if (empty($data['discount_start']))
			{
				$data['discount_start'] = date('Y-m-d H:i:s');
			}
			if (empty($data['discount_end']))
			{
				$data['discount_end'] = date('Y-m-d H:i:s');
			}

			$product_id = DB::table('products')
							->insertGetId([
											  'active'         => $data['active'],
											  'quantity'       => $data['quantity'],
											  'original_price' => $data['original_price'],
											  'price'          => $data['price'],
											  'discount_price' => $data['discount_price'],
											  'discount_start' => $data['discount_start'],
											  'discount_end'   => $data['discount_end'],
											  'position'       => $data['position'],
											  'created_at'     => $data['created_at'],
											  'updated_at'     => date('Y-m-d H:i:s'),
										  ]);

			if ( ! empty($product_id) && ! empty($data) && is_array($data))
			{
				self::setProductObjects($data, $product_id);
			}

			return $product_id;
		}
		else
		{
			return FALSE;
		}
	}

	public static function updateProduct($product_id, $data)
	{
		if ( ! empty($data))
		{

			//Set defaults
			if (empty($data['position']))
			{
				$data['position'] = 0;
			}
			if (empty($data['active']))
			{
				$data['active'] = 0;
			}
			else
			{
				$data['active'] = 1;
			}
			if (empty($data['quantity']))
			{
				$data['quantity'] = 0;
			}
			if (empty($data['created_at']))
			{
				$data['created_at'] = date('Y-m-d H:i:s');
			}
			if (empty($data['discount_price']))
			{
				$data['discount_price'] = 0;
			}
			if (empty($data['discount_start']))
			{
				$data['discount_start'] = date('Y-m-d H:i:s');
			}
			if (empty($data['discount_end']))
			{
				$data['discount_end'] = date('Y-m-d H:i:s');
			}

			DB::table('products')
			  ->where('id', '=', $product_id)
			  ->update([
						   'active'         => $data['active'],
						   'quantity'       => $data['quantity'],
						   'original_price' => $data['original_price'],
						   'price'          => $data['price'],
						   'discount_price' => $data['discount_price'],
						   'discount_start' => $data['discount_start'],
						   'discount_end'   => $data['discount_end'],
						   'position'       => $data['position'],
						   'created_at'     => $data['created_at'],
						   'updated_at'     => date('Y-m-d H:i:s'),
					   ]);

			if ( ! empty($product_id) && ! empty($data) && is_array($data))
			{
				self::setProductObjects($data, $product_id);
			}

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public static function setProductObjects($data, $product_id)
	{
		if ( ! empty($data) && ! empty($product_id))
		{
			$objects         = [];
			$current_objects = self::getProductObjects($product_id);
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

			if ( ! empty($data['sizes']) && is_array($data['sizes']))
			{
				$objects['sizes'] = [
					'value' => json_encode($data['sizes']),
					'type'  => 'json',
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
						DB::table('products_data')
						  ->where('object', '=', $name)
						  ->where('product_id', '=', $product_id)
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
						DB::table('products_data')
						  ->insert([
									   'product_id'    => $product_id,
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

	public static function getProductObjects($product_id, $objects = array())
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

	public static function removeProduct($product_id)
	{
		if ( ! empty($product_id))
		{
			DB::table('products')
			  ->where('id', '=', $product_id)
			  ->delete();
			DB::table('products_data')
			  ->where('product_id', '=', $product_id)
			  ->delete();

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 *    Manage product to category
	 *
	 * @param $product_id - int
	 * @param $categories - array contains elements $category_id - int
	 *
	 * @return bool
	 */
	public static function setProductToCategory($product_id, $categories)
	{
		if ( ! empty($product_id) && ! empty($categories) && is_array($categories))
		{
			$current_categories  = self::getProductToCategory($product_id);
			$remove_categories   = [];
			$insert_categories   = $categories;
			$categories_ids      = Model_Categories::getCategoriesIDs();
			$existing_categories = [];

			foreach ($categories_ids as $cat)
			{
				if ( ! empty($cat['id']))
				{
					$existing_categories[] = $cat['id'];
				}
			}

			//Determine update and insert categories

			if (is_array($current_categories))
			{
				foreach ($current_categories as $category)
				{
					if ( ! array_key_exists($category, $categories))
					{
						$remove_categories[] = $category;
					}
					elseif ( ! in_array($category, $existing_categories))
					{
						$remove_categories[] = $category;
					}
					elseif (array_key_exists($category, $insert_categories))
					{
						unset($insert_categories[$category]);
					}
				}
			}
			else
			{
				$insert_categories = $categories;
			}

			//Process remove categories
			if (is_array($remove_categories))
			{
				foreach ($remove_categories as $category)
				{
					if ( ! empty($category))
					{
						DB::table('product_to_category')
						  ->where('product_id', '=', $product_id)
						  ->where('category_id', '=', $category)
						  ->delete();
					}
				}
			}

			//Process insert categories
			if (is_array($insert_categories))
			{
				foreach ($insert_categories as $category)
				{
					if ( ! empty($category))
					{
						DB::table('product_to_category')
						  ->insert([
									   'product_id'  => $product_id,
									   'category_id' => $category,
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

	/**
	 * @param $product_id
	 *
	 * @return array
	 */
	public static function getProductToCategory($product_id)
	{
		$response = [];
		$result   = DB::table('product_to_category');

		if (is_array($product_id))
		{
			$result = $result->whereIn('product_id', $product_id);
		}
		elseif (is_string($product_id) || is_int($product_id))
		{
			$result = $result->where('product_id', '=', $product_id);
		}

		$result = $result->get();

		if ( ! empty($result) && is_array($result))
		{
			foreach ($result as $key => $value)
			{
				if ( ! empty($value['category_id']))
				{
					$response[] = $value['category_id'];
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
	public static function checkURL($url) {
		if(DB::table('seo_url')->select('slug', 'type')->where('type', '=', 'product')->where('slug', '=', $url)->count() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public static function getURL($product_id) {
		$response = DB::table('seo_url')->where('type', '=', 'product')->where('object', '=', $product_id)->get();

		if(!empty($response[0]['slug'])) {
			return $response[0]['slug'];
		} else {
			return FALSE;
		}
	}

	/**
	 * @param $product_id
	 * @param $url
	 */
	public static function setURL($product_id, $url)
	{
		if ( ! empty($product_id) && ! empty($url))
		{
			$have_url = DB::table('seo_url')->select('type', 'object')->where('type', '=', 'product')->where('object', '=', $product_id)->count();

			if ($have_url)
			{
				$response = DB::table('seo_url')
							  ->where('type', '=', 'product')
							  ->where('object', '=', $product_id)
							  ->update([
										   'slug' => $url
									   ]);
			} else {
				$response = DB::table('seo_url')
							  ->insert([
										   'slug' => $url,
										   'type' => 'product',
										   'object' => $product_id
									   ]);
			}
		}
	}
}