<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Pages;
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

class Module_Pages extends BaseController
{
	private $active_module = '';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('modules', $modules))
		{
			$this->active_module = 'pages';
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
		$response['pageTitle'] = trans('global.pages');

		$response['blade_custom_css'] = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];
		$response['blade_custom_js']  = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		$response['pages'] = Model_Pages::getPage(FALSE, ['id', 'title']);

		return Theme::view('pages.list_pages', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$response['pageTitle'] = trans('pages.create_page');

		$response['blade_custom_css'] = [
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote',
		];

		$response['blade_custom_js'] = [
			'global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0',
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote.min',
			'global/plugins/bootstrap-switch/js/bootstrap-switch.min',
			'global/plugins/jquery-slugify/speakingurl',
			'global/plugins/jquery-slugify/slugify.min',
		];

		return Theme::view('pages.create_edit_page', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 * @return \Illuminate\Http\Response
	 */
	public function postStore()
	{
		$response['status']  = 'error';
		$response['message'] = trans('pages.not_saved');

		if ( ! empty($_POST))
		{
			$error = FALSE;

			if (empty(trim(Input::get('title'))))
			{
				$response['message'] = trans('pages.title_required');
				$error               = TRUE;
			}

			if ($error === FALSE)
			{
				$data = [
					'title'            => trim(Input::get('title')),
					'content'          => Input::get('content'),
					'page_title'       => Input::get('page_title'),
					'meta_description' => Input::get('meta_description'),
					'meta_keywords'    => Input::get('meta_keywords'),
					'active'           => Input::get('active'),
					'show_footer'      => Input::get('show_footer'),
				];

				if (empty(Input::get('id')))
				{
					if (($page_id = Model_Pages::createPage($data)) != FALSE)
					{
						try
						{
							//Manage Friendly URL
							Model_Pages::setURL($page_id, Input::get('friendly_url'));

							$response['status']   = 'success';
							$response['message']  = trans('pages.saved');
							$response['id']       = $page_id;
							$response['redirect'] = TRUE;
						} catch (Exception $e)
						{
							$response['message'] = $e;
						}
					}
				}
				elseif (($id = intval(Input::get('id'))) > 0)
				{
					if (Model_Pages::updatePage($id, $data) != FALSE)
					{
						try
						{
							//Manage Friendly URL
							Model_Pages::setURL($id, Input::get('friendly_url'));

							$response['status']  = 'success';
							$response['message'] = trans('pages.saved');
						} catch (Exception $e)
						{
							$response['message'] = $e;
						}
					}
				}
			}
		}

		return response()->json($response);
	}

	/**
	 * Used to display partials or do ajax requests
	 *
	 * @param $request
	 * @param $param
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 */
	public function getShow($request, $param)
	{
		if ( ! empty($request) && ! empty($param))
		{

			if ($request == 'check_url')
			{
				if (Model_Pages::checkURL($param) === TRUE)
				{
					$response['status']  = 'error';
					$response['title']   = trans('global.warning');
					$response['message'] = trans('products.url_exists');

					return response()->json($response);
				}
				else
				{
					return 'available';
				}
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getEdit($id)
	{
		$response['pageTitle'] = trans('pages.create_page');

		$response['blade_custom_css'] = [
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote',
		];

		$response['blade_custom_js'] = [
			'global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0',
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote.min',
			'global/plugins/bootstrap-switch/js/bootstrap-switch.min',
			'global/plugins/jquery-slugify/speakingurl',
			'global/plugins/jquery-slugify/slugify.min',
		];

		$response['page'] = Model_Pages::getPage($id);

		if ( ! empty($response['page'][0]))
		{
			$response['page'] = $response['page'][0];
		}
		//SEO Tab
		if (($slug = Model_Pages::getURL($id)) != FALSE)
		{
			$response['seo']['friendly_url'] = $slug;
		}

		if ( ! empty($response['page']['page_title']))
		{
			$response['seo']['page_title'] = $response['page']['page_title'];
			unset($response['page']['page_title']);
		}

		if ( ! empty($response['page']['meta_description']))
		{
			$response['seo']['meta_description'] = $response['page']['meta_description'];
			unset($response['page']['meta_description']);
		}

		if ( ! empty($response['page']['meta_keywords']))
		{
			$response['seo']['meta_keywords'] = $response['page']['meta_keywords'];
			unset($response['page']['meta_keywords']);
		}

		return Theme::view('pages.create_edit_page', $response);
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
		$response['message'] = trans('pages.not_removed');

		if ( ! empty($id) && intval($id) > 0)
		{
			if (Model_Pages::removePage($id) === TRUE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('pages.removed');
			}
		}

		return response()->json($response);
	}
}
