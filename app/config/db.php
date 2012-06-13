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
 * Database config file
 *
 * @package miniMVC
 * @subpackage App
 */

// --------------------------------------------------------------------------

$db_conf = array(
	'default' => array(
		'type' => 'sqlite',
		'host' => '',
		'user' => '',
		'pass' => '',
		'port' => '',
		'database'   => '',
		'file' => MM_SYS_PATH . 'meta.sqlite',
	)
);

// End of db.php