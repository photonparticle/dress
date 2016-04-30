<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_UpcomingProduct extends Model
{

	/**
	 * @return array
	 */
	public static function getUpcomingProduct()
	{
		return DB::table('upcoming_product')
				 ->skip(0)->take(1)
				 ->get();
	}

	public static function saveUpcomingProduct($data)
	{
		//If already saved update else create
		if ( ! empty(self::getUpcomingProduct()))
		{
			DB::table('upcoming_product')
			  ->where('id', '=', 1)
			  ->update([
						   'title'      => $data['title'],
						   'product_id' => $data['product_id'],
						   'date'       => $data['date'],
						   'active'     => $data['active'],
					   ]);

			return TRUE;
		}
		else
		{
			DB::table('upcoming_product')
			  ->insert([
						   'title'      => $data['title'],
						   'product_id' => $data['product_id'],
						   'date'       => $data['date'],
						   'active'     => $data['active'],
					   ]);
		}

		return TRUE;
	}
}