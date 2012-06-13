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
 * Class for using JSON as a key->value data store
 *
 * @package miniMVC
 * @subpackage Libraries
 */
class Data_Store {
	
	/**
	 * Settings object represented by the currently loaded JSON file
	 */
	private $current;
	
	/**
	 * Singleton instance
	 */
	private static $instance;
	
	/**
	 * Create and/or load json file
	 */
	protected function __construct()
	{
		$path = MM_APP_PATH .'config/data_store.json';
		
		if ( ! is_file($path))
		{
			touch($path);
			$this->current = (object)[];
		}
		else
		{
			// Load the file
			$json = file_get_contents($path);
		
			// Load the object into the class
			$this->current = json_decode($json);
		}
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Output the data on destruct
	 */
	public function __destruct()
	{
		$file_string = json_encode($this->current, JSON_PRETTY_PRINT);

		file_put_contents(MM_APP_PATH . 'config/data_store.json', $file_string);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Magic function called when cloning an object
	 */
	public function __clone()
	{
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Magic method to simplify isset checking for config options
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return (isset($this->current->{$key}))
			? $this->current->{$key}
			: NULL;
	}

	// --------------------------------------------------------------------------

	/**
	 * Magic method to simplify setting config options
	 *
	 * @param string $key
	 * @param mixed
	 */
	public function __set($key, $val)
	{
		return $this->current->{$key} = $val;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Static method to retreive current instance
	 * of the singleton
	 *
	 * @return self
	 */
	public static function &get_instance()
	{
		if( ! isset(self::$instance))
		{
			$name = __CLASS__;
			self::$instance = new $name();
		}

		return self::$instance;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Removes a key from the data store
	 *
	 * @param string $key
	 * @return void
	 */
	public function del($key)
	{
		unset($this->current->{$key});
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Return the entire data store object
	 *
	 * @return object
	 */
	public function get_all()
	{
		return $this->current;
	}
}

// End of data store.php