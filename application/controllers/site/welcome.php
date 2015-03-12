<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('page_model');
		$this->load->helper('format');
	}
	
	public function index()
	{	
		$this->template->title('Welcome!');
		$this->template->content('welcome-index');
		$this->template->show();

		
	}
}
