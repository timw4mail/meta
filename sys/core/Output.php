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
 * Class for displaying output and setting http headers
 *
 * @package miniMVC
 * @subpackage System
 */
class Output extends MM {

	/**
	 * Content for outputting
	 *
	 * @var string
	 */
	private $buffer;

	/**
	 * HTTP headers to send
	 *
	 * @var array
	 */
	private $headers;

	/**
	 * Initialize the output class
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->buffer = "";
		$this->headers = array();
	}

	// --------------------------------------------------------------------------

	/**
	 * PHP magic method called when ending the script
	 * Used for outputing HTML
	 *
	 * @return void
	 */
	public function __destruct()
	{
		if ( ! empty($this->headers))
		{
			// Set headers
			foreach($this->headers as $key => $val)
			{
				if ( ! isset($val))
				{
					@header($key);
				}
				else
				{
					@header("$key: $val");
				}
			}
		}

		if ( ! empty($this->buffer))
		{
			if (is_null(error_get_last()))
			{
				// Compression is good!
				ob_start("ob_gzhandler");
			}
			else
			{
				ob_start();
			}

			echo $this->buffer;
			ob_end_flush();
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Sets a header for later output
	 *
	 * @param string $key
	 * @param string $val
	 */
	public function set_header($key, $val)
	{
		$this->headers[$key] = $val;
	}

	// --------------------------------------------------------------------------

	/**
	 * Adds text to the output buffer
	 *
	 * @param string $string
	 */
	public function append_output($string)
	{
		$this->buffer .= $string;
	}

	// --------------------------------------------------------------------------

	/**
	 * Sets the output buffer
	 *
	 * @param string $string
	 */
	public function set_output($string)
	{
		$this->buffer = $string;
	}

	// --------------------------------------------------------------------------

	/**
	 * Sends headers and then removes them
	 */
	public function flush_headers()
	{
		// Set headers
		foreach ($this->headers as $key => &$val)
		{
			if ( ! isset($val))
			{
				@header($key);
			}
			else
			{
				@header("{$key}: {$val}");
			}
		}

		// Empty headers
		$this->headers = array();
	}
}

// End of Output.php