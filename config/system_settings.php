<?php
/**
 * Created by PhpStorm.
 * User: Shooky
 * Date: 31.1.2016 г.
 * Time: 11:40
 */

return [
	'product_upload_path' => public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR,
	'tables_upload_path' => public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'tables' . DIRECTORY_SEPARATOR,
	'sliders_upload_path' => public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'sliders' . DIRECTORY_SEPARATOR,
	'product_public_path' => '/images/products/',
	'tables_public_path' => '/images/tables/',
	'sliders_public_path' => '/images/sliders/',
	'modules'             => [
		'dashboard',
		'users',
		'categories',
		'products',
		'pages',
		'reports'
	],
	'plug-ins'            => [
		'sliders'        => [
			'title'     => 'Slider',
			'icon'      => 'fa-image',
			'color'     => 'bg-blue-steel',
			'tile-size' => 'double-down',
		],
		'carousels'      => [
			'title'     => 'Carousels',
			'icon'      => 'fa-arrows-h',
			'color'     => 'bg-green-seagreen',
			'tile-size' => 'double-down',
		],
		'manufacturers' => [
			'title'     => 'Manufacturers',
			'icon'      => 'fa-link',
			'color'     => 'bg-purple-studio',
			'tile-size' => 'double',
		],
		'colors'        => [
			'title'     => 'Colors',
			'icon'      => 'fa-paint-brush',
			'color'     => 'bg-yellow-casablanca',
			'tile-size' => '',
		],
		'sizes'         => [
			'title'     => 'Sizes',
			'icon'      => 'fa-arrows',
			'color'     => 'bg-purple-plum',
			'tile-size' => '',
		],
		'tables'        => [
			'title'     => 'Tables',
			'icon'      => 'fa-table',
			'color'     => 'bg-grey-gallery',
			'tile-size' => 'double',
		],
		'materials'     => [
			'title'     => 'Materials',
			'icon'      => 'fa-info-circle',
			'color'     => 'bg-green',
			'tile-size' => '',
		],
		'tags'          => [
			'title'     => 'Tags',
			'icon'      => 'fa-tags',
			'color'     => 'bg-red-sunglo',
			'tile-size' => '',
		],
	],
];