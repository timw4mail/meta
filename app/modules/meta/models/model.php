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
class model extends \miniMVC\Model {

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
	 * @return bool
	 */
	public function add_category($cat, $genre_id)
	{
		// Check for duplicates
		$query = $this->db->from('category')
			->where('genre_id', $genre_id)
			->where('category', $cat)
			->get();

		// Fetch the data as a workaround
		// for databases that do not support
		// grabbing result counts (SQLite / Firebird)
		$array = $query->fetchAll();
		if (count($array) === 0)
		{
			$this->db->set('category', $cat)
				->set('genre_id', $genre_id)
				->insert('category');

			return TRUE;
		}

		return FALSE;
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

	// --------------------------------------------------------------------------

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
	 * Gets the name of the category from its id
	 *
	 * @param int
	 * @return string
	 */
	public function get_category_by_id($id)
	{
		$query = $this->db->select('category')
			->from('category')
			->where('id', (int) $id)
			->get();

		$row = $query->fetch(\PDO::FETCH_ASSOC);

		return $row['category'];
	}

	// --------------------------------------------------------------------------

	/**
	 * Gets the name of the section from its id
	 *
	 * @param int
	 * @return string
	 */
	public function get_section_by_id($id)
	{
		$query = $this->db->select('section')
			->from('section')
			->where('id', (int) $id)
			->get();

		$row = $query->fetch(\PDO::FETCH_ASSOC);

		return $row['section'];
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
	
	// --------------------------------------------------------------------------
	
	/**
	 * Get data for a full outline
	 *
	 * @return array
	 */
	public function get_outline_data()
	{
		// Get the genres
		$g_query = $this->db->from('genre')
			->get();
			
		$genres = array();
			
		while ($row = $g_query->fetch(\PDO::FETCH_ASSOC))
		{
			$genres[$row['id']] = $row['genre'];
		}
		
		// Get the categories
		$c_query = $this->db->from('category')
			->get();
			
		$categories = array();
		
		while($row = $c_query->fetch(\PDO::FETCH_ASSOC))
		{
			$categories[$row['genre_id']][$row['id']] = $row['category'];
		}
		
		// Get the sections
		$s_query = $this->db->from('section')
			->get();
			
		$sections = array();
		
		while($row = $s_query->fetch(\PDO::FETCH_ASSOC))
		{
			$sections[$row['category_id']][$row['id']] = $row['section'];
		}
				
		
		// Organize into a nested array			
		foreach($genres as $genre_id => $genre)
		{
			$return[$genre_id][$genre] = array();
			$g =& $return[$genre_id][$genre];
			
			// Categories for this genre
			if (isset($categories[$genre_id]))
			{
				$g = $categories[$genre_id];
			
				foreach($categories[$genre_id] as $category_id => $category)
				{
					$g[$category_id] = array($category => array());
					$c =& $g[$category_id][$category];
				
					// Sections for this category
					if (isset($sections[$category_id]))
					{
						$c = $sections[$category_id];
					}
				}
			}
		}
	
		return $return;
	}

}

// End of model.php