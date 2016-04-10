<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class Model_System_Settings extends Model
{
	/**
	 * @param bool $object - int|array - FALSE for to get all pages
	 * @param array $objects
	 * @param bool $for_list
	 *
	 * @return array
	 */
	public static function getSetting($object = FALSE, $objects = [], $for_list = FALSE)
	{
		$settings = DB::table('system_settings')
					  ->orderBy('object', 'ASC');

		if ( ! empty($objects) && is_array($objects))
		{
			$settings = $settings->select($objects);
		}

		if (is_array($object))
		{
			$settings = $settings->whereIn('id', $object);
		}
		elseif (is_string($object) || is_int($object))
		{
			$settings = $settings->where('id', '=', $object);
		}

		$settings = $settings->get();

		//Rebuild array
		$response = [];

		if ( ! empty($settings) && is_array($settings))
		{
			foreach ($settings as $setting)
			{
				$response[$setting['object']] = [
					'value' => $setting[$setting['type']],
					'type'  => $setting['type'],
				];
			}
		}

		if ($for_list === TRUE)
		{
			if ( ! empty($response) && is_array($response))
			{
				foreach ($response as $name => $setting)
				{
					unset($response[$name]);
					$response[$name] = $setting['value'];
				}
			}
		}

		return $response;
	}

	public static function saveSettings($data)
	{
		$object_types = [
			'title'                  => 'string',
			'email'                  => 'string',
			'phone'                  => 'string',
			'work_time'              => 'text',
			'quantity'               => 'number',
			'page_title'             => 'string',
			'meta_description'       => 'string',
			'meta_keywords'          => 'string',
			'delivery_to_office'     => 'string',
			'delivery_to_address'    => 'string',
			'delivery_free_delivery' => 'string',
		];

		if ( ! empty($data))
		{
			$objects         = [];
			$current_objects = self::getSetting();
			$update_objects  = [];
			$insert_objects  = [];

			if ( ! empty($object_types) && is_array($object_types))
			{
				foreach ($object_types as $object => $type)
				{
					if (isset($data[$object]))
					{
						$objects[$object] = [
							'value' => $data[$object],
							'type'  => $type,
						];
					}
				}
			}

			//Determine update and insert objects
			foreach ($objects as $name => $object)
			{
				if (is_array($current_objects))
				{
					if (array_key_exists($name, $current_objects))
					{
						$update_objects[$name] = $object;
					}
					else
					{
						$insert_objects[$name] = $object;
					}
				}
				else
				{
					$insert_objects[$name] = $object;
				}
			}

			//Process update objects
			if (is_array($update_objects))
			{
				foreach ($update_objects as $name => $object)
				{
					if ( ! empty($object['value']) && ! empty($object['type']))
					{
						DB::table('system_settings')
						  ->where('object', '=', $name)
						  ->update([
									   'object'        => $name,
									   'type'          => $object['type'],
									   $object['type'] => $object['value'],
								   ]);
					}
				}
			}

			//Process insert objects
			if (is_array($insert_objects))
			{
				foreach ($insert_objects as $name => $object)
				{
					if ( ! empty($object['value']) && ! empty($object['type']))
					{
						DB::table('system_settings')
						  ->insert([
									   'object'        => $name,
									   'type'          => $object['type'],
									   $object['type'] => $object['value'],
								   ]);
					}
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