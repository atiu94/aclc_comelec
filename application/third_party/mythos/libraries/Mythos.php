<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mythos {

	private $CI;
	const SUBCLASS_PREFIX = 'MYTHOS_';	
	
	public function __construct() 
	{
		$this->CI =& get_instance();
		$this->CI->load->library('config');
		
		define('MYTHOS_VERSION', '4.0.12');
		define('MYTHOS_VERSION_NAME', 'Doppelganger');
		
		$this->CI->config->load('mythos', true);
		
		$timezone = $this->CI->config->item('timezone', 'mythos');
		if(!empty($timezone))
		{			
			date_default_timezone_set($timezone);
		}
		
		$this->autoload('libraries', 'library');
		$this->autoload('helper');
		$this->autoload('config');
		$this->autoload('language');
		$this->autoload('model');
	}
	
	private function autoload($config, $type = null)
	{
		if($type == null)
		{
			$type = $config;
		}
		
		$autoload = $this->CI->config->item('autoload', 'mythos');
		$files = $autoload[$config];
		
		if(is_array($files))
		{
			foreach($files as $file)
			{
				$this->$type($file);
			}
		}
	}
	
	public function library($lib_name)
	{
		$file = Mythos::SUBCLASS_PREFIX . ucfirst(strtolower($lib_name));
		if(substr($file, 0, strlen(Mythos::SUBCLASS_PREFIX)) == Mythos::SUBCLASS_PREFIX)
		{
			$library_var = substr($file, strlen(Mythos::SUBCLASS_PREFIX));					
		}
		else
		{
			$library_var = $file;
		}
		$library_var = strtolower($library_var);
		
		$this->CI->load->library($file, '', $library_var);
	}
		
	public function helper($file)
	{
		$this->CI->load->helper($file);
	}
	
	public function config($file)
	{
		$this->CI->load->config($file);
	}
	
	public function language($file)
	{
		$this->CI->load->language($file);
	}
	
	public function model($file)
	{
		$this->CI->load->model($file);
	}

}
