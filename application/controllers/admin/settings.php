<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		
		$this->access_control->account_type('admin');
		$this->access_control->validate();
		$this->load->model('settings_model');
	}
	
	public function index() 
	{
		$params = array();
		$params['models'] = $this->db->list_tables();
		

		$this->template->title('Settings Summary');
		$this->template->content('settings-index', $params);
		$this->template->content('menu-settings', null, 'admin', 'page-nav');
		$this->template->show();
	}


	public function votes(){

		$params = array();
		$params['models'] = $this->db->list_tables();

		$this->form_validation->set_rules('set_count', 'Set Count', 'trim|required|integer|max_length[3]');

		if($this->input->post('submit'))
		{
			$settings = $this->extract->post();
			$settings['set_id'] = 1;

			// Call run method from Form_validation to check
			if($this->form_validation->run() !== false)
			{
				$this->settings_model->update($settings, $this->form_validation->get_fields());
				// Set a notification using notification method from Template.
				// It is okay to redirect after and the notification will be displayed on the redirect page.
				$this->template->notification('Number of voters has been set.', 'success');
				redirect('admin/candidates');
			}
			else
			{
				// To display validation errors caught by the Form_validation, you should have the code below.
				$this->template->notification(validation_errors(), 'danger');
			}

			$this->template->autofill($setting);




		}

		$this->template->title('Vote Settings');
		$this->template->content('settings-votes');
		$this->template->show();
	}
	
	public function phpinfo()
	{
		$this->template->title('PHP Info');
		$this->template->content('settings-phpinfo');
		$this->template->content('menu-settings', null, 'admin', 'page-nav');
		$this->template->show();
	}
	
	public function codeigniter()
	{
		$this->template->title('CodeIgniter Info');

		$page = array();
		
		
		$this->load->library('config');
		$ci_configs = array('autoload', 'config', 'database', 'routes');
		$page['configs'] = array();
		foreach($ci_configs as $config_name)
		{
			require(APPPATH . 'config/' . $config_name . '.php');
			if($config_name == 'database')
			{
				$page['configs'][$config_name]['active_group'] = $active_group;
				$page['configs'][$config_name]['active_record'] = $active_record;
				$page['configs'][$config_name]['db'] = $db;
			}
			elseif($config_name == 'routes')
			{
				$page['configs'][$config_name] = $route;
			}
			else
			{
				$page['configs'][$config_name] = $$config_name;
			}
		}
		
		$configs = array('email', 'mythos');
		foreach($configs as $config_name)
		{
			$this->config->load($config_name, true);
			$page['configs'][$config_name] = $this->config->item($config_name);
		}
		
		$this->template->content('settings-codeigniter', $page);
		$this->template->content('menu-settings', null, 'admin', 'page-nav');
		$this->template->show();
	}
}