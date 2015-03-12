<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller 
{
	private $TEST_DATA_PATH;
	
	public function __construct() 
	{
		parent::__construct();
		$this->mythos->library('upload');
		$this->TEST_DATA_PATH = FCPATH . 'application/controllers/test/data/upload';
	}
	
	public function index() 
	{
		$url = site_url('test/upload/begin');
		$post_data['file001'] = "@" . $this->TEST_DATA_PATH . '/input/test001.jpg;type=image/jpeg';
		$post_data['file101'] = "@" . $this->TEST_DATA_PATH . '/input/test101.png;type=image/png';
		$post_data['file102'] = "@" . $this->TEST_DATA_PATH . '/input/test102.png;type=image/png';
		$post_data['file103'] = "@" . $this->TEST_DATA_PATH . '/input/test103.jpg;type=image/jpeg';
		$post_data['file201'] = "@" . $this->TEST_DATA_PATH . '/input/test201.txt;type=text/plain';
		 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($ch);
		echo $response;
	}
	
	public function begin() 
	{
		$this->test001();
		$this->test002();
		$this->test003();
		$this->test004();
		$this->test005();
	}
	
	private function test001()
	{
		$output_path = $this->TEST_DATA_PATH . '/output/test001';
		if(is_dir($output_path) == false) {
			mkdir($output_path);
		}
		$files = glob($output_path . '*');
		foreach($files as $file)
		{
			if(is_file($file)) 
			{
				unlink($file);
			}
		}
		
		echo "--------------------\n";
		echo __METHOD__ . "\n";
		echo "--------------------\n";
		echo "Single file upload";
		echo "\n\n";
		$result = $this->upload->do_upload_resize('file001', 200, 100, $output_path);
		var_dump($result) . "\n";
		echo "\n";
	}
	
	private function test002()
	{
		$output_path = $this->TEST_DATA_PATH . '/output/test002';
		if(is_dir($output_path) == false) {
			mkdir($output_path);
		}
		$files = glob($output_path . '*');
		foreach($files as $file)
		{
			if(is_file($file)) 
			{
				unlink($file);
			}
		}
		
		echo "--------------------\n";
		echo __METHOD__ . "\n";
		echo "--------------------\n";
		echo "Invalid file upload";
		echo "\n\n";
		$result = $this->upload->do_upload_resize('file000', 200, 100, $output_path);
		var_dump($result) . "\n";
		echo "\n";
	}
	
	private function test003()
	{
		$output_path = $this->TEST_DATA_PATH . '/output/test003';
		if(is_dir($output_path) == false) {
			mkdir($output_path);
		}
		$files = glob($output_path . '*');
		foreach($files as $file)
		{
			if(is_file($file)) 
			{
				unlink($file);
			}
		}
		
		echo "--------------------\n";
		echo __METHOD__ . "\n";
		echo "--------------------\n";
		echo "Invalid upload folder";
		echo "\n\n";
		$result = $this->upload->do_upload_resize('file001', 200, 100, $this->TEST_DATA_PATH . '/invalid-upload-folder/test003');
		var_dump($result) . "\n";
		echo "\n";
	}
	
	private function test004()
	{
		$output_path = $this->TEST_DATA_PATH . '/output/test004';
		if(is_dir($output_path) == false) {
			mkdir($output_path);
		}
		$files = glob($output_path . '*');
		foreach($files as $file)
		{
			if(is_file($file)) 
			{
				unlink($file);
			}
		}
		
		echo "--------------------\n";
		echo __METHOD__ . "\n";
		echo "--------------------\n";
		echo "Multiple file upload";
		echo "\n\n";
		$result = $this->upload->do_upload_resize('file101', 200, 100, $output_path);
		var_dump($result) . "\n";
		
		$result = $this->upload->do_upload_resize('file102', 200, 100, $output_path);
		var_dump($result) . "\n";
		
		$result = $this->upload->do_upload_resize('file103', 200, 100, $output_path);
		var_dump($result) . "\n";
		
		echo "\n";
	}
	
	private function test005()
	{
		$output_path = $this->TEST_DATA_PATH . '/output/test005';
		if(is_dir($output_path) == false) {
			mkdir($output_path);
		}
		$files = glob($output_path . '*');
		foreach($files as $file)
		{
			if(is_file($file)) 
			{
				unlink($file);
			}
		}
		
		echo "--------------------\n";
		echo __METHOD__ . "\n";
		echo "--------------------\n";
		echo "Invalid file type";
		echo "\n\n";
		$result = $this->upload->do_upload_resize('file201', 200, 100, $output_path);
		var_dump($result) . "\n";
		echo "\n";
	}
	
}
