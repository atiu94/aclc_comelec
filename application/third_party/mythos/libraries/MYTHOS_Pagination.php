<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(SYSDIR . '/libraries/Pagination.php');

class MYTHOS_Pagination extends CI_Pagination {

	private $CI;
	private $model;
	private $model_function;
	private $parameters;
	private $page_uri;
	private $query_config;
	
	const PAGE_URL_ID = '__PAGE__';
	
	public function __construct()
	{
		parent::__construct();
		$this->CI =& get_instance();
		
		$this->query_config = array();
		
		$this->query_config = $this->CI->config->item('pagination', 'mythos');
	}
	
	public function set_per_page($value)
	{
		$this->query_config['per_page'] = $value;
	}

	public function set_num_links($value)
	{
		$this->query_config['num_links'] = $value;
	}
	
	public function set_function()
	{
		$parameters = func_get_args();
		$this->model = array_shift($parameters);
		$this->model_function = array_shift($parameters);
		$this->parameters = $parameters[0];
	}
	
	public function run_query($page_uri)
	{
		$this->page_uri = $page_uri;
		
		$uri_segments = explode('/', trim($page_uri, '/'));
		$this->query_config['uri_segment'] = array_search(MYTHOS_Pagination::PAGE_URL_ID, $uri_segments) + 1;
		
		$offset = $this->CI->uri->segment($this->query_config['uri_segment']) - 1 + 1;

		$model = $this->model;
		
		$this->CI->db->select('COUNT(*) AS total_rows');
		$result = call_user_func_array(array($this->CI->$model, $this->model_function), $this->parameters);
		$row = $result->row();
		if(isset($row->total_rows) && is_numeric($row->total_rows))
		{
			$this->query_config['total_rows'] = $row->total_rows;
		}
		else
		{
			// If total_rows did not exist, then query must be a custom query.
			// NOTES: Need to improve this. Has performance issues because it queries for the whole result.
			$result = call_user_func_array(array($this->CI->$model, $this->model_function), $this->parameters);
			$this->query_config['total_rows'] = $result->num_rows();
		}
		
		$this->CI->load->model($model);
		$this->CI->db->limit($this->query_config['per_page'], $offset);
		return call_user_func_array(array($this->CI->$model, $this->model_function), $this->parameters);
	}
	
	public function total_rows()
	{
		return $this->total_rows;
	}
	
	public function query_links()
	{
		$this->initialize($this->query_config); 
		
		return $this->create_query_links();
	}
	
	// Customized create_links() function that uses page_uri instead of the preset base_url
	private function create_query_links()
	{
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
			return '';
		}

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			return '';
		}

		// Determine the current page number.
		$CI =& get_instance();

		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			if ($CI->input->get($this->query_string_segment) != 0)
			{
				$this->cur_page = $CI->input->get($this->query_string_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		else
		{
			if ($CI->uri->segment($this->uri_segment) != 0)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}

		$this->num_links = (int)$this->num_links;

		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}

		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}

		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->cur_page > $this->total_rows)
		{
			$this->cur_page = ($num_pages - 1) * $this->per_page;
		}

		$uri_page_number = $this->cur_page;
		$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;
		
		// Generate pagination base URL from page URI
		$uri = site_url($this->page_uri);		

		// And here we go...
		$output = '';
		
		// Render the "First" link
		if  ($this->first_link !== FALSE AND $this->cur_page > ($this->num_links + 1))
		{
			$first_url = ($this->first_url == '') ? str_replace(MYTHOS_Pagination::PAGE_URL_ID, '', $uri) : $this->first_url;
			$output .= $this->first_tag_open.'<a '.$this->anchor_class.'href="'.$first_url.'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  ($this->prev_link !== FALSE AND $this->cur_page != 1)
		{
			$i = $uri_page_number - $this->per_page;

			if ($i == 0 && $this->first_url != '')
			{
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}
			else
			{
				$i = ($i == 0) ? '' : $this->prefix.$i.$this->suffix;
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.str_replace(MYTHOS_Pagination::PAGE_URL_ID, $i, $uri).'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}
		}

		// Render the pages
		if ($this->display_pages !== FALSE)
		{
			// Write the digit links
			for ($loop = $start -1; $loop <= $end; $loop++)
			{
				$i = ($loop * $this->per_page) - $this->per_page;

				if ($i >= 0)
				{
					if ($this->cur_page == $loop)
					{
						$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
					}
					else
					{
						$n = ($i == 0) ? '0' : $i;

						if ($n == '' && $this->first_url != '')
						{
							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$loop.'</a>'.$this->num_tag_close;
						}
						else
						{
							$n = ($n == '') ? '' : $this->prefix.$n.$this->suffix;

							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.str_replace(MYTHOS_Pagination::PAGE_URL_ID, $n, $uri).'">'.$loop.'</a>'.$this->num_tag_close;
						}
					}
				}
			}
		}

		// Render the "next" link
		if ($this->next_link !== FALSE AND $this->cur_page < $num_pages)
		{
			$output .= $this->next_tag_open.'<a '.$this->anchor_class.'href="'.str_replace(MYTHOS_Pagination::PAGE_URL_ID, $this->prefix.($this->cur_page * $this->per_page).$this->suffix, $uri).'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}

		// Render the "Last" link
		if ($this->last_link !== FALSE AND ($this->cur_page + $this->num_links) < $num_pages)
		{
			$i = (($num_pages * $this->per_page) - $this->per_page);
			$output .= $this->last_tag_open.'<a '.$this->anchor_class.'href="'.str_replace(MYTHOS_Pagination::PAGE_URL_ID, $this->prefix.$i.$this->suffix, $uri).'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;

		return $output;
	}
}
