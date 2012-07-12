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
class welcome extends miniMVC\Controller {

	/**
	 * Initialize the constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load_model('meta\model');
		$this->load_model('meta\user_model');

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

	}
}

// End of welcome.php