<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Categories;
use App\Admin\Model_Sliders;
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

class Module_Sliders extends BaseController
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
	 * Display a listing of slliders
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('sliders.sliders');

		$response['sliders'] = Model_Sliders::getSliders();

		$response['blade_custom_css'] = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];

		$response['blade_custom_js'] = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		return Theme::view('sliders.list_sliders', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$response['pageTitle'] = trans('sliders.create');

		$response['blade_custom_css'] = [
			'global/plugins/dropzone/css/dropzone',
			'global/plugins/select2/select2',
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
			//MiniColors_CSS\\
			'global/plugins/jquery-minicolors/jquery.minicolors',
		];

		$response['blade_custom_js'] = [
			'global/plugins/dropzone/dropzone',
			'admin/pages/scripts/form-dropzone',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'admin/pages/scripts/components-dropdowns',
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
			//MiniColors_JS\\
			'global/plugins/jquery-minicolors/jquery.minicolors.min',
		];

		$response['slider_dir']        = uniqid('slider_');
		$response['images_dir']        = Config::get('system_settings.sliders_upload_path');
		$response['public_images_dir'] = Config::get('system_settings.sliders_public_path');
		$response['categories']        = Model_Categories::getCategory(FALSE, ['title']);

		return Theme::view('sliders.create_edit_slider', $response);
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
		$response['message'] = trans('sliders.not_saved');

		if ( ! empty($_POST))
		{
//			Save slides
			if ( ! empty($slides) && $slides == 'slides')
			{
				$response['message'] = trans('sliders.slides_not_saved');

				if ( ! empty(Input::get('slides')) && ! empty(Input::get('slides_positions')) && ! empty(Input::get('slider_id')))
				{
					if (Model_Sliders::setSlides(intval(Input::get('slider_id')), Input::get('slides'), Input::get('slides_positions')) === TRUE)
					{
						$response['status']  = 'success';
						$response['message'] = trans('sliders.slides_saved');
					}
				}
				else
				{
					if (Model_Sliders::removeSlides(intval(Input::get('slider_id'))) === TRUE)
					{
						$response['status']  = 'success';
						$response['message'] = trans('sliders.slides_saved');
					}
				}

			}
			else
			{
//				Save slider
				$error = FALSE;

				if (empty(trim(Input::get('title'))))
				{
					$response['message'] = trans('sliders.title_required');
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
						if (($slider_id = Model_Sliders::insertSlider($data)) != FALSE)
						{
							$response['status']   = 'success';
							$response['message']  = trans('sliders.saved');
							$response['id']       = $slider_id;
							$response['redirect'] = TRUE;
						}
					}
					elseif (($id = intval(Input::get('id'))) > 0)
					{
						if (Model_Sliders::updateSlider($id, $data) != FALSE)
						{
							$response['status']  = 'success';
							$response['message'] = trans('sliders.saved');
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

			if (is_dir(Config::get('system_settings.sliders_upload_path').DIRECTORY_SEPARATOR.$target))
			{
				$images = array_diff(scandir(Config::get('system_settings.sliders_upload_path').DIRECTORY_SEPARATOR.$target), array('..', '.'));

				if ( ! empty($images) && is_array($images))
				{
					foreach ($images as $key => $data)
					{
						$images_array[$data] = 0;
					}
				}
			}

			$slider_data = Model_Sliders::getSliders(FALSE, FALSE, ['slides', 'slides_positions'], $target);
			if ( ! empty($slider_data) && ! empty($slider_data[0]))
			{
				$slider_data = $slider_data[0];
			}

			if ( ! empty($slider_data['slides_positions']))
			{
				$saved_images = json_decode($slider_data['slides_positions'], TRUE);
				$images_array = array_merge($images_array, $saved_images);
			}

			if ( ! empty($slider_data['slides_positions']))
			{
				$response['image_data'] = json_decode($slider_data['slides'], TRUE);
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
			$response['thumbs_path'] = Config::get('system_settings.sliders_public_path').$target;

			return Theme::view('sliders.show_slider_form_partial', $response);
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
		$response['pageTitle'] = trans('sliders.edit');

		$response['blade_custom_css'] = [
			'global/plugins/jquery-minicolors/jquery.minicolors',
			'global/plugins/dropzone/css/dropzone',
			'global/plugins/select2/select2',
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
		];

		$response['blade_custom_js'] = [
			'global/plugins/jquery-minicolors/jquery.minicolors.min',
			'global/plugins/dropzone/dropzone',
			'admin/pages/scripts/form-dropzone',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'admin/pages/scripts/components-dropdowns',
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
		];

		$response['images_dir']        = Config::get('system_settings.sliders_upload_path');
		$response['public_images_dir'] = Config::get('system_settings.sliders_public_path');
		$response['categories']        = Model_Categories::getCategory(FALSE, ['title']);
		$response['slider']            = Model_Sliders::getSliders($id, FALSE, ['id', 'title', 'dir', 'active_from', 'active_to', 'position', 'type', 'target']);

		if ( ! empty($response['slider']) && ! empty($response['slider'][0]))
		{
			$response['slider'] = $response['slider'][0];
		}

		if ( ! empty($response['slider']['active_from']) && $response['slider']['active_from'] == '0000-00-00 00:00:00')
		{
			$response['slider']['active_from'] = '';
		}

		if ( ! empty($response['slider']['active_to']) && $response['slider']['active_to'] == '0000-00-00 00:00:00')
		{
			$response['slider']['active_to'] = '';
		}

		return Theme::view('sliders.create_edit_slider', $response);
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
			$path = Config::get('system_settings.sliders_upload_path');

			if (file_exists($path.Input::get('dir').DIRECTORY_SEPARATOR.Input::get('image')))
			{
				unlink($path.Input::get('dir').DIRECTORY_SEPARATOR.Input::get('image'));
			}

			$response['status']  = 'success';
			$response['message'] = trans('sliders.image_removed');
		}
		elseif ($method === FALSE || $method == 'slider')
		{
			$response['status']  = 'error';
			$response['message'] = trans('sliders.not_removed');

			if ( ! empty($id) && intval($id) > 0)
			{
				$dir = Config::get('system_settings.sliders_upload_path');
				if (Model_Sliders::removeSlider($id, $dir) === TRUE)
				{
					$response['status']  = 'success';
					$response['message'] = trans('sliders.removed');
				}
			}
		}

		return response()->json($response);
	}
}
