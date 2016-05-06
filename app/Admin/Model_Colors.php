<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Colors extends Model
{

	/**
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function getColors($id = FALSE)
	{
		$color = DB::table('colors');

		if ($id != FALSE && intval($id) > 0)
		{
			$color = $color->where('id', '=', $id);
		}

		$color = $color
			->orderBy('title', 'ASC')
			->get();

		return $color;
	}

	public static function insertColor($color)
	{
		if ( ! empty($color))
		{
			$color = DB::table('colors')
							  ->insertGetId([
												'title'    => $color['title'],
												'position' => $color['position'],
												'created_at' => $color['created_at']
											]);

			return $color;
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
	public static function updateColor($id, $data)
	{
		if ( ! empty($data) && ! empty($id))
		{
			try
			{
				DB::table('colors')
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
	public static function removeColor($id)
	{
		if ( ! empty($id))
		{
			try
			{
				$query = DB::table('colors');

				if (is_array($id))
				{
					$query = $query->whereIn('id', $id);
				}
				else
				{
					$query = $query->where('id', $id);
				}

				$query = $query->delete();

				$query2 = DB::table('product_to_color');

				if (is_array($id))
				{
					$query2 = $query2->whereIn('color_id', $id);
				}
				else
				{
					$query2 = $query2->where('color_id', $id);
				}

				$query2 = $query2->delete();

				if ($query && $query2)
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
		return DB::table('colors')->select('title')->where('title', '=', $title)->count();
	}
}