<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Products;
use App\Admin\Model_Categories;
use App\Admin\Model_Sizes;
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

class Module_Products extends BaseController
{
	private $active_module = '';
	private $images_path = '';

	public function __construct(Request $request)
	{
		$modules = Config::get('system_settings.modules');
		if (in_array('users', $modules))
		{
			$this->active_module = 'products';
			View::share('active_module', $this->active_module);
		}
		parent::__construct($request);

		$this->images_path = public_path().'/images/products/';
	}

	/**
	 * Display a listing of products
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('global.products');

		$response['products'] = Model_Products::getProducts(FALSE, ['title']);

		$customCSS = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];

		$customJS = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		return Theme::view('products.list_products', $response);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$customCSS                    = [
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2',
			'global/plugins/jquery-multi-select/css/multi-select',
			'global/plugins/bootstrap-switch/css/bootstrap-switch.min',
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
			'global/plugins/dropzone/css/dropzone',
		];
		$customJS                     = [
			'global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0',
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote.min',
			'admin/pages/scripts/components-dropdowns',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'global/plugins/jquery-multi-select/js/jquery.multi-select',
			'global/plugins/fuelux/js/spinner.min',
			'global/plugins/bootstrap-switch/js/bootstrap-switch.min',
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
			'global/plugins/dropzone/dropzone',
			'admin/pages/scripts/form-dropzone',
			'global/plugins/jquery-slugify/speakingurl',
			'global/plugins/jquery-slugify/slugify.min',
		];
		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		$response['pageTitle'] = trans('global.create_product');

		$response['images_dir'] = uniqid('product_');

		$response['categories'] = Model_Categories::getCategory(FALSE, ['title']);
		$response['groups']     = Model_Sizes::getSizes(TRUE);
		$response['products']   = Model_Products::getProducts(FALSE, ['title']);

		return Theme::view('products.create_product', $response);
	}

	/**
	 * Store a newly created resource in storage.
	 * @return \Illuminate\Http\Response
	 */
	public function postStore()
	{
		$response['status']  = 'error';
		$response['message'] = trans('products.not_created');

		if ( ! empty($_POST))
		{

			$error = FALSE;

			if (empty(trim(Input::get('title'))))
			{
				$response['message'] = trans('products.title_required');
				$error               = TRUE;
			}
			if (empty(trim(Input::get('friendly_url'))))
			{
				$response['title']   = trans('global.warning');
				$response['message'] = trans('products.url_required');
				$error               = TRUE;
			}

			if ($error === FALSE)
			{
				//Get images
				$images_array = [];

				if ( ! empty(Input::get('images_dir')) &&
					is_dir($this->images_path.Input::get('images_dir')) &&
					is_dir($this->images_path.Input::get('images_dir').'/'.Config::get('images.full_size'))
				)
				{
					$images = array_diff(scandir($this->images_path.Input::get('images_dir').'/'.Config::get('images.full_size')), array('..', '.'));

					if ( ! empty($images) && is_array($images))
					{
						foreach ($images as $key => $data)
						{
							$images_array[$data] = 0;
						}
					}
				}

				$data = [
					'title'            => trim(Input::get('title')),
					'description'      => Input::get('description'),
					'quantity'         => Input::get('quantity'),
					'position'         => Input::get('position'),
					'active'           => Input::get('active'),
					'original_price'   => Input::get('original_price'),
					'price'            => Input::get('price'),
					'discount_price'   => Input::get('discount_price'),
					'discount_start'   => Input::get('discount_start'),
					'discount_end'     => Input::get('discount_end'),
					'created_at'       => Input::get('created_at'),
					'sizes'            => Input::get('sizes'),
					'meta_description' => Input::get('meta_description'),
					'meta_keywords'    => Input::get('meta_keywords'),
					'images'           => $images_array,
				];

				if ($id = Model_Products::createProduct($data))
				{
					try
					{
						//Manage Friendly URL
						Model_Products::setURL($id, Input::get('friendly_url'));

						//Rename images directory
						if ( ! empty(Input::get('images_dir')) && is_dir($this->images_path.Input::get('images_dir')))
						{
							//Loop trough uploaded images and insert them to the database
							rename($this->images_path.Input::get('images_dir'), $this->images_path.$id);
						}

						//Manage tags
						$tags = Input::get('tags');
						if(!empty($tags)) {
							$tags = explode(',', $tags);
							Model_Products::saveTags($id, $tags);
						}

					} catch (Exception $e)
					{
						$response['message'] = $e;
					}
					$response['status']     = 'success';
					$response['message']    = trans('products.created');
					$response['product_id'] = $id;
				}
				else
				{
					$response['message'] = trans('products.not_created');
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
			if ($request == 'sizes')
			{
				$response['blade_standalone'] = TRUE;
				$response['sizes']            = Model_Sizes::getSizes(FALSE, $param);

				return Theme::View('products_partials.product_sizes_form', $response);
			}
			else
			{
				if ($request == 'check_url')
				{
					if (Model_Products::checkURL($param))
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
	public function getEdit($id = FALSE)
	{
		$customCSS                    = [
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2',
			'global/plugins/jquery-multi-select/css/multi-select',
			'global/plugins/bootstrap-switch/css/bootstrap-switch.min',
			'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
			'global/plugins/dropzone/css/dropzone',
		];
		$customJS                     = [
			'global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0',
			'global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5',
			'global/plugins/bootstrap-summernote/summernote.min',
			'admin/pages/scripts/components-dropdowns',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/bootstrap-select/bootstrap-select.min',
			'global/plugins/select2/select2.min',
			'global/plugins/jquery-multi-select/js/jquery.multi-select',
			'global/plugins/fuelux/js/spinner.min',
			'global/plugins/bootstrap-switch/js/bootstrap-switch.min',
			'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
			'global/plugins/dropzone/dropzone',
			'admin/pages/scripts/form-dropzone',
			'global/plugins/jquery-slugify/speakingurl',
			'global/plugins/jquery-slugify/slugify.min',
		];
		$response['blade_custom_css'] = $customCSS;
		$response['blade_custom_js']  = $customJS;

		$response['categories']         = Model_Categories::getCategory(FALSE, ['title']);
		$response['related_categories'] = Model_Products::getProductToCategory($id);
		$response['products']           = Model_Products::getProducts(FALSE, ['title']);
		$response['groups']             = Model_Sizes::getSizes(TRUE);

		$product = Model_Products::getProducts($id);

		if ( ! empty($product[$id]))
		{
			$response['product'] = $product[$id];
			if ( ! empty($product[$id]['sizes']))
			{
				$response['sizes'] = json_decode($product[$id]['sizes'], TRUE);
			}
		}

		//SEO Tab
		if (($slug = Model_Products::getURL($id)) != FALSE)
		{
			$response['seo']['friendly_url'] = $slug;
		}

		if ( ! empty($response['product']['meta_description']))
		{
			$response['seo']['meta_description'] = $response['product']['meta_description'];
			unset($response['product']['meta_description']);
		}
		if ( ! empty($response['product']['meta_keywords']))
		{
			$response['seo']['meta_keywords'] = $response['product']['meta_keywords'];
			unset($response['product']['meta_keywords']);
		}
		//Images Tab
		if ( ! empty($response['product']['images']))
		{
			$response['product']['images'] = json_decode($response['product']['images'], TRUE);

			if (is_array($response['product']['images']))
			{
				$response['thumbs_path'] = Config::get('system_settings.product_public_path').$id.'/'.Config::get('images.sm_icon_size').'/';
				uasort($response['product']['images'], function ($a, $b)
				{
					if ($a == $b)
					{
						return 0;
					}

					return ($a < $b) ? -1 : 1;
				});
			}
		}

		//Tags
		$tags = Model_Products::getTags($id);

		if(!empty($tags) && is_array($tags)) {
			foreach($tags as $key => $tag) {
				$response['product']['tags'][] = $tag['title'];
			}

			$response['product']['tags'] = implode(',', $response['product']['tags']);
		}

		$response['pageTitle'] = trans('products.edit');

		return Theme::view('products.edit_product', $response);
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
	public function postUpdate(Request $request, $id)
	{
		$response['status']  = 'error';
		$response['message'] = trans('products.not_updated');

		if ( ! empty($_POST))
		{
			if ( ! empty(Input::get('image_sync')))
			{
				if (empty(($images = json_decode(Input::get('images'), TRUE))))
				{
					$images = [];
				}
				$response['message'] = trans('products.images_not_synced');

				//Get current local images
				$images_array = [];

				if ( ! empty($id) &&
					is_dir($this->images_path.$id) &&
					is_dir($this->images_path.$id.DIRECTORY_SEPARATOR.Config::get('images.full_size'))
				)
				{
					$local_images = array_diff(scandir($this->images_path.$id.DIRECTORY_SEPARATOR.Config::get('images.full_size')), array('..', '.'));

					if ( ! empty($local_images) && is_array($local_images))
					{
						foreach ($local_images as $key => $data)
						{
							$images_array[$data] = 0;
						}
					}
				}

				//Remove image
				if ( ! empty($remove_image = Input::get('remove_image')))
				{
					if (isset($images[$remove_image]))
					{

						//Remove local files
						$images_to_remove = [
							$this->images_path.$id.DIRECTORY_SEPARATOR.Config::get('images.full_size').DIRECTORY_SEPARATOR.$remove_image,
							$this->images_path.$id.DIRECTORY_SEPARATOR.Config::get('images.lg_icon_size').DIRECTORY_SEPARATOR.$remove_image,
							$this->images_path.$id.DIRECTORY_SEPARATOR.Config::get('images.md_icon_size').DIRECTORY_SEPARATOR.$remove_image,
							$this->images_path.$id.DIRECTORY_SEPARATOR.Config::get('images.sm_icon_size').DIRECTORY_SEPARATOR.$remove_image,
						];
						foreach ($images_to_remove as $image)
						{
							if (file_exists($image))
							{
								unlink($image);
							}
						}

						//Remove message
						$message_success = trans('products.image_removed');
					}
				}
				else
				{
					//Images save message
					$message_success = trans('products.images_synced');
				}

				if (is_array($images))
				{
					$images = array_merge($images_array, $images);
				} else {
					$images = $images_array;
				}

				if (isset($images[$remove_image]))
				{
					unset($images[$remove_image]);
				}
				if ( ! empty($images))
				{
					Model_Products::deleteAllImages($id);
					if (Model_Products::setProductObjects(['images' => $images], $id) === TRUE)
					{
						$response['status']  = 'success';
						$response['message'] = $message_success;
					}
				}
				else
				{
					if (Model_Products::deleteAllImages($id) === TRUE)
					{
						$response['status']  = 'success';
						$response['message'] = $message_success;
					}
				}
			}
			else
			{
				$error = FALSE;

				if (empty(trim(Input::get('title'))))
				{
					$response['message'] = trans('products.title_required');
					$error               = TRUE;
				}
				if (empty(trim(Input::get('friendly_url'))))
				{
					$response['message'] = trans('products.url_required');
					$error               = TRUE;
				}

				if ($error === FALSE)
				{
					$data = [
						'title'            => trim(Input::get('title')),
						'description'      => Input::get('description'),
						'quantity'         => Input::get('quantity'),
						'position'         => Input::get('position'),
						'active'           => Input::get('active'),
						'original_price'   => Input::get('original_price'),
						'price'            => Input::get('price'),
						'discount_price'   => Input::get('discount_price'),
						'discount_start'   => Input::get('discount_start'),
						'discount_end'     => Input::get('discount_end'),
						'created_at'       => Input::get('created_at'),
						'sizes'            => Input::get('sizes'),
						'meta_description' => Input::get('meta_description'),
						'meta_keywords'    => Input::get('meta_keywords'),
					];

					if (Model_Products::updateProduct($id, $data) === TRUE)
					{
						try
						{
							//Manage relations
							if ( ! empty($_POST['categories']) && is_array($_POST['categories']))
							{
								Model_Products::setProductToCategory($id, $_POST['categories']);
							}
							//Manage Friendly URL
							Model_Products::setURL($id, Input::get('friendly_url'));

							//Manage tags
							$tags = Input::get('tags');
							if(!empty($tags)) {
								$tags = explode(',', $tags);
								Model_Products::saveTags($id, $tags);
							} else {
								Model_Products::removeAllTags($id);
							}

							$response['status']  = 'success';
							$response['message'] = trans('products.updated');
						} catch (Exception $e)
						{
							$response['message'] = $e;
						}
					}
					else
					{
						$response['message'] = trans('products.not_updated');
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
		$response['status']  = 'error';
		$response['message'] = trans('products.not_removed');

		if ( ! empty($id) && intval($id) > 0)
		{
			if (Model_Products::removeProduct($id) === TRUE)
			{
				$response['status']  = 'success';
				$response['message'] = trans('products.removed');
			}
		}

		return response()->json($response);
	}

	private function compareArrayKeys($arr, $col, $dir = SORT_ASC)
	{
		if ( ! empty($arr) && ! empty($col) && is_array($arr))
		{
			$sort_col = array();
			foreach ($arr as $key => $row)
			{
				$sort_col[$key] = $row[$col];
			}

			return array_multisort($sort_col, $dir, $arr);
		}
		else
		{
			return FALSE;
		}
	}

}
