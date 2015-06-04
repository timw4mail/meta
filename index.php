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
 * miniMVC bootstrap file
 *
 * @package miniMVC
 * @subpackage App
 */

// --------------------------------------------------------------------------

namespace miniMVC;

error_reporting(-1);

// Set the default paths
define('MM_BASE_PATH', __DIR__);
define('MM_SYS_PATH', __DIR__.'/sys/');
define('MM_APP_PATH', __DIR__.'/app/');
define('MM_MOD_PATH', MM_APP_PATH.'modules/');

// Autoload vendors
require(MM_BASE_PATH . '/vendor/autoload.php');

// Require the basic configuration file
require(MM_APP_PATH . 'config/config.php');

// Require the most important files
require(MM_SYS_PATH . 'common.php');

// Start the autoloader
spl_autoload_register('miniMVC\autoload');

// And away we go!
init();

// End of index.php