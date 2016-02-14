<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\ImageRepository;
use Illuminate\Support\Facades\Input;

class ImageController extends BaseController
{
	protected $image;

	public function __construct(ImageRepository $imageRepository)
	{
		$this->image = $imageRepository;
	}

	public function postUpload()
	{
		$photo = Input::all();
		$response = $this->image->upload($photo);
		return $response;

	}
}