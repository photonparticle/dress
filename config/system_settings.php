<?php
/**
 * Created by PhpStorm.
 * User: Shooky
 * Date: 31.1.2016 г.
 * Time: 11:40
 */

return [
	'modules' => [
		'dashboard',
		'users',
		'categories',
		'products',
	],
	'plug-ins' => [
		'slider' => [
			'title' => 'Slider',
			'icon' => 'fa-image',
			'color' => 'bg-blue-hoki',
			'tile-size' => 'double-down',
		],
		'carousel' => [
			'title' => 'Carousel',
			'icon' => 'fa-arrows-h',
			'color' => 'bg-green-turquoise',
			'tile-size' => 'double-down',
		],
		'manufacturers' => [
			'title' => 'Manufacturers',
			'icon' => 'fa-link',
			'color' => 'bg-purple-studio',
			'tile-size' => 'double',
		],
		'colors' => [
			'title' => 'Colors',
			'icon' => 'fa-paint-brush',
			'color' => 'bg-yellow-lemon',
			'tile-size' => '',
		],
		'sizes' => [
			'title' => 'Sizes',
			'icon' => 'fa-arrows',
			'color' => 'bg-red-sunglo',
			'tile-size' => '',
		],
		'tables' => [
			'title' => 'Tables',
			'icon' => 'fa-table',
			'color' => 'bg-grey-cascade',
			'tile-size' => 'double',
		],
		'materials' => [
			'title' => 'Materials',
			'icon' => 'fa-info-circle',
			'color' => 'bg-green',
			'tile-size' => 'double',
		],
	]
];