<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Template extends MYTHOS_Template
{
	private $CI;
	
	public function __construct() 
	{
		$this->CI =& get_instance();
		parent::__construct();
	}

	// Displays the page using the parameters preset using the set methods of this class
	public function show($template_folder = null, $template_view = 'template', $return_string = false)
	{
		$validator = $this->CI->form_validation->jquery_validator();
		if($validator !== false)
		{
			$this->set('head', $validator);
		}
		
		$this->set('mythos', $this->mythos());
		$this->set('bootstrap', $this->bootstrap());
		$this->set('notification', $this->render_notification());
		
		return parent::show($template_folder, $template_view, $return_string);
	}
	
	/*
	Notification types: warning (yellow), error (red), success (green), and info (blue)
	*/
	public function notification($message, $type = 'info')
	{
		$this->CI->session->set_userdata('notification', $message);
		$this->CI->session->set_userdata('notification_type', $type);
	}
	
	private function render_notification()
	{
		$message = $this->CI->session->userdata('notification');
		$type = $this->CI->session->userdata('notification_type');
		
		$this->CI->session->unset_userdata('notification');
		$this->CI->session->unset_userdata('notification_type');
		
		if($message !== false) 
		{
			return <<<EOT
			<div class="alert alert-{$type} fade in">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<div class="center">{$message}</div>
			</div>
EOT;
		}
		else
		{
			return '';
		}
	}
	
	private function mythos()
	{
		$base_url = base_url();
		$site_url = site_url();
		$resources_url = res_url();
		$mythosHead = <<<EOT
		<link rel="stylesheet" type="text/css" href="{$base_url}resources/mythos/css/jquery-ui-1.8.16.custom.css" />
		<link rel="stylesheet" type="text/css" href="{$base_url}resources/mythos/css/jquery-ui-extended.css" />
		<script type="text/javascript"> var BASE_URL = "{$base_url}"; var SITE_URL = "{$site_url}"; var RESOURCES_URL = "{$resources_url}"; </script>
		<script type="text/javascript" src="{$base_url}resources/mythos/js/jquery.min.js"></script>
		<script type="text/javascript" src="{$base_url}resources/mythos/js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="{$base_url}resources/mythos/js/jquery.validate.complete.min.js"></script>
		<script type="text/javascript" src="{$base_url}resources/mythos/js/jquery.floodling.min.js"></script>
		<script type="text/javascript" src="{$base_url}resources/mythos/js/utils.js"></script>
EOT;

		$this->CI->load->library('config');
		$csrfJS = '';
		if($this->CI->config->config['csrf_protection'])
		{
			$csrf_token_name = $this->CI->security->get_csrf_token_name();
			$csrf_hash = $this->CI->security->get_csrf_hash();
			$mythosHead .= "<script type=\"text/javascript\">eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\\b'+e(c)+'\\\b','g'),k[c]);return p}('\$(1(){\$(\'9\').b(1(i){6 a=\$(c);7(a.8(\'3[4=\"2\"]\').5()==0){a.d(1(){a.e(\'<3 f=\"g\" 4=\"2\" h=\"j\" />\')})}})});',20,20,'|function|{$csrf_token_name}|input|name|size|var|if|find|form||each|this|submit|append|type|hidden|value||{$csrf_hash}'.split('|'),0,{}))</script>";
			
			/* SOURCE CODE
			1. Compress code using http://javascriptcompressor.com/ (Base 62, shrink variables)
			2. Replace all " with \"
			3. Replace all $ with \$
			4. Replace all \\ with \\\
			
			$(function() {	
				$('form').each(function(i) {
					var form_elem =  $(this);
					if(form_elem.find('input[name="{$csrf_token_name}"]').size() == 0) {
						form_elem.submit(function() {
							form_elem.append('<input type="hidden" name="{$csrf_token_name}" value="{$csrf_hash}" />');
						});
					}
				});
			});
			*/			
		}
		
		return $mythosHead;
	}
	
	private function bootstrap()
	{
		$resources_url = res_url();
		return <<<EOT
		<link rel="stylesheet" type="text/css" href="{$resources_url}mythos/bootstrap/css/bootstrap.css" />
		<script type="text/javascript" src="{$resources_url}mythos/bootstrap/js/bootstrap.js"></script>
EOT;
	}
	
	public function autofill($data = array(), $form_selector = 'form')
	{
		if(count($data) > 0)
		{
			$jsFill = '';
			foreach($data as $key => $value)
			{
				$value = addslashes($value);
				$jsFill .= "$('{$form_selector}').floodling('{$key}', \"{$value}\");";
			}
			$this->set('head', "<script type=\"text/javascript\">$(function() { {$jsFill} });</script>");
		}
	}
}
