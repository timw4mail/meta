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
 * Model for dealing with user logins / permissions
 *
 * @package meta
 */
class user_model extends \miniMVC\Model {

	/**
	 * Reference to database connection
	 *
	 * @var Query_Builder
	 */
	protected $db;

	/**
	 * Reference to bcrypt object
	 *
	 * @var Bcrypt
	 */
	protected $bcrypt;
	
	/**
	 * Reference to session
	 *
	 * @var Session
	 */
	protected $session;

	/**
	 * Initialize the User model
	 */
	public function __construct()
	{
		parent::__construct();

		$this->bcrypt = new \Bcrypt(15);
		$this->db =& \miniMVC\db::get_instance();
		$this->session =& \miniMVC\Session::get_instance();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add a user for access
	 *
	 * @param string
	 * @param string
	 * @param string
	 */
	public function add_user($username, $pass1, $pass2)
	{
		
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Check and see if the login is valid
	 *
	 * @param string
	 * @param string
	 * @return bool
	 */
	public function check_login($username, $pass)
	{
		$query = $this->db->from('user')
			->where('username', $username)
			->get();

		$row = $query->fetch(\PDO::FETCH_ASSOC);

		// The user does not exist
		if (empty($row))
		{
			return FALSE;
		}

		return $this->bcrypt->verify($pass, $row['hash']);
	}

}

// End of user_model.php