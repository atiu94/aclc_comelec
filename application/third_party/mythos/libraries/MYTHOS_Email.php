<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(SYSDIR . '/libraries/Email.php');

class MYTHOS_Email extends CI_Email 
{
	private $CI;
	
	public function __construct() 
	{
		parent::__construct();
		$this->CI =& get_instance();
		$this->CI->load->library('email');
	}
	
	public function send_mail($mail_to,$subject,$params = array(), $template_folder = 'email', $template_view = 'template',$debug=false)
	{
		$template_params = array();
		$template_params['template'] = $params;
		$html_message = $this->CI->template->get_view($template_view, $template_params, $template_folder, true);
		if ($debug)
		{
			return $html_message;
		}
		else 
		{
			$email_config = $this->CI->config->load('email', TRUE);
			$from_email = $this->CI->config->item('from_email', 'email');
			$from_email_name = $this->CI->config->item('from_email_name', 'email');
			
			$config['useragent'] = $this->CI->config->item('useragent', 'email');
			$config['protocol'] = $this->CI->config->item('protocol', 'email');
			$config['mailpath'] = $this->CI->config->item('mailpath', 'email');

			$config['smtp_host'] = $this->CI->config->item('smtp_host', 'email');
			$config['smtp_user'] = $this->CI->config->item('smtp_user', 'email');
			$config['smtp_pass'] = $this->CI->config->item('smtp_pass', 'email');
			$config['smtp_port'] = $this->CI->config->item('smtp_port', 'email');
			$config['smtp_timeout'] = $this->CI->config->item('smtp_timeout', 'email');

			$config['wordwrap'] = $this->CI->config->item('wordwrap', 'email');
			$config['wrapchars'] = $this->CI->config->item('wrapchars', 'email');
			$config['mailtype'] = $this->CI->config->item('mailtype', 'email');
			$config['charset'] = $this->CI->config->item('charset', 'email');

			$config['validate'] = $this->CI->config->item('validate', 'email');
			$config['priority'] = $this->CI->config->item('priority', 'email');

			$config['crlf'] = $this->CI->config->item('crlf', 'email');
			$config['newline'] = $this->CI->config->item('newline', 'email');

			$config['bcc_batch_mode'] = $this->CI->config->item('bcc_batch_mode', 'email');
			$config['bcc_batch_size'] = $this->CI->config->item('bcc_batch_size', 'email');
				
			$this->CI->email->initialize($config);
			$this->CI->email->subject($subject);
			$this->CI->email->message($html_message);
			$this->CI->email->to($mail_to);
			$this->CI->email->from($from_email, $from_email_name);
			if( $this->CI->email->send() )
			{
				return true;
			}
			else
			{
				return $this->CI->email->print_debugger();
			}
		}
	}
}