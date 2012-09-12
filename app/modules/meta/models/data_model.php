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
class data_model extends \miniMVC\Model {

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
	// ! Data Manipulation
	// --------------------------------------------------------------------------

	/**
	 * Delete a genre/category/section or data item
	 *
	 * @param string $type
	 * @param int $id
	 * @return bool
	 */
	public function delete($type, $id)
	{
		try
		{
			$this->db->where('id', (int) $id)
				->delete($type);
		}
		catch (\PDOException $e)
		{
			return FALSE;
		}

		return TRUE;
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
	 * Rename a genre/category/section
	 *
	 * @param string
	 * @param int
	 * @param string
	 * @return bool
	 */
	public function update($type, $id, $name)
	{
		$query = $this->db->set($type, $name)
			->where('id', (int) $id)
			->update($type);

		return ( ! empty($query)) ;
	}

	// --------------------------------------------------------------------------

	/**
	 * Update the data
	 *
	 * @param int
	 * @param string
	 * @param string
	 * @return bool
	 */
	public function update_data($data_id, $key, $val)
	{
		try{
			// Save the data
			$this->db->set('key', $key)
				->set('value', $val)
				->where('id', (int) $data_id)
				->update('data');
		}
		catch(\PDOException $e)
		{
			return FALSE;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------------
	// ! Adding data
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
			->limit(1)
			->get();

		// Fetch the data as a workaround
		// for databases that do not support
		// grabbing result counts (SQLite / Firebird)
		$array = $query->fetchAll(\PDO::FETCH_ASSOC);
		if (count($array) < 1)
		{
			$this->db->set('genre', $genre)
				->insert('genre');

			return TRUE;
		}

		return FALSE;

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
			->limit(1)
			->get();

		// Fetch the data as a workaround
		// for databases that do not support
		// grabbing result counts (SQLite / Firebird)
		$array = $query->fetchAll();
		if (count($array)< 1)
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
	 * Add a section to a category
	 *
	 * @param string
	 * @param int
	 */
	public function add_section($section, $category_id)
	{
        // Check if the section exists
        $q = $this->db->from('section')
        	->where('category_id', $category_id)
        	->where('section', $section)
        	->limit(1)
        	->get();

        // Fetch the data as a workaround
		// for databases that do not support
		// grabbing result counts (SQLite / Firebird)
        $array = $q->fetchAll();
        if (count($array) < 1)
        {
			$this->db->set('section', $section)
				->set('category_id', (int) $category_id)
				->insert('section');

			return TRUE;
        }

		return FALSE;
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
		foreach($data as $key => $val)
		{
            // See if the data exists
        	$q = $this->db->from('data')
        		->where('section_id', $section_id)
        		->where('key', $key)
        		->get();

        	if ($this->db->num_rows() > 0) return FALSE;

			// Save the data
			$this->db->set('key', $key)
				->set('value', $val)
				->set('section_id', (int) $section_id)
				->insert('data');
		}

		return TRUE;
	}



	// --------------------------------------------------------------------------
	// ! Data Retrieval
	// --------------------------------------------------------------------------

	/**
	 * Get the id of the last item of the type
	 *
	 * @param string $type
	 * @return int
	 */
	public function get_last_id($type)
	{
		$query = $this->db->select('id')
			->from($type)
			->order_by('id', 'DESC')
			->limit(1)
			->get();

		$r = $query->fetch(\PDO::FETCH_ASSOC);

		return $r['id'];
	}

	// --------------------------------------------------------------------------

	/**
	 * Get breadcrumb data for section
	 *
	 * @param section_id
	 * @return array
	 */
	public function get_path_by_section($section_id)
	{
		$query = $this->db->select('genre, genre_id, category, category_id')
			->from('section s')
			->join('category c', 'c.id=s.category_id')
			->join('genre g', 'g.id=c.genre_id')
			->where('s.id', $section_id)
			->get();

		return $query->fetch(\PDO::FETCH_ASSOC);
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
	 * Get the genre name by category id
	 *
	 * @param int
	 * @return array
	 */
	public function get_genre_by_category($cat_id)
	{
		$query = $this->db->select('g.id, genre')
			->from('genre g')
			->join('category c', 'c.genre_id=g.id', 'inner')
			->where('c.id', (int)$cat_id)
			->get();

		$row = $query->fetch(\PDO::FETCH_ASSOC);

		return $row;
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
	 *  Gets the data for the specified id
	 *
	 * @param int $id
	 * @return array
	 */
	public function get_data_by_id($id)
	{
		$query = $this->db->select('key, value')
			->from('data')
			->where('id', (int) $id)
			->get();

		$row = $query->fetch(\PDO::FETCH_ASSOC);

		return $row;
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

		$query = $this->db->select('id, key, value')
			->from('data')
			->where('section_id', (int) $section_id)
			->get();

		while($row = $query->fetch(\PDO::FETCH_ASSOC))
		{
			$data[$row['id']] = array($row['key'] => $row['value']);
		}

		return $data;
	}

	// --------------------------------------------------------------------------

	/**
	 * Get sections and data for a general data outline
	 *
	 * @param int $category_id
	 * @return array
	 */
	public function get_category_outline_data($category_id)
	{
		// Get the sections
		$s_query = $this->db->from('section')
			->where('category_id', (int) $category_id)
			->get();

		$sections = array();

		while($row = $s_query->fetch(\PDO::FETCH_ASSOC))
		{
			$sections[$row['id']] = $row['section'];
		}

		// Get the data for the sections
		$d_array = array();

		if ( ! empty($sections))
		{
			$d_query = $this->db->from('data')
				->where_in('section_id', array_keys($sections))
				->get();

			while($row = $d_query->fetch(\PDO::FETCH_ASSOC))
			{
				$d_array[$row['section_id']][$row['key']] = $row['value'];
			}
		}

		// Reorganize the data
		$data = array();

		foreach($sections as $section_id => $section)
		{
			$data[$section_id] = (isset($d_array[$section_id]))
				? array($section, $d_array[$section_id])
				: $section;
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

	// --------------------------------------------------------------------------
	// ! Miscellaneous methods
	// --------------------------------------------------------------------------

	/**
	 * Check if a valid type for editing
	 *
	 * @param string
	 * @return bool
	 */
	public function is_valid_type($str)
	{
		$valid = array(
			'genre','category','section','data'
		);

		return in_array(strtolower($str), $valid);
	}

}

// End of data_model.php