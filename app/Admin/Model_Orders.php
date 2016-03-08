<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Orders extends Model
{

	/**
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function getOrders($id = FALSE, $for_list = TRUE, $objects = FALSE)
	{
		$order = DB::table('orders');

		if ($for_list === TRUE)
		{
			$order = $order->select(['id', 'name', 'last_name', 'email', 'phone', 'status']);
		}

		if ($id != FALSE && intval($id) > 0)
		{
			$order = $order->where('id', '=', $id);
		}

		if ($objects !== FALSE && is_array($objects))
		{
			$order = $order->select($objects);
		}

		$order = $order
			->orderBy('created_at', 'DESC')
			->get();

		return $order;
	}

	public static function insertOrder($order)
	{
		if ( ! empty($order) && is_array($order))
		{
			//Default creation date
			if (empty($order['created_at']))
			{
				$order['created_at'] = date('Y-m-d H:i:s');
			}

			$order = DB::table('orders')
					   ->insertGetId($order);

			if ($order)
			{
				return $order;
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
	 * @param $id
	 * @param $order
	 *
	 * @return bool|\Exception|Exception
	 */
	public static function updateOrder($id, $order)
	{
		if ( ! empty($order) && is_array($order) && ! empty($id))
		{
			$order['updated_at'] = date('Y-m-d H:i:s');

			$query = DB::table('orders')
					   ->where('id', '=', $id)
					   ->update($order);

			if ($query)
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

	/**
	 * @param $id
	 *
	 * @return bool|\Exception|Exception
	 */
	public static function removeOrder($id)
	{
		if ( ! empty($id))
		{
			try
			{
				$query = DB::table('orders');

				if (is_array($id))
				{
					$query = $query->whereIn('id', $id);
				}
				else
				{
					$query = $query->where('id', $id);
				}

				$query = $query->delete();

				if ($query)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			} catch (Exception $e)
			{
				return $e;
			}
		}
		else
		{
			return FALSE;
		}
	}

	public static function insertProduct($product)
	{
		if ( ! empty($product) && is_array($product))
		{
			//Default creation date
			if (empty($product['created_at']))
			{
				$product['created_at'] = date('Y-m-d H:i:s');
			}

			$product = DB::table('order_products')
						 ->insert($product);

			if ($product)
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

	/**
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function getOrderProducts($order_id)
	{
		$products = DB::table('order_products');

		if ($order_id != FALSE && intval($order_id) > 0)
		{
			$products = $products->where('order_id', '=', $order_id);
		}

		$products = $products
			->orderBy('created_at', 'DESC')
			->get();

		return $products;
	}

	public static function removeOrderProducts($record_id)
	{
		if ( ! empty($record_id))
		{
			try
			{
				$query = DB::table('order_products')
						   ->where('id', '=', $record_id)
						   ->delete();

				if ($query)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			} catch (Exception $e)
			{
				return $e;
			}
		}
		else
		{
			return FALSE;
		}
	}

	public static function discountProduct($product_id, $sizes, $total)
	{
		if ( ! empty($product_id) && ! empty($sizes) && isset($total))
		{
			$quantity = DB::table('products')
					   ->where('id', '=', $product_id)
					   ->update(['quantity' => $total]);

			$sizes = DB::table('products_data')
					   ->where('product_id', '=', $product_id)
					   ->where('object', '=', 'sizes')
					   ->update(['json' => $sizes]);

			if ($sizes)
			{
				return TRUE;
			}
		}
		else
		{
			return FALSE;
		}
	}
}