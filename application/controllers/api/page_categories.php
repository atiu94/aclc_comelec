<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_categories extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('page_category_model');
		$this->mythos->helper('output');
	}
	
	public function get_all()
	{
		$page_categories = $this->page_category_model->get_all();
		$result = array();
		
		foreach($page_categories->result() as $page_category) 
		{
			$result[] = $page_category;
		}
		
		output_json($result);
	}
}