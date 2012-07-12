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
 * File including common framework-wide functions
 *
 * @package miniMVC
 * @subpackage System
 */

namespace miniMVC;

// --------------------------------------------------------------------------
// ! Autoloading
// --------------------------------------------------------------------------

/**
 * Function to autoload system libraries
 *
 * @param string
 */
function _autoload($name)
{
	if ($name == '') return;

	// strip off namespaces - they all go to the same folder
	$names = explode('\\', trim($name));
	$name = end($names);

	// Paths to load from
	$sys_path = MM_SYS_PATH . "core/{$name}.php";
	$lib_path =  MM_SYS_PATH . "libraries/{$name}.php";
	$class_path = MM_APP_PATH . "classes/{$name}.php";

	if (is_file($sys_path))
	{
		require_once($sys_path);
	}
	elseif (is_file($lib_path))
	{
		require_once($lib_path);
	}

	if (is_file($class_path))
	{
		require_once($class_path);
	}
}

// Start the autoloader
spl_autoload_register('miniMVC\_autoload');

// --------------------------------------------------------------------------
// ! Error handling / messages
// --------------------------------------------------------------------------

/**
 * Function to run on script shutdown
 * -used to catch most fatal errors, and
 * display them cleanly
 *
 * @return void
 */
function shutdown()
{
    // Catch the last error
    $error = error_get_last();

    // types of errors that are fatal
    $fatal = array(E_ERROR, E_PARSE, E_RECOVERABLE_ERROR);

    // Display pretty error page
    if (in_array($error['type'], $fatal))
    {
        $file = str_replace(MM_BASE_PATH, "", $error['file']);

        $err_msg = "<h2>Fatal Error: </h2>
		{$error['message']}<br /><br />
		<strong>File:</strong> {$file}<br /><br />
		<strong>Line:</strong> {$error['line']}";

        show_error($err_msg);
    }
}

// --------------------------------------------------------------------------

/**
 * Custom error handler
 *
 * @param int $severity
 * @param string $message
 * @param string $filepath
 * @param int $line
 * @return ErrorException
 */
function on_error($severity, $message, $filepath, $line)
{
    throw new \ErrorException($message, 0, $severity, $filepath, $line);
}

// --------------------------------------------------------------------------

/**
 * Custom exception handlererror_get_last
 *
 * @param Exception $exception
 * @return void
 */
function on_exception($exception)
{
	// This is passed to the error template
	$message = $exception->getMessage();

	// Contain the content for buffering
	ob_start();

	include(MM_APP_PATH . '/views/errors/error_php_exception.php');

	$buffer = ob_get_contents();
	ob_end_clean();
	echo $buffer;
}

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
	$skip_methods = array_merge(\get_class_methods('miniMVC\Controller'), \get_class_methods('miniMVC\Model'));
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
function site_url($segment)
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
 * Load required classes for bootstraping
 *
 * @return void
 */
function init()
{
	// Catch fatal errors, don't show them
	register_shutdown_function('miniMVC\shutdown');

	//Set error handlers
	set_error_handler('miniMVC\on_error');
	set_exception_handler('miniMVC\on_exception');

	// Load Database classes
	require_once(MM_SYS_PATH . 'db/autoload.php');

	// Load the page class
	$GLOBALS['page'] = new \miniMVC\Page();

	// Map to the appropriate module/controller/function
	route();
}

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

	// Get the path info
	$pi = $_SERVER['PATH_INFO'];
	$ru = $_SERVER['REQUEST_URI'];
	$sn = $_SERVER['SCRIPT_NAME'];

	// Make sure the home page works when in a sub_directory
	if (strlen($sn) > strlen($ru))
	{
		$pi = '/';
	}

	// Load the routes config file
	$routes = require_once(MM_APP_PATH . 'config/routes.php');

	// Set the default route
	$module = $routes['default_module'];
	$controller = $routes['default_controller'];
	$func = "index";
	$route_set = FALSE;

	// If it isn't the index page
	if ( ! empty($pi) && $pi !== "/")
	{
		//Remove trailing slash and begining slash
		$pi = trim($pi, '/');
		$segments = explode("/", $pi);

		// URL matches the route exactly? Cool, that was easy
		if (isset($routes[$pi]))
		{
			list($module, $controller, $func) = explode("/", $routes[$pi]);
			run($module, $controller, $func);
			return;
		}
		else
		{
			$custom_routes = $routes;

			// Skip required routes
			unset($custom_routes['default_module']);
			unset($custom_routes['default_controller']);
			unset($custom_routes['404_handler']);

			foreach($custom_routes as $uri => $map)
			{
				if (preg_match("`{$uri}`i", $pi))
				{
					list($module, $controller, $func) = explode("/", $map);
					run($module, $controller, $func);
					return;
				}
			}
		}

		// Doesn't match a predefined route?
		// Match on module/controller/method, module/controller, controller/method, or method
		if ( ! $route_set)
		{
			$num_segments = 0;

			if (strpos($pi, '/') === FALSE  &&  ! empty($pi))
			{
				$num_segments = 1;
			}
			else
			{
				$segments = explode('/', $pi);
				$num_segments = count($segments);
			}

			// Determine route based on uri segments
			if ($num_segments === 1)
			{
				$func = $pi;
			}
			elseif ($num_segments === 2)
			{

				list($module, $controller) = $segments;

				// If it's just controller/function
				if ($controller == 'index')
				{
					$controller = $module;
					$module = $routes['default_module'];
					$func = 'index';
				}

			}
			else
			{
				list($module, $controller, $func) = $segments;
			}
		}
	}

	run($module, $controller, $func);
	return;
}

// --------------------------------------------------------------------------

/**
 * Instantiate the appropriate controller
 *
 * @param string
 * @param string
 * @param string
 * @param array
 */
function run($module, $controller, $func, $args = array())
{
	$path = MM_MOD_PATH . "{$module}/controllers/{$controller}.php";

	if (is_file($path))
	{
		require_once($path);

		// Get the list of valid methods for that controller
		$methods = controller_methods($controller);

		if (in_array($func, $methods))
		{
			// Define the name of the current module for file loading
			if ( ! defined('MM_MOD'))
			{
				define('MM_MOD', $module);
			}

			$class = new $controller();
			return call_user_func_array(array(&$class, $func), $args);
		}
	}

	// Function doesn't exist...404
	show_404();
}

// End of common.php