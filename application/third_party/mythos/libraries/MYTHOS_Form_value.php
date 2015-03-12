<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MYTHOS_Form_value {

	private $CI;
	private $js_code;
	
	public function __construct() 
	{
		$this->CI =& get_instance();
		$js_code = '';
	}
	
	public function load($values)
	{
		foreach($values as $name => $value)
		{
		
		}
		
		$this->js_code .= <<<EOT
		$('input[type="password"][name="{$name}"]').val('{$value}');
EOT;
	}

}
