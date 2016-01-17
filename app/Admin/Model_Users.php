<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class Model_Users extends Model
{
	/**
	 * Returns array of all users data
	 *
	 * @param $object - string|array - object name - first_name, last_name etc.
	 *
	 * @return
	 */
	public static function getUsersData($object = FALSE)
	{
		$users = DB::table('users_info')
				   ->orderBy('created_at', 'ASC');

		if ( ! empty($object))
		{
			if (is_array($object))
			{
				$users = $users->whereIn('object', $object);
			}
			else
			{
				$users = $users->where('object', '=', $object);
			}
		}

		$users = $users->get();

		return $users;
	}

	/**
	 * Returns array of single user data
	 *
	 * @param $id - int - user id
	 *
	 * @return array
	 */
	public static function getUserData($id)
	{
		$response = [];
		$userData = DB::table('users_info');

		if ( ! empty($id))
		{
			$userData = $userData->where('user_id', '=', $id);
		}

		$userData = $userData->get();

		if (is_array($userData))
		{
			foreach ($userData as $key => $data)
			{
				$response[$data['object']] = $data['value'];
			}
		}

		return $response;
	}

	/**
	 * Get users list or user by id
	 *
	 * @param $id - int|array
	 */
	public static function getUsers($id = FALSE)
	{
		$users = DB::table('users')
				   ->orderBy('created_at', 'ASC');

		if ( ! empty($id))
		{
			if (is_array($id))
			{
				$users = $users->whereIn('id', $id);
			}
			else
			{
				$users = $users->where('id', $id);
			}
		}

		$users = $users->get();

		if ( ! empty($id))
		{
			$users = $users[0];
		}

		return $users;
	}

	/**
	 *    Get user full info by user ID
	 *
	 * @param $id - user ID
	 *
	 * @return array|bool - user data or false if have error
	 */
	public static function getUserFullInfo($id)
	{
		if ( ! empty($id) && ! empty(intval($id)))
		{
			//Get users data
			$users = array_merge(self::getUsers($id), self::getUserData($id));

			//If have result - return it
			if ( ! empty($users) && is_array($users))
			{
				return $users;
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

	public static function updateUserInfo($user_id, $update_data)
	{
		if ( ! empty($user_id) && ! empty($update_data))
		{
			$current_data = self::getUserData($user_id);
			$new_data     = array_diff_key($update_data, $current_data);

			foreach ($new_data as $key => $data)
			{
				unset($update_data[$key]);

				if ($data != '' && ! empty($data))
				{
					DB::table('users_info')->insert(
						['user_id' => $user_id, 'object' => $key, 'value' => $data, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
					);
				}
			}

			foreach ($update_data as $key => $data)
			{
				if (isset($current_data[$key]) && $data != $current_data[$key])
				{
					DB::table('users_info')
					  ->where('object', '=', $key)
					  ->where('user_id', '=', $user_id)
					  ->update(['user_id' => $user_id, 'value' => $data, 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}

			return TRUE;

		}
		else
		{
			return FALSE;
		}
	}

	public static function getSentinelUserByID($user_id)
	{
		if ( ! empty($user_id))
		{
			return Sentinel::findById($user_id);
		}
		else
		{
			return FALSE;
		}
	}

	public static function getLoggedUserID()
	{
		$user = Sentinel::check();

		return $user->id;
	}

	public static function setUserGroup($user_id, $group)
	{
		if (isset($group) && $group == 0 || $group == 1)
		{
			DB::table('users')
			  ->where('id', '=', $user_id)
			  ->update(['admin' => $group, 'updated_at' => date('Y-m-d H:i:s')]);

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * 	Get user group - admin (int 1) or user (int 0)
	 * @param $user_id
	 * @param bool $email
	 *
	 * @return bool
	 */
	public static function getUserGroup($user_id, $email = FALSE)
	{
		if ( ! empty($user_id) || (empty($user_id) && !empty($email)))
		{
			$response = DB::table('users')
					 ->select('admin');

			if(!empty($email)) {
				$response = $response->where('email', '=', $email);
			} else {
				$response = $response->where('id', '=', $user_id);
			}

			$response = $response->get();

			if(!empty($response) && isset($response[0]['admin'])) {
				return $response[0]['admin'];
			} else {
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
}
