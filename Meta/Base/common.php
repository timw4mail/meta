<?php
/**
 * meta
 *
 * Simple hierarchial data management
 *
 * @package		meta
 * @author 		Timothy J. Warren
 * @copyright	Copyright (c) 2012
 * @link 		https://github.com/aviat4ion/meta
 * @license 	http://philsturgeon.co.uk/code/dbad-license
 */

// --------------------------------------------------------------------------

namespace Meta\Base;

use \Aura\Router\RouterFactory;

// --------------------------------------------------------------------------
// ! Messages
// --------------------------------------------------------------------------

/**
 * General 404 function
 *
 * @return void
 */
function show_404()
{
	@header('HTTP/1.1 404 Not Found', TRUE, 404);

	// Contain the content for buffering
	ob_start();

	// This is passed to the error template
	$message = '404 Not Found';

	include(MM_APP_PATH . '/views/errors/error_404.php');

	$buffer = ob_get_contents();
	ob_end_clean();
	die($buffer);
}

// --------------------------------------------------------------------------

/**
 * Fatal Error page function
 *
 * @param string $message
 * @param int $status_code
 */
function show_error($message, $status_code=null)
{
	if ( ! is_null($status_code))
	{
		@header("HTTP/1.1 {$status_code}", TRUE, (int) $status_code);
	}

	// Contain the content for buffering
	ob_start();

	include(MM_APP_PATH . '/views/errors/error_general.php');

	$buffer = ob_get_contents();
	ob_end_clean();
	die($buffer);
}

// --------------------------------------------------------------------------
// ! Utility Functions
// --------------------------------------------------------------------------

/**
 * Utility function to check if a variable is set, and is an array or object
 *
 * @param mixed $var
 * @return bool
 */
function is_like_array(&$var)
{
	if ( ! isset($var))
	{
		return FALSE;
	}

	return (is_array($var) OR is_object($var)) && ( ! empty($var));
}

// --------------------------------------------------------------------------

/**
 * Returns routable methods for the specified controller class
 *
 * @param string $controller
 * @return array
 */
function controller_methods($controller)
{
	$methods = \get_class_methods($controller);

	// Eliminate methods from Controller and Model classes
	$skip_methods = array_merge(\get_class_methods('\Meta\Base\Controller'), \get_class_methods('\Meta\Base\Model'));
	$methods = array_diff($methods, $skip_methods);

	return $methods;
}

// --------------------------------------------------------------------------

/**
 * Returns a full url from a url segment
 *
 * @param string $segment
 * @return string
 */
function site_url($segment='')
{
	return $url = BASE_URL . URL_INDEX_FILE . $segment;
}

// --------------------------------------------------------------------------

/**
 * Prints out the contents of the object
 *
 * @param object/array $data
 * @param string $method
 * @return string
 */
function to_string($data, $method='print_r')
{
	$output = '<pre>';

	if ($method == "var_dump")
	{
		ob_start();
		var_dump($data);
		$output .= ob_get_contents();
		ob_end_clean();
	}
	elseif ($method == "var_export")
	{
		ob_start();
		var_export($data);
		$output .= ob_get_contents();
		ob_end_clean();
	}
	else
	{
		$output .= print_r($data, TRUE);
	}

	return $output . '</pre>';
}

// --------------------------------------------------------------------------

if ( ! function_exists('do_include'))
{
	/**
	 * Array_map callback to load a folder of classes at once
	 *
	 * @param string $path
	 * @return void
	 */
	function do_include($path)
	{
		require_once($path);
	}
}

// --------------------------------------------------------------------------
// ! Bootstrap functions
// --------------------------------------------------------------------------

/**
 * Returns the last segment of the current url
 *
 * @return string
 */
function get_last_segment()
{
	$array = get_segments();
	return end($array);
}

// --------------------------------------------------------------------------

/**
 * Gets an array of the segments of the current url
 *
 * @return array
 */
function get_segments()
{
	$sn = $_SERVER['SCRIPT_NAME'];
	$ru = $_SERVER['REQUEST_URI'];

	// Get the equivalent to path info
	$pi = (isset($_SERVER['PATH_INFO']))
		? str_replace($sn, '', $ru)
		: '/';

	// Correct for being in a sub-directory
	if (strlen($sn) > strlen($ru))
	{
		$pi = '/';
	}

	return explode('/', $pi);
}

// --------------------------------------------------------------------------

/**
 * Calls the appropriate module/controller/function based on the url
 *
 * @return void
 */
function route()
{
	$router_factory = new RouterFactory;
	$router = $router_factory->newInstance();

	// Load the routes config file to add additional routes
	$routes = [];
	require_once(MM_APP_PATH . 'config/routes.php');

	// get the incoming request URL path
	$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$path = str_replace(URL_INDEX_FILE, '', $path);
	$path = str_replace(BASE_PATH, '', $path);

	// get the route based on the path and server
	$route = $router->match($path, $_SERVER);

	// Set default controller/function
	$controller = $routes['default_controller'];
	$action = 'index';

	// 404 Condition
	if (empty($route))
	{
		throw new \Exception("404: Page not found.");
		//show_404();
		return;
	}

	// Home
	if (isset($route->name) && $route->name === 'home')
	{
		run($controller, $action);
		return;
	}

	// Gather route parts
	foreach(array('controller', 'action', 'id') as $param)
	{
		if (isset($route->params[$param]))
		{
			$$param = $route->params[$param];
		}
	}

	if ( ! isset($id)) $id = array();

	// Dispatch to the appropriate controller
	run($controller, $action, array($id));
}

// --------------------------------------------------------------------------

/**
 * Instantiate the appropriate controller
 *
 * @param string $controller
 * @param string $func
 * @param array $args
 * @return void
 */
function run($controller, $func, $args = array())
{
	$controller_class = ucfirst($controller);
	$controller = "Meta\\Controller\\{$controller_class}";

	// Get the list of valid methods for that controller
	$methods = controller_methods($controller);

	if (in_array($func, $methods))
	{
		if (class_exists($controller))
		{
			$class = new $controller();
		}

		call_user_func_array(array($class, $func), $args);
		return;
	}

	// Function doesn't exist...404
	show_404();
}

// End of common.php