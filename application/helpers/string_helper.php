<?php
/*
 * Create a page slug on the fly
*/
if(!function_exists('post_slug'))
{
	function post_slug($str)
	{
		return strtolower(preg_replace(array('/[^a-zA-Z0-9_ -]/', '/[ -]+/', '/^-|-$/'),
				array('', '-', ''), $str));
	}
}