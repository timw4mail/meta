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
 * CSS Minifier and Cacher
 *
 * @package miniMVC
 * @subpackage Assets
 */

//Get config files
require './config/config.php';

//Include the css groups
$groups = require './config/css_groups.php';

//The name of this file
$this_file = __FILE__;

// --------------------------------------------------------------------------

/**
 * CSS Minifier
 *
 * @param string $buffer
 * @return string
 */
function compress($buffer) {

    //Remove CSS comments
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

    //Remove tabs, spaces, newlines, etc.
    $buffer = preg_replace('`\s+`', ' ', $buffer);
    $replace = [
    	' )' => ')',
    	') ' => ')',
    	' }' => '}',
    	'} ' => '}',
    	' {' => '{',
    	'{ ' => '{',
    	', ' => ',',
    	': ' => ':',
    	'; ' => ';',
    ];

    //Eradicate every last space!
    $buffer = trim(strtr($buffer, $replace));
    $buffer = str_replace('{ ', '{', $buffer);
    $buffer = str_replace('} ', '}', $buffer);

    return $buffer;
}

// --------------------------------------------------------------------------

//Creative rewriting
$pi = $_SERVER['PATH_INFO'];
$pia = explode('/', $pi);

$pia_len = count($pia);
$i = 1;

while($i < $pia_len)
{
	$j = $i+1;
	$j = (isset($pia[$j])) ? $j : $i;

	$_GET[$pia[$i]] = $pia[$j];

	$i = $j + 1;
};

$css = '';
$modified = [];

if (isset($groups[$_GET['g']]))
{
	foreach ($groups[$_GET['g']] as &$file)
	{
		$new_file = $css_root.$file;
		$css .= file_get_contents($new_file);
		$modified[] = filemtime($new_file);
	}
}

//Add this page too
$modified[] = filemtime($this_file);

//Get the latest modified date
rsort($modified);
$last_modified = $modified[0];

$requested_time= (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
	? strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])
	: time();

if ($last_modified === $requested_time)
{
	header("HTTP/1.1 304 Not Modified");
	exit();
}

// Correct paths that have changed due to concatenation
// based on rules in the config file
$css = str_replace($path_from, $path_to, $css);

if (!isset($_GET['debug']))
{
	$css = compress($css);
}

$size = strlen($css) * 8;

//This GZIPs the CSS for transmission to the user
//making file size smaller and transfer rate quicker
ob_start("ob_gzhandler");

header("Content-Type: text/css; charset=utf8");
header("Cache-control: public, max-age=691200, must-revalidate");
header("Last-Modified: ".gmdate('D, d M Y H:i:s', $last_modified)." GMT");
header("Expires: ".gmdate('D, d M Y H:i:s', (filemtime($this_file) + 691200))." GMT");

echo $css;

ob_end_flush();
//End of css.php