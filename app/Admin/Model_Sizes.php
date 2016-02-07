<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Sizes extends Model
{

	/**
	 * @param bool $category_id - int|array - FALSE for to get all categories
	 * @param array $objects
	 *
	 * @return array
	 */
	public static function getSizes($by_group = TRUE, $group = FALSE)
	{
		$sizes = DB::table('sizes');

		if ($by_group === TRUE)
		{
			$sizes = $sizes->select(['group'])
						   ->groupBy('group');
		}

		$response = [];

		if ( ! empty($group) && is_array($group))
		{
			$sizes = $sizes->whereIn('group', $group);
		}
		elseif (is_string($group) || is_int($group))
		{
			$sizes = $sizes->where('group', '=', $group);
		}

		$sizes = $sizes
			->orderBy('position', 'ASC')
			->get();

		if ( ! empty($sizes) && is_array($sizes))
		{
			foreach ($sizes as $key => $size)
			{
				if ( ! empty($sizes) && is_array($size))
				{
					if ($by_group === TRUE)
					{
						$response[] = $size['group'];
					}
					elseif ($by_group === FALSE)
					{
						$response[$size['id']] = $size;
					}
				}
			}
		}

		return $response;
	}

	public static function insertSize($data)
	{
		if ( ! empty($data))
		{
			$size_id = DB::table('sizes')
						 ->insertGetId([
										   'name'     => $data['name'],
										   'group'    => $data['group'],
										   'position' => $data['position'],
									   ]);

			return $size_id;
		}
		else
		{
			return FALSE;
		}
	}

	public static function updateSize($size_id, $data)
	{
		if ( ! empty($data) && ! empty($size_id))
		{
			try
			{
				DB::table('sizes')
				  ->where('id', '=', $size_id)
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

	public static function removeSize($by_group = TRUE, $group, $size_id = FALSE)
	{
		if ( ! empty($by_group) && $by_group === TRUE && ! empty($group) && is_string($group))
		{
			try
			{
				$query = DB::table('sizes');

				if ( ! empty($by_group) && $by_group === TRUE && ! empty($group) && is_string($group))
				{
					$query = $query->where('group', '=', $group);
				}

				if ( ! empty($size_id))
				{
					if (is_array($size_id))
					{
						$query = $query->whereIn('id', $size_id);
					}
					else
					{
						$query = $query->where('id', $size_id);
					}
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
		elseif ($by_group === FALSE && ! empty($size_id))
		{
			try
			{
				$query = DB::table('sizes');

				if (is_array($size_id))
				{
					$query = $query->whereIn('id', $size_id);
				}
				else
				{
					$query = $query->where('id', '=', $size_id);
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

	/**
	 * @param $group int
	 * @param array $update_sizes
	 * @param bool $new_group_name | string for new name
	 * @param array $new_sizes
	 *
	 * @return bool
	 */
	public static function saveSizes($group, $update_sizes = [], $new_group_name = FALSE, $new_sizes = [])
	{
		if ( ! empty($group))
		{
			$current_sizes = self::getSizes(FALSE, $group);

			if ( ! empty($new_sizes) && is_array($new_sizes))
			{
				$insert_sizes = $new_sizes;
			}
			else
			{
				$insert_sizes = [];
			}

			//Check is group name changed
			if ($new_group_name != FALSE && is_string($new_group_name))
			{
				if ( ! empty($update_sizes) && is_array($update_sizes))
				{
					foreach ($update_sizes as $size_id => $size)
					{
						if ( ! empty($update_sizes[$size_id]))
						{
							$update_sizes[$size_id]['group'] = $new_group_name;
						}
					}
				}
				if ( ! empty($insert_sizes) && is_array($insert_sizes))
				{
					foreach ($insert_sizes as $size_id => $size)
					{
						if ( ! empty($insert_sizes[$size_id]))
						{
							$insert_sizes[$size_id]['group'] = $new_group_name;
						}
					}
				}
			}
			//Process insert
			if ( ! empty($insert_sizes) && is_array($insert_sizes))
			{
				$save = DB::table('sizes')
						  ->insert($insert_sizes);
			}

			//Process update
			if ( ! empty($update_sizes) && is_array($update_sizes))
			{
				foreach ($update_sizes as $size_id => $size)
				{
					self::updateSize($size_id, $size);
				}
			}

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}