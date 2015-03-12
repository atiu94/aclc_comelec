<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once(SYSDIR . '/libraries/Upload.php');

class MYTHOS_Upload extends CI_Upload
{
	private $CI;
	
	public function __construct() 
	{
		$this->CI =& get_instance();
	}
	
	public function do_upload_resize($field, $width, $height, $path = "")
	{
		$upload_config = array();
		
		if($path == "")
		{
			$upload_config['upload_path'] = FCPATH . 'uploads/';
		}
		else
		{
			$upload_config['upload_path'] = rtrim($path, '/\\') . '/';
		}
		$upload_config['allowed_types'] = 'gif|jpg|png|jpeg';
		$upload_config['max_size']	= '0';
		$upload_config['max_width']  = '0';
		$upload_config['max_height']  = '0';
		$upload_config['encrypt_name'] = true;
		$upload_config['overwrite'] = false;
		$this->CI->upload->initialize($upload_config);
		
		if(!$this->CI->upload->do_upload($field))
		{
			$error = array('error' => $this->CI->upload->display_errors());
			$d = $this->CI->upload->data();
			return $error;
		}
		else
		{
			$upload_data = $this->CI->upload->data('full_path');

			$image_config = array();
			$image_config['image_library'] = 'gd2';
			$image_config['source_image'] = $upload_data['full_path'];
			$image_config['create_thumb'] = true;
			$image_config['maintain_ratio'] = true;
			$image_config['width'] = $width;
			$image_config['height'] = $height;
			
			$this->CI->load->library('image_lib');
			$this->CI->image_lib->initialize($image_config);
			$this->CI->image_lib->resize();
			$this->CI->image_lib->clear();
			
			$data = array();
			$data['upload_data'] = $this->CI->upload->data();
			$data['thumb_file_name'] = $upload_data['raw_name']."_thumb" . $upload_data['file_ext'];
			return $data;
		}
	}
}