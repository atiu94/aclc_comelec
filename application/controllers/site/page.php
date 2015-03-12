<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('page_model');
		$this->load->helper('format');
	}
	
	public function index($slug) 
	{
		$page_params = array();
		$page = $this->page_model->get_published($slug);
		if($page !== false)
		{
			$this->template->title($page->pag_title);
			
			// Use format_image_path() to convert all relative image paths to absolute paths
			$page->pag_content = format_url_path($page->pag_content);
			$page->pag_content = format_image_path($page->pag_content);
			
			$page_params['page'] = $page;
			$this->template->content('page-index', $page_params);
			
			$this->template->show('site');
		}
		else
		{
			show_404(site_url('page/index/' . $slug));
		}
	}
}
