<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class A_example_pdf extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
	}
	
	public function index() 
	{
		//data to be passed to the PDF
		
		$pdf_data = array();
		$pdf_data["first_name"] ="First Name";
		$pdf_data["last_name"] ="Last Name";
		
		//html view to be placed inside the PDF
		
		$template['content'] = $this->template->get_view('welcome', $pdf_data, 'email');		
		
		//generate the PDF and return the path of the created file
		echo $this->pdf->generate($template);
	}
}
