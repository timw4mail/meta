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
| Base Url
|--------------------------------------------------------------------------
|
| This is the url path of the domain. Requires trailing
| slash.
|
*/
define('BASE_URL', '//' . $_SERVER['HTTP_HOST'] . '/');

/*
|--------------------------------------------------------------------------
| Base Path
|--------------------------------------------------------------------------
|
| This is the url path where the framework is located. Requires trailing
| slash.
|
*/
define('BASE_PATH', 'meta/');

/*
|--------------------------------------------------------------------------
| Url index file
|--------------------------------------------------------------------------
|
| This determines whether "index.php" is in generated urls
|
*/
define('URL_INDEX_FILE',  BASE_PATH . 'index.php/');

/*
|--------------------------------------------------------------------------
| Content Domain
|--------------------------------------------------------------------------
|
| This is the domain used for serving content, such as css, javascript.
|
*/
define('CONTENT_DOMAIN', BASE_URL . BASE_PATH);

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
define('STYLE_PATH', STATIC_LIB_PATH . 'css.php?g=');

/*
|--------------------------------------------------------------------------
| Group Javascript Path
|--------------------------------------------------------------------------
|
| This is the path that is used to determine the relative path to the
| javascript minifier. This should not need to be changed.
|
*/
define('SCRIPT_PATH', STATIC_LIB_PATH . 'js.php?g=');


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
| Default css group to show if none explicity chose
|
*/
define('DEFAULT_CSS_GROUP', "css");

/*
|--------------------------------------------------------------------------
| Default js group
|--------------------------------------------------------------------------
|
| Default js group to show if none explicitly chosen
|
*/
define('DEFAULT_JS_GROUP', "js");

/*
|--------------------------------------------------------------------------
| Debug backtrace
|--------------------------------------------------------------------------
|
| Whether or not to show a backtrace for php errors
|
| Must be defined as TRUE for the backtrace to display.
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Gzip compress
|--------------------------------------------------------------------------
|
| Whether or not use gzip compression on page output
|
*/
define('GZ_COMPRESS', TRUE);

// End of config.php