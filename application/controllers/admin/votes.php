<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Votes extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->access_control->logged_in();
		$this->access_control->validate();

		$this->load->model('vote_model');
	}

	public function index()
	{
		$this->template->title('Votes');

		if($this->input->post('form_mode'))
		{
			$form_mode = $this->input->post('form_mode');

			if($form_mode == 'delete')
			{
				$vot_ids = $this->input->post('vot_ids');
				if($vot_ids !== false)
				{
					foreach($vot_ids as $vot_id)
					{
						$vote = $this->vote_model->get_one($vot_id);
						if($vote !== false)
						{
							$this->vote_model->delete($vot_id);
						}
					}
					$this->template->notification('Selected votes were deleted.', 'success');
				}
			}
		}

		$page = array();
		$page['votes'] = $this->vote_model->pagination("admin/votes/index/__PAGE__", 'get_all');
		$page['votes_pagination'] = $this->vote_model->pagination_links();
		$this->template->content('votes-index', $page);
		$this->template->content('menu-votes', null, 'admin', 'page-nav');
		$this->template->show();
	}

	public function create()
	{
		$this->template->title('Create Vote');


		// Use the set_rules from the Form_validation class for form validation.
		// Already combined with jQuery. No extra coding required for JS validation.
		// We get both JS and PHP validation which makes it both secure and user friendly.
		// NOTE: Set the rules before you check if $_POST is set so that the jQuery validation will work.


		if($this->input->post('submit'))
		{
			$vote = $this->extract->post();

			// Call run method from Form_validation to check
			if($this->form_validation->run() !== false)
			{
				$this->vote_model->create($vote, $this->form_validation->get_fields());
				// Set a notification using notification method from Template.
				// It is okay to redirect after and the notification will be displayed on the redirect page.
				$this->template->notification('New vote created.', 'success');
				redirect('admin/votes');
			}
			else
			{
				// To display validation errors caught by the Form_validation, you should have the code below.
				$this->template->notification(validation_errors(), 'error');
			}

			$this->template->autofill($vote);
		}

		$page = array();
		
		$this->template->content('votes-create', $page);
		$this->template->show();
	}

	public function edit($vot_id)
	{
		$this->template->title('Edit Vote');




		if($this->input->post('submit'))
		{
			$vote = $this->extract->post();
			if($this->form_validation->run() !== false)
			{
				$vote['vot_id'] = $vot_id;
				$rows_affected = $this->vote_model->update($vote, $this->form_validation->get_fields());

				$this->template->notification('Vote updated.', 'success');
				redirect('admin/votes');
			}
			else
			{
				$this->template->notification(validation_errors());
			}
			$this->template->autofill($vote);
		}

		$page = array();
		$page['vote'] = $this->vote_model->get_one($vot_id);

		if($page['vote'] === false)
		{
			$this->template->notification('Vote was not found.', 'error');
			redirect('admin/votes');
		}

		$this->template->content('votes-edit', $page);
		$this->template->show();
	}

	public function view($vote_id)
	{
		$this->template->title('View Vote');
		
		$page = array();
		$page['vote'] = $this->vote_model->get_one($vote_id);

		if($page['vote'] === false)
		{
			$this->template->notification('Vote was not found.', 'error');
			redirect('admin/votes');
		}
		
		$this->template->content('votes-view', $page);
		$this->template->show();
	}
}