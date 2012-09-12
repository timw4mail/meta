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
 * Default Controller class
 *
 * @package meta
 */
class welcome extends \meta\controller {

	/**
	 * Initialize the constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	// --------------------------------------------------------------------------

	/**
	 * Default route for the controller
	 *
	 * @return void
	 */
	public function index()
	{
		$data = array();
		$data['genres'] = $this->data_model->get_genres();

		$this->load_view('genres', $data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Authenticate a user
	 */
	public function login()
	{
		$this->load_view('login');
	}

	// --------------------------------------------------------------------------

	/**
	 * Logout
	 */
	public function logout()
	{

	}

	// --------------------------------------------------------------------------

	/**
	 * Display an outline of the data for a table of contents
	 */
	public function outline()
	{
		$outline_data = $this->data_model->get_outline_data();
		$this->load_view('outline', array('outline' => $outline_data));
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

		switch($type)
		{
			case "genre":
			case "category":
			case "section":
			case "data":
				$res = (int) $this->data_model->delete($type, (int) $_POST['id']);
			break;

			default:
				$res = 0;
			break;
		}
		die(trim($res));
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

	public function update_item()
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
			
			exit(trim($res));
		}
		
		exit(0);
	}
}

// End of welcome.php