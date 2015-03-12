<?php
// Extend Base_model instead of CI_model
class Page_model extends Base_model 
{	
	public function __construct() 
	{
		// List all fields of the table.
		// Primary key must be auto-increment and must be listed here first.
		$fields = array(
			'pag_id',
			'pag_title',
			'pct_id',
			'pag_slug',
			'pag_content',
			'pag_date_created',
			'pag_date_published',
			'pag_type',
			'pag_status'
		);
		// Call the parent constructor with the table name and fields as parameters.
		parent::__construct('page', $fields);
	}
	
	// Inherits the create, update, delete, get_one, and get_all methods of base_model.
	
	public function get_by_slug($pag_slug)
	{
		$this->db->where('pag_slug', $pag_slug);
		$query = $this->db->get($this->table); // Use $this->table to get the table name
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	
	public function get_published($pag_slug)
	{
		$this->db->where('pag_slug', $pag_slug);
		$this->db->where('pag_status', 'published');
		$this->db->where('pag_date_published <=', format_mysql_datetime());
		$query = $this->db->get($this->table); // Use $this->table to get the table name
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	
	public function update_slug($pag_id, $pag_slug)
	{
		$page = $this->get_one($pag_id);
		if($page !== false)
		{
			$data = array();
			$data['pag_id'] = $pag_id;
			$data['pag_slug'] = $pag_slug;
			
			return $this->update($data);
		}
		else
		{
			return 0;
		}
	}
	
	public function get_all_with_categories($filter = array())
	{
		$this->db->from($this->table);
		$this->db->join('page_category', $this->table . '.pct_id = page_category.pct_id', 'left');
		$this->db->order_by('pct_name', 'asc');
		$this->db->order_by('pag_title', 'asc');
		$this->db->order_by('pag_date_published', 'asc');
		foreach($filter as $field => $value)
		{
			$this->db->where($field, $value);
		}
		return $this->db->get();
	}
	
	public function get_all_from_category($pct_name)
	{
		$this->db->from($this->table);
		$this->db->join('page_category', $this->table . '.pct_id = page_category.pct_id', 'left');
		$this->db->where('pct_name', $pct_name);
		$this->db->order_by('pct_name', 'asc');
		$this->db->order_by('pag_title', 'asc');
		$this->db->order_by('pag_date_published', 'asc');
		return $this->db->get();
	}
}
