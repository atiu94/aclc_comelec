<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Votes extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->access_control->logged_in();
		$this->access_control->validate();

		$this->load->model('vote_model');
		$this->load->model('candidate_model');
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
		$this->template->title('Cast Vote');

		if($this->input->post('submit'))
		{
			$can_ids = $this->input->post('can_ids');

		
			if($can_ids !== false)
			{
				foreach($can_ids as $can_id)
				{
					$can_id_int = intval($can_id);

					$vote = array();

					$vote['vot_can'] = $can_id_int;

					$this->vote_model->create($vote, $this->vote_model->get_fields());
				}

				$this->template->notification('Vote has been casted.', 'success');
			}		
				
			

			$this->template->autofill($vote);
		}

		$page = array();
		$page['candidates'] = $this->candidate_model->pagination("admin/candidates/index/__PAGE__", 'get_all_alphabetical_called');
		$page['candidates_pagination'] = $this->candidate_model->pagination_links();
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