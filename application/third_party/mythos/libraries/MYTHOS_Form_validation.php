<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(SYSDIR . '/libraries/Form_validation.php');

class MYTHOS_Form_validation extends CI_Form_validation {
	private $form_group_rules = array();
	public function __construct($rules = array())
	{
		parent::__construct($rules);
		$this->set_message('time', 'The %s field must contain a time.');
		$this->set_message('date', 'The %s field must contain a valid date.');
		$this->set_message('datetime', 'The %s field must contain a valid date and time.');
	}	
	
	/*
	Override parent function to allow jquery_validator() function to read
	the rules even if a form was not submitted.
	*/
	public function set_rules($field, $label = '', $rules = '', $form_id = '')
	{
		if($form_id == '') //continue with CI's set_rules()
		{
			// Removed this for jQuery validation script
			/*
			// No reason to set rules if we have no POST data
			if (count($_POST) == 0)
			{
				return $this;
			}
			*/

			// If an array was passed via the first parameter instead of indidual string
			// values we cycle through it and recursively call this function.
			if (is_array($field))
			{
				foreach ($field as $row)
				{
					// Houston, we have a problem...
					if ( ! isset($row['field']) OR ! isset($row['rules']))
					{
						continue;
					}

					// If the field label wasn't passed we use the field name
					$label = ( ! isset($row['label'])) ? $row['field'] : $row['label'];

					// Here we go!
					$this->set_rules($row['field'], $label, $row['rules']);
				}
				return $this;
			}

			// No fields? Nothing to do...
			if ( ! is_string($field) OR  ! is_string($rules) OR $field == '')
			{
				return $this;
			}

			// If the field label wasn't passed we use the field name
			$label = ($label == '') ? $field : $label;

			// Is the field name an array?  We test for the existence of a bracket "[" in
			// the field name to determine this.  If it is an array, we break it apart
			// into its components so that we can fetch the corresponding POST data later
			if (strpos($field, '[') !== FALSE AND preg_match_all('/\[(.*?)\]/', $field, $matches))
			{
				// Note: Due to a bug in current() that affects some versions
				// of PHP we can not pass function call directly into it
				$x = explode('[', $field);
				$indexes[] = current($x);

				for ($i = 0; $i < count($matches['0']); $i++)
				{
					if ($matches['1'][$i] != '')
					{
						$indexes[] = $matches['1'][$i];
					}
				}

				$is_array = TRUE;
			}
			else
			{
				$indexes	= array();
				$is_array	= FALSE;
			}

			// Build our master array
			$this->_field_data[$field] = array(
				'field'				=> $field,
				'label'				=> $label,
				'rules'				=> $rules,
				'is_array'			=> $is_array,
				'keys'				=> $indexes,
				'postdata'			=> NULL,
				'error'				=> ''
			);

			return $this;
		}
		else
		{
			$rule_set = array();
			$rule_set['field'] = $field;
			$rule_set['label'] = $label;
			$rule_set['rules'] = $rules;
			$this->form_group_rules[$form_id][] = $rule_set;
			return $this;
		}
	}
	
	// Override parent function to return true if there are no validation rules set, accepting the form as valid.
	public function run($group = '')
	{
		if(count($this->_field_data) == 0)
		{
			return true;
		}
		else
		{
			return parent::run($group);
		}
	}
	
	public function run_form($form_id)
	{
		foreach($this->form_group_rules[$form_id] as $rule_set)
		{
			$this->set_rules($rule_set['field'], $rule_set['label'], $rule_set['rules']);
		}
		return $this->run();
	}
	
	public function min($str, $min)
	{
		if ( ! is_numeric($str))
		{
			return FALSE;
		}
		return $str >= $min;
	}
	
	public function max($str, $max)
	{
		if ( ! is_numeric($str))
		{
			return FALSE;
		}
		return $str <= $max;
	}
	
	public function time($str)
	{
		return preg_match('/^([0-1]\d|2[0-3]):([0-5]\d):([0-5]\d)$/', $str);
	}
	
	public function date($str)
	{
		$date = explode('-', $str);
		
		if(count($date) == 3)
		{
			return checkdate($date[1], $date[2], $date[0]);
		}
		else
		{
			return false;
		}
	}
	
	public function datetime($str)
	{
		$datetime = explode(' ', $str, 2);
		if(count($datetime) == 2)
		{
			return $this->date($datetime[0]) && $this->time($datetime[1]);
		}
		else
		{
			return false;
		}
	}
	
	/*
	Generates the jQuery validator instance based on the validation rules set in this class.
	*/
	public function jquery_validator()
	{
		$field_data = $this->_field_data;

		if(count($field_data) > 0 || count($this->form_group_rules) > 0)
		{
			$jquery_validate = <<<EOT
<script type="text/javascript">
$(function() {

EOT;
			if(count($field_data) > 0)
			{
				$jquery_rules = $this->build_jquery_rules($field_data);
				$json_rules = json_encode($jquery_rules);
			
				$jquery_validate .= <<<EOT
	$('form').validate({"rules": {$json_rules}});

EOT;
			}
			elseif(count($this->form_group_rules) > 0)
			{
				foreach($this->form_group_rules as $form_id => $form_group_rule)
				{
					$jquery_rules = $this->build_jquery_rules($form_group_rule);
					$json_rules = json_encode($jquery_rules);
				
					$jquery_validate .= <<<EOT
		$('form#{$form_id}').validate({rules: {$json_rules}});

EOT;
				}
			}
			$jquery_validate .= <<<EOT
});
</script>

EOT;
			return $jquery_validate;
		}
		else
		{
			return false;
		}
	}
	
	public function build_jquery_rules($field_data = array())
	{
		$jquery_rules = array();
		foreach($field_data as $field_validation)
		{
			$field = $field_validation['field'];
			$rules = explode('|', $field_validation['rules']);
			
			$jquery_field_rules = array();
			foreach($rules as $rule)
			{
				$rule_params = explode('[', $rule);
				$rule_name = $rule_params[0];
				if(count($rule_params) == 2)
				{
					$rule_value = substr($rule_params[1], 0, -1);
				}
				
				switch($rule_name)
				{
					case 'required':
						$jquery_field_rules['required'] = true;
						break;
					case 'matches':
						$jquery_field_rules['matches'] = array($rule_value);
						break;
					case 'min_length':
						$jquery_field_rules['minlength'] = array($rule_value);
						break;
					case 'max_length':
						$jquery_field_rules['maxlength'] = array($rule_value);
						break;
					case 'exact_length':
						$jquery_field_rules['exactlength'] = array($rule_value);
						break;
					case 'min':
						$jquery_field_rules['min'] = array($rule_value);
						break;
					case 'max':
						$jquery_field_rules['max'] = array($rule_value);
						break;
					case 'greater_than':
						$jquery_field_rules['greaterthan'] = array($rule_value);
						break;
					case 'less_than':
						$jquery_field_rules['lessthan'] = array($rule_value);
						break;
					case 'alpha':
						$jquery_field_rules['lettersonly'] = true;
						break;
					case 'alpha_numeric':
						$jquery_field_rules['alphanumeric'] = true;
						break;
					case 'alpha_dash':
						$jquery_field_rules['alphadash'] = true;
						break;
					case 'numeric':
						$jquery_field_rules['number'] = true;
						break;
					case 'integer':
						$jquery_field_rules['integer'] = true;
						break;
					case 'decimal':
						$jquery_field_rules['decimal'] = true;
						break;
					case 'is_natural':
						$jquery_field_rules['digits'] = true;
						break;
					case 'is_natural_no_zero':
						$jquery_field_rules['naturalnozero'] = true;
						break;
					case 'valid_email':
						$jquery_field_rules['email'] = true;
						break;
					case 'valid_emails':
						die('valid_emails not supported by framework');
						break;
					case 'valid_ip':
						$jquery_field_rules['ipv4'] = true;
						break;
					case 'valid_base64':
						die('valid_base64 not supported by framework');
						break;
					case 'time':
						$jquery_field_rules['time'] = true;
						break;
					case 'date':
						$jquery_field_rules['date'] = true;
						break;
					case 'datetime':
						$jquery_field_rules['datetime'] = true;
						break;
				}
			}
			$jquery_rules[$field] = $jquery_field_rules;
		}
		return $jquery_rules;
	}
	
	public function get_fields($form_id = '')
	{
		if($form_id == '')
		{
			return array_keys($this->_field_data);
		}
		else
		{
			return array_keys($this->form_group_rules[$form_id]);
		}
	}
	
}
