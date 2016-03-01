<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Carousels extends Model
{

	/**
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function getCarousels($id = FALSE, $for_list = TRUE, $objects = FALSE)
	{
		$carousel = DB::table('carousels');

		if ($for_list === TRUE)
		{
			$carousel = $carousel->select(['id', 'title', 'type', 'active_from', 'active_to', 'created_at']);
		}

		if ($id != FALSE && intval($id) > 0)
		{
			$carousel = $carousel->where('id', '=', $id);
		}

		if ($objects !== FALSE && is_array($objects))
		{
			$carousel = $carousel->select($objects);
		}

		$carousel = $carousel
			->orderBy('title', 'ASC')
			->get();

		return $carousel;
	}

	public static function insertCarousel($carousel)
	{
		if ( ! empty($carousel) && is_array($carousel))
		{
			$carousel['created_at'] = date('Y-m-d H:i:s');

			$carousel = DB::table('carousels')
						  ->insertGetId($carousel);

			if ($carousel)
			{
				return $carousel;
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
	 * @param $carousel
	 *
	 * @return bool|\Exception|Exception
	 */
	public static function updateCarousel($id, $carousel)
	{
		if ( ! empty($carousel) && is_array($carousel) && ! empty($id))
		{
			$carousel['updated_at'] = date('Y-m-d H:i:s');

			$query = DB::table('carousels')
					   ->where('id', '=', $id)
					   ->update($carousel);

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
	public static function removeCarousel($id)
	{
		if ( ! empty($id))
		{
			try
			{
				$query = DB::table('carousels');

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
}