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
 * Section Controller
 *
 * @package meta
 */
class section extends \miniMVC\Controller {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default controller method
	 */
	public function detail($id=0)
	{
		if ($id === 0)
		{
			$id = (int) miniMVC\get_last_segment();
		}

		$data = array(
			'section' => $this->data_model->get_section_by_id($id),
			'sdata' => $this->data_model->get_data($id),
			'p' => $this->data_model->get_path_by_section($id),
			'section_id' => $id
		);

		if (empty($data['section']))
		{
			$this->page->render_message('error', "Section doesn't exist.");
			return;
		}

		$this->render('section_detail', $data);
	}

	/**
	 * Adds a data item to the current section
	 */
	public function add_data()
	{
		$section_id = (int) $_POST['section_id'];


		$keys = filter_var_array($_POST['name'], FILTER_SANITIZE_STRING);

        // Raw to allow use of HTML formatting
        // Prepared statements keep the database safe here.
		$vals = $_POST['val'];


		$data = array_combine($keys, $vals);

		$res = $this->data_model->add_data($section_id, $data);


		($res)
			? $this->page->set_message('success', 'Added data')
			: $this->page->set_message('error', 'Data already exists');

		$this->detail($section_id);
	}
}

// End of section.php