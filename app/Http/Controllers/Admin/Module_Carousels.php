<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Categories;
use App\Admin\Model_Carousels;
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

class Module_Carousels extends BaseController
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
	 * Display a listing of tables
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('tables.tables');

		$response['carousels']            = Model_Carousels::getCarousels();

		$response['blade_custom_css'] = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];

		$response['blade_custom_js']  = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		return Theme::view('carousels.list_carousels', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$response['pageTitle'] = trans('carousels.create');

		$response['blade_custom_css'] = [
			'global/plugins/dropzone/css/dropzone',
			'global/plugins/select2/select2',
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
		];

		$response['blade_custom_js'] = [
			'global/plugins/dropzone/dropzone',
			'admin/pages/scripts/form-dropzone',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'admin/pages/scripts/components-dropdowns',
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
		];

		$response['carousel_dir']        = uniqid('carousel_');
		$response['images_dir']        = Config::get('system_settings.carousels_upload_path');
		$response['public_images_dir'] = Config::get('system_settings.carousels_public_path');
		$response['categories']        = Model_Categories::getCategory(FALSE, ['title']);

		return Theme::view('carousels.create_edit_carousel', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param bool $slides
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postStore($slides = FALSE)
	{
		$response['status']  = 'error';
		$response['message'] = trans('carousels.not_saved');

		if ( ! empty($_POST))
		{
//			Save slides
			if ( ! empty($slides) && $slides == 'slides' && ! empty(Input::get('slides')) && ! empty(Input::get('slides_positions')) && ! empty(Input::get('carousel_id')))
			{
				$response['message'] = trans('carousels.slides_not_saved');

				if (Model_Carousels::setSlides(intval(Input::get('carousel_id')), Input::get('slides'), Input::get('slides_positions')) === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('carousels.slides_saved');
				}

			}
			else
			{
//				Save carousel
				$error = FALSE;

				if (empty(trim(Input::get('title'))))
				{
					$response['message'] = trans('carousels.title_required');
					$error               = TRUE;
				}

				if ($error === FALSE)
				{
					$data = [
						'title'       => trim(Input::get('title')),
						'position'    => trim(Input::get('position')),
						'type'        => Input::get('type'),
						'target'      => Input::get('target'),
						'active_from' => Input::get('active_from'),
						'active_to'   => Input::get('active_to'),
						'dir'         => Input::get('dir'),
					];

					if (empty(Input::get('id')))
					{
						if (($carousel_id = Model_Carousels::insertCarousel($data)) != FALSE)
						{
							$response['status']   = 'success';
							$response['message']  = trans('carousels.saved');
							$response['id']       = $carousel_id;
							$response['redirect'] = TRUE;
						}
					}
					elseif (($id = intval(Input::get('id'))) > 0)
					{
						if (Model_Carousels::updateCarousel($id, $data) != FALSE)
						{
							$response['status']  = 'success';
							$response['message'] = trans('carousels.saved');
							$response['id']      = $id;
						}
					}
				}
			}
		}

		return response()->json($response);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param bool|string $target
	 * @param $object
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getShow($object = FALSE, $target = FALSE)
	{
		$response['blade_standalone'] = TRUE;

		if ($object == 'sync_images' && ! empty($target))
		{
			//Get images
			$images_array = [];

			if (is_dir(Config::get('system_settings.carousels_upload_path').DIRECTORY_SEPARATOR.$target))
			{
				$images = array_diff(scandir(Config::get('system_settings.carousels_upload_path').DIRECTORY_SEPARATOR.$target), array('..', '.'));

				if ( ! empty($images) && is_array($images))
				{
					foreach ($images as $key => $data)
					{
						$images_array[$data] = 0;
					}
				}
			}

			$carousel_data = Model_Carousels::getCarousels(FALSE, FALSE, ['slides', 'slides_positions'], $target);
			if ( ! empty($carousel_data) && ! empty($carousel_data[0]))
			{
				$carousel_data = $carousel_data[0];
			}

			if ( ! empty($carousel_data['slides_positions']))
			{
				$saved_images = json_decode($carousel_data['slides_positions'], TRUE);
				$images_array = array_merge($images_array, $saved_images);
			}

			if ( ! empty($carousel_data['slides_positions']))
			{
				$response['image_data'] = json_decode($carousel_data['slides'], TRUE);
			}

			//Sort by position
			if ( ! empty($images_array) && is_array($images_array))
			{
				uasort($images_array, function ($a, $b)
				{
					if ($a == $b)
					{
						return 0;
					}

					return ($a < $b) ? -1 : 1;
				});
			}

			$response['images']      = $images_array;
			$response['thumbs_path'] = Config::get('system_settings.carousels_public_path').$target;

			return Theme::view('carousels.show_carousel_form_partial', $response);
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
		$response['pageTitle'] = trans('carousels.edit');

		$response['blade_custom_css'] = [
			'global/plugins/dropzone/css/dropzone',
			'global/plugins/select2/select2',
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
		];

		$response['blade_custom_js'] = [
			'global/plugins/dropzone/dropzone',
			'admin/pages/scripts/form-dropzone',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'admin/pages/scripts/components-dropdowns',
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
		];

		$response['images_dir']        = Config::get('system_settings.carousels_upload_path');
		$response['public_images_dir'] = Config::get('system_settings.carousels_public_path');
		$response['categories']        = Model_Categories::getCategory(FALSE, ['title']);
		$response['carousel']            = Model_Carousels::getCarousels($id, FALSE, ['id', 'title', 'dir', 'active_from', 'active_to', 'position', 'type', 'target']);

		if ( ! empty($response['carousel']) && ! empty($response['carousel'][0]))
		{
			$response['carousel'] = $response['carousel'][0];
		}

		return Theme::view('carousels.create_edit_carousel', $response);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param bool $method
	 * @param bool|int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postDestroy($method = FALSE, $id = FALSE)
	{
		if ($method == 'image' && ! empty(Input::get('image')) && ! empty(Input::get('dir')))
		{
			$response['status']  = 'error';
			$response['message'] = trans('carousels.image_not_removed');
			$path                = Config::get('system_settings.carousels_upload_path');

			if (file_exists($path.Input::get('dir').DIRECTORY_SEPARATOR.Input::get('image')))
			{
				if (unlink($path.Input::get('dir').DIRECTORY_SEPARATOR.Input::get('image')))
				{
					$response['status']  = 'success';
					$response['message'] = trans('carousels.image_removed');
				}
			}
		}
		elseif ($method === FALSE || $method == 'carousel')
		{
			$response['status']  = 'error';
			$response['message'] = trans('carousels.not_removed');

			if ( ! empty($id) && intval($id) > 0)
			{
				$dir = Config::get('system_settings.carousels_upload_path');
				if (Model_Carousels::removeCarousel($id, $dir) === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('carousels.removed');
				}
			}
		}

		return response()->json($response);
	}
}
