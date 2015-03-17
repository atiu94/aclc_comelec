<?php
// Extend Base_model instead of CI_model
class Candidate_model extends Base_model
{
	public function __construct()
	{
		// List all fields of the table.
		// Primary key must be auto-increment and must be listed here first.
		$fields = array('can_id', 'can_first_name', 'can_last_name', 'can_votes', 'can_quota', 'can_called');
		// Call the parent constructor with the table name and fields as parameters.
		parent::__construct('candidate', $fields);
	}

	// Inherits the create, update, delete, get_one, and get_all methods of base_model.


	public function count_votes($vot_can)
	{
		$this->db->join('vote', "vote.vot_can = {$this->table}.can_id", "left");
		$this->db->where('vot_can', $vot_can);			
		$this->db->order_by("vot_can","desc");
		$query = $this->db->get($this->table); // 
		$rowcount = $query->num_rows();
		return $rowcount;

	}





}