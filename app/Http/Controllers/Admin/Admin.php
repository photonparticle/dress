<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Orders;
use App\Admin\Model_Users;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Custom packages
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Config;
use View;

class Admin extends BaseController
{
	private $active_module = '';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('users', $modules))
		{
			$this->active_module = 'dashboard';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	public function index()
	{
		$customCSS = [

		];
		$customJS  = [
			'global/plugins/flot/jquery.flot',
			'global/plugins/flot/jquery.flot.resize',
			'global/plugins/flot/jquery.flot.categories',
			'admin/pages/scripts/ecommerce-index',
		];

		$response = [
			'blade_custom_css' => $customCSS,
			'blade_custom_js'  => $customJS,
		];

		$response['total_sales'] = intval(Model_Orders::getTotalSales());
		$response['count_sales'] = intval(Model_Orders::getCountSales());
		$response['avg_sales']   = intval(Model_Orders::getAvgSales());

		if ( ! empty(($last_orders = Model_Orders::getOrders(FALSE, TRUE, FALSE, 0, 20))))
		{
			foreach ($last_orders as $key => $order)
			{
				$response['last_orders'][$key]['id']         = $order['id'];
				$response['last_orders'][$key]['first_name'] = $order['name'];
				$response['last_orders'][$key]['last_name']  = $order['last_name'];
				$response['last_orders'][$key]['created_at'] = date('d.m.Y H:i', strtotime($order['created_at']));
				$response['last_orders'][$key]['status']     = trans('dashboard.'.$order['status']);

				switch ($order['status'])
				{
					case 'pending':
						$response['last_orders'][$key]['status_color'] = 'bg-green-jungle';
						break;
					case 'confirmed':
						$response['last_orders'][$key]['status_color'] = 'bg-yellow-casablanca';
						break;
					case 'completed':
						$response['last_orders'][$key]['status_color'] = 'bg-blue-madison';
						break;
					case 'canceled':
						$response['last_orders'][$key]['status_color'] = 'bg-red-thunderbird';
						break;
				}

			}
		}

		if ( ! empty(($last_users = Model_Users::getUsers(FALSE, FALSE, 0, 20))))
		{
			if ( ! empty(($users_data = Model_Users::getUsersData(['first_name', 'last_name'], 0, 20))))
			{
				//Merge users and users data
				foreach ($last_users as $key => $user)
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
							$response['last_users'][$user_id][$user_info_key] = $user_info;
						}
					}
				}
				foreach ($users_data as $key => $data)
				{
					$response['last_users'][$data['user_id']][$data['object']] = $data['value'];
				}

			}
		}

		if ( ! empty($response['last_orders']))
		{
			$response['last_orders_count'] = count($response['last_orders']);
		}
		if ( ! empty($response['last_users']))
		{
			$response['last_users_count'] = count($response['last_users']);
		}

		$date_seven_days_ago    = date('Y-m-d 00:00:00', strtotime('-7 days'));
		$last_seven_days_orders = Model_Orders::getOrders(FALSE, TRUE, FALSE, 0, 0, $date_seven_days_ago, date('Y-m-d H:i:s', time()));

		$count = 1;
		$response['graph'][date('d.m', time())] = 0.00;
		$response['graph2'][date('d.m', time())] = 0;
		while ($count <= 6)
		{
			$date                     = date('d.m', strtotime('-'.$count.' days'));
			$response['graph'][$date] = 0.00;
			$response['graph2'][$date] = 0;

			$count++;
		}

		if ( ! empty($last_seven_days_orders) && is_array($last_seven_days_orders))
		{
			foreach ($last_seven_days_orders as $key => $order)
			{
				$date                     = date('d.m', strtotime($order['created_at']));
				$amount                   = Model_Orders::getTotalSales($order['id']);
				$response['graph'][$date] = $response['graph'][$date] + $amount;
				$response['graph2'][$date] = $response['graph2'][$date] + 1;
			}
		}
		//Sort by date
		ksort($response['graph']);
		ksort($response['graph2']);

//		dd($response['graph']);

		return Theme::view('dashboard.index', $response);
	}
}
