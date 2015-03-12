<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Photos extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		
		$this->access_control->logged_in();
		$this->access_control->account_type('dev', 'admin');
		$this->access_control->validate();
		
		$this->load->model('photo_album_model');
	}
	
	public function index() 
	{
		$this->template->title('Photos');
		
		if($this->input->post('form_mode'))
		{
			$form_mode = $this->input->post('form_mode');
			
			if($form_mode == 'delete')
			{
				$alb_ids = $this->input->post('alb_ids');
				if($alb_ids !== false)
				{
					foreach($alb_ids as $alb_id)
					{
						$album = $this->photo_album_model->get_one($alb_id);
						if($album !== false)
						{
							$this->photo_album_model->delete($alb_id);
							
							$alb_dir = BASEPATH . '../uploads/images/albums/' . $album->alb_slug;
							foreach(glob($alb_dir . '/thumbnails/*.*') as $file){
								unlink($file);
							}
							rmdir($alb_dir . '/thumbnails');
							
							foreach(glob($alb_dir . '/*.*') as $file){
								unlink($file);
							}
							rmdir($alb_dir);
						}
					}
					$this->template->notification('Selected albums were deleted.', 'success');
				}
			}
		}
		
		$page = array();
		$page['albums'] = $this->photo_album_model->pagination("admin/photos/index/__PAGE__", 'get_all');
		$page['albums_pagination'] = $this->photo_album_model->pagination_links();
		$this->template->content('photos-index', $page);
		$this->template->content('menu-photos_index', null, 'admin', 'page-nav');
		$this->template->show();
	}
	
	public function album_create() 
	{
		$this->template->title('Create Album');
		
		$this->form_validation->set_rules('alb_name', 'Album Name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('alb_description', 'Description', 'trim');
		
		if($this->input->post('submit'))
		{
			$photo_album = $this->extract->post();
			if($this->form_validation->run() !== false)
			{
				
				$alb_id = $this->photo_album_model->create($photo_album, $this->form_validation->get_fields());
				
				$slug = format_html_slug($photo_album['alb_name']);
				if($this->photo_album_model->get_by_slug($slug) !== false)
				{
					$slug .= '-' . $alb_id;
				}
				$this->photo_album_model->update_slug($alb_id, $slug);
				
				if(mkdir(BASEPATH . '../uploads/images/albums/' . $slug, 0755) && 
					mkdir(BASEPATH . '../uploads/images/albums/' . $slug . '/thumbnails', 0755))
				{
					$this->template->notification('New album created.', 'success');
					redirect('admin/photos/album/' . $alb_id);
				}
				else
				{
					// Revert changes
					$this->photo_album_model->delete($alb_id);
					$this->template->notification('Could not create folders for the album.', 'error');
					redirect('admin/photos');
				}
			}
			else
			{
				// To display validation errors caught by the Form_validation, you should have the code below. 
				$this->template->notification(validation_errors(), 'error');
			}
			$this->template->autofill($photo_album);
		}
		
		$this->template->content('photos-album_create');
		$this->template->show();
	}
	
	public function album_edit($alb_id = '')
	{
		$this->template->title('Edit Album');
		
		$this->form_validation->set_rules('alb_name', 'Album Name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('alb_description', 'Description', 'trim');
		
		if($this->input->post('submit'))
		{
			$album = $this->extract->post();
			if($this->form_validation->run() !== false)
			{
				
				$album['alb_id'] = $alb_id;
				$rows_affected = $this->photo_album_model->update($album, $this->form_validation->get_fields());
				
				$this->template->notification('Album updated.', 'success');
				redirect('admin/photos/album/' . $alb_id);
			}
			else
			{
				$this->template->notification(validation_errors(), 'warning');
			}
			$this->template->autofill($album);
		}
		
		$page['album'] = $this->photo_album_model->get_one($alb_id);
		
		if($page['album'] === false)
		{
			$this->template->notification('Album was not found.', 'error');
			redirect('admin/photos');
		}
		
		$this->template->content('photos-album_edit', $page);
		
		$this->template->show();
	}
	
    public function album($alb_id = '') 
	{
		$page = array();
		
		$page['album'] = $this->photo_album_model->get_one($alb_id);
		if($page['album'] === false)
		{
			$this->template->notification('Album does not exist.');
			redirect('admin/photos');
		}
		
		$this->template->title($page['album']->alb_name);
		
		$this->template->set('head', '<!--[if lt IE 7]><link rel="stylesheet" href="' . res_url('mythos/file_upload/css/bootstrap-ie6.min.css') . '"><![endif]-->');
		$this->template->set('head', '<link rel="stylesheet" href="' . res_url('mythos/file_upload/css/bootstrap-image-gallery.min.css') . '">');
		$this->template->set('head', '<link rel="stylesheet" href="' . res_url('mythos/file_upload/css/jquery.fileupload-ui.css') . '">');
		$this->template->set('head', '<!--[if lt IE 9]><script src="' . res_url('mythos/file_upload/js/html5.js') . '"></script><![endif]-->');
		
		$this->template->content('photos-album', $page);
		$this->template->content('menu-photos_album', $page, 'admin', 'page-nav');
		$this->template->show();
	}
   
	public function upload($alb_slug = '') 
	{
		$album = $this->photo_album_model->get_by_slug($alb_slug);
		
		$this->load->library('jquery_upload');

		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		if($album !== false)
		{
			$this->jquery_upload->set_album($alb_slug);
			
			switch ($_SERVER['REQUEST_METHOD']) {
				case 'OPTIONS':
					break;
				case 'HEAD':
				case 'GET':
					$this->jquery_upload->get();
					break;
				case 'POST':
					if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
						$this->jquery_upload->delete();
					} else {
						$this->jquery_upload->post();
					}
					break;
				case 'DELETE':
					$this->jquery_upload->delete();
					break;
				default:
					header('HTTP/1.1 405 Method Not Allowed');
			}
		}
		else
		{
			header('HTTP/1.1 404 Not Found');
		}
		die();
   }
}