<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Access_control extends MYTHOS_Access_control
{
	private $CI;
	
	public function __construct() 
	{
		$this->CI =& get_instance();
		parent::__construct();
	}

	public function validate($type = '')
	{
		$type = trim($type, '/');
		if($type == '')
		{
			$this->CI->mythos->helper('template_helper');
			$type = get_module();
			if($type == 'site')
			{
				$type = '';
			}
		}

		$result = parent::validate();
		
		if($result == 'login')
		{
			$this->CI->session->set_flashdata('current_url', current_url());
			$this->CI->template->notification('Please login first.');
			redirect($type . '/login');
		}
		elseif($result == 'forbidden')
		{
			redirect($type . '/forbidden');
		}
	}
}
