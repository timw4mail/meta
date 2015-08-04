<?php
/**
 * meta
 *
 * Hierarchial data tool
 *
 * @package		meta
 * @author 		Timothy J. Warren
 * @copyright	Copyright (c) 2012 - 2015
 * @link 		https://github.com/aviat4ion/meta
 * @license 	http://philsturgeon.co.uk/code/dbad-license
 */

// --------------------------------------------------------------------------

namespace Meta\Base;
use Meta\Model\Data as Data_Model;

/**
 * Base Controller Class
 */
class Controller {

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
		// Create the page object
		if (is_null($this->page))
		{
			$this->page = new Page();
		}


		$this->data_model = new Data_Model();

		$db = \Meta\Base\db::get_instance();

		$this->page->queries =& $db->queries;
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
	public function load_view($file, array $data=array(), $return=FALSE)
	{
		return $this->page->load_view($file, $data, $return);
	}

	// --------------------------------------------------------------------------

	/**
	 * Automate loading of header and footer
	 *
	 * @param string $file
	 * @param array $data
	 * @param bool $return
	 * @return mixed
	 */
	public function render($file, array $data=array(), $return=FALSE)
	{
		return $this->page->render($file, $data, $return);
	}
}

// End of controller.php