<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Admin\Model_Users;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use Caffeinated\Themes\Facades\Theme;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Input;

class Module_Users extends BaseController
{
	/**
	 * Display a listing of the users
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		//Get users
		$response = [];
		$users    = Model_Users::getUsers();
		//Get users data
		$users_data_to_retrive = [
			'first_name',
			'last_name',
		];
		$users_data            = Model_Users::getUsersData($users_data_to_retrive);

		//Merge users and users data
		foreach ($users as $key => $user)
		{
			$user_id = $user['id'];
			foreach ($user as $user_info_key => $user_info)
			{
				//Do not pass sensitive data to view
				if (
					$user_info_key != 'password' &&
					$user_info_key != 'remember_token' &&
					$user_info_key != 'updated_at' &&
					$user_info_key != 'last_login'
				)
				{
					$response['users'][$user_id][$user_info_key] = $user_info;
				}
			}
		}
		foreach ($users_data as $key => $data)
		{
			$response['users'][$data['user_id']][$data['object']] = $data['value'];
		}

		$customCSS = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];

		$customJS = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min'
		];

		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;
		$response['pageTitle'] = trans('global.users_list');
//$this->dd($response);

		return Theme::view('users.list_users', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$response['pageTitle'] = trans('global.create_user');

		return Theme::view('users.register_user', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postStore()
	{
		if ( ! empty(($request['email'] = Input::get('email'))) &&
			! empty(($request['password'] = Input::get('password')))
		)
		{

			if ( ! Sentinel::findByCredentials($request))
			{
				if(mb_strlen(Input::get('password')) < 8) {
					$response['status']  = 'warning';
					$response['message'] = trans('user_notifications.password_length');
				} else {
					if (Sentinel::registerAndActivate($request))
					{
						$response['status']  = 'success';
						$response['message'] = trans('user_notifications.user_created');
					}
					else
					{
						$response['status']  = 'error';
						$response['message'] = trans('user_notifications.user_not_created');
					}
				}
			}
			else
			{
				$response['status']  = 'error';
				$response['message'] = trans('user_notifications.user_exists');
			}

		}
		else
		{
			$response['status']  = 'warning';
			$response['message'] = trans('global.all_fields_required');
		}

		return response()->json($response);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getShow($id)
	{
		$reponse = [];
		$response['pageTitle'] = trans('global.user_profile');

		return Theme::view('users.user_profile', $response);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getEdit($id = FALSE)
	{
		if ( ! empty($id) && ! empty(intval($id)))
		{
			//Get user data
			$response            = Model_Users::getUserData(intval($id));
			$response['user_id'] = $id;
			//Do not pass sensitive data to view
			$remove = ['password', 'remember_token', 'last_login', 'created_at', 'updated_at'];

			foreach ($remove as $key => $object)
			{
				unset($response[$key]);
			}

			$response['pageTitle'] = trans('global.edit') . ' - ' . trans('global.users');
			$response['blade_custom_css'] = [
				'global/plugins/bootstrap-select/bootstrap-select.min',
				'global/plugins/select2/select2',
				'global/plugins/jquery-multi-select/css/multi-select'
			];
			$response['blade_custom_js'] = [
				'admin/pages/scripts/components-dropdowns',
				'global/plugins/bootstrap-select/bootstrap-select.min',
				'global/plugins/bootstrap-select/bootstrap-select.min',
				'global/plugins/select2/select2.min',
				'global/plugins/jquery-multi-select/js/jquery.multi-select',
			];
			$response['is_admin'] = Model_Users::getUserGroup($id);

			return Theme::view('users.edit_user', $response);
		}
		else
		{
			$this->redirectTo('/admin/users');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @param  int $action
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postUpdate(Request $request, $id, $action)
	{
		$response['status']  = 'error';
		$response['message'] = trans('user_notifications.user_info_not_updated');

		if ( ! empty(($request)) && ! empty($id) && ! empty($action))
		{
			if ($action == 'personal_info')
			{
				$user_data['first_name'] = ( ! empty(Input::get('first_name'))) ? Input::get('first_name') : '';
				$user_data['last_name']  = ( ! empty(Input::get('last_name'))) ? Input::get('last_name') : '';
				$user_data['phone']      = ( ! empty(Input::get('phone'))) ? Input::get('phone') : '';
				$user_data['address']    = ( ! empty(Input::get('address'))) ? Input::get('address') : '';
				$user_data['city']       = ( ! empty(Input::get('city'))) ? Input::get('city') : '';
				$user_data['country']    = ( ! empty(Input::get('country'))) ? Input::get('country') : '';

				if (Model_Users::updateUserInfo($id, $user_data) === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('user_notifications.personal_info_updated');
				}
				else
				{
					$response['message'] = trans('user_notifications.personal_info_not_updated');
				}
			}
			elseif ($action == 'change_password')
			{
				$user_data['password']        = ( ! empty(Input::get('password'))) ? Input::get('password') : '';
				$user_data['new_password']    = ( ! empty(Input::get('new_password'))) ? Input::get('new_password') : '';
				$user_data['re_new_password'] = ( ! empty(Input::get('re_new_password'))) ? Input::get('re_new_password') : '';

				if ( ! empty($user_data['password']) && ! empty($user_data['new_password']) && ! empty($user_data['re_new_password']))
				{
					$user   = Model_Users::getSentinelUserByID($id);
					$hasher = Sentinel::getHasher();

					if ( ! Sentinel::validateCredentials($user, ['email' => $user->email, 'password' => $user_data['password']]))
					{
						$response['message'] = trans('user_notifications.old_password_do_not_match');
					}
					elseif (
						$hasher->check($user_data['password'], $user_data['new_password']) ||
						$user_data['new_password'] != $user_data['re_new_password']
					)
					{
						$response['message'] = trans('user_notifications.new_passwords_do_not_match');
					} elseif(
						mb_strlen($user_data['new_password']) < 8
					) {
						$response['status'] = 'warning';
						$response['message'] = trans('user_notifications.password_length');
					}
					else
					{
						if (Sentinel::update($user, ['password' => $user_data['new_password']]))
						{
							$response['status']  = 'success';
							$response['message'] = trans('user_notifications.password_changed');
						}
					}
				}
			} elseif ($action == 'user_group') {
				$user_group = ( !empty(Input::get('user_group')) ? Input::get('user_group') : 0);

				if($user_group == 0 || $user_group == 1) {
					if(Model_Users::setUserGroup($id, $user_group) === TRUE ) {
						$response['status'] = 'success';
						$response['message'] = trans('user_notifications.user_group_changed');
					}
				}
			}
		}

		return response()->json($response);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postDestroy($id)
	{
		$response['status'] = 'error';
		$response['message'] = trans('user_notifications.user_not_removed');

		if(!empty($id) && intval($id) > 0) {
			if(Model_Users::removeUser($id) === TRUE) {
				$response['status'] = 'success';
				$response['message'] = trans('user_notifications.user_removed');
			}
		}

		return response()->json($response);
	}
}
