<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Admin\Model_Users;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use Caffeinated\Themes\Facades\Theme;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

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
			'custom/js/users',
		];

		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;
		$response['pageTitle'] = trans('global.users_list');
//$this->dd($response);

		return Theme::view('users.users_list', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$response['pageTitle'] = trans('global.create_user');

		return Theme::view('users.user_register', $response);
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
		if ( ! empty(($request['email'] = $_POST['email'])) &&
			! empty(($request['password'] = $_POST['password']))
		)
		{

			if ( ! Sentinel::findByCredentials($request))
			{
				if (Sentinel::registerAndActivate($request))
				{
					$response['status']  = 'success';
					$response['message'] = 'User was created successfully.';
				}
				else
				{
					$response['status']  = 'error';
					$response['message'] = 'User was not created successfully.';
				}
			}
			else
			{
				$response['status']  = 'error';
				$response['message'] = 'User with this email is already registered.';
			}

		}
		else
		{
			$response['status']  = 'warning';
			$response['message'] = 'All fields are required.';
		}

		echo json_encode($response);
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

			return Theme::view('users.users_edit', $response);
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
				$user_data['first_name'] = ( ! empty($_POST['first_name'])) ? $_POST['first_name'] : '';
				$user_data['last_name']  = ( ! empty($_POST['last_name'])) ? $_POST['last_name'] : '';
				$user_data['phone']      = ( ! empty($_POST['phone'])) ? $_POST['phone'] : '';
				$user_data['address']    = ( ! empty($_POST['address'])) ? $_POST['address'] : '';
				$user_data['city']       = ( ! empty($_POST['city'])) ? $_POST['city'] : '';
				$user_data['country']    = ( ! empty($_POST['country'])) ? $_POST['country'] : '';

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
				$user_data['password']        = ( ! empty($_POST['password'])) ? $_POST['password'] : '';
				$user_data['new_password']    = ( ! empty($_POST['new_password'])) ? $_POST['new_password'] : '';
				$user_data['re_new_password'] = ( ! empty($_POST['re_new_password'])) ? $_POST['re_new_password'] : '';

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
				$user_group = ( isset($_POST['user_group']) ? $_POST['user_group'] : 0);

				if($user_group == 0 || $user_group == 1) {
					if(Model_Users::setUserGroup($id, $user_group) === TRUE ) {
						$response['status'] = 'success';
						$response['message'] = trans('user_notifications.user_group_changed');
					}
				}
			}
		}

		echo json_encode($response);
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
		//
	}
}
