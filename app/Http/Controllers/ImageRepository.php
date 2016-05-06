<?php

namespace App\Http\Controllers;

use App\Admin\Image;
use App\Admin\Model_Products;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;

class ImageRepository
{
	private $temp_name = '';
	private $module = '';

	public function upload($form_data)
	{

		$validator = Validator::make($form_data, Image::$rules, Image::$messages);

		if ($validator->fails())
		{

			return Response::json([
									  'error'   => TRUE,
									  'message' => $validator->messages()->first(),
									  'code'    => 400,
								  ], 400);

		}

		$photo           = $form_data['file'];
		$this->temp_name = $form_data['temp_key'];
		$this->module    = $form_data['module'];

		if ( ! empty($this->module) && $this->module == 'products')
		{

			$originalName           = $photo->getClientOriginalName();
			$originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - 4);

			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
			{
				$filename = iconv("UTF-8", "WINDOWS-1251", html_entity_decode(htmlentities(basename($originalNameWithoutExt), ENT_QUOTES, 'UTF-8')));
			}
			else
			{
				$filename = html_entity_decode(htmlentities(basename($originalNameWithoutExt), ENT_QUOTES, 'UTF-8'));
			}

			$filenameExt = $filename.'.jpg';

			$uploadSuccess1 = $this->original($photo, $filenameExt);

			$uploadSuccess2 = $this->sm_icon($photo, $filenameExt);
			$uploadSuccess3 = $this->md_icon($photo, $filenameExt);
			$uploadSuccess4 = $this->lg_icon($photo, $filenameExt);

			//If image is uploaded and thumbnails created
			if ( ! $uploadSuccess1 || ! $uploadSuccess2 || ! $uploadSuccess3 || ! $uploadSuccess4)
			{

				//Store to database
				if ( ! empty($form_data['target']))
				{
					$image = [
						'img'      => $filenameExt,
						'position' => 0,
					];
					Model_Products::storeImages($image, $form_data['target']);
				}

				return Response::json([
										  'error'   => TRUE,
										  'message' => 'Server error while uploading',
										  'code'    => 500,
									  ], 500);

			}
		}
		elseif ( ! empty($this->module) && $this->module == 'tables')
		{
			$filename    = basename($this->temp_name);
			$filenameExt = $filename.'.png';

			$uploadSuccess1 = $this->table_img($photo, $filenameExt);

			//If image is uploaded and thumbnails created
			if ( ! $uploadSuccess1)
			{

				return Response::json([
										  'error'   => TRUE,
										  'message' => 'Server error while uploading',
										  'code'    => 500,
									  ], 500);

			}
		}
		elseif ( ! empty($this->module) && $this->module == 'sliders')
		{
			$originalName           = $photo->getClientOriginalName();
			$originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - 4);

			$filename = basename($originalNameWithoutExt);

			$filenameExt = $filename.'.jpg';

			$uploadSuccess1 = $this->sliders($photo, $filenameExt);

			//If image is uploaded and thumbnails created
			if ( ! $uploadSuccess1)
			{

				return Response::json([
										  'error'   => TRUE,
										  'message' => 'Server error while uploading',
										  'code'    => 500,
									  ], 500);

			}
		}

//		$sessionImage = new Image;
//		$sessionImage->filename      = $allowed_filename;
//		$sessionImage->original_name = $originalName;
//		$sessionImage->save();

		return Response::json([
								  'error' => FALSE,
								  'code'  => 200,
							  ], 200);

	}

	public function createUniqueFilename($filename)
	{
		$full_size_dir   = Config::get('images.full_size');
		$dir             = Config::get('system_settings.product_upload_path');
		$full_image_path = $dir.$full_size_dir.$filename.'.jpg';
		if (File::exists($full_image_path))
		{
			// Generate token for image
			$imageToken = substr(sha1(mt_rand()), 0, 5);

			return $filename.'-'.$imageToken;
		}

		return $filename;
	}

	/**
	 * Optimize Original Image
	 */
	public function original($photo, $filename)
	{
		$manager = new ImageManager();
		$dir     = Config::get('system_settings.product_upload_path');

		if ( ! is_dir($dir.$this->temp_name.DIRECTORY_SEPARATOR))
		{
			mkdir($dir.$this->temp_name.DIRECTORY_SEPARATOR);
		}
		if ( ! is_dir($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.full_size').DIRECTORY_SEPARATOR))
		{
			mkdir($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.full_size').DIRECTORY_SEPARATOR);
		}
		$image = $manager->make($photo)->encode('jpg')->resize(intval(Config::get('images.full_size')), NULL, function ($constraint)
		{
			$constraint->aspectRatio();
		})->save($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.full_size').DIRECTORY_SEPARATOR.$filename);

		return $image;
	}

	/**
	 * Create Icon From Original
	 */
	public function lg_icon($photo, $filename)
	{
		$manager = new ImageManager();
		$dir     = Config::get('system_settings.product_upload_path');
		if ( ! is_dir($dir.$this->temp_name.DIRECTORY_SEPARATOR))
		{
			mkdir($dir.$this->temp_name.DIRECTORY_SEPARATOR);
		}
		if ( ! is_dir($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.lg_icon_size').DIRECTORY_SEPARATOR))
		{
			mkdir($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.lg_icon_size').DIRECTORY_SEPARATOR);
		}
		$image = $manager->make($photo)->encode('jpg')->resize(intval(Config::get('images.lg_icon_size')), NULL, function ($constraint)
		{
			$constraint->aspectRatio();
		})->save($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.lg_icon_size').DIRECTORY_SEPARATOR.$filename);

		return $image;
	}

	public function md_icon($photo, $filename)
	{
		$manager = new ImageManager();
		$dir     = Config::get('system_settings.product_upload_path');
		if ( ! is_dir($dir.$this->temp_name.DIRECTORY_SEPARATOR))
		{
			mkdir($dir.$this->temp_name.DIRECTORY_SEPARATOR);
		}
		if ( ! is_dir($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.md_icon_size').DIRECTORY_SEPARATOR))
		{
			mkdir($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.md_icon_size').DIRECTORY_SEPARATOR);
		}
		$image = $manager->make($photo)->encode('jpg')->resize(intval(Config::get('images.md_icon_size')), NULL, function ($constraint)
		{
			$constraint->aspectRatio();
		})->save($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.md_icon_size').DIRECTORY_SEPARATOR.$filename);

		return $image;
	}

	public function sm_icon($photo, $filename)
	{
		$manager = new ImageManager();
		$dir     = Config::get('system_settings.product_upload_path');
		if ( ! is_dir($dir.$this->temp_name.DIRECTORY_SEPARATOR))
		{
			mkdir($dir.$this->temp_name.DIRECTORY_SEPARATOR);
		}
		if ( ! is_dir($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.sm_icon_size').DIRECTORY_SEPARATOR))
		{
			mkdir($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.sm_icon_size').DIRECTORY_SEPARATOR);
		}
		$image = $manager->make($photo)->encode('jpg')->resize(intval(Config::get('images.sm_icon_size')), NULL, function ($constraint)
		{
			$constraint->aspectRatio();
		})->save($dir.$this->temp_name.DIRECTORY_SEPARATOR.Config::get('images.sm_icon_size').DIRECTORY_SEPARATOR.$filename);

		return $image;
	}

	/**
	 * Table Image
	 */
	public function table_img($photo, $filename)
	{
		$manager = new ImageManager();
		$dir     = Config::get('system_settings.tables_upload_path');

		if ( ! is_dir($dir))
		{
			mkdir($dir);
		}

		$background = $manager->canvas(256, 256);

		$image = $manager->make($photo)->resize(intval(Config::get('images.table_image_size')), NULL, function ($constraint)
		{
			$constraint->aspectRatio();
			$constraint->upsize();
		});

		$background->insert($image, 'center');
		$background->save($dir.$filename);

		return $image;
	}

	/**
	 * Sliders Image
	 */
	public function sliders($photo, $filename)
	{
		$manager = new ImageManager();
		$dir     = Config::get('system_settings.sliders_upload_path');

		if ( ! is_dir($dir.$this->temp_name.DIRECTORY_SEPARATOR))
		{
			mkdir($dir.$this->temp_name.DIRECTORY_SEPARATOR);
		}
		$image = $manager->make($photo)->encode('jpg')->save($dir.$this->temp_name.DIRECTORY_SEPARATOR.$filename);

		return $image;
	}

	function sanitize($string, $force_lowercase = TRUE, $anal = FALSE)
	{
		$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
					   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
					   "â€”", "â€“", ",", "<", ".", ">", "/", "?");
		$clean = trim(str_replace($strip, "", strip_tags($string)));
		$clean = preg_replace('/\s+/', "-", $clean);
		$clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;

		return ($force_lowercase) ?
			(function_exists('mb_strtolower')) ?
				mb_strtolower($clean, 'UTF-8') :
				strtolower($clean) :
			$clean;
	}
}