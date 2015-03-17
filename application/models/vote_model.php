<?php
// Extend Base_model instead of CI_model
class Vote_model extends Base_model
{
	public function __construct()
	{
		// List all fields of the table.
		// Primary key must be auto-increment and must be listed here first.
		$fields = array('vot_id', 'vot_can');
		// Call the parent constructor with the table name and fields as parameters.
		parent::__construct('vote', $fields);
	}

	// Inherits the create, update, delete, get_one, and get_all methods of base_model.



}