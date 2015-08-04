<?php
/**
 * meta
 *
 * Hierarchial data tool
 *
 * @package		meta
 * @author 		Timothy J. Warren
 * @copyright	Copyright (c) 2012
 * @link 		https://github.com/aviat4ion/meta
 * @license 	http://philsturgeon.co.uk/code/dbad-license
 */

// --------------------------------------------------------------------------

namespace Meta\Base;

/**
 * Base Model Class
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