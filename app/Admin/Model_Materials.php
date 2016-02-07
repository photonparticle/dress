<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Manufacturers extends Model
{

	/**
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function getManufacturers($id = FALSE)
	{
		$manufacturer = DB::table('manufacturers');

		if ($id != FALSE && intval($id) > 0)
		{
			$manufacturer = $manufacturer->where('id', '=', $id);
		}

		$manufacturer = $manufacturer
			->orderBy('title', 'ASC')
			->get();

		return $manufacturer;
	}

	public static function insertManufacturer($manufacturer)
	{
		if ( ! empty($manufacturer))
		{
			$manufacturer = DB::table('manufacturers')
							  ->insertGetId([
												'title'    => $manufacturer['title'],
												'position' => $manufacturer['position'],
												'created_at' => $manufacturer['created_at']
											]);

			return $manufacturer;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param $id
	 * @param $data
	 *
	 * @return bool|\Exception|Exception
	 */
	public static function updateManufacturer($id, $data)
	{
		if ( ! empty($data) && ! empty($id))
		{
			try
			{
				DB::table('manufacturers')
				  ->where('id', '=', $id)
				  ->update($data);

				return TRUE;
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

	/**
	 * @param $id
	 *
	 * @return bool|\Exception|Exception
	 */
	public static function removeManufacturer($id)
	{
		if ( ! empty($id))
		{
			try
			{
				$query = DB::table('manufacturers');

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

	public static function checkTitleExists($title) {
		return DB::table('manufacturers')->select('title')->where('title', '=', $title)->count();
	}
}