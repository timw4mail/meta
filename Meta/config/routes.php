<?php
/**
 * MiniMVC
 *
 * Convention-based micro-framework for PHP
 *
 * @package		miniMVC
 * @author 		Timothy J. Warren
 * @copyright	Copyright (c) 2011 - 2012
 * @link 		https://github.com/aviat4ion/miniMVC
 * @license 	http://philsturgeon.co.uk/code/dbad-license
 */

// --------------------------------------------------------------------------

/**
 * File to configure routes
 *
 * Routes work on simple/regex matching.
 *
 * For a route mapping http://example.com/blog to the blog controller in the blog module:
 *	'blog' => 'blog/blog/index'
 *
 * To route a special 404 page, set '404_route' to the "module/controller/method" you wish to use
 *
 * @package miniMVC
 * @subpackage App
 */

// --------------------------------------------------------------------------

$routes = [
	// Default Paths
	'default_controller'	=>	'genre',
	'404_route'				=>	'',
];

// Add default routes
$router->add('home', '/');
$router->add(null, '/{controller}/{action}/{id}');
$router->add('no_id', '/{controller}/{action}');

// Custom routes
$router->add('outline', '/outline');
$router->add('edit', '/edit');
$router->add('delete', '/delete');
$router->addPost('data_add', '/section/add_data');
$router->addPost('update', '/update');

// End of routes.php