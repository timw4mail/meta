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
 
// Set as either DEVELOPMENT or PRODUCTION
// DEVELOPMENT enables error reporting
// PRODUCTION disables error reporting
define('ENVIRONMENT', 'DEVELOPMENT');

if(ENVIRONMENT == 'DEVELOPMENT')
{
	error_reporting(-1);
}
else if(ENVIRONMENT == 'PRODUCTION')
{
	error_reporting(0);
}

// Set the default paths
define('MM_BASE_PATH', __DIR__);
define('MM_SYS_PATH', __DIR__.'/sys/');
define('MM_APP_PATH', __DIR__.'/app/');
define('MM_MOD_PATH', MM_APP_PATH.'modules/');

// Require the basic configuration file
require(MM_APP_PATH .'config/config.php');

// Require the most important files
require(MM_SYS_PATH . 'common.php');

// And away we go!
init();

// End of index.php 