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
 * Section Controller
 *
 * @package meta
 */
class section extends meta\controller {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default controller method
	 */
	public function index($id=0)
	{
		if ($id === 0)
		{
			$id = (int) miniMVC\get_last_segment();
		}

		if ($id === 0)
		{
			miniMVC\show_404();
		}

		$data = array(
			'section' => $this->model->get_section_by_id($id),
			'sdata' => $this->model->get_data($id),
			'p' => $this->model->get_path_by_section($id),
			'section_id' => $id
		);

		$this->load_view('section_detail', $data);
	}

	/**
	 * Adds a data item to the current section
	 */
	public function add_data()
	{
		$section_id = (int) $_POST['section_id'];


		$keys = filter_var_array($_POST['name'], FILTER_SANITIZE_STRING);
		$vals = filter_var_array($_POST['val'], FILTER_SANITIZE_STRING);


		$data = array_combine($keys, $vals);

		$res = $this->model->add_data($section_id, $data);


		($res)
			? $this->page->set_message('success', 'Added data')
			: $this->page->set_message('error', 'Data already exists');

		$this->index($section_id);
	}
}

// End of section.php