<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class Model_Pages extends Model
{

	/**
	 * @param bool $page_id - int|array - FALSE for to get all pages
	 * @param array $objects
	 *
	 * @return array
	 */
	public static function getPage($page_id = FALSE, $objects = [])
	{
		$pages = DB::table('pages')
				   ->orderBy('created_at', 'DESC');

		if ( ! empty($objects) && is_array($objects))
		{
			$pages = $pages->select($objects);
		}

		if (is_array($page_id))
		{
			$pages = $pages->whereIn('id', $page_id);
		}
		elseif (is_string($page_id) || is_int($page_id))
		{
			$pages = $pages->where('id', '=', $page_id);
		}

		$pages = $pages->get();

		return $pages;
	}

	public static function createPage($data)
	{
		if ( ! empty($data))
		{
			if (empty($data['active']))
			{
				$data['active'] = 0;
			}
			else
			{
				$data['active'] = 1;
			}

			$page_id = DB::table('pages')
						 ->insertGetId([
										   'title'            => $data['title'],
										   'content'          => $data['content'],
										   'active'           => $data['active'],
										   'page_title'       => $data['page_title'],
										   'meta_description' => $data['meta_description'],
										   'meta_keywords'    => $data['meta_keywords'],
										   'created_at'       => date('Y-m-d H:i:s'),
										   'updated_at'       => date('Y-m-d H:i:s'),
									   ]);

			return $page_id;
		}
		else
		{
			return FALSE;
		}
	}

	public static function updatePage($page_id, $data)
	{
		if ( ! empty($data))
		{
			if (empty($data['active']))
			{
				$data['active'] = 0;
			}
			else
			{
				$data['active'] = 1;
			}

			DB::table('pages')
			  ->where('id', '=', $page_id)
			  ->update([
						   'title'            => $data['title'],
						   'content'          => $data['content'],
						   'active'           => $data['active'],
						   'page_title'       => $data['page_title'],
						   'meta_description' => $data['meta_description'],
						   'meta_keywords'    => $data['meta_keywords'],
						   'updated_at'       => date('Y-m-d H:i:s'),
					   ]);

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public static function removePage($page_id)
	{
		if ( ! empty($page_id))
		{
			DB::table('pages')
			  ->where('id', '=', $page_id)
			  ->delete();
			DB::table('seo_url')
			  ->where('type', '=', 'page')
			  ->where('object', '=', $page_id)
			  ->delete();

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param $url
	 *
	 * @return bool
	 */
	public static function checkURL($url)
	{
		if (DB::table('seo_url')->select('slug', 'type')->where('slug', '=', $url)->count() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param $page_id
	 *
	 * @return bool
	 */
	public static function getURL($page_id)
	{
		$response = DB::table('seo_url')->where('type', '=', 'page')->where('object', '=', $page_id)->get();

		if ( ! empty($response[0]['slug']))
		{
			return $response[0]['slug'];
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param $page_id
	 * @param $url
	 */
	public static function setURL($page_id, $url)
	{
		if ( ! empty($page_id) && ! empty($url))
		{
			$have_url = DB::table('seo_url')->select('type', 'object')->where('type', '=', 'page')->where('object', '=', $page_id)->count();

			if ($have_url)
			{
				$response = DB::table('seo_url')
							  ->where('type', '=', 'page')
							  ->where('object', '=', $page_id)
							  ->update([
										   'slug' => $url,
									   ]);
			}
			else
			{
				$response = DB::table('seo_url')
							  ->insert([
										   'slug'   => $url,
										   'type'   => 'page',
										   'object' => $page_id,
									   ]);
			}

			if ($response)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}
}