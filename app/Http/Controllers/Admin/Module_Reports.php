<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Reports;
use App\Admin\Model_Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use Caffeinated\Themes\Facades\Theme;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Symfony\Component\DomCrawler\Form;
use View;

class Module_Reports extends BaseController
{
	private $active_module = '';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('modules', $modules))
		{
			$this->active_module = 'reports';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	/**
	 * Display a listing of tables
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('global.reports');

		$response['blade_custom_css'] = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];
		$response['blade_custom_js']  = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min',
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		$response['current_time'] = date('Y-m-d');

		return Theme::view('reports.reports', $response);
	}

	/**
	 * Used to display partials or do ajax requests
	 *
	 * @param $date_start
	 * @param $date_end
	 * @param bool $group_by
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 */
	public function postStore()
	{
		if (empty(($group_by = Input::get('group_by'))))
		{
			echo 'select_group_by';
			exit;
		}

		if ( ! empty(($date_start = Input::get('date_start'))) && ! empty(($date_end = Input::get('date_end'))) &&
			strtotime(($date_start_unix = Input::get('date_start'))) !== FALSE &&
			strtotime(($date_end_unix = Input::get('date_end'))) !== FALSE
		)
		{
			$response = [];

			if ($group_by == 'days')
			{
				$days = $this->createDateRangeArray($date_start, $date_end);
				if ( ! empty($days) && is_array($days))
				{
					foreach ($days as $key => $data)
					{
						$date_range[$key]['date_start'] = $data.' 00:00:00';
						$date_range[$key]['date_end']   = $data.' 23:59:59';
					}
				}
			}
			elseif ($group_by == 'weeks')
			{
				$weeks = $this->createWeeksRangeArray($date_start, $date_end);
				if ( ! empty($weeks) && is_array($weeks))
				{
					foreach ($weeks as $key => $data)
					{
						$date_range[$key]['date_start'] = $data['date_start'].' 00:00:00';
						$date_range[$key]['date_end']   = $data['date_end'].' 23:59:59';
					}
				}
			}
			elseif ($group_by == 'months')
			{
				$months = $this->getMonthsInRange($date_start, $date_end);

				if ( ! empty($months) && is_array($months))
				{
					foreach ($months as $key => $data)
					{
						$date_range[$key]['date_start'] = $data['year'].'-'.$data['month'].'-01';
						$date_range[$key]['date_end']   = $data['year'].'-'.$data['month'].'-'.cal_days_in_month(CAL_GREGORIAN, $data['month'], $data['year']);
					}
				}
			}

			if ( ! empty($date_range) && is_array($date_range))
			{
//					dd($date_range);
				foreach ($date_range as $date)
				{
					$results = [
						'date_start'     => date('Y-m-d', strtotime($date['date_start'])),
						'date_end'       => date('Y-m-d', strtotime($date['date_end'])),
						'orders'         => 0,
						'products'       => 0,
						'total'          => 0,
						'profit'         => 0,
						'original_total' => 0,
					];

					if (($data = Model_Reports::getOrders($date['date_start'], $date['date_end'])))
					{
						//Loop trough results
						if ( ! empty($data) && is_array($data))
						{
							foreach ($data as $key => $item)
							{
								$results['orders']         = $results['orders'] + 1;
								$results['products']       = $results['products'] + $item['products'];
								$results['total']          = $results['total'] + $item['total'];
								$results['original_total'] = $results['original_total'] + floatval($item['original_total']);
							}
						}
					}

					$response['results'][] = $results;
				}

				foreach ($response['results'] as $key => $object)
				{
					//Calculate profits
					if ( ! empty($object['original_total']))
					{
						$response['results'][$key]['profit'] = $object['total'] - $object['original_total'];
						unset($response['results'][$key]['original_total']);
					}
				}

				return Theme::view('reports.reports_table_partial', $response);
			}
		}
		else
		{
			echo 'invalid_dates';
		}
	}

	private function createDateRangeArray($strDateFrom, $strDateTo)
	{
		// takes two dates formatted as YYYY-MM-DD and creates an
		// inclusive array of the dates between the from and to dates.

		// could test validity of dates here but I'm already doing
		// that in the main script

		$aryRange = array();

		$iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
		$iDateTo   = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

		if ($iDateTo >= $iDateFrom)
		{
			array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
			while ($iDateFrom < $iDateTo)
			{
				$iDateFrom += 86400; // add 24 hours
				if ($iDateFrom < $iDateTo)
				{
					array_push($aryRange, date('Y-m-d', $iDateFrom));
				}
			}
		}

		return $aryRange;
	}
	private function createWeeksRangeArray($strDateFrom, $strDateTo)
	{
		// takes two dates formatted as YYYY-MM-DD and creates an
		// inclusive array of the dates between the from and to dates.

		// could test validity of dates here but I'm already doing
		// that in the main script

		$aryRange = array();

		$iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
		$iDateTo   = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

		if ($iDateTo >= $iDateFrom)
		{
			while ($iDateFrom < $iDateTo)
			{
				$date_end = strtotime('next Sunday', strtotime(date('Y-m-d', $iDateFrom)));
				$date_end_print = date('Y-m-d', $date_end);

				if ($iDateFrom < $iDateTo)
				{
					$dates = [
						'date_start' => date('Y-m-d', $iDateFrom),
						'date_end' => $date_end_print
					];
				}

				$iDateFrom = $date_end + 86400;

				array_push($aryRange, $dates);
			}
		}

		return $aryRange;
	}

	private function getMonthsInRange($startDate, $endDate)
	{
		$months = array();
		while (strtotime($startDate) <= strtotime($endDate))
		{
			$months[]  = array('year' => date('Y', strtotime($startDate)), 'month' => date('m', strtotime($startDate)),);
			$startDate = date('d M Y', strtotime($startDate.
												 '+ 1 month'));
		}

		return $months;
	}
}
