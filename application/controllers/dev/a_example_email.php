<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class A_example_email extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->mythos->library("email"); //use this line to load the mythos library make sure you do NOT use $this->load->library('email');
	}
	
	public function index() 
	{
		/*
		mail settings are placed in /application/config/email.php (default CI config file). by default it uses the test email settings from zeaple there are 2 added config settings:
		
		$config['from_email'] = "test-email@zeaple.com";
		$config['from_email_name'] = "Zeaple Test Email";
		
		the next lines will set the array to be passed to the view
		*/
		
		$email_data = array();
		$email_data["first_name"] ="First Name";
		$email_data["last_name"] ="Last Name";
		
		/*
		uses a mailchimp template that renders correctly for most mail programs (outlook, gmail, yahoo, etc.)
		
		select the email template to be loaded. this templating works similar to the current templating calls except at the end instead of calling render, you call $this->emailer->send
		
		this will load /application/views/email/welcome.php (1st parameter) into /application/views/email/template.php
		
		email images have to be in a live url site so that it will be rendered correctly. the default template header image is: http://gallery.mailchimp.com/653153ae841fd11de66ad181a/images/placeholder_600.gif so that you can test sending the email in localhost. 
		
		when deploying to the live server. place the header image in /templates/email/images and call it from there in the live site. do not use relative paths.
		*/
		
		$template['content'] = $this->template->get_view('welcome', $email_data, 'email');		
		
		//send the email
		$send_to = "jonconanan@zeaple.com";
		$subject = "Email Subject";
		
		$this->email->send_mail($send_to, $subject, $template);
	}
}
