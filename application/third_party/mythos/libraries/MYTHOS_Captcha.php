<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(FCPATH . 'resources/mythos/securimage/securimage.php');

class MYTHOS_Captcha extends Securimage 
{
	private $CI;
	
	public function __construct() 
	{
		parent::__construct();
		$this->CI =& get_instance();
	}
}