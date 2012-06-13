<?php
/**
 * meta
 *
 * Simple hierarchial data management
 *
 * @package		meta
 * @author 		Timothy J. Warren
 * @copyright	Copyright (c) 2012
 * @link 		https://github.com/aviat4ion/meta
 * @license 	http://philsturgeon.co.uk/code/dbad-license
 */

// --------------------------------------------------------------------------

namespace meta;

/**
 * Main Model for database interaction
 *
 * @package meta
 */
class Model extends \miniMVC\Model {

	/**
	 * Reference to database connection
	 *
	 * @var Query_Builder
	 */
	protected $db;

	/**
	 * Reference to session
	 *
	 * @var Session
	 */
	protected $session;

	/**
	 * Initialize the model
	 */
	public function __construct()
	{
		parent::__construct();

		$this->session =& \miniMVC\Session::get_instance();
		$this->db =& \miniMVC\db::get_instance();
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete a genre/category/section or data item
	 *
	 * @param string $type
	 * @param int $id
	 */
	public function delete($type, $id)
	{
		$this->db->where('id', (int) $id)
			->delete($type);
	}

	// --------------------------------------------------------------------------

	/**
	 * Move a category/section/data item to another parent
	 *
	 * @param string
	 * @param int
	 * @param int
	 */
	public function move($type, $type_id, $parent_id)
	{
		$parent_type = array(
			'data' => 'section',
			'section' => 'category',
			'category' => 'genre'
		);

		$parent_field = "{$parent_type[$type]}_id";

		$this->db->set($parent_field, $parent_id)
			->where('id', (int) $type_id)
			->update($type);
	}

	// --------------------------------------------------------------------------

	/**
	 * Add genre
	 *
	 * @param string
	 * @return bool
	 */
	public function add_genre($genre)
	{
		// Check for duplicates
		$query = $this->db->from('genre')
			->where('genre', $genre)
			->get();

		// Fetch the data as a workaround
		// for databases that do not support
		// grabbing result counts (SQLite / Firebird)
		$array = $query->fetchAll();
		if (count($array) === 0)
		{
			$this->db->set('genre', $genre)
				->insert('genre');

			return TRUE;
		}

		return FALSE;

	}

	// --------------------------------------------------------------------------

	/**
	 * Rename a genre
	 *
	 * @param int
	 * @param string
	 */
	public function update_genre($genre_id, $genre)
	{
		$this->db->set('genre', $genre)
			->where('id', $genre_id)
			->update('genre');
	}

	// --------------------------------------------------------------------------

	/**
	 * Add category to genre
	 *
	 * @param string
	 * @param int
	 */
	public function add_category($cat, $genre_id)
	{
		$this->db->set('category', $cat)
			->set('genre_id', $genre_id)
			->insert('category');
	}

	// --------------------------------------------------------------------------

	/**
	 * Rename a category
	 *
	 * @param int
	 * @param string
	 */
	public function update_category($cat_id, $category)
	{
		$this->db->set('category', $category)
			->where('id', (int) $cat_id)
			->update('category');
	}

	// --------------------------------------------------------------------------

	/**
	 * Add a section to a category
	 *
	 * @param string
	 * @param int
	 */
	public function add_section($section, $category_id)
	{
		$this->db->set('section', $section)
			->set('category_id', (int) $category_id)
			->insert('section');
	}

	// --------------------------------------------------------------------------

	/**
	 * Rename a section
	 *
	 * @param int
	 * @param string
	 */
	public function update_section($section_id, $section)
	{
		$this->db->set('section', $section)
			->where('id', (int) $section_id)
			->update('section');
	}

	// --------------------------------------------------------------------------

	/**
	 * Add key/value data to a section
	 *
	 * @param int
	 * @param mixed object/array
	 */
	public function add_data($section_id, $data)
	{
		// Convert the data to json for storage
		$data_str = json_encode($data);

		// Save the data
		$this->db->set('data', $data_str)
			->set('section_id', (int) $section_id)
			->insert('data');
	}

	// --------------------------------------------------------------------------

	/**
	 * Update the data
	 *
	 * @param int
	 * @param mixed
	 */
	public function update_data($data_id, $data)
	{
		// Convert the data to json for storage
		$data_str = json_encode('data', $data_str);

		// Save the data
		$this->db->set('data', $data_str)
			->where('id', (int) $data_id)
			->update('data');

	}

	// --------------------------------------------------------------------------

	/**
	 * Gets the list of genres
	 *
	 * @return array
	 */
	public function get_genres()
	{
		$genres = array();
		$query = $this->db->select('id, genre')
			->from('genre')
			->order_by('genre', 'asc')
			->get();

		while($row = $query->fetch(\PDO::FETCH_ASSOC))
		{
			$genres[$row['id']] = $row['genre'];
		}

		return $genres;
	}

	/**
	 * Gets the name of the genre from its id
	 *
	 * @param int
	 * @return string
	 */
	public function get_genre_by_id($id)
	{
		$query = $this->db->select('genre')
			->from('genre')
			->where('id', (int) $id)
			->get();

		$row = $query->fetch(\PDO::FETCH_ASSOC);

		return $row['genre'];
	}

	// --------------------------------------------------------------------------

	/**
	 * Get the categories for the specified genre
	 *
	 * @param int
	 * @return array
	 */
	public function get_categories($genre_id)
	{
		$cats = array();

		$query = $this->db->select('id, category')
			->from('category')
			->where('genre_id', (int) $genre_id)
			->get();

		while($row = $query->fetch(\PDO::FETCH_ASSOC))
		{
			$cats[$row['id']] = $row['category'];
		}

		return $cats;
	}

	// --------------------------------------------------------------------------

	/**
	 * Get the sections for the specified category id
	 *
	 * @param int
	 * @return array
	 */
	public function get_sections($category_id)
	{
		$sections = array();

		$query = $this->db->select('id, section')
			->from('section')
			->where('category_id', (int) $category_id)
			->get();

		while($row = $query->fetch(\PDO::FETCH_ASSOC))
		{
			$sections[$row['id']] = $row['section'];
		}

		return $sections;
	}

	// --------------------------------------------------------------------------

	/**
	 * Get the data fro the section
	 *
	 * @param int
	 * @return array
	 */
	public function get_data($section_id)
	{
		$data = array();

		$query = $this->db->select('id, data')
			->from('data')
			->where('section_id', (int) $section_id)
			->get();

		while($row = $query->fetch(\PDO::FETCH_ASSOC))
		{
			$data[$row['id']] = json_decode($row['data'], TRUE);
		}

		return $data;
	}

}

// End of model.php