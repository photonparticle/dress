<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\CountValidator\Exception;

class Model_Sliders extends Model
{

	/**
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function getSliders($id = FALSE, $for_list = TRUE, $objects = FALSE, $by_dir = FALSE)
	{
		$slider = DB::table('sliders');

		if ($for_list === TRUE)
		{
			$slider = $slider->select(['id', 'title', 'image']);
		}

		if ($id != FALSE && intval($id) > 0)
		{
			$slider = $slider->where('id', '=', $id);
		}
		if ($by_dir != FALSE)
		{
			$slider = $slider->where('dir', '=', $by_dir);
		}

		if ($objects !== FALSE && is_array($objects))
		{
			$slider = $slider->select($objects);
		}

		$slider = $slider
			->orderBy('title', 'ASC')
			->get();

		return $slider;
	}

	public static function insertSlider($slider)
	{
		if ( ! empty($slider) && is_array($slider))
		{
			$slider['created_at'] = date('Y-m-d H:i:s');

			$slider = DB::table('sliders')
						->insertGetId($slider);

			if ($slider)
			{
				return $slider;
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
	public static function updateSlider($id, $slider)
	{
		if ( ! empty($slider) && is_array($slider) && ! empty($id))
		{
			$slider['updated_at'] = date('Y-m-d H:i:s');

			$query = DB::table('sliders')
					   ->where('id', '=', $id)
					   ->update($slider);

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
	public static function removeSlider($id)
	{
		if ( ! empty($id))
		{
			try
			{
				$query = DB::table('sliders');

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

	public static function setSlides($id, $slides, $slides_positions)
	{
		if ( ! empty($id) && ! empty($slides) && is_array($slides) && ! empty($slides_positions) && is_array($slides_positions))
		{
			DB::table('sliders')
			  ->where('id', '=', $id)
			  ->update([
						   'slides'           => json_encode($slides),
						   'slides_positions' => json_encode($slides_positions),
					   ]);

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}