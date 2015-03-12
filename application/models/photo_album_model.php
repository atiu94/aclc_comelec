<?php
// Extend Base_model instead of CI_model
class Photo_album_model extends Base_model 
{	
	public function __construct() 
	{
		// List all fields of the table.
		// Primary key must be auto-increment and must be listed here first.
		$fields = array(
			'alb_id',
			'alb_name',
			'alb_description',
			'alb_slug'
		);
		// Call the parent constructor with the table name and fields as parameters.
		parent::__construct('photo_album', $fields);
	}
	
	public function get_all($params = array())
	{
		$this->db->order_by('alb_id', 'desc');
		return parent::get_all($params);
	}
	
	public function get_by_slug($alb_slug)
	{
		$this->db->where('alb_slug', $alb_slug);
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	
	public function update_slug($alb_id, $alb_slug)
	{
		$album = $this->get_one($alb_id);
		if($album !== false)
		{
			$data = array();
			$data['alb_id'] = $alb_id;
			$data['alb_slug'] = $alb_slug;
			
			return $this->update($data);
		}
		else
		{
			return 0;
		}
	}
}