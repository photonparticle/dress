<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Materials extends Model
{

	/**
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function getMaterials($id = FALSE)
	{
		$material = DB::table('materials');

		if ($id != FALSE && intval($id) > 0)
		{
			$material = $material->where('id', '=', $id);
		}

		$material = $material
			->orderBy('title', 'ASC')
			->get();

		return $material;
	}

	public static function insertMaterial($material)
	{
		if ( ! empty($material))
		{
			$material = DB::table('materials')
							  ->insertGetId([
												'title'    => $material['title'],
												'position' => $material['position'],
												'created_at' => $material['created_at']
											]);

			return $material;
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
	public static function updateMaterial($id, $data)
	{
		if ( ! empty($data) && ! empty($id))
		{
			try
			{
				DB::table('materials')
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
	public static function removeMaterial($id)
	{
		if ( ! empty($id))
		{
			try
			{
				$query = DB::table('materials');

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
		return DB::table('materials')->select('title')->where('title', '=', $title)->count();
	}
}