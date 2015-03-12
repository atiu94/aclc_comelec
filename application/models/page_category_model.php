<?php
// Extend Base_model instead of CI_model
class Page_category_model extends Base_model 
{	
	const UNCATEGORIZED = 'Uncategorized';

	public function __construct() 
	{
		// List all fields of the table.
		// Primary key must be auto-increment and must be listed here first.
		$fields = array(
			'pct_id',
			'pct_name'
		);
		// Call the parent constructor with the table name and fields as parameters.
		parent::__construct('page_category', $fields);
	}
	
	// Inherits the create, update, delete, get_one, and get_all methods of base_model.
	public function delete($id)
	{
		parent::delete($id);
		
		$data = array();
		$data['pct_id'] = 0;
		$this->db->where('pct_id', $id);
		$this->db->update('page', $data);
	}
}
