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

namespace miniMVC;

/**
 * Base Controller Class
 *
 * @package miniMVC
 * @subpackage System
 */
class Controller {

	/**
	 * Instance of Page class
	 *
	 * @var Page
	 */
	protected $page;

	/**
	 * Create the controller object
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Create the page object
		if (is_null($this->page))
		{
			$this->page = new Page();
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Function for loading a model into the current class
	 *
	 * @param string $file
	 * @param array $args
	 * @return void
	 */
	public function load_model($file, $args=array())
	{
		$segments = explode('\\', $file);
		$file_name = end($segments);

		// The module is set via the router
		$module = strtolower(MM_MOD);
		$path = MM_MOD_PATH . "{$module}/models/{$file_name}.php";

		if (is_file($path))
		{
			require_once($path);
		}

		if ( ! empty($args))
		{

			$this->$file_name = new $file($args);
		}
		else
		{
			$this->$file_name = new $file;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Function for loading a view
	 *
	 * @param string $file
	 * @param array $data
	 * @param bool $return
	 * @return mixed
	 */
	public function load_view($file, array $data=array(), $return=FALSE)
	{
		return $this->page->load_view($file, $data, $return);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Automate loading of header and footer
	 *
	 * @param string $file
	 * @param array $data
	 * @param bool $return
	 * @return mixed
	 */
	public function render($file, array $data=array(), $return=FALSE)
	{
		return $this->page->render($file, $data, $return);
	}
}

// End of controller.php