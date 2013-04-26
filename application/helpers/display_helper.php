<?php
/*
 * Add body classes
*/
if(!function_exists('body_classes'))
{
	function body_class($body_class = NULL)
	{
		$ret = '';
		if(isset($body_class)){
			if(is_array($body_class))
			{
				foreach($body_class AS $class)
				{
					$ret .= $class." ";
				}
	 	} else {
	 		$ret .= $body_class;
	 	}
	 	return ' class="'.$ret.'"';
		} else {
			return false;
		}
	}
}

/*
 * Display cleaned up content
*/
if(!function_exists('display'))
{
	function display($str)
	{
		$allowed = "<a><img><br><p><ol><ul><li><b><strong><i><em>";
		return strip_tags($str, $allowed);
	}
}