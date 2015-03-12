<?php
// Extend Base_model instead of CI_model
class Candidate_model extends Base_model
{
	public function __construct()
	{
		// List all fields of the table.
		// Primary key must be auto-increment and must be listed here first.
		$fields = array('can_id', 'can_first_name', 'can_middle_name', 'can_last_name', 'can_votes', 'can_quota');
		// Call the parent constructor with the table name and fields as parameters.
		parent::__construct('candidate', $fields);
	}

	// Inherits the create, update, delete, get_one, and get_all methods of base_model.



}