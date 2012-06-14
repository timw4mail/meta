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
class Category extends miniMVC\Controller {

	/**
	 * Initialize the Controller
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load_model('meta\model');

		$this->page->build_header();
	}

	/**
	 * Default controller method
	 */
	public function index()
	{
		$id = (int) miniMVC\get_last_segment();

		if ($id === 0)
		{
			return miniMVC\show_404();
		}

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
		$this->index();
	}

	/**
	 * Returns the sections / editing options for a category
	 */
	public function detail()
	{
		$id = (int) miniMVC\get_last_segment();

		$data = array(
			'category' => $this->model->get_category_by_id($id),
			'sections' => $this->model->get_sections($id),
			'category_id' => $id
		);

		$this->load_view('category_detail', $data);
		$this->page->build_footer();
	}
}

// End of genre.php