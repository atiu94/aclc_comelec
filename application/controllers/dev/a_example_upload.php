<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class A_example_upload extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('page_model');
		$this->load->helper('format');
		$this->mythos->library('upload'); //use this line to load the mythos library make sure you do NOT use $this->load->library('upload');
	}
	
	public function index() 
	{
		$template = array();
		$template['title'] = "Example Upload";
		
		$data ="";
		$template['content'] =  $this->template->get_view('example_upload_form', $data, 'example');
		
		$this->template->render($template, 'admin');
	}
	
	public function do_upload()
	{	
		$data = $this->upload->do_upload_resize("sample_file",300,300,'./uploads/');
		/*
		parameters: name of upload field, max width of thumb, max height of thumb, upload path
		
		$data contains the error data if the upload fails. if not, it contains the file info. file name + _thumb for the thumbnail. right now, it all dumps everything in the upload folder.
		
		note: make sure the folder where the upload will go to exists. if it does not it will fail with the error path does not appear valid. still to-do: auto create the folder.
		*/
		
		if(isset($data['error']))
		{
			$template['title'] = "Upload Failure";
			$template['content'] =  $this->template->get_view('example_upload_form', $data, 'example');
			$this->template->render($template, 'admin');
		}
		else
		{
			$template['title'] = "Upload Success";
			$template['content'] =  $this->template->get_view('example_upload_success', $data, 'example');
			$this->template->render($template, 'admin');
		}
	}
}
