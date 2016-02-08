<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Tags;
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

class Module_Tags extends BaseController
{
	private $active_module = '';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('modules', $modules))
		{
			$this->active_module = 'modules';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);
	}

	/**
	 * Display a listing of tags
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('tags.tags');
/**
		$response['tags'] = Model_tags::gettags();
*/
		$response['blade_custom_js'] = [
			'global/plugins/bootbox/bootbox.min',
		];

		return Theme::view('tags.list', $response);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postDestroy($id = FALSE)
	{
		$response['status']  = 'error';
		$response['message'] = trans('tags.not_removed');

		if ( ! empty($id) && intval($id) > 0)
		{
			if (Model_Tags::removeTag($id) === TRUE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('tags.removed');
			}
		}

		return response()->json($response);
	}
}
