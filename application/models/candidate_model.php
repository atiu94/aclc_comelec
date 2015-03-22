<?php
// Extend Base_model instead of CI_model
class Candidate_model extends Base_model
{
	public function __construct()
	{
		// List all fields of the table.
		// Primary key must be auto-increment and must be listed here first.
		$fields = array('can_id', 'can_first_name', 'can_last_name', 'can_votes', 'can_quota', 'can_called', 'can_win');
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


	public function get_all_alphabetical($params = array())
	{
		if(is_array($params))
		{
			foreach($params as $key=> $value)
			{
				$this->db->where($key, $value);
			}
		}

		$this->db->order_by("can_last_name");
		//$this->db->order_by("har_date_added","desc");

		return $this->db->get($this->table);
	}

	public function get_all_alphabetical_lose($params = array())
	{
		if(is_array($params))
		{
			foreach($params as $key=> $value)
			{
				$this->db->where($key, $value);
			}
		}

		$this->db->where('can_win', false);	
		$this->db->order_by("can_last_name");
		//$this->db->order_by("har_date_added","desc");

		return $this->db->get($this->table);
	}

	public function get_all_alphabetical_called($params = array())
	{
		if(is_array($params))
		{
			foreach($params as $key=> $value)
			{
				$this->db->where($key, $value);
			}
		}
		$this->db->where('can_called', true);	
		$this->db->order_by("can_last_name");
		//$this->db->order_by("har_date_added","desc");

		return $this->db->get($this->table);
	}

	public function get_all_ids($params = array())
	{
		$this->db->select('can_id', FALSE);	
		if(is_array($params))
		{
			foreach($params as $key=> $value)
			{
				$this->db->where($key, $value);
			}
		}
		return $this->db->get($this->table);
	}


	public function delete_votes($vot_can)
	{
		$this->db->join('vote', "vote.vot_can = {$this->table}.can_id", "left");
		$this->db->where('vot_can', $vot_can);			
		$this->db->order_by("vot_can","desc");
		$this->db->delete('vote'); // 
	}





}