<?php
/**
 * Created by PhpStorm.
 * User: Shooky
 * Date: 31.1.2016 г.
 * Time: 11:35
 */

namespace App\Http\Controllers\Admin;

use App\Admin\Model_Products;
use App\Admin\Model_Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use Caffeinated\Themes\Facades\Theme;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Symfony\Component\DomCrawler\Form;
use View;

class Modules extends BaseController
{

}