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
	 * Default controller method
	 */
	public function index()
	{
		$this->detail();
	}

	/**
	 * Adds a new category
	 */
	public function add()
	{
		// Strip away tags for the sake of security
		$name = strip_tags($_POST['category']);
		$id = (int) $_POST['genre_id'];

		// Make sure the name doesn't already exist. If it does, show an error.
		$res = $this->model->add_category($name, $id);

		if ($res === TRUE)
		{
			$this->page->set_message('success', 'Added new category');
		}
		else
		{
			$this->page->set_message('error', 'Category already exists for this genre');
		}

		// Render the basic page
		$this->detail($this->model->get_last_id('category'));
	}

	/**
	 * Returns the sections / editing options for a category
	 */
	public function detail($id = 0)
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
}

// End of genre.php