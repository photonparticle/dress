<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Pages extends Model
{

	/**
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function getTables($id = FALSE, $for_list = TRUE, $object = FALSE)
	{
		$table = DB::table('tables');

		if ($for_list === TRUE)
		{
			$table = $table->select(['id', 'title', 'image']);
		}

		if ($id != FALSE && intval($id) > 0)
		{
			$table = $table->where('id', '=', $id);
		}

		if ($object !== FALSE)
		{
			if ($object == 'rows')
			{
				$table = $table->select(['id', 'title', 'rows']);
			}
			if ($object == 'cols')
			{
				$table = $table->select(['id', 'title', 'cols']);
			}
		}

		$table = $table
			->orderBy('title', 'ASC')
			->get();

		return $table;
	}

	public static function insertTable($table)
	{
		if ( ! empty($table))
		{
			$insertData = [
				'title' => $table['title'],
				'image' => $table['image']
			];

			if ( ! empty($table['cols']) && is_array($table['cols']))
			{
				$insertData['cols'] = json_encode($table['cols']);
			}

			if ( ! empty($table['rows']) && is_array($table['rows']))
			{
				$insertData['rows'] = json_encode($table['rows']);
			}

			$table = DB::table('tables')
					   ->insertGetId($insertData);

			if ($table)
			{
				return $table;
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
	 * @param $data
	 *
	 * @return bool|\Exception|Exception
	 */
	public static function updateTable($id, $table)
	{
		if ( ! empty($table) && ! empty($id))
		{
			$updateData = [
				'title' => $table['title'],
				'image' => $table['image']
			];

			if ( ! empty($table['cols']) && is_array($table['cols']))
			{
				$updateData['cols'] = json_encode($table['cols']);
			}

			if ( ! empty($table['rows']) && is_array($table['rows']))
			{
				$updateData['rows'] = json_encode($table['rows']);
			}

			$query = DB::table('tables')
					   ->where('id', '=', $id)
					   ->update($updateData);
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
	public static function removeTable($id)
	{
		if ( ! empty($id))
		{
			try
			{
				$query = DB::table('tables');

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

	public static function setImage($id, $image)
	{
		if ( ! empty($id) && ! empty($image))
		{
			$query = DB::table('tables')
					   ->where('id', '=', $id)
					   ->update([
									'image' => $image,
								]);

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
}