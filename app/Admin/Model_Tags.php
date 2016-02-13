<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Tags extends Model
{

	/**
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function getTags($id = FALSE)
	{
		$tag = DB::table('tags');

		if ($id != FALSE && intval($id) > 0)
		{
			$tag = $tag->where('id', '=', $id);
		}

		$tag = $tag
			->orderBy('title', 'ASC')
			->get();

		return $tag;
	}

	public static function insertTag($tag)
	{
		if ( ! empty($tag))
		{
			$tag = DB::table('tags')
							  ->insertGetId([
												'title'    => $tag['title'],
												'position' => $tag['position'],
												'created_at' => $tag['created_at']
											]);

			return $tag;
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
	public static function updateTag($id, $data)
	{
		if ( ! empty($data) && ! empty($id))
		{
			try
			{
				DB::table('tags')
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
	public static function removeTag($id)
	{
		if ( ! empty($id))
		{
			try
			{
				$query = DB::table('tags');

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
					DB::table('product_to_tag')->select('tag_id')->where('tag_id', '=', $id)->delete();
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
		return DB::table('tags')->select('title')->where('title', '=', $title)->count();
	}
}