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

namespace Meta\Controller;

/**
 * Category controller
 *
 * @package meta
 */
class Category extends \Meta\Base\Controller {

	/**
	 * Returns the sections / editing options for a category
	 */
	public function detail($id = 0)
	{
		if ($id === 0)
		{
			$id = (int) miniMVC\get_last_segment();
		}

		$data = array(
			'category' => $this->data_model->get_category_by_id($id),
			'sections' => $this->data_model->get_category_outline_data($id),
			'genre' => $this->data_model->get_genre_by_category($id),
			'category_id' => $id
		);

		if (empty($data['category']))
		{
			$this->page->render_message('error', "Category doesn't exist.");
			return;
		}

		$this->render('category_detail', $data);
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
		$res = $this->data_model->add_section($name, $id);

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

// End of category.php