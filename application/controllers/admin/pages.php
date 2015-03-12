<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		
		$this->access_control->logged_in();
		$this->access_control->account_type('dev', 'admin');
		$this->access_control->validate();
		
		$this->load->model('page_model');
		$this->load->model('page_category_model');
	}
	
	public function index($page = 0, $pct_id = -1) 
	{
		$this->template->title('Pages');
		
		if($this->input->post('form_mode'))
		{
			$form_mode = $this->input->post('form_mode');
			
			if($form_mode == 'delete')
			{
				$page_ids = $this->input->post('pag_ids');
				if($page_ids !== false)
				{
					foreach($page_ids as $page_id)
					{
						$page = $this->page_model->get_one($page_id);
						if($page !== false)
						{
							$this->page_model->delete($page_id);
						}
					}
					$this->template->notification('Selected pages were deleted.', 'success');
				}
			}
		}
		
		$page = array();
		$filter = array();	
		
		$page['page_categories'] = $this->page_category_model->get_all();
		
		if(!$this->access_control->check_account_type('dev'))
		{
			$filter['pag_type'] = 'editable';
			
			if($pct_id < -1)
			{
				$pct_id = -1;
			}
			
			if($page['page_categories']->num_rows() > 0)
			{
				$this->template->content('menu-pages', null, 'admin', 'page-nav');
			}
		}
		else
		{
			$this->template->content('menu-pages', null, 'admin', 'page-nav');
		}
		
		if($pct_id > -1)
		{
			$filter['page.pct_id'] = $pct_id;
		}
		
		if($pct_id == -1)
		{
			$page['current_pct_filter'] = '';
		}
		else
		{
			$page['current_pct_filter'] = $pct_id;
		}
		
		$page['pages'] = $this->page_model->pagination("admin/pages/index/__PAGE__", 'get_all_with_categories', $filter);
		$page['pages_pagination'] = $this->page_model->pagination_links();
		$this->template->content('pages-index', $page);
		
		$this->template->show();	
	}
	
	public function create($mce_fix = null)
	{
		// Patch for tinyMCE image upload relative URLs
		if($mce_fix == null || $mce_fix != 'blank')
		{
			redirect('admin/pages/create/blank');
		}
	
		$this->template->title('Create Page');
		
		// Use the set_rules from the Form_validation class for form validation.
		// Already combined with jQuery. No extra coding required for JS validation.
		// We get both JS and PHP validation which makes it both secure and user friendly.
		// NOTE: Set the rules before you check if $_POST is set so that the jQuery validation will work.
		$this->form_validation->set_rules('pag_title', 'Page Title', 'trim|required|max_length[140]');
		$this->form_validation->set_rules('pct_id', 'Category', 'integer|required');
		$this->form_validation->set_rules('pag_content', 'Content', '');
		$this->form_validation->set_rules('pag_date_published', 'Date Published', 'trim');
		$this->form_validation->set_rules('pag_status', 'Status', 'trim|required');
		if($this->access_control->check_account_type('dev'))
		{
			$this->form_validation->set_rules('pag_type', 'Type', 'trim|required');
		}
		
		if($this->input->post('submit'))
		{
			$page = $this->extract->post();
			// Call run method from Form_validation to check
			if($this->form_validation->run() !== false)
			{
				if($page['pag_status'] == 'draft' && isset($page['pag_date_published']))
				{
					$page['pag_date_published'] = null;
				}
				
				$page['pag_date_created'] = format_mysql_datetime();
				
				$insert_fields = $this->form_validation->get_fields();
				$insert_fields[] = 'pag_date_created';
				
				$page_id = $this->page_model->create($page, $insert_fields);
				$slug = format_html_slug($page['pag_title']);
				if($this->page_model->get_by_slug($slug) !== false)
				{
					$slug .= '-' . $page_id;
				}
				$this->page_model->update_slug($page_id, $slug);
				
				// Set a notification using notification method from Template.
				// It is okay to redirect after and the notification will be displayed on the redirect page.
				$this->template->notification('New page created.', 'success');
				redirect('admin/pages');
			}
			else
			{
				// To display validation errors caught by the Form_validation, you should have the code below. 
				$this->template->notification(validation_errors(), 'warning');
			}
			$this->template->autofill($page);
		}
		
		$page_params = array();
		
		$page_params['page_categories'] = $this->page_category_model->get_all();
		if(!$this->access_control->check_account_type('dev') && $page_params['page_categories']->num_rows() == 0)
		{
			$this->template->notification('There were no page categories found. Cannot create pages.', 'warning');
			redirect('admin/pages');
		}
		
		$this->template->content('pages-create', $page_params);
		
		$this->template->show();
	}
	
	public function edit($page_id)
	{
		$this->template->title('Edit Page');
		
		$this->form_validation->set_rules('pag_title', 'Page Title', 'trim|required|max_length[140]');
		$this->form_validation->set_rules('pct_id', 'Category', 'integer');
		$this->form_validation->set_rules('pag_content', 'Content', '');
		$this->form_validation->set_rules('pag_date_published', 'Date Published', 'trim');
		$this->form_validation->set_rules('pag_status', 'Status', 'trim|required');
		
		if($this->input->post('submit'))
		{
			$page = $this->extract->post();
			if($this->form_validation->run() !== false)
			{
				if($page['pag_status'] == 'draft' && isset($page['pag_date_published']))
				{
					$page['pag_date_published'] = null;
				}				
				$page['pag_id'] = $page_id;
				$rows_affected = $this->page_model->update($page, $this->form_validation->get_fields());
				
				$this->template->notification('Page updated.', 'success');
				redirect('admin/pages');
			}
			else
			{
				$this->template->notification(validation_errors(), 'warning');
			}
			$this->template->autofill($page);
		}
		
		$this->load->model('page_category_model');
		$page_params = array();
		$page_params['page_categories'] = $this->page_category_model->get_all();
		$page_params['page'] = $this->page_model->get_one($page_id);
		
		if($page_params['page'] === false)
		{
			$this->template->notification('Page was not found.', 'error');
			redirect('admin/pages');
		}
		
		$this->template->content('pages-edit', $page_params);
		
		$this->template->show();
	}
	
}
