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
class Controller extends miniMVC {

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
		parent::__construct();

		// Create the page object
		$this->page = new Page($this);
	}

	// --------------------------------------------------------------------------

	/**
	 * Function for loading a model into the current class
	 *
	 * @param string $file
	 * @param array $args
	 * @return void
	 */
	public function load_model($file, $args=[])
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
	public function load_view($file, array $data=[], $return=FALSE)
	{
		$path = "";

		// The module is set via the router
		$module = strtolower(MM_MOD);
		$path = MM_MOD_PATH . "{$module}/views/{$file}.php";

		// If it's not a module, or doesn't exist in the module view folder
		// look in the app view folder
		if ( ! is_file($path))
		{
			$path = MM_APP_PATH . "views/{$file}.php";
		}

		// Contain the content for buffering
		ob_start();

		// Extract the data array
		extract($data);

		// Include the file
		include($path);

		$buffer = ob_get_contents();
		ob_end_clean();

		if ($return == TRUE)
		{
			return $buffer;
		}
		else
		{
			$this->page->append_output($buffer);
		}
	}
}

// End of controller.php