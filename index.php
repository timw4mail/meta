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

// --------------------------------------------------------------------------


use \Whoops\Handler\PrettyPageHandler;
use \Whoops\Handler\JsonResponseHandler;

error_reporting(-1);

// Set the default paths
define('MM_BASE_PATH', __DIR__);
define('MM_SYS_PATH', __DIR__.'/Meta/Base/');
define('MM_APP_PATH', __DIR__.'/Meta/');

// Autoload vendors
require(MM_BASE_PATH . '/vendor/autoload.php');

// Setup error handling
$whoops = new \Whoops\Run();
$defaultHandler = new PrettyPageHandler();
$whoops->pushHandler($defaultHandler);
$whoops->register();

// Require the basic configuration file
require(MM_APP_PATH . 'config/config.php');

// Start the autoloader
spl_autoload_register(function($name) {
	if ($name == '') return;

	// load by namespace
	$names = explode('\\', trim($name));
	$ns_path = MM_BASE_PATH . '/' .  implode('/', $names) . '.php';

	if (is_file($ns_path))
	{
		require_once($ns_path);
	}
});

// Require the most important files
require(MM_SYS_PATH . 'common.php');

// And away we go!
route();

// End of index.php