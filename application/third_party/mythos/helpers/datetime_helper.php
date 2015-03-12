<?php
/*
Converts any string to a MySQL date format.
If no string is passed, it will return the current date.
*/
function format_mysql_date($date = null, $timezone = 'UTC')
{
	$date = strtotime($date);
	if($date != null)
	{
		$timestamp = $date;
	}
	else
	{
		$timestamp = mktime();
	}
	$current_tz = date_default_timezone_get();
	date_default_timezone_set($timezone);
	$output = date('Y-m-d', $timestamp);
	date_default_timezone_set($current_tz);
	return $output;
}

/*
Converts any string to a MySQL time format.
If no string is passed, it will return the current time.
*/
function format_mysql_time($time = null, $timezone = 'UTC')
{
	$time = strtotime($time);
	if($time != null)
	{
		$timestamp = $time;
	}
	else
	{
		$timestamp = mktime();
	}
	$current_tz = date_default_timezone_get();
	date_default_timezone_set($timezone);
	$output = date('H:i:s', $timestamp);
	date_default_timezone_set($current_tz);
	return $output;
}

/*
Converts any string to a MySQL datetime format.
If no string is passed, it will return the current date.
*/
function format_mysql_datetime($datetime = null, $timezone = 'UTC')
{
	$datetime =strtotime($datetime);
	if($datetime != null)
	{
		$timestamp = $datetime;
	}
	else
	{
		$timestamp = mktime();
	}
	$current_tz = date_default_timezone_get();
	date_default_timezone_set($timezone);
	$output = date('Y-m-d H:i:s', $timestamp);
	date_default_timezone_set($current_tz);
	return $output;
}

/*
Converts any string to a custom date format, often used for front-end display.
*/
function format_date($date = 'now', $format = '', $timezone = '')
{
	$date = strtotime($date);
	if($date != "") {
		if($format == '')
		{
			$CI =& get_instance();
			$config = $CI->config->item('format_helper', 'mythos');
			$format = $config['date'];
		}
		
		$current_tz = date_default_timezone_get();
		if($timezone == '')
		{
			$timezone = $current_tz;
		}
		date_default_timezone_set($timezone);
		$output = date($format, $date);
		date_default_timezone_set($current_tz);
		return $output;
	}
	else
	{
		return "n/a";
	}
}

/*
Converts any string to a custom time format, often used for front-end display.
*/
function format_time($time = 'now', $format = '', $timezone = '')
{
	$time = strtotime($time);
	if ($time != "") {
		if($format == '')
		{
			$CI =& get_instance();
			$config = $CI->config->item('format_helper', 'mythos');
			$format = $config['time'];
		}
		
		$current_tz = date_default_timezone_get();
		if($timezone == '')
		{
			$timezone = $current_tz;
		}
		date_default_timezone_set($timezone);
		$output = date($format, $time);
		date_default_timezone_set($current_tz);
		return $output;
	}
	else 
	{
		return "n/a";
	}
}

/*
Converts any string to a custom datetime format, often used for front-end display.
*/
function format_datetime($datetime = 'now', $format = '', $timezone = '')
{
	$datetime = strtotime($datetime);
	if ($datetime != "") {
		if($format == '')
		{
			$CI =& get_instance();
			$config = $CI->config->item('format_helper', 'mythos');
			$format = $config['datetime'];
		}
		
		$current_tz = date_default_timezone_get();
		if($timezone == '')
		{
			$timezone = $current_tz;
		}
		date_default_timezone_set($timezone);
		$output = date($format, $datetime);
		date_default_timezone_set($current_tz);
		return $output;
	}
	else 
	{
		return "n/a";
	}
}