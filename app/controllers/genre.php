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
class genre extends \miniMVC\Controller {

	/**
	 * Default controller method
	 */
	public function index()
	{
		//$this->data_model->create_tables();

		$data = array();
		$data['genres'] = $this->data_model->get_genres();

		$this->render('genres', $data);

		return;
	}

	// --------------------------------------------------------------------------

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

	// --------------------------------------------------------------------------

	/**
	 * Returns the categories / editing options for a genre
	 *
	 * @param int
	 */
	public function detail($id = 0)
	{
		if ($id === 0)
		{
			// Re-route to detail page if the last segment
			// is a valid integer
			$id = (int) miniMVC\get_last_segment();
		}

		$genre = $this->data_model->get_genre_by_id($id);
		$categories = $this->data_model->get_categories($id);

		if (empty($genre))
		{

			$this->page->render_message('error', "Genre doesn't exist.");
			return;
			return;
		}

		$data = array(
			'genre' => $genre,
			'categories' => $categories,
			'genre_id' => $id
		);

		$this->render('genre_detail', $data);
	}

	// --------------------------------------------------------------------------

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

	// --------------------------------------------------------------------------

	/**
	 * Display an outline of the data for a table of contents
	 */
	public function outline()
	{
		$outline_data = $this->data_model->get_outline_data();
		$this->render('outline', array('outline' => $outline_data));
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a message for ajax insertion
	 */
	public function message()
	{
		$type = strip_tags($_GET['type']);
		$message = $_GET['message'];

		$this->page->set_output(
			$this->page->set_message($type, $message, TRUE)
		);
	}

	// --------------------------------------------------------------------------

	public function delete()
	{
		$type = strip_tags($_POST['type']);

		$valid_types = ['genre', 'category', 'section', 'data'];

		$res = (in_array($type, $valid_types))
			? $this->data_model->delete($type, (int) $_POST['id'])
			: 0;

		exit(mb_trim($res));
	}

	// --------------------------------------------------------------------------

	public function edit()
	{
		$type = strip_tags($_GET['type']);
		$id = (int) $_GET['id'];

		if ($this->data_model->is_valid_type($type))
		{
			$data = call_user_func(array($this->data_model, "get_{$type}_by_id"), $id);

			$form_array = array(
            	'name' => is_array($data) ? $data['key'] : "",
            	'val' => is_array($data) ? $data['value'] : $data,
            	'type' => $type,
            	'id' => $id
			);

			exit($this->load_view('edit_form', $form_array, TRUE));
		}
	}

	// --------------------------------------------------------------------------

	public function update()
	{
		$id = (int) $_POST['id'];
		$type = strip_tags($_POST['type']);
		$name = strip_tags($_POST['name']);
		$val = (isset($_POST['val'])) ? $_POST['val'] : NULL;

		if ($this->data_model->is_valid_type($type))
		{
			if ($type != 'data')
			{
				$res = $this->data_model->update($type, $id, $name);
			}
			else
			{
				$res = $this->data_model->update_data($id, $name, $val);
			}

			$res = (int) $res;

			exit(mb_trim($res));
		}

		exit(0);
	}
}

// End of genre.php