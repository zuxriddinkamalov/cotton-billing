<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function go_to($url=FALSE)
{
	if($url) 
		$to = $url;
	else
		$to = $_SERVER['HTTP_REFERER'];
	redirect($to);
}