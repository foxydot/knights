<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

if(!function_exists('clean_url'))
{
    function clean_url($url){
            return preg_replace('/[^a-zA-Z0-9\_\-\?\&\+\.\/\:]/i','',$url);
        }
}

if(!function_exists('get_the_fee'))
{
function get_the_fee($post){
        switch($post->type){
            case 'business-professional':
            case 'businesses-professional':
                $fee = 250;
                break;
            case 'business-personal':
            case 'businesses-personal':
                $fee = 40;
                break;
            case 'business-student':
            case 'businesses-student':
            case 'service':
                $fee = 20;
                break;
            case 'student-service':
            case 'student-services':
            case 'request':
                $fee = 5;
                break;
            case 'product':
            default:
                $cost = (float) $post->cost;
                if($cost<=10){
                    $fee = 0;
                } elseif($cost<=100){
                    $fee = .1*$cost;
                } elseif($cost>100 && $cost<=1000) {
                    $fee = (.05*($cost-100))+10;
                } else {
                    $fee = (.02*($cost-1000))+55;
                }
                break;
        }
        return $fee;
    }
}
if(!function_exists('preg_replacement_quote'))
{
function preg_replacement_quote($str) {
    return preg_replace('/(\$|\\\\)(?=\d)/', '\\\\\1', $str);
}
}

if(!function_exists('wildcard_replacements'))
{
function wildcard_replacements($str) {
        global $org_id,$org_name,$site_title,$site_logo,$theme_url;
        $pattern = array(
            '/__ORGANIZATION_LOGO__/',
            '/__ORGANIZATION_NAME__/',
            '/__SITE_TITLE__/',
        );
        $replacement = array(
            preg_replacement_quote($site_logo),
            preg_replacement_quote($org_name),
            preg_replacement_quote($site_title),
        );
        return(preg_replace($pattern, $replacement, $str));
}
}
