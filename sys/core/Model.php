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
 * Base Model Class
 *
 * @package miniMVC
 * @subpackage System
 */
class Model extends \ArrayObject {

	/**
	 * Initialize the model class
	 *
	 * @param array $args
	 * @return void
	 */
	public function __construct(array $args = array())
	{
		parent::__construct($args, \ArrayObject::STD_PROP_LIST | \ArrayObject::ARRAY_AS_PROPS);
	}
}

// End of model.php