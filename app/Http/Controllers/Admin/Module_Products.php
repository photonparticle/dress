<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Products;
use App\Admin\Model_Categories;
use App\Admin\Model_Sizes;
use App\Admin\Model_Tables;
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

		$this->images_path = public_path().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR;
	}

	/**
	 * Display a listing of products
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$response['pageTitle'] = trans('global.products');

		$response['products']    = Model_Products::getProducts(FALSE, ['title', 'images']);
		$response['thumbs_path'] = Config::get('system_settings.product_public_path');
		$response['icon_size']   = Config::get('images.sm_icon_size');
		$upload_path             = Config::get('system_settings.product_upload_path');

		$customCSS = [
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
		];

		$customJS = [
			'global/plugins/datatables/media/js/jquery.dataTables.min',
			'global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap',
			'global/plugins/bootbox/bootbox.min',
		];

		//Images
		foreach ($response['products'] as $key => $product)
		{
			if ( ! empty($product['images']))
			{
				$product['images'] = json_decode($product['images'], TRUE);

				if (is_array($product['images']))
				{
					uasort($product['images'], function ($a, $b)
					{
						if ($a == $b)
						{
							return 0;
						}

						return ($a < $b) ? -1 : 1;
					});

					reset($product['images']);
					$product['images'] = key($product['images']);
					if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
					{
						if (file_exists(
							iconv("UTF-8", "WINDOWS-1251",
								  $upload_path.$product['id'].DIRECTORY_SEPARATOR.$response['icon_size'].DIRECTORY_SEPARATOR.$product['images']
							)
						))
						{
							$response['products'][$product['id']]['image'] = $product['images'];
						}
					}
					else
					{
						if (file_exists($upload_path.$product['id'].DIRECTORY_SEPARATOR.$response['icon_size'].DIRECTORY_SEPARATOR.$product['images']))
						{
							$response['products'][$product['id']]['image'] = $product['images'];
						}
					}
				}
				unset($response['product'][$product['id']]['images']);
			}
		}

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

		$response['categories']        = Model_Categories::getCategory(FALSE, ['title']);
		$response['groups']            = Model_Sizes::getSizes(TRUE);
		$response['products']          = Model_Products::getProducts(FALSE, ['title'], TRUE);
		$response['manufacturers']     = Model_Products::getManufacturers();
		$response['colors']            = Model_Products::getColors();
		$response['materials']         = Model_Products::getMaterials();
		$response['dimensions_tables'] = Model_Tables::getTables();
		if ( ! empty($response['dimensions_tables']) && is_array($response['dimensions_tables']))
		{
			foreach ($response['dimensions_tables'] as $key => $table)
			{
				if (isset($table['image']))
				{
					unset($response['dimensions_tables'][$key]['image']);
				}
			}
		}

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
					is_dir($this->images_path.Input::get('images_dir').DIRECTORY_SEPARATOR.Config::get('images.full_size'))
				)
				{
					$images = array_diff(scandir($this->images_path.Input::get('images_dir').DIRECTORY_SEPARATOR.Config::get('images.full_size')), array('..', '.'));
					natcasesort($images);
					$images = array_values($images);

					if ( ! empty($images) && is_array($images))
					{
						foreach ($images as $key => $data)
						{
							if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
							{
								$data = iconv("WINDOWS-1251", "UTF-8", $data);
							}

							$images_array[$data] = $key;
						}
					}
				}

				$available_sizes = [];

				if ( ! empty(Input::get('sizes')) && is_array(Input::get('sizes')))
				{
					foreach (Input::get('sizes') as $size_name => $size)
					{
						if ($size['quantity'] > 0)
						{
							$available_sizes[] = $size_name;
						}
					}
				}

				if ( ! empty(Input::get('quantity')))
				{
					$available = 1;
				}
				else
				{
					$available = 0;
				}

				$data = [
					'title'            => trim(Input::get('title')),
					'description'      => Input::get('description'),
					'main_category'    => Input::get('main_category'),
					'quantity'         => Input::get('quantity'),
					'available'        => $available,
					'position'         => Input::get('position'),
					'active'           => Input::get('active'),
					'original_price'   => Input::get('original_price'),
					'price'            => Input::get('price'),
					'discount_price'   => Input::get('discount_price'),
					'discount_start'   => Input::get('discount_start'),
					'discount_end'     => Input::get('discount_end'),
					'created_at'       => Input::get('created_at'),
					'sizes'            => Input::get('sizes'),
					'page_title'       => Input::get('page_title'),
					'meta_description' => Input::get('meta_description'),
					'meta_keywords'    => Input::get('meta_keywords'),
					'related_products' => Input::get('related_products'),
					'images'           => $images_array,
					'dimensions_table' => Input::get('dimensions_table'),
				];

				if ($id = Model_Products::createProduct($data))
				{
					try
					{
						//Manage sizes relations
						if ( ! empty($available_sizes) && is_array($available_sizes))
						{
							Model_Products::setProductToCategory($id, $available_sizes);
						}

						//Manage categories relations
						if ( ! empty(Input::get('categories')) && is_array(Input::get('categories')))
						{
							Model_Products::setProductToCategory($id, Input::get('categories'));
						}

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
						if ( ! empty($tags))
						{
							$tags = explode(',', $tags);
							Model_Products::saveTags($id, $tags);
						}

						//Manage manufacturer
						$manufacturer = Input::get('manufacturer');
						if ( ! empty($manufacturer))
						{
							Model_Products::setManufacturer($id, $manufacturer);
						}

						//Manage material
						$material = Input::get('material');
						if ( ! empty($material))
						{
							Model_Products::setMaterial($id, $material);
						}

						//Manage colors
						if ( ! empty(Input::get('colors')) && is_array(Input::get('colors')))
						{
							Model_Products::setColors($id, Input::get('colors'));
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
			elseif ($request == 'check_url')
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
			elseif ($request == 'render_table')
			{
				$response['blade_standalone'] = TRUE;
				$table                        = Model_Tables::getTables($param, FALSE);
				if ( ! empty($table) && is_array($table) && ! empty($table[0]))
				{
					$response['table']         = $table[0];
					$response['table']['cols'] = json_decode($table[0]['cols'], TRUE);
					$response['table']['rows'] = json_decode($table[0]['rows'], TRUE);
				}
				$response['images_dir']        = Config::get('system_settings.tables_upload_path');
				$response['public_images_dir'] = Config::get('system_settings.tables_public_path');

				return Theme::View('products_partials.product_render_dimensions_table_partial', $response);
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
		$response['colors']             = Model_Products::getColors();
		$response['related_colors']     = Model_Products::getColor($id);
		$response['dimensions_tables']  = Model_Tables::getTables();
		if ( ! empty($response['dimensions_tables']) && is_array($response['dimensions_tables']))
		{
			foreach ($response['dimensions_tables'] as $key => $table)
			{
				if (isset($table['image']))
				{
					unset($response['dimensions_tables'][$key]['image']);
				}
			}
		}

		//Get product and it's data
		$product = Model_Products::getProducts($id);

		//Prepare product for response
		if ( ! empty($product[$id]))
		{
			$response['product'] = $product[$id];
			if ( ! empty($product[$id]['sizes']))
			{
				$response['sizes'] = json_decode($product[$id]['sizes'], TRUE);
			}
			if ( ! empty($response['product']['discount_start']) && $response['product']['discount_start'] == '0000-00-00 00:00:00')
			{
				$response['product']['discount_start'] = '';
			}

			if ( ! empty($response['product']['discount_end']) && $response['product']['discount_end'] == '0000-00-00 00:00:00')
			{
				$response['product']['discount_end'] = '';
			}
		}

		//SEO Tab
		if (($slug = Model_Products::getURL($id)) != FALSE)
		{
			$response['seo']['friendly_url'] = $slug;
		}

		if ( ! empty($response['product']['page_title']))
		{
			$response['seo']['page_title'] = $response['product']['page_title'];
			unset($response['product']['page_title']);
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

		if ( ! empty($tags) && is_array($tags))
		{
			foreach ($tags as $key => $tag)
			{
				$response['product']['tags'][] = $tag['title'];
			}

			$response['product']['tags'] = implode(',', $response['product']['tags']);
		}

		//Manufacturer
		$response['manufacturers']           = Model_Products::getManufacturers();
		$response['product']['manufacturer'] = Model_Products::getManufacturer($id);

		//Material
		$response['materials']           = Model_Products::getMaterials();
		$response['product']['material'] = Model_Products::getMaterial($id);
		if ( ! empty($response['product']['material'][0]))
		{
			$response['product']['material'] = $response['product']['material'][0];
		}

		//Related products
		if ( ! empty($response['product']['related_products']))
		{
			$response['related_products'] = json_decode($response['product']['related_products'], TRUE);
			unset($response['product']['related_products']);
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
					natcasesort($local_images);
					$local_images = array_values(array_filter($local_images));

					if ( ! empty($local_images) && is_array($local_images))
					{
						foreach ($local_images as $key => $data)
						{
							if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
							{
								$data = iconv("WINDOWS-1251", "UTF-8", $data);
							}
							if (empty($images_array[$data]))
							{
								$images_array[$data] = $key;
							}
						}
					}
				}

				//Remove image
				if ( ! empty($remove_image = Input::get('remove_image')))
				{
					if (isset($images[$remove_image]))
					{
						//Remove from array
						unset($images[$remove_image]);

						//If WIN reconvert to utf8
						if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
						{
							$remove_image = iconv("UTF-8", "WINDOWS-1251", $remove_image);
						}
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
				}
				else
				{
					$images = $images_array;
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

				$available_sizes = [];

				if ( ! empty(Input::get('sizes')) && is_array(Input::get('sizes')))
				{
					foreach (Input::get('sizes') as $size_name => $size)
					{
						if ($size['quantity'] > 0)
						{
							$available_sizes[] = $size_name;
						}
					}
				}

				if ( ! empty(Input::get('quantity')))
				{
					$available = 1;
				}
				else
				{
					$available = 0;
				}

				if ($error === FALSE)
				{
					$data = [
						'title'            => trim(Input::get('title')),
						'description'      => Input::get('description'),
						'main_category'    => Input::get('main_category'),
						'quantity'         => Input::get('quantity'),
						'available'        => $available,
						'position'         => Input::get('position'),
						'active'           => Input::get('active'),
						'original_price'   => Input::get('original_price'),
						'price'            => Input::get('price'),
						'discount_price'   => Input::get('discount_price'),
						'discount_start'   => Input::get('discount_start'),
						'discount_end'     => Input::get('discount_end'),
						'created_at'       => Input::get('created_at'),
						'sizes'            => Input::get('sizes'),
						'page_title'       => Input::get('page_title'),
						'meta_description' => Input::get('meta_description'),
						'meta_keywords'    => Input::get('meta_keywords'),
						'related_products' => Input::get('related_products'),
						'dimensions_table' => Input::get('dimensions_table'),
					];

					if (Model_Products::updateProduct($id, $data) === TRUE)
					{
						try
						{
							//Manage sizes relations
							if ( ! empty($available_sizes) && is_array($available_sizes))
							{
								Model_Products::saveProductToSize($id, $available_sizes);
							}

							//Manage categories relations
							if ( !empty(Input::get('categories')) && is_array(Input::get('categories')))
							{
								Model_Products::setProductToCategory($id, Input::get('categories'));
							}

							//Manage Friendly URL
							Model_Products::setURL($id, Input::get('friendly_url'));

							//Manage tags
							$tags = Input::get('tags');
							if ( ! empty($tags))
							{
								$tags = explode(',', $tags);
								Model_Products::saveTags($id, $tags);
							}
							else
							{
								Model_Products::removeAllTags($id);
							}

							//Manage manufacturer
							$manufacturer = Input::get('manufacturer');
							if ( ! empty($manufacturer))
							{
								Model_Products::setManufacturer($id, $manufacturer);
							}

							//Manage material
							$material = Input::get('material');
							if ( ! empty($material))
							{
								Model_Products::setMaterial($id, $material);
							}

							//Manage colors
							if ( ! empty(Input::get('colors')) && is_array(Input::get('colors')))
							{
								Model_Products::setColors($id, Input::get('colors'));
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
}
