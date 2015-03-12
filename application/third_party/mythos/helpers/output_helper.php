<?php
/* 
Parses input data and outputs it in JSON format
*/
function output_json($data = array())
{
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
	header("Cache-Control: no-cache, must-revalidate"); 
	header("Pragma: no-cache");
	header("Content-type: application/json");
	
	if(!is_string($data))
	{
		$data = json_encode($data);
	}
	echo $data;
	die();
}