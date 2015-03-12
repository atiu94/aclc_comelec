<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		
		$this->access_control->logged_in();
		$this->access_control->account_type('dev', 'admin');
		$this->access_control->validate();
	}
	
	public function index()
	{
		$this->load->model('account_model');
		$username = $this->session->userdata('acc_username');
		$account = $this->account_model->get_by_username($username);
		
		$this->template->title($account->acc_first_name . ' ' . $account->acc_last_name);
		
		if($account !== false)
		{
			$using_default = false;
			if($account->acc_type == 'dev')
			{
				$using_default = $this->account_model->using_default_pass($account->acc_username);
			}
			
			if($using_default !== false)
			{
				$this->template->notification("Please reset this account's password for security.", 'warning');
				redirect('admin/accounts/reset_password/' . $account->acc_id);
			}
			
			$page = array();
			$page['account'] = $account;
			$this->template->content('profile-index', $page);
			
			$this->template->show();
		}
		else
		{
			redirect('/admin/accounts/');
		}
	}
	
	public function change_password()
	{
		$template = array();
		$this->template->title('Change Password');
		
		$this->form_validation->set_rules('old_password', 'Old Password', 'required');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
		$this->form_validation->set_rules('new_password2', 'Retype New Password', 'required|matches[new_password]');
		
		if($this->input->post('submit') !== false)
		{
			$this->load->model('account_model');
			$username = $this->session->userdata('acc_username');
			$old_password = $this->input->post('old_password');
			$new_password = $this->input->post('new_password');
			$new_password2 = $this->input->post('new_password2');
			
			$account = $this->account_model->authenticate($username, $old_password);
			if($account !== false)
			{
				if($this->form_validation->run() !== false)
				{
					$this->account_model->change_password($username, $new_password);
					$this->template->notification('Password changed.', 'success');
					redirect('/admin/profile/');
				}
				else
				{
					$this->template->notification(validation_errors(), 'error');
				}
			}
			else
			{
				$this->template->notification('Incorrect old password.', 'error');
			}
		}
		
		$this->template->content('profile-change_password');
			
		$this->template->show();
	}
	
}