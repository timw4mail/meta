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
 * Base class for the framework
 *
 * @package miniMVC
 * @subpackage System
 */
class miniMVC extends MM {

	/**
	 * Constructor - Any classes loaded here become subclasses of miniMVC
	 *
	 * @param array $members
	 */
	public function __construct($members = array())
	{
		// Allow the class to be used like an array
		parent::__construct($members);
	}

	// --------------------------------------------------------------------------

	/**
	 * Convenience function to load config files
	 *
	 * @param string $name
	 */
	public function load_config($name)
	{
		$path = MM_APP_PATH . "config/{$name}.php";

		if (is_file($path))
		{
			require_once($path);
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Singleton getter function
	 *
	 * @return self
	 */
	public static function &get_instance()
	{
		if ( ! isset(self::$instance))
		{
			$class = __CLASS__;

			self::$instance = new $class;
		}

		return self::$instance;
	}

	// --------------------------------------------------------------------------

	/**
	 * Magic function called when cloning an object
	 */
	public function __clone()
	{
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}
}

// End of miniMVC.php