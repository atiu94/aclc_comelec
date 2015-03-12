<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
	
		$this->access_control->account_type('dev', 'admin');
		$this->access_control->validate();
		
		$this->load->model('account_model');
	}
	
	public function index() 
	{
		$this->template->title('Accounts');
		
		if($this->input->post('form_mode'))
		{
			$form_mode = $this->input->post('form_mode');
			
			if($form_mode === 'delete')
			{
				$account_ids = $this->input->post('acc_ids');
				if($account_ids !== false)
				{
					foreach($account_ids as $account_id)
					{
						$account = $this->account_model->get_one($account_id);
						if($account !== false)
						{
							// Prevent admin user from being deleted
							if($account->acc_username != 'admin')
							{
								$this->account_model->delete($account_id);
							}
						}
					}
					$this->template->notification('Selected accounts were deleted.', 'success');
				}
			}
		}
		
		$page = array();
		$page['accounts'] = $this->account_model->pagination('admin/accounts/index/__PAGE__', 'get_all', array('acc_type !=' => 'dev'));
		$page['accounts_pagination'] = $this->account_model->pagination_links();
		
		$this->template->content('accounts-index', $page);
		$this->template->content('menu-accounts', null, 'admin', 'page-nav');
		$this->template->show();
	}
	
	public function create() 
	{
		$this->template->title('Create Account');
		
		// Use the set_rules from the Form_validation class for form validation.
		// Already combined with jQuery. No extra coding required for JS validation.
		// We get both JS and PHP validation which makes it both secure and user friendly.
		// NOTE: Set the rules before you check if $_POST is set so that the jQuery validation will work.
		$this->form_validation->set_rules('acc_username', 'Email', 'trim|required|valid_email|max_length[150]');
		$this->form_validation->set_rules('acc_password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('acc_password2', 'Retype Password', 'required|matches[acc_password]');
		$this->form_validation->set_rules('acc_first_name', 'First Name', 'trim|required|max_length[60]');
		$this->form_validation->set_rules('acc_last_name', 'Last Name', 'trim|required|max_length[30]');
		
		if($this->input->post('submit'))
		{
			// Extract all $_POST variables using the method post from Extract
			$account = $this->extract->post();

			// Call run method from Form_validation to check
			if($this->form_validation->run() !== false)
			{
				$duplicateAccount = $this->account_model->get_by_username($account['acc_username']);
				if($duplicateAccount === false)
				{
					// Encrypt password
					$account['acc_password'] = md5($account['acc_password']);
					$this->account_model->create($account, $this->form_validation->get_fields());
					// Set a notification using notification method from Template.
					// It is okay to redirect after and the notification will be displayed on the redirect page.
					$this->template->notification('New account created.', 'success');
					redirect('admin/accounts');
				}
				else
				{
					$this->template->notification('Username already exists.', 'warning');
				}
			}
			else
			{
				// To display validation errors caught by the Form_validation, you should have the code below. 
				$this->template->notification(validation_errors(), 'error');
			}

			unset($account['acc_password']);
			unset($account['acc_password2']);
			$this->template->autofill($account);
		}
		
		$this->template->content('accounts-create');
		$this->template->show();
	}
	
	public function view($id = 0)
	{
		$this->template->title('Accounts');
		
		$account = $this->account_model->get_one($id);
		if($account !== false)
		{
			// Prevent viewing 'dev' accounts if user is not 'dev'
			if($account->acc_type == 'dev' && !$this->access_control->check_account_type('dev'))
			{
				redirect('admin/accounts');
			}
			
			$page = array();
			$page['account'] = $account;
			$this->template->content('accounts-view', $page);
			$this->template->show();
		}
		else
		{
			redirect('admin/accounts');
		}
	}
	
	public function reset_password($id = 0)
	{
		$this->template->title('Reset Password');
		
		$account = $this->account_model->get_one($id);
		if($account === false)
		{
			redirect('admin/accounts');
		}
		else
		{
			// Prevent viewing 'dev' accounts if user is not 'dev' 
			if($account->acc_type == 'dev' && !$this->access_control->check_account_type('dev'))
			{
				redirect('admin/accounts');
			}
		
			if($this->input->post('submit') !== false)
			{
				
				$password = $this->input->post('acc_password');
				$this->account_model->change_password($account->acc_username, $password);
				
				$this->template->notification('Password for ' . $account->acc_username . ' was changed.', 'success');
				
				redirect('admin/accounts');
			}
			else
			{
				$page = array();
				$page['account'] = $account;
				$page['acc_password'] = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 12)),0, 12);
				$this->template->content('accounts-reset_password', $page);
				$this->template->show();
			}
		}
	}
	
}
