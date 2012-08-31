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
 * Data Controller
 *
 * @package meta
 */
class data extends meta\controller {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * View section data
	 */
	public function index()
	{

	}

	/**
	 * Add data
	 */
	public function add()
	{
		$section_id = (int) $_POST['section_id'];
		//$old_data = $this->model->get_data($section_id);


		$keys = filter_var_array($_POST['name'], FILTER_SANITIZE_STRING);
		$vals = filter_var_array($_POST['val'], FILTER_SANITIZE_STRING);

		//echo miniMVC\to_string($_POST);

		$data = array_combine($keys, $vals);

		$res = /*(empty($old_data))
			?*/ $this->model->add_data($section_id, $data);
			//: FALSE;

		($res)
			? $this->page->set_message('success', 'Added data')
			: $this->page->set_message('error', 'Data already exists');

	}
}

// End of data.php