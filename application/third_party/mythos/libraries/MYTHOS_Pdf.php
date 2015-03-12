<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MYTHOS_Pdf
{
	
	private $CI;
	
	public function __construct() 
	{
		$this->CI =& get_instance();
	}
	
	public function generate($params = array(), $template_folder = 'pdf', $template_view = 'template')
	{
		$path_of_generated_file ="somepath";
		return $path_of_generated_file;
	}
}
