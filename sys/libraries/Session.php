<?php
/**
 * MiniMVC
 *
 * Convention-based micro-framework for PHP
 *
 * @package		miniMVC
 * @author 		Timothy J. Warren
 * @copyright	Copyright (c) 2011 - 2012
 * @link 		https://github.com/aviat4ion/miniMVC
 * @license 	http://philsturgeon.co.uk/code/dbad-license
 */

// --------------------------------------------------------------------------

namespace miniMVC;

/**
 * Class to improve handling of PHP sessions
 *
 * @package miniMVC
 * @subpackage Libraries
 */
class Session {

	/**
	 * Reference to session superglobal
	 *
	 * @var array
	 */
	protected $sess = array();

	/**
	 * Reference to current instance
	 *
	 * @var Session
	 */
	protected static $instance;

	/**
	 * Start a session
	 */
	protected function __construct()
	{
		session_start();

		// Save a reference to the session for later access
		$_SESSION['MM_SESSION'] = (isset($_SESSION['MM_SESSION'])) ?: array();
		$this->sess =& $_SESSION['MM_SESSION'];
	}

	// --------------------------------------------------------------------------

	/**
	 * Set a session value
	 *
	 * @param string $key
	 * @param mixed $val
	 * @return void
	 */
	public function __set($key, $val)
	{
		$this->sess[$key] = $val;
	}

	// --------------------------------------------------------------------------

	/**
	 * Retreive a session value
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->sess[$key];
	}

	// --------------------------------------------------------------------------

	/**
	 * Destroy a session
	 *
	 * @return void
	 */
	public function destroy()
	{
		sess_destroy();
	}

	// --------------------------------------------------------------------------

	/**
	 * Singleton getter function
	 *
	 * @return self
	 */
	public static function &get_instance()
	{
		if ( ! isset(self::$instance))
		{
			$class = __CLASS__;

			self::$instance = new $class;
		}

		return self::$instance;
	}

	// --------------------------------------------------------------------------

	/**
	 * Magic function called when cloning an object
	 */
	public function __clone()
	{
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}
}

// End of session.php