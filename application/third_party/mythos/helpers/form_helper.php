<?php
function validation_errors($prefix = '', $suffix = '')
{
	$CI =& get_instance();
	$form_validation = $CI->form_validation;
		
	if (FALSE === $form_validation)
	{
		return '';
	}

	return $form_validation->error_string($prefix, $suffix);
}

require_once(dirname(__FILE__) . '/../../../../system/helpers/form_helper.php');