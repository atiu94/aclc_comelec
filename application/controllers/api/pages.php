<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('page_model');
		$this->mythos->helper('output');
	}
	
	public function get_of_category($pct_id = 0)
	{
		$this->db->where('page.pct_id', $pct_id);
		$this->db->where('pag_status', 'published');
		$this->db->where('pag_date_published <=', format_mysql_datetime());
		$pages = $this->page_model->get_all_with_categories();
		
		$result = array();
		
		foreach($pages->result() as $page) 
		{
			$result[] = $page;
		}
		
		output_json($result);
	}
	
	public function get_by_slug($pag_slug)
	{
		$this->db->where('page.pag_slug', $pag_slug);
		$this->db->where('pag_status', 'published');
		$this->db->where('pag_date_published <=', format_mysql_datetime());
		$pages = $this->page_model->get_all_with_categories();
		
		$result = array();
		
		foreach($pages->result() as $page) 
		{
			$result = $page;
		}
		
		output_json($result);
	}
}