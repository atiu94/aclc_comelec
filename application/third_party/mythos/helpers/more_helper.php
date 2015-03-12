<?php
/*
Clips a plain text string based on the number of characters.
*/
function more_by_characters($plain_text, $max_char_count = false, $ellipsis = false)
{
	$CI =& get_instance();
	$config = $CI->config->item('more_helper', 'mythos');
	
	if($max_char_count === false)
	{
		$max_char_count = $config['max_char_count'];
	}
	
	if($ellipsis === false)
	{
		$ellipsis = $config['ellipsis'];
	}	
	
	$plain_text = trim(strip_tags($plain_text));
	$clipped = trim(substr($plain_text, 0, $max_char_count));
	if(strlen($plain_text) > strlen($clipped))
	{
		$clipped .= $ellipsis;
	}
	return $clipped;
}

/*
Clips a plain text string based on the number of words.
*/
function more_by_words($plain_text, $max_word_count = null, $ellipsis = null)
{
	$CI =& get_instance();
	$config = $CI->config->item('more_helper', 'mythos');
	
	if($max_word_count === false)
	{
		$max_word_count = $config['max_word_count'];
	}
	
	if($ellipsis === false)
	{
		$ellipsis = $config['ellipsis'];
	}	
	
	$plain_text = trim(strip_tags($plain_text));
	$word_array = explode(' ', $plain_text);
	$word_array = array_slice($word_array, 0, $max_word_count);
	$clipped = trim(implode(' ', $word_array));
	
	if(strlen($plain_text) > strlen($clipped))
	{
		$clipped .= $ellipsis;
	}
	return $clipped;
}