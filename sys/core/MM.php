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
 * Class for standalone JSObject objects
 *
 * @package miniMVC
 * @subpackage System
 */
class MM extends \ArrayObject {
	
	/**
	 * Create the ArrayObject hybrid object
	 *
	 * @param array
	 */
	public function __construct($members = array())
	{
		parent::__construct($members);
	
		// Add the passed parameters to the object
 		foreach ($members as $name => &$value)
 		{
 			$this->$name = $value;
 		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Allow calling of array methods on the object and 
	 * dynamic methods
	 *
	 * @param string $name
	 * @param array $params
	 * @return mixed
	 */
	public function __call($name, $params = array())
	{
		// Allow array operations on the object
		if (substr($name, 0, 6) === 'array_' && is_callable($name))
		{
			$args = array_merge($this->getArrayCopy(), $args);
			return call_user_func_array($name, $args);
		}
		
		// Allow dynamic method calls
		if (is_callable($this->$name))
		{	
			//Call the dynamic function
			return call_user_func_array($this->$name, $params);
		}
	}
}

// End of MM.php