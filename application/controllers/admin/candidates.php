<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidates extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->access_control->logged_in();
		$this->access_control->validate();

		$this->load->model('candidate_model');
	}

	public function index()
	{
		$this->template->title('Candidates');
		$page = array();
		$page['candidates'] = $this->candidate_model->pagination("admin/candidates/index/__PAGE__", 'get_all');
		$page['candidates_pagination'] = $this->candidate_model->pagination_links();

		$this->set_votes($page['candidates']);



		if($this->input->post('form_mode'))
		{
			$form_mode = $this->input->post('form_mode');

			if($form_mode == 'delete')
			{
				$can_ids = $this->input->post('can_ids');
				if($can_ids !== false)
				{
					foreach($can_ids as $can_id)
					{
						$candidate = $this->candidate_model->get_one($can_id);
						if($candidate !== false)
						{
							$this->candidate_model->delete($can_id);
						}
					}
					$this->template->notification('Selected candidates were deleted.', 'success');
				}
			}
		}


		$this->template->content('candidates-index', $page);
		$this->template->content('menu-candidates', null, 'admin', 'page-nav');
		$this->template->show();
	}

	public function create()
	{
		$this->template->title('Create Candidate');


		// Use the set_rules from the Form_validation class for form validation.
		// Already combined with jQuery. No extra coding required for JS validation.
		// We get both JS and PHP validation which makes it both secure and user friendly.
		// NOTE: Set the rules before you check if $_POST is set so that the jQuery validation will work.
		$this->form_validation->set_rules('can_first_name', 'First Name', 'trim|required|max_length[30]');
		//$this->form_validation->set_rules('can_middle_name', 'Middle Name', 'trim|required|max_length[30]');
		$this->form_validation->set_rules('can_last_name', 'Last Name', 'trim|required|max_length[30]');
		//$this->form_validation->set_rules('can_votes', 'Votes', 'trim|required|integer|max_length[11]');
		//$this->form_validation->set_rules('can_quota', 'Quota', 'trim|required|integer|max_length[1]');

		if($this->input->post('submit'))
		{
			$candidate = $this->extract->post();

			// Call run method from Form_validation to check
			if($this->form_validation->run() !== false)
			{
				$this->candidate_model->create($candidate, $this->form_validation->get_fields());
				// Set a notification using notification method from Template.
				// It is okay to redirect after and the notification will be displayed on the redirect page.
				$this->template->notification('New candidate created.', 'success');
				redirect('admin/candidates');
			}
			else
			{
				// To display validation errors caught by the Form_validation, you should have the code below.
				$this->template->notification(validation_errors(), 'danger');
			}

			$this->template->autofill($candidate);
		}

		$page = array();
		
		$this->template->content('candidates-create', $page);
		$this->template->show();
	}

	public function edit($can_id)
	{
		$this->template->title('Edit Candidate');


		$this->form_validation->set_rules('can_first_name', 'First Name', 'trim|required|max_length[30]');
		//$this->form_validation->set_rules('can_middle_name', 'Middle Name', 'trim|required|max_length[30]');
		$this->form_validation->set_rules('can_last_name', 'Last Name', 'trim|required|max_length[30]');
		//$this->form_validation->set_rules('can_votes', 'Votes', 'trim|required|integer|max_length[11]');
		//$this->form_validation->set_rules('can_quota', 'Quota', 'trim|required|integer|max_length[1]');

		if($this->input->post('submit'))
		{
			$candidate = $this->extract->post();
			if($this->form_validation->run() !== false)
			{
				$candidate['can_id'] = $can_id;
				$rows_affected = $this->candidate_model->update($candidate, $this->form_validation->get_fields());

				$this->template->notification('Candidate updated.', 'success');
				redirect('admin/candidates');
			}
			else
			{
				$this->template->notification(validation_errors());
			}
			$this->template->autofill($candidate);
		}

		$page = array();
		$page['candidate'] = $this->candidate_model->get_one($can_id);

		if($page['candidate'] === false)
		{
			$this->template->notification('Candidate was not found.', 'error');
			redirect('admin/candidates');
		}

		$this->template->content('candidates-edit', $page);
		$this->template->show();
	}

	public function view($candidate_id)
	{
		$this->template->title('View Candidate');
		
		$page = array();
		$page['candidate'] = $this->candidate_model->get_one($candidate_id);

		if($page['candidate'] === false)
		{
			$this->template->notification('Candidate was not found.', 'error');
			redirect('admin/candidates');
		}
		
		$this->template->content('candidates-view', $page);
		$this->template->show();
	}



	public function set_votes($candidates)
	{

		foreach($candidates->result() as $candidate)
		{
			$row_count = $this->candidate_model->count_votes($candidate->can_id);

			$candidate->can_votes = $row_count;
		}
	}
}