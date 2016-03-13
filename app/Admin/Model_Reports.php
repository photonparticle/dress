<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class Model_Reports extends Model
{

	/**
	 * @param $start_date
	 * @param $end_date
	 * @param bool $by_week
	 *
	 * @return array
	 */
	public static function getOrders($start_date, $end_date)
	{
		if ( ! empty($start_date) && ! empty($end_date))
		{
			$orders = DB::table('orders')
						->orderBy('id', 'DESC')
						->select(['id'])
						->where('created_at', '>=', $start_date)
						->where('created_at', '<=', $end_date);

			$orders = $orders->get();

			$response  = [];
			$orders_id = [];

			if ( ! empty($orders) && is_array($orders))
			{
				//Get order ID in array
				foreach ($orders as $order_id)
				{
					$orders_id[]               = $order_id['id'];
					$response[$order_id['id']] = [
						'id'             => $order_id['id'],
						'products'       => 0,
						'total'          => 0,
						'original_total' => 0,
					];
				}

				//Get products
				$products = DB::table('order_products')
							  ->orderBy('id', 'DESC')
							  ->select(['order_id', 'original_price', 'quantity', 'total'])
							  ->whereIn('order_id', $orders_id)
							  ->get();

				if ( ! empty($products) && is_array($products))
				{
					foreach ($products as $product)
					{
						if ( ! empty($product['total']))
						{
							$response[$product['order_id']]['total'] = floatval($response[$product['order_id']]['total']) + floatval($product['total']);
						}

						$response[$product['order_id']]['original_total'] = $response[$product['order_id']]['original_total'] + (floatval($product['original_price']) * intval($product['quantity']));

						$response[$product['order_id']]['products'] = $response[$product['order_id']]['products'] + 1;
					}
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
}