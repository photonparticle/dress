<?php

namespace App\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class Model_Categories extends Model
{
	/**
	 * Returns array of all categories
	 *
	 * @return
	 */
    public static function getAllCategories() {
		$categories = DB::table('categories')
				   ->orderBy('created_at', 'ASC');

		$categories = $categories->get();

		return $categories;
	}

	/**
	 * Returns array of all categories relations
	 *
	 * @return array
	 */
	public static function getAllCategoriesRelatios() {
		$relations = DB::table('categories_relations')
						->orderBy('id', 'ASC');

		$relations = $relations->get();

		return $relations;
	}
}
