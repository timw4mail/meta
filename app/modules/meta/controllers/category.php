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
 * Category controller
 *
 * @package meta
 */
class category extends meta\controller {

	/**
	 * Initialize the Controller
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Returns the sections / editing options for a category
	 */
	public function index($id = 0)
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
			'category' => $this->model->get_category_by_id($id),
			'sections' => $this->model->get_category_outline_data($id),
			'genre' => $this->model->get_genre_by_category($id),
			'category_id' => $id
		);

		$this->load_view('category_detail', $data);
	}

	/**
	 * Adds a section to the current category
	 */
	public function add_section()
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

		$this->detail($id);
	}
}

// End of genre.php