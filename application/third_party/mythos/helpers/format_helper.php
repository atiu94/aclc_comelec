<?php
/*
Parses a string and converts it into an SEO friendly page name.
Replaces all spaces with dashes(-), lowers all cases, and 
strips all special characters except dashes(-) and underscores(_).
*/
function format_html_slug($string)
{
	$CI =& get_instance();
	$config = $CI->config->item('format_helper', 'mythos');
	return strtolower(substr(preg_replace('/[^a-zA-Z0-9_-]/s', "", str_replace(' ', '-', $string)), 0, $config['html_slug_length']));
}

/*
Replaces relative paths of images to absolute paths
*/
function format_image_path($string)
{
	$CI =& get_instance();
	$CI->load->helper('url');
	return str_replace('src="../../../uploads/images/pages/', 'src="' . base_url('uploads/images/pages') . '/', $string);
}

/*
Replaces {SITE_URL} tags to actual site_url() value
*/
function format_url_path($string)
{
	$CI =& get_instance();
	$CI->load->helper('url');
	return str_replace('{SITE_URL}', site_url(), $string);
}