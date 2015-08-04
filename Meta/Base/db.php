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

namespace Meta\Base;

/**
 * Extend PHP's PDO class to add some more functionality
 *
 */
class db extends \Query\Query_Builder {

	/**
	 * DB connection instances
	 *
	 * @var array
	 */
	private static $instance = array();

	// --------------------------------------------------------------------------

	/**
	 * Indexed singleton method
	 *
	 * @param string $dbname
	 * @param array $options
	 * @return DB
	 */
	public static function &get_instance($dbname="default", array $options=array())
	{
		if ( ! isset(self::$instance[$dbname]))
		{
			// Include the database config file
			require_once(MM_APP_PATH.'config/db.php');

			// Get the correct database in the config file
			if ( ! is_like_array($db_conf[$dbname]))
			{
				// Apparently the database doesn't exist
				$this->get_last_error();
				trigger_error("Database does not exist", E_USER_ERROR);
				die();
			}

			//echo 'Creating new instance of db class.';
			self::$instance[$dbname] = Query($db_conf[$dbname]);
		}

		return self::$instance[$dbname];
	}

	// --------------------------------------------------------------------------

	/**
	 * Returns the last error from the database
	 *
	 * @return string
	 */
	public function get_last_error()
	{
		$error = array();

		if (isset($this->statement))
		{
			$error = $this->statement->errorInfo();
		}
		else
		{
			$error = $this->errorInfo();
		}

		list($code, $driver_code, $message) = $error;

		// Contain the content for buffering
		ob_start();

		include(MM_APP_PATH.'/views/errors/error_db.php');

		$buffer = ob_get_contents();
		ob_end_clean();
		echo $buffer;
	}
}

// End of db.php