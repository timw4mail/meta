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

return array(
	// Default Paths
	'default_controller' => 'welcome',
	'default_module' 	 => 'meta',
	'genre'	=> 'meta/genre/index',
	'genre/add' => 'meta/genre/add',
	'404_route'			 => '',
);

// End of routes.php