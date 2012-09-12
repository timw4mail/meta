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
 * Genre controller
 *
 * @package meta
 */
class genre extends meta\controller {

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
	public function index($id = 0)
	{
		if ($id === 0)
		{
			// Re-route to detail page if the last segment
			// is a valid integer
			$id = (int) miniMVC\get_last_segment();
		}

		if ($id === 0)
		{
			// Otherwise, display list of genres
			$data = array();
			$data['genres'] = $this->data_model->get_genres();

			$this->load_view('genres', $data);

			return;
		}

		return $this->detail($id);
	}

	/**
	 * Adds a new genre
	 */
	public function add()
	{
		// Strip away tags for the sake of security
		$name = strip_tags($_POST['genre']);

		// Make sure the name doesn't already exist. If it does, show an error.
		$res = $this->data_model->add_genre($name);

		if ($res === TRUE)
		{
			$this->page->set_message('success', 'Added new genre');
		}
		else
		{
			$this->page->set_message('error', 'Genre already exists');
		}

		// Render the basic page
		$this->index();
	}

	/**
	 * Returns the categories / editing options for a genre
	 *
	 * @param int
	 */
	public function detail($id)
	{
		$genre = $this->data_model->get_genre_by_id($id);
		$categories = $this->data_model->get_categories($id);

		$data = array(
			'genre' => $genre,
			'categories' => $categories,
			'genre_id' => $id
		);

		$this->load_view('genre_detail', $data);
	}

	/**
	 * Adds a category to the current genre
	 */
	public function add_category()
	{
		// Strip away tags for the sake of security
		$name = strip_tags($_POST['category']);
		$id = (int) $_POST['genre_id'];

		// Make sure the name doesn't already exist. If it does, show an error.
		$res = $this->data_model->add_category($name, $id);

		if ($res === TRUE)
		{
			$this->page->set_message('success', 'Added new category');
		}
		else
		{
			$this->page->set_message('error', 'Category already exists for this genre');
		}

		$this->detail($id);
	}
}

// End of genre.php