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
	public static function getProducts($product_id = FALSE, $objects = [], $for_list = FALSE, $skip = 0, $limit = 0, $active_only = FALSE, $available_only = FALSE)
	{
		$products = DB::table('products')
					  ->orderBy('id', 'DESC');

		if ($skip > 0 && $limit > 0)
		{
			$products = $products->skip($skip)->take($limit);
		}

		$response = [];

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

		if ( ! empty($active_only))
		{
			$products = $products->where('active', '=', 1);
		}

		if ( ! empty($available_only))
		{
			$products = $products->where('quantity', '>', 0);
		}

		$products = $products->get();

		$loaded_product = [];

		if ( ! empty($products) && is_array($products))
		{
			foreach ($products as $key => $product)
			{
				if ( ! empty($product) && is_array($product))
				{
					$response[$product['id']] = $product;
					$loaded_product[]         = $product['id'];
				}
			}
		}

		if ($objects != 'none' && is_array(($product_objects = self::getProductObjects($loaded_product, $objects))))
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
				$data['discount_start'] = '';
			}
			if (empty($data['discount_end']))
			{
				$data['discount_end'] = '';
			}

			$product_id = DB::table('products')
							->insertGetId([
											  'active'         => $data['active'],
											  'quantity'       => $data['quantity'],
											  'available'      => $data['available'],
											  'main_category'  => $data['main_category'],
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
				$data['discount_start'] = '';
			}
			if (empty($data['discount_end']))
			{
				$data['discount_end'] = '';
			}

			DB::table('products')
			  ->where('id', '=', $product_id)
			  ->update([
						   'active'         => $data['active'],
						   'quantity'       => $data['quantity'],
						   'available'      => $data['available'],
						   'main_category'  => $data['main_category'],
						   'original_price' => $data['original_price'],
						   'price'          => $data['price'],
						   'discount_price' => $data['discount_price'],
						   'discount_start' => $data['discount_start'],
						   'discount_end'   => $data['discount_end'],
						   'position'       => $data['position'],
						   'created_at'     => $data['created_at'],
						   'updated_at'     => date('Y-m-d H:i:s'),
					   ]);

			//Loop trough images

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

			if (isset($current_objects[$product_id]))
			{
				$current_objects = $current_objects[$product_id];
			}

			//Collect objects
			if ( ! empty($data['title']))
			{
				$objects['title'] = [
					'value' => $data['title'],
					'type'  => 'string',
				];
			}
			if (isset($data['description']))
			{
				$objects['description'] = [
					'value' => $data['description'],
					'type'  => 'text',
				];
			}

			if (isset($data['sizes']) && is_array($data['sizes']))
			{
				$objects['sizes'] = [
					'value' => json_encode($data['sizes']),
					'type'  => 'json',
				];
			}

			if (isset($data['related_products']))
			{
				$objects['related_products'] = [
					'value' => json_encode($data['related_products']),
					'type'  => 'json',
				];
			}
			elseif (empty($data['related_products']))
			{
				$objects['related_products'] = [
					'value' => '',
					'type'  => 'json',
				];
			}

			if (isset($data['page_title']))
			{
				$objects['page_title'] = [
					'value' => $data['page_title'],
					'type'  => 'string',
				];
			}

			if (isset($data['meta_description']))
			{
				$objects['meta_description'] = [
					'value' => $data['meta_description'],
					'type'  => 'text',
				];
			}

			if (isset($data['meta_keywords']))
			{
				$objects['meta_keywords'] = [
					'value' => $data['meta_keywords'],
					'type'  => 'text',
				];
			}

			if (isset($data['images']))
			{
				$objects['images'] = [
					'value' => json_encode($data['images']),
					'type'  => 'json',
				];
			}
			if (isset($data['dimensions_table']))
			{
				$objects['dimensions_table'] = [
					'value' => $data['dimensions_table'],
					'type'  => 'text',
				];
			}

			//Determine update and insert objects
			foreach ($objects as $name => $object)
			{
				if (is_array($current_objects))
				{
					if (isset($current_objects[$name]))
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
					if (isset($object['value']) && ! empty($object['type']))
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
					if (isset($object['value']) && ! empty($object['type']))
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
			DB::table('product_to_category')
			  ->where('product_id', '=', $product_id)
			  ->delete();
			DB::table('product_to_color')
			  ->where('product_id', '=', $product_id)
			  ->delete();
			DB::table('product_to_manufacturer')
			  ->where('product_id', '=', $product_id)
			  ->delete();
			DB::table('product_to_material')
			  ->where('product_id', '=', $product_id)
			  ->delete();
			DB::table('product_to_tag')
			  ->where('product_id', '=', $product_id)
			  ->delete();
			DB::table('seo_url')
			  ->where('type', '=', 'product')
			  ->where('object', '=', $product_id)
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

			//Process remove categories
			DB::table('product_to_category')
			  ->where('product_id', '=', $product_id)
			  ->delete();

			//Process insert categories
			if (is_array($categories))
			{
				foreach ($categories as $category)
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
	public static function checkURL($url)
	{
		if (DB::table('seo_url')->select('slug', 'type')
			  ->where('slug', '=', $url)->count() > 0
		)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public static function getURL($product_id)
	{
		$response = DB::table('seo_url')->where('type', '=', 'product')->where('object', '=', $product_id)->get();

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
										   'slug' => $url,
									   ]);
			}
			else
			{
				$response = DB::table('seo_url')
							  ->insert([
										   'slug'   => $url,
										   'type'   => 'product',
										   'object' => $product_id,
									   ]);
			}
		}
	}

	/**
	 * @param $images
	 * @param $product_id
	 *
	 * @return bool
	 */
	public static function storeImages($images, $product_id)
	{
		if ( ! empty($images) && is_array($images) && ! empty($product_id))
		{
			$images_update = [];

			//Get current images
			if (($current_images = self::getProductObjects($product_id, ['images'])) != FALSE)
			{
				$images_update = json_decode($current_images, TRUE);
			}

			//Merge images
			array_merge($images_update, $images);

			if (self::setProductObjects(
					['images' => $images_update],
					$product_id
				) == TRUE
			)
			{
				return TRUE;
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

	public static function deleteAllImages($product_id)
	{
		$query = DB::table('products_data')
				   ->where('product_id', '=', $product_id)
				   ->where('object', '=', 'images')
				   ->delete();
		if ($query)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param $product_id
	 * @param $tags
	 *
	 * @return bool
	 */
	public static function saveTags($product_id, $tags)
	{
		if ( ! empty($product_id) && ! empty($tags) && is_array($tags))
		{
			self::removeAllTags($product_id);

			foreach ($tags as $key => $tag)
			{
				$tag = trim($tag);

				//Create the tag if is missing
				$tag_id = DB::table('tags')->select(['id', 'title'])->where('title', '=', $tag)->get();

				if ( ! empty($tag_id) && is_array($tag_id))
				{
					$tag_id = $tag_id[0]['id'];
				}

				if ( ! $tag_id)
				{
					$tag_id = DB::table('tags')->insertGetId(['title' => $tag, 'created_at' => date('Y-m-d H:i:s')]);
				}

				//Create the relation if doesn't exists already
				$exists = DB::table('product_to_tag')->select(['product_id', 'tag_id'])->where('product_id', '=', $tag)->where('tag_id', '=', $tag_id)->count();

				if ( ! $exists)
				{
					DB::table('product_to_tag')->insert(['product_id' => $product_id, 'tag_id' => $tag_id]);
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
	 * @return bool
	 */
	public static function getTags($product_id)
	{
		if ( ! empty($product_id))
		{
			$response = DB::table('product_to_tag')
						  ->join('tags', 'product_to_tag.tag_id', '=', 'tags.id')
						  ->select('product_to_tag.product_id', 'product_to_tag.tag_id', 'tags.title')
						  ->where('product_to_tag.product_id', '=', $product_id)
						  ->orderBy('product_to_tag.id', 'ASC')
						  ->get();

			if ($response)
			{
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

	public static function removeAllTags($product_id)
	{
		if ( ! empty($product_id))
		{
			//Remove all current tags
			DB::table('product_to_tag')->where('product_id', '=', $product_id)->delete();

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public static function setManufacturer($product_id, $manufacturer_id)
	{
		if ( ! empty($product_id) && ! empty($manufacturer_id))
		{
			DB::table('product_to_manufacturer')
			  ->where('product_id', '=', $product_id)
			  ->delete();

			DB::table('product_to_manufacturer')
			  ->insert(
				  [
					  'product_id'      => $product_id,
					  'manufacturer_id' => $manufacturer_id,
				  ]
			  );
		}
		else
		{
			return FALSE;
		}
	}

	public static function getManufacturers()
	{
		return DB::table('manufacturers')
				 ->select(['id', 'title'])
				 ->orderBy('title', 'ASC')
				 ->get();
	}

	public static function getManufacturer($product_id)
	{
		if ( ! empty($product_id))
		{
			$response = DB::table('product_to_manufacturer')
						  ->select(['product_id', 'manufacturer_id'])
						  ->where('product_id', '=', $product_id)
						  ->get();

			if ($response)
			{
				return $response[0]['manufacturer_id'];
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
	 * @return mixed
	 */
	public static function getColors()
	{
		return DB::table('colors')
				 ->select(['id', 'title'])
				 ->orderBy('title', 'ASC')
				 ->get();
	}

	/**
	 * @param $product_id
	 * @param $colors
	 *
	 * @return bool
	 */
	public static function setColors($product_id, $colors)
	{
		if ( ! empty($product_id) && $product_id > 0 && ! empty($colors) && is_array($colors))
		{

			foreach ($colors as $color_id)
			{
				$insertColors[] = [
					'product_id' => $product_id,
					'color_id'   => $color_id,
				];
			}

			//Remove current relations
			DB::table('product_to_color')
			  ->where('product_id', '=', $product_id)
			  ->delete();

			if ( ! empty($insertColors))
			{
				DB::table('product_to_color')
				  ->insert($insertColors);
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
	 * @return bool
	 */
	public static function getColor($product_id)
	{
		if ( ! empty($product_id) && $product_id > 0)
		{
			$query = DB::table('product_to_color')
					   ->select('product_to_color.color_id')
					   ->where('product_to_color.product_id', '=', $product_id)
					   ->orderBy('product_to_color.id', 'ASC')
					   ->get();

			if ($query && is_array($query))
			{
				$response = [];
				foreach ($query as $key => $value)
				{
					$response[] = $value['color_id'];
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
	 * @return mixed
	 */
	public static function getMaterials()
	{
		return DB::table('materials')
				 ->select(['id', 'title'])
				 ->orderBy('title', 'ASC')
				 ->get();
	}

	/**
	 * @param $product_id
	 * @param $material_id
	 *
	 * @return bool
	 */
	public static function setMaterial($product_id, $material_id)
	{
		if ( ! empty($product_id) && $product_id > 0 && ! empty($material_id))
		{
			//Remove current relations
			DB::table('product_to_material')
			  ->where('product_id', '=', $product_id)
			  ->delete();

			//Insert new relation
			DB::table('product_to_material')
			  ->insert([
						   'product_id'  => $product_id,
						   'material_id' => $material_id,
					   ]
			  );

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
	 * @param $data
	 */
	public static function saveProductToSize($product_id, $data)
	{
		DB::table('product_to_size')
		  ->where('product_id', '=', $product_id)
		  ->delete();

		if ( ! empty($data) && is_array($data))
		{
			foreach ($data as $size)
			{
				DB::table('product_to_size')
				  ->insert([
							   'product_id' => $product_id,
							   'size'       => $size,
						   ]);
			}
		}
	}

	public static function duplicateProduct($product_id)
	{
		//Get product
		$product = DB::table('products')
					 ->where('id', $product_id)
					 ->get();

		if ( ! empty($product[0]))
		{
			$product = $product[0];

			//Replace product data
			if (isset($product['id']))
			{
				unset($product['id']);
			}

			$product['created_at'] = date('Y-m-d H:i:s');
			$product['updated_at'] = date('Y-m-d H:i:s');
			$product['active']     = 0;

			$new_id = DB::table('products')
						->insertGetId($product);

			//Get product data
			$product_data = DB::table('products_data')
							  ->where('product_id', $product_id)
							  ->get();

			//Loop trough product data
			if ( ! empty($product_data) && is_array($product_data))
			{
				foreach ($product_data as $key => $data)
				{
					//Unset row id
					if ( ! empty($product_data[$key]['id']))
					{
						unset($product_data[$key]['id']);
					}

					//Change id
					$product_data[$key]['product_id'] = $new_id;

					//Remove images
					if($product_data[$key]['object'] == 'images') {
						unset($product_data[$key]);
					}
				}

				//Insert new data
				DB::table('products_data')
					->insert($product_data);
			}

			//Get product to category
			$product_to_category = DB::table('product_to_category')
									 ->where('product_id', $product_id)
									 ->get();

			//Loop trough product data and replace product_id
			if ( ! empty($product_to_category) && is_array($product_to_category))
			{
				foreach ($product_to_category as $key => $data)
				{
					if (isset($product_to_category[$key]['id']))
					{
						unset($product_to_category[$key]['id']);
					}

					$product_to_category[$key]['product_id'] = $new_id;
				}

				DB::table('product_to_category')
				  ->insert($product_to_category);
			}

			//Get product to color
			$product_to_color = DB::table('product_to_color')
								  ->where('product_id', $product_id)
								  ->get();

			//Loop trough product data and replace product_id
			if ( ! empty($product_to_color) && is_array($product_to_color))
			{
				foreach ($product_to_color as $key => $data)
				{
					if (isset($product_to_color[$key]['id']))
					{
						unset($product_to_color[$key]['id']);
					}

					$product_to_color[$key]['product_id'] = $new_id;
				}

				DB::table('product_to_color')
				  ->insert($product_to_color);
			}

			//Get product to manufacturer
			$product_to_manufacturer = DB::table('product_to_manufacturer')
										 ->where('product_id', $product_id)
										 ->get();

			//Loop trough product data and replace product_id
			if ( ! empty($product_to_manufacturer) && is_array($product_to_manufacturer))
			{
				foreach ($product_to_manufacturer as $key => $data)
				{
					if (isset($product_to_manufacturer[$key]['id']))
					{
						unset($product_to_manufacturer[$key]['id']);
					}

					$product_to_manufacturer[$key]['product_id'] = $new_id;
				}

				DB::table('product_to_manufacturer')
				  ->insert($product_to_manufacturer);
			}

			//Get product to material
			$product_to_material = DB::table('product_to_material')
									 ->where('product_id', $product_id)
									 ->get();

			//Loop trough product data and replace product_id
			if ( ! empty($product_to_material) && is_array($product_to_material))
			{
				foreach ($product_to_material as $key => $data)
				{
					if (isset($product_to_material[$key]['id']))
					{
						unset($product_to_material[$key]['id']);
					}

					$product_to_material[$key]['product_id'] = $new_id;
				}

				DB::table('product_to_material')
				  ->insert($product_to_material);
			}

			//Get product to size
			$product_to_size = DB::table('product_to_size')
								 ->where('product_id', $product_id)
								 ->get();

			//Loop trough product data and replace product_id
			if ( ! empty($product_to_size) && is_array($product_to_size))
			{
				foreach ($product_to_size as $key => $data)
				{
					if (isset($product_to_size[$key]['id']))
					{
						unset($product_to_size[$key]['id']);
					}

					$product_data[$key]['product_id'] = $new_id;
				}

				DB::table('product_to_size')
				  ->insert($product_to_size);
			}

			//Get product to tag
			$product_to_tag = DB::table('product_to_tag')
								->where('product_id', $product_id)
								->get();

			//Loop trough product data and replace product_id
			if ( ! empty($product_to_tag) && is_array($product_to_tag))
			{
				foreach ($product_to_tag as $key => $data)
				{
					if (isset($product_to_tag[$key]['id']))
					{
						unset($product_to_tag[$key]['id']);
					}

					$product_to_tag[$key]['product_id'] = $new_id;
				}

				DB::table('product_to_tag')
				  ->insert($product_to_tag);
			}

			return $new_id;
		} else {
			return FALSE;
		}
	}
}