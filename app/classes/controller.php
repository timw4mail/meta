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

namespace meta;

/**
 * Base controller class to hold common functionality
 *
 * @param package meta
 */
abstract class Controller extends \miniMVC\Controller {

	/**
	 * Create the controller and build page header
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load_model('meta\Model');
		$this->page->build_header();
	}

	/**
	 * Destruct controller and build page footer
	 */
	public function __destruct()
	{
		$this->page->build_footer();
	}

}
