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
 * Main config file
 *
 * @package miniMVC
 * @subpackage App
 */

// --------------------------------------------------------------------------

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors.
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Base Url
|--------------------------------------------------------------------------
|
| This is the url path where the framework is located. Requires trailing
| slash.
|
*/
// Determine the default site url
$ri = $_SERVER['REQUEST_URI'];
$ind_pos = stripos($ri, "index.php");
$default_path = ($ind_pos !== FALSE) ? substr($ri, 0, $ind_pos) : $ri;
$default_baseurl = "//" . str_replace("//", "/", $_SERVER['HTTP_HOST']. $default_path);
define('BASE_URL', $default_baseurl);

/*
|--------------------------------------------------------------------------
| Url index file
|--------------------------------------------------------------------------
|
| This determines whether "index.php" is in generated urls
|
*/
define('URL_INDEX_FILE', 'index.php/');

/*
|--------------------------------------------------------------------------
| Content Domain
|--------------------------------------------------------------------------
|
| This is the domain used for serving content, such as css, javascript.
|
*/
define('CONTENT_DOMAIN', BASE_URL);

/*
|--------------------------------------------------------------------------
| Static Lib Path
|--------------------------------------------------------------------------
|
| This is the path where the 'assets' directory is on the static domain.
|
*/
define('STATIC_LIB_PATH', CONTENT_DOMAIN.'assets/');


/*
|--------------------------------------------------------------------------
| Group Style Path
|--------------------------------------------------------------------------
|
| This is the path that is used to determine the relative path to the
| stylesheet minifier. This should not need to be changed.
|
*/
define('STYLE_PATH', STATIC_LIB_PATH . 'css.php/g/');

/*
|--------------------------------------------------------------------------
| Group Javascript Path
|--------------------------------------------------------------------------
|
| This is the path that is used to determine the relative path to the
| javascript minifier. This should not need to be changed.
|
*/
define('SCRIPT_PATH', STATIC_LIB_PATH . 'js.php/g/');


/*
|--------------------------------------------------------------------------
| Default title
|--------------------------------------------------------------------------
|
| Default title for webpages
|
*/
define('DEFAULT_TITLE', "meta");

/*
|--------------------------------------------------------------------------
| Default css group
|--------------------------------------------------------------------------
|
| Default css group
|
*/
define('DEFAULT_CSS_GROUP', "css");

/*
|--------------------------------------------------------------------------
| Default js group
|--------------------------------------------------------------------------
|
| Default js group
|
*/
define('DEFAULT_JS_GROUP', "js");

// End of config.php