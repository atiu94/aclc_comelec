<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_categories extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		
		$this->access_control->logged_in();
		$this->access_control->account_type('dev');
		$this->access_control->validate();
		
		$this->load->model('page_category_model');
	}
	
	public function index() 
	{
		$this->template->title('Page Categories');
		
		if($this->input->post('form_mode'))
		{
			$form_mode = $this->input->post('form_mode');
			
			if($form_mode == 'delete')
			{
				$page_category_ids = $this->input->post('pct_ids');
				if($page_category_ids !== false)
				{
					foreach($page_category_ids as $page_category_id)
					{
						$page_category = $this->page_category_model->get_one($page_category_id);
						if($page_category !== false)
						{
							$this->page_category_model->delete($page_category_id);
						}
					}
					$this->template->notification('Selected page categories were deleted.', 'success');
				}
			}
		}
		
		$page = array();
		$page['page_categories'] = $this->page_category_model->pagination("admin/page_categories/index/__PAGE__", 'get_all');
		$page['page_categories_pagination'] = $this->page_category_model->pagination_links();
		$this->template->content('page_categories-index', $page);
		$this->template->content('menu-page_categories', null, 'admin', 'page-nav');
		$this->template->show();
	}
	
	public function create() 
	{
		$this->template->title('Create Page Category');
		
		// Use the set_rules from the Form_validation class for form validation.
		// Already combined with jQuery. No extra coding required for JS validation.
		// We get both JS and PHP validation which makes it both secure and user friendly.
		// NOTE: Set the rules before you check if $_POST is set so that the jQuery validation will work.
		$this->form_validation->set_rules('pct_name', 'Category Name', 'trim|required|max_length[50]');
		
		if($this->input->post('submit'))
		{
			$page_category = $this->extract->post();
			
			// Call run method from Form_validation to check
			if($this->form_validation->run() !== false)
			{
				$this->page_category_model->create($page_category, $this->form_validation->get_fields());
				// Set a notification using notification method from Template.
				// It is okay to redirect after and the notification will be displayed on the redirect page.
				$this->template->notification('New page category created.', 'success');
				redirect('admin/page_categories');
			}
			else
			{
				// To display validation errors caught by the Form_validation, you should have the code below. 
				$this->template->notification(validation_errors(), 'error');
			}

			$this->template->autofill($page_category);
		}
		
		$this->template->content('page_categories-create');
		$this->template->show();
	}
	
	public function edit($page_category_id)
	{
		$this->template->title('Edit Page Category');
		
		$this->form_validation->set_rules('pct_name', 'Category Name', 'trim|required|max_length[50]');
		
		if($this->input->post('submit'))
		{
			$page_category = $this->extract->post();
			if($this->form_validation->run() !== false)
			{
				$page_category['pct_id'] = $page_category_id;
				$rows_affected = $this->page_category_model->update($page_category, $this->form_validation->get_fields());
				
				$this->template->notification('Page category updated.', 'success');
				redirect('admin/page_categories');
			}
			else
			{
				$this->template->notification(validation_errors());
			}
			$this->template->autofill($page_category);
		}
		
		$page = array();
		$page['page_category'] = $this->page_category_model->get_one($page_category_id);
		
		if($page['page_category'] === false)
		{
			$this->template->notification('Page category was not found.', 'error');
			redirect('admin/page_categories');
		}
		
		$this->template->content('page_categories-edit', $page);
		$this->template->show();
	}
	
}
