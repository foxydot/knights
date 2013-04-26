<?php
/*
 * Add page specific CSS by passing a string or array.
*/
if(!function_exists('page_css'))
{
	function page_css($page_css = NULL)
	{
		$ret = '';
		if(isset($page_css))
		{
			if(is_array($page_css))
			{
				foreach($page_css AS $css)
				{
					$ret .= '<link rel="stylesheet" href="'.THEME_URL.'/css/'.$css.'.css" type="text/css" />'."\n";
				}
			} else {
		 	$ret = '<link rel="stylesheet" href="'.THEME_URL.'/css/'.$page_css.'.css" type="text/css" />'."\n";
			}
			return $ret;
		} else {
			return false;
		}
	}
}
/*
 * Add page specific JS by passing a string or array.
*/
if(!function_exists('page_js'))
{
	function page_js($page_js = NULL)
	{
		$ret = '';
		if(isset($page_js))
		{
			if(is_array($page_js))
			{
				foreach($page_js AS $js)
				{
					$ret .= '<script src="'.THEME_URL.'/js/'.$js.'.js"></script>'."\n";
				}
			} else {
		 	$ret = '<script src="'.THEME_URL.'/js/'.$page_js.'.js"></script>'."\n";
			}
			return $ret;
		} else {
			return false;
		}
	}
}
/*
 * Add pge specific jQuery by passing a string or array.
*/
if(!function_exists('page_jquery'))
{
	function page_jquery($page_jquery = NULL)
	{
		$ret = '';
		if(isset($page_jquery)){
			$ret .= '<script type="text/javascript">
		 $(document).ready(function() {';
			if(is_array($page_jquery))
			{
				foreach($page_jquery AS $jq)
				{
					$ret .= $jq."\n";
				}
	 	} else {
	 		$ret .= $page_jquery."\n";
	 	}
	 	$ret .= '});
			</script>';
	 	return $ret;
		} else {
			return false;
		}
	}
}