<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MYTHOS_Access_control 
{
	
	private $CI;
	protected $is_allow_logged_in;
	protected $allowed_users;
	protected $account_types;
	
	protected $logged_in_index;
	protected $account_type_index;
	
	public function __construct() 
	{
		$this->CI =& get_instance();
		$this->is_allow_logged_in = false;
		$this->allowed_users = array();
		$this->account_types = array();
		
		$config = $this->CI->config->item('access_control', 'mythos');
		$this->logged_in_index = $config['logged_in_index'];
		$this->account_type_index = $config['account_type_index'];
		
		$this->CI->load->library('session');
	}
	
	/*
	Set access control rule for logged in users only
	*/
	public function logged_in($val = true)
	{
		$this->is_allow_logged_in = $val;
	}
	
	/*
	Set access control rule for a set of usernames.
	
	Receives multiple username parameters.
	Example:
		$this->Access_control->user('adamsmith', 'johndoe');
	*/
	public function user()
	{
		$usernames = func_get_args();
		foreach($usernames as $username)
		{
			$this->allowed_users[] = $username;
		}
	}
	
	/*
	Set access control rule for a set of account types
	
	Receives multiple account type parameters.
	Example:
		$this->Access_control->account_type('admin', 'user');
	*/
	public function account_type()
	{
		$account_types = func_get_args();
		foreach($account_types as $account_type)
		{
			$this->account_types[] = $account_type;
		}
	}
	
	/*
	Checks if the user is logged in
	*/
	public function check_logged_in()
	{
		if($this->CI->session->userdata($this->logged_in_index) !== false)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	Checks if the user's username matches the input username
	*/
	public function check_user()
	{
		$usernames = func_get_args();
		$user_username = $this->CI->session->userdata($this->logged_in_index);
		foreach($usernames as $username)
		{
			if($user_username == $username)
			{
				return true;
			}
		}
		return false;
	}
	
	/*
	Checks if the user's account type matches the input account type
	*/
	public function check_account_type()
	{
		$account_types = func_get_args();
		$user_account_type = $this->CI->session->userdata($this->account_type_index);
		foreach($account_types as $account_type)
		{
			if($user_account_type == $account_type)
			{
				return true;
			}
		}
		return false;
	}
	
	/*
	Checks if a user is logged in if a logged in rule was set
	*/
	private function validate_allow_logged_in()
	{
		if($this->is_allow_logged_in)
		{
			return $this->check_logged_in();
		}
		else
		{
			return true;
		}
	}
	
	/*
	Checks if the user's username matches the input username if a user rule was set
	*/
	private function validate_allow_user()
	{
		if(count($this->allowed_users) > 0)
		{
			foreach($this->allowed_users as $allowed_user) 
			{
				if($this->check_user($allowed_user)) 
				{
					return true;
				}			
			}
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/*
	Checks if the user's account type matches the input account type if an account type rule was set
	*/
	private function validate_account_types()
	{
		if(count($this->account_types) > 0)
		{		
			foreach($this->account_types as $account_type) 
			{
				if($this->check_account_type($account_type)) 
				{
					return true;
				}			
			}
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/*
	Checks if all the access control rules pass.
	Returns a boolean.
	*/
	public function check()
	{
		$validation_result = ($this->validate_allow_logged_in() && $this->validate_allow_user() && $this->validate_account_types());
		return $validation_result;
	}
	
	/*
	Runs all validation checks and returns login, forbidden, or allowed depending on the result.
	*/
	public function validate()
	{
		$validation_result = $this->check();
		if($validation_result === false)
		{
			if($this->check_logged_in() === false)
			{
				// Page requires user to be logged in
				return 'login';
			}
			else
			{
				// Not allowed user or account type
				return 'forbidden';
			}
		}
		
		return 'allowed';
	}
}
