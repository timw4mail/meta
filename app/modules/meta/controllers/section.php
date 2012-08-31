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
	 * Adds a new category
	 */
	public function add()
	{
		// Strip away tags for the sake of security
		$name = strip_tags($_POST['section']);
		$id = (int) $_POST['category_id'];

		// Make sure the name doesn't already exist. If it does, show an error.
		$res = $this->model->add_section($name, $id);

		if ($res === TRUE)
		{
			$this->page->set_message('success', 'Added new section');
		}
		else
		{
			$this->page->set_message('error', 'Section already exists for this category');
		}

		// Render the basic page
		$this->index($this->model->get_last_id('section'));
	}
}

// End of section.php