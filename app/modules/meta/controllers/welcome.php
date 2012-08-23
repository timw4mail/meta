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

/**
 * Default Controller class
 *
 * @package meta
 */
class welcome extends \meta\controller {

	/**
	 * Initialize the constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	// --------------------------------------------------------------------------

	/**
	 * Default route for the controller
	 *
	 * @return void
	 */
	public function index()
	{
		$data = array();
		$data['genres'] = $this->model->get_genres();

		$this->page->render('genres', $data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Authenticate a user
	 */
	public function login()
	{
		$this->page->render('login');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Display an outline of the data for a table of contents
	 */
	public function outline()
	{
		$outline_data = $this->model->get_outline_data();
		$this->page->render('outline', array('outline' => $outline_data));
	}
}

// End of welcome.php