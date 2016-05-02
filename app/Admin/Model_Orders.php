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
	 * @param bool $for_list
	 * @param bool $objects
	 * @param int $skip
	 * @param int $limit
	 * @param bool $start_date
	 * @param bool $end_date
	 *
	 * @return array
	 */
	public static function getOrders($id = FALSE, $for_list = TRUE, $objects = FALSE, $skip = 0, $limit = 0, $start_date = FALSE, $end_date = FALSE)
	{
		$order = DB::table('orders');

		if ($skip > 0 && $limit > 0)
		{
			$order = $order->skip($skip)->take($limit);
		}

		if ( ! empty($where) && is_array($where))
		{
			$order = $order->where($where[0], $where[1], $where[2]);
		}

		if ($for_list === TRUE)
		{
			$order = $order->select(['id', 'name', 'last_name', 'email', 'address', 'phone', 'status', 'created_at', 'updated_at']);
		}

		if ($id != FALSE && intval($id) > 0)
		{
			$order = $order->where('id', '=', $id);
		}

		if ($objects !== FALSE && is_array($objects))
		{
			$order = $order->select($objects);
		}

		if ($start_date != FALSE && strtotime($start_date) !== FALSE)
		{
			$order = $order->where('created_at', '>=', $start_date);
		}

		if ($end_date != FALSE && strtotime($end_date) !== FALSE)
		{
			$order = $order->where('created_at', '<=', $end_date);
		}

		$order = $order->orderBy('created_at', 'DESC')->get();

		return $order;
	}

	/**
	 * @param $order
	 *
	 * @return array|bool
	 */
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

				$query = DB::table('order_products');

				if (is_array($id))
				{
					$query = $query->whereIn('order_id', $id);
				}
				else
				{
					$query = $query->where('order_id', $id);
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
			if (empty($total))
			{
				$available = 0;
			}
			else
			{
				$available = 1;
			}

			$quantity = DB::table('products')
						  ->where('id', '=', $product_id)
						  ->update([
									   'quantity'  => $total,
									   'available' => $available,
								   ]);

			$sizes = DB::table('products_data')
					   ->where('product_id', '=', $product_id)
					   ->where('object', '=', 'sizes')
					   ->update(['json' => $sizes]);

			if ($quantity && $sizes)
			{
				return TRUE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	public static function getTotalSales($order_id = FALSE)
	{
		$total = DB::table('order_products')
				   ->select('total');

		if ( ! empty($order_id))
		{
			$total = $total->where('order_id', '=', $order_id);
		}

		$total = $total->sum('total');

		return $total;
	}

	public static function getCountSales()
	{
		$count = DB::table('orders')
				   ->select('id')
				   ->count('id');

		return $count;
	}

	public static function getAvgSales()
	{
		$count = DB::table('order_products')
				   ->select('total')
				   ->groupby('order_id')
				   ->avg('total');

		return $count;
	}

	public static function getOrigPrices($ids)
	{
		if ( ! empty($ids) && is_array($ids))
		{
			$results  = DB::table('products')
						  ->select(['id', 'original_price'])
						  ->whereIn('id', $ids)
						  ->get();
			$response = [];

			if ( ! empty($results) && is_array($results))
			{
				foreach ($results as $result)
				{
					$response[$result['id']] = $result['original_price'];
				}
			}

			return $response;
		}
		else
		{
			return FALSE;
		}
	}
}