<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MYTHOS_Extract 
{

	private $CI;
	
	public function __construct() 
	{
		$this->CI =& get_instance();
	}

	/*
	Gets all $_POST values and places them in an associative array.
	*/
	public function post($xss_filtering = true)
	{
		$result = array();
		foreach($_POST as $key => $value)
		{
			$result[$key] = $this->CI->input->post($key, $xss_filtering);
		}
		return $result;
	}

	/*
	Gets all $_GET values and places them in an associative array.
	*/
	public function get($xss_filtering = true)
	{
		$result = array();
		foreach($_GET as $key => $value)
		{
			$result[$key] = $this->CI->input->get($key,$xss_filtering);
		}
		return $result;
	}

}
