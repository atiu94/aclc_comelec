<?php
/* 
Echoes the content of the template parameter based on the specified position.
Prints blank ("") if template parameter has no content.
*/
function template($position)
{
	$CI =& get_instance();
	return $CI->template->get($position);
}

function template_header($template_folder)
{
	$CI =& get_instance();
	return $CI->template->show($template_folder, 'template-header');
}

function template_footer($template_folder)
{
	$CI =& get_instance();
	return $CI->template->show($template_folder, 'template-footer');
}

/*
Shorthand function for the base URL of resources folder.
*/
function res_url($path = '')
{
	$CI =& get_instance();
	$CI->load->helper('url');
	
	if(!empty($path))
	{
		return base_url('resources/' . ltrim($path, '/'));
	}
	else
	{
		return base_url('resources') . '/';
	}
}

/*
DEPRECATED: Old res_url() function
*/
function resources_url($path = '')
{
	return res_url($path);
}

function uri_css_class()
{
	$CI =& get_instance();
	$s2 = $CI->uri->segment(2);
	$s3 = $CI->uri->segment(3, 'index');
	return 'page-' . $s2 . ' page-' . $s2 . '-' . $s3;
}

function get_module()
{
	$RTR =& load_class('Router', 'core');
	return trim($RTR->fetch_directory(), '/');
}
