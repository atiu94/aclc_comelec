<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
	}
	
	public function index()
	{
		if($this->access_control->check_logged_in())
		{
			redirect('admin/profile');
		}
	
		$this->template->title('Login');
		
		$page = array();
		$page['acc_username'] = '';
		
		$show_captcha = false;
		$this->load->model('account_model');
					
		if($this->input->post('submit'))
		{
			$post = $this->extract->post();
			$username = $post['acc_username'];
			$password = $post['acc_password'];
			
			$account_captcha = $this->account_model->get_by_username($username);
			if($account_captcha !== false && $account_captcha->acc_failed_login >= 5)
			{
				$check_captcha = true;
			}
			else
			{
				$check_captcha = false;
			}
	
			$this->mythos->library('captcha');
			if ($check_captcha === false || (isset($post['captcha_code']) && $this->captcha->check($post['captcha_code']) !== false)) 
			{
				$account = $this->account_model->authenticate($username, $password);
				if($account !== false)
				{
					$this->account_model->failed_login_reset($username);
					
					$this->session->set_userdata('acc_username', $account->acc_username);
					$this->session->set_userdata('acc_type', $account->acc_type);
					$this->session->set_userdata('acc_first_name', $account->acc_first_name);
					$this->session->set_userdata('acc_last_name', $account->acc_last_name);
					$this->session->set_userdata('acc_name', $account->acc_first_name . ' ' . $account->acc_last_name);
					
					if(isset($post['current_url']) && $post['current_url'] != '')
					{
						redirect($post['current_url'], 'refresh');
					}
					else 
					{
						redirect('admin/profile');
					}
				}
				else
				{
					$this->account_model->failed_login($username);
					
					if($account_captcha !== false && $account_captcha->acc_failed_login + 1 >= 5)
					{
						$show_captcha = true;
					}
					else
					{
						$this->template->notification('Invalid username or password.', 'error');
						$page['acc_username'] = $username;
					}
				}
			}
			else
			{
				$this->account_model->failed_login($username);
				$show_captcha = true;
				
				$this->template->notification('Incorrect CAPTCHA code.', 'error');
				$page['acc_username'] = $username;
			}

			unset($post['acc_password']);
			unset($post['captcha_code']);
			unset($post['current_url']);
			
			$this->template->autofill($post);
		}
		
		$page['show_captcha'] = $show_captcha;
		
		$this->template->content('index-index', $page);
		$this->template->show();
	}
	
	public function forbidden()
	{
		$this->template->title('Forbidden');
		
		$this->template->content('index-forbidden');
			
		$this->template->show();
	}
	
	public function logout()
	{
		$this->session->unset_userdata('acc_username');
		$this->session->unset_userdata('acc_type');
		$this->session->unset_userdata('acc_first_name');
		$this->session->unset_userdata('acc_last_name');
		$this->session->unset_userdata('acc_name');
		
		$this->template->notification('You are now logged out.', 'success');
		
		redirect('admin/index');
	}
	
}