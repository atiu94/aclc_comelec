<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Base_model extends CI_Model 
{
	protected $table;
	protected $fields;
	
	public function __construct($table = '', $fields = array()) 
	{
		$this->table = $table;
		$this->fields = $fields;
		
		parent::__construct();
		
		$this->load->library('MYTHOS_Pagination', '', 'pagination');
	}
	
	// Returns the name of the table associated to the Base_model.
	public function get_table()
	{
		return $this->table;
	}
	
	// Returns an array of the fields of the Base_model's table.
	public function get_fields()
	{
		return $this->fields;
	}
	
	protected function filter_data($data, $field_list)
	{
		foreach($data as $key => $value)
		{
			if(!in_array($key, $field_list))
			{
				unset($data[$key]);
			}
		}
		
		return $data;
	}
	
	// Inserts a row in the Base_model's table
	public function create($data, $field_list = array())
	{
		if(!is_array($data))
		{
			$data = get_object_vars($data);
		}
		
		if(count($field_list) > 0)
		{
			$data = $this->filter_data($data, $field_list);
		}
		
		$valid_data = array();
		$i = 0;
		foreach($this->fields as $field)
		{
			if($i > 0) // Skip primary key from the list of fields
			{
				if(isset($data[$field]))
				{
					$valid_data[$field] = $data[$field];
				}
			}
			$i++;
		}
		$this->db->insert($this->table, $valid_data);
		return $this->db->insert_id();
	}
	
	// Updates a row in the Base_model's table using the primary key as filter.
	public function update($data, $field_list = array())
	{
		if(!is_array($data))
		{
			$data = get_object_vars($data);
		}
		
		if(count($field_list) > 0)
		{
			$id = $data[$this->fields[0]];
			$data = $this->filter_data($data, $field_list);
			$data[$this->fields[0]] = $id;
		}
		
		$valid_data = array();
		$i = 0;
		foreach($this->fields as $field)
		{
			if($i > 0)
			{
				if(isset($data[$field]))
				{
					$valid_data[$field] = $data[$field];
				}
			}
			else
			{
				$this->db->where($field, $data[$field]);
			}
			$i++;
		}
		$this->db->update($this->table, $valid_data);
		return $this->db->affected_rows();
	}
	
	// Deletes a row in the Base_model's table using the primary key as filter.
	public function delete($id)
	{
		$this->db->where($this->fields[0], $id);
		$this->db->delete($this->table); 
		return $this->db->affected_rows();
	}
	
	// Retrieves a row from the Base_model's table using the primary key as filter.
	public function get_one($id)
	{
		$this->db->where($this->fields[0], $id);
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
	
	/* 
	Returns a result set from the Base_model's table.
	Optional parameter is an associative array to filter the result set.
		Example:
			$params = array(
				'page_category_id' => 1,
				'status' => 'published'
			);
			
			Returns all rows with page_category_id "1" AND status "published"
	*/
	public function get_all($params = array())
	{
		if(is_array($params))
		{
			foreach($params as $key=> $value)
			{
				$this->db->where($key, $value);
			}
		}
		return $this->db->get($this->table);
	}
	
	public function pagination()
	{
		$parameters = func_get_args();
		$page_uri = array_shift($parameters);
		$function = array_shift($parameters);
		
		$this->pagination->set_function($this->table . '_model', $function, $parameters);
		return $this->pagination->run_query($page_uri);
	}
	
	public function pagination_links()
	{
		return $this->pagination->query_links();
	}
	
	public function join($join_table, $join_type)
	{
		$this->db->join($join_table, $join_table . '.' . $this->fields[0] . ' = ' . $this->table . '.' . $this->fields[0], $join_type);
		return $this->db->get($this->table);
	}
}
