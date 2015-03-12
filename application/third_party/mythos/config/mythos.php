<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*** Base Configurations ***/

// Default timezone. If set to NULL, Mythos will not set a timezone.
$config['timezone'] = 'Asia/Manila';



/*** Autoload Mythos Files ***/

$config['autoload']['libraries'] = array('template', 'access_control', 'form_validation', 'extract', 'pagination','email','pdf');
$config['autoload']['helper'] = array('format', 'datetime', 'template', 'form');
$config['autoload']['config'] = array();
$config['autoload']['language'] = array();
$config['autoload']['model'] = array('base_model');



/*** More helper ***/

$config['more_helper']['max_char_count'] = 100;
$config['more_helper']['max_word_count'] = 100;
$config['more_helper']['ellipsis'] = '...';



/*** Format helper ***/

$config['format_helper']['date'] = 'D, j M Y';
$config['format_helper']['time'] = 'h:i A';
$config['format_helper']['datetime'] = 'D, j M Y h:i A';
$config['format_helper']['html_slug_length'] = 70;



/*** Access_control library ***/

// Index of the session that Mythos will check to determine if the user is logged in.
$config['access_control']['logged_in_index'] = 'acc_username';
// Index of the session that Mythos will check to get the user's account type.
$config['access_control']['account_type_index'] = 'acc_type';



/*** Pagination library ***/

// Refer to the Pagination library's documentation (http://codeigniter.com/user_guide/libraries/pagination.html)
$config['pagination']['per_page'] = 20;
$config['pagination']['num_links'] = 4;
$config['pagination']['first_link'] = '&larr; First';
$config['pagination']['prev_link'] = '&larr; Back';
$config['pagination']['next_link'] = '&rarr; Next';
$config['pagination']['last_link'] = '&rarr; Last';
$config['pagination']['full_tag_open'] = '<div class="pagination"><ul>';
$config['pagination']['full_tag_close'] = '</ul></div>';
$config['pagination']['first_tag_open'] = '<li class="prev">';
$config['pagination']['first_tag_close'] = '</li>';
$config['pagination']['prev_tag_open'] = '<li class="prev">';
$config['pagination']['prev_tag_close'] = '</li>';
$config['pagination']['next_tag_open'] = '<li class="next">';
$config['pagination']['next_tag_close'] = '</li>';
$config['pagination']['last_tag_open'] = '<li class="next">';
$config['pagination']['last_tag_close'] = '</li>';
$config['pagination']['cur_tag_open'] = '<li class="active"><a href="#">';
$config['pagination']['cur_tag_close'] = '</a></li>';
$config['pagination']['num_tag_open'] = '<li>';
$config['pagination']['num_tag_close'] = '</li>';



/*** Facebook library ***/

$config['facebook']['app_id'] = '';
$config['facebook']['secret'] = '';
$config['facebook']['file_upload'] = false;
$config['facebook']['verify_peer_certificate'] = true;

