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
 * Asset management configuration file
 *
 * @package miniMVC
 * @subpackage Assets
 */

/*
|--------------------------------------------------------------------------
| Document Root
|--------------------------------------------------------------------------
|
| The folder where the index of the website exists. In most situations,
| this will not need to be changed.
|
| If the website is in a folder off of the domain name, like:
|	http://example.com/website/
| you will need to add that folder to the document root.
|
*/
$document_root = './';

/*
|--------------------------------------------------------------------------
| CSS Folder
|--------------------------------------------------------------------------
|
| The folder where css files exist, in relation to the document root
|
*/
$css_root = $document_root. 'css/';

/*
|--------------------------------------------------------------------------
| Path from
|--------------------------------------------------------------------------
|
| Path fragment to rewrite in css files
|
*/
$path_from = './images/';

/*
|--------------------------------------------------------------------------
| Path to
|--------------------------------------------------------------------------
|
| The path fragment replacement for the css files
|
*/
$path_to = '//github.timshomepage.net/meta/assets/images/';

/*
|--------------------------------------------------------------------------
| JS Folder
|--------------------------------------------------------------------------
|
| The folder where javascript files exist, in relation to the document root
|
*/
$js_root = $document_root. 'js/';