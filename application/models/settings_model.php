<?php
// Extend Base_model instead of CI_model
class Settings_model extends Base_model
{
	public function __construct()
	{
		// List all fields of the table.
		// Primary key must be auto-increment and must be listed here first.
		$fields = array('set_id', 'set_count');
		// Call the parent constructor with the table name and fields as parameters.
		parent::__construct('settings', $fields);
	}

	public function get_popn()
	{
		$this->db->select('set_count');
		$this->db->where('set_id', 1);
		$query = $this->db->get($this->table);
		return $query->row();
	}

	

}