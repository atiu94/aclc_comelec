<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MYTHOS_Template 
{
	private $CI;
	protected $template_params;
	
	public function __construct() 
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('template_helper');
	}
	
	// Sets the content of a template position
	public function set($position, $data, $append = true)
	{
		if(!isset($this->template_params[$position]) || $append === false)
		{
			$this->template_params[$position] = $data;
		}
		else
		{
			$this->template_params[$position] .= $data;
		}
	}
	
	// Gets the content of a template position
	public function get($position)
	{
		if(isset($this->template_params[$position]))
		{
			return $this->template_params[$position];
		}
		else
		{
			return '';
		}
	}
	
	// Sets the title of the page
	public function title($title = '')
	{
		$this->template_params['title'] = $title;
	}
	
	// Sets the content of the page
	public function content($view, $params = array(), $template_folder = null, $position = 'content') 
	{
		$this->template_params[$position] = $this->get_view($view, $params, $template_folder);
	}

	// Displays the page using the parameters preset using the set methods of this class
	public function show($template_folder = null, $template_view = 'template', $return_string = false)
	{	
		/*
		Pass parameters to template's view.
		
		Deprecated: Use template('content') function instead of echo @$template['content']
		when displaying parameters of template.
		*/
		$render_params = array();		
		$render_params['template'] = $this->template_params;
		
		if($template_folder == '')
		{
			$template_folder = get_module();
		}

		$complete_page = $this->get_view($template_view, $render_params, $template_folder, $return_string);
		
		if($return_string == true)
		{
			return $complete_page;
		}
		else
		{
			echo $complete_page;
		}
	}
	
	// Returns the content of the view
	public function get_view($view, $params = array(), $template_folder = null, $return_string = true)
	{
		if($template_folder == null)
		{
			$template_folder = get_module();
		}		
		
		$view_path ="{$template_folder}/{$view}";
		if($view == 'template')
		{
			$uri_segment2 = str_replace('/', '', $this->CI->uri->segment(2));
			$uri_segment3 = str_replace('/', '', $this->CI->uri->segment(3));
			
			if($uri_segment2 == '' && $this->CI->uri->segment(1) != '')
			{
				if($this->CI->uri->segment(1) != $template_folder){
					$uri_segment2 = $this->CI->uri->segment(1);
					$uri_segment3 = 'index';
				}
				else {
					$uri_segment2 = 'index';
					$uri_segment3 = 'index';
				}
			}
			elseif($this->CI->uri->segment(1) == '')
			{
				$uri_segment2 = 'index';
				$uri_segment3 = 'index';
			}
			elseif($uri_segment2 != '' && $this->CI->uri->segment(1) != '' && $uri_segment3 == "")
			{
				$uri_segment3 = $uri_segment2;
				$uri_segment2 = $this->CI->uri->segment(1);
				
			}
			
			$uri_segment2 = str_replace("-", "_", $uri_segment2);
			$uri_segment3 = str_replace("-", "_", $uri_segment3);
			
			$template_path = APPPATH . "views/{$template_folder}/templates/";
			if($uri_segment2 != '' && $uri_segment3 != '' && is_file($template_path . $uri_segment2 . '/' . $uri_segment3 . '.php'))
			{
				$view_path = "{$template_folder}/templates/" . $uri_segment2 . '/' . $uri_segment3;
			}
			elseif($uri_segment2 != '' && is_file($template_path . $uri_segment2 . '/template.php'))
			{
				$view_path = "{$template_folder}/templates/" . $uri_segment2 . '/template';
			}
			elseif(is_file($template_path . 'template.php'))
			{
				$view_path = "{$template_folder}/templates/template";
			}
			else
			{
				// Do not override the view path
			}
		}
		else 
		{
			$dash_pos = strpos($view, '-');
			if($dash_pos !== false)
			{
				$uri = explode('-', $view, 2);
				$view_path = "{$template_folder}/{$uri[0]}/{$uri[1]}";
			}
		}
		return $this->CI->load->view($view_path, $params, $return_string);
	}

	// Displays the page using the parameters ($params) passed to the method
	public function render($params = array(), $template_folder = null, $template_view = 'template')
	{
		if($template_folder == '')
		{
			$template_folder = get_module();
		}

		$this->template_params = $params;
		$this->show($template_folder, $template_view);
	}
}
