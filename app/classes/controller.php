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
		$this->load_model('meta\model');
		$this->load_model('meta\user_model');

    	$this->session =& \miniMVC\Session::get_instance();

    	// Check if user is logged in
    	$this->check_login_status();

		$this->page->build_header();
	}

	/**
	 * Require user login for access
	 */
	private function check_login_status()
	{
		if ( ! isset($this->session->uid))
		{
			// Redirect to login
		}

		return;

	}

	/**
	 * Destruct controller and build page footer
	 */
	public function __destruct()
	{
		$this->page->set_foot_js_group('js');
		$this->page->build_footer();
	}

}
