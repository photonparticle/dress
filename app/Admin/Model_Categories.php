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

		if(is_array($relations)) {
			$response = [];

			foreach($relations as $key => $relation) {
				$response[$relation['parent_id']][] = $relation['category_id'];
			}

			return $response;
		} else {
			return FALSE;
		}
	}

	public static function getCategoriesThree() {
		$tree = [];

		$categories = self::getAllCategories();
		$relations = self::getAllCategoriesRelatios();

		if(is_array($categories)) {
			foreach($categories as $key => $category) {
				if(
					!empty($relations[$category['id']]) &&
					is_array($relations[$category['id']])
				) {

				}
			}
			foreach($relations as $key => $relation) {
				if(is_array($relation)) {
					foreach($relation as $parent_id => $category_id) {
						if(!empty($tree[$parent_id])) {
								$tree[$parent_id]['childs'][] = $categories[$category_id];
						} elseif(!empty($tree)) {

						}
					}
				}
			}
		} else {
			return FALSE;
		}
	}
}
