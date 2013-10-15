<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Basic functions
 */

Class Common extends CI_Model {
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	    }
	    
	function checkinstallation(){
		if($this->db->table_exists('system_info')){
			return true;
		} else {
			return false;
		}
	}

	function getSystemInfo(){
		if($this->session->userdata['accesslevel'] > 10){
			return false;
		} else {
			if($this->db->table_exists('system_info')){
				$query = $this->db->get('system_info');
				$result = $query->result();
				foreach($result AS $item){
					$data[$item->sysinfo_key] = $item->sysinfo_value;
				}
				return $data;
			} else {
				return false;
			}
		}
	}
	
	function is_author($author_id,$element_author_id){
		if($author_id==$element_author_id){
			return TRUE;
		} else {
			return FALSE;
		}
	}
    
    function get_sysadmin_item($key,$single = TRUE){
        $query = $this->db->get_where('system_info',array('sysinfo_key' => $key),1);
        $result = $query->result();
        if($single){
            return $result[0];
        } else {
            return $result;
        }
    }
    
    function get_org_info_from_subdomain(){
        global $org_id,$site_title;
        $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2); //creates the various parts  
        $subdomain = $subdomain_arr[0]; //assigns the first part  
        $query = $this->db->get_where('org_meta',array('meta_key' => 'subdomain','meta_value' => $subdomain),1);
        $result = $query->result();
        $org_id = $result[0]->org_id;
        $this->db->select('meta_value');
        $query = $this->db->get_where('org_meta',array('meta_key' => 'site_title','org_id' => $org_id),1);
        $result = $query->result();
        $site_title = $result[0]->meta_value;
        if($site_title == ''){
            define('SITENAME', 'Community List');
        } else {
            define('SITENAME', $site_title);
        }
    }
	
	/*
	 * Convert a timestamp into increments of ago.
	 */
	function nicetime($date)
	{
	    if(empty($date)) {
	        return "No date provided";
	    }
	   
	    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	    $lengths         = array("60","60","24","7","4.35","12","10");
	   
	    $now             = time();
	    $unix_date       = $date;
	   
	       // check validity of date
	    if(empty($unix_date)) {   
	        return "Bad date";
	    }
	
	    // is it future date or past date
	    if($now > $unix_date) {   
	        $difference     = $now - $unix_date;
	        $tense         = "ago";
	       
	    } else {
	        $difference     = $unix_date - $now;
	        $tense         = "from now";
	    }
	   
	    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	        $difference /= $lengths[$j];
	    }
	   
	    $difference = round($difference);
	   
	    if($difference != 1) {
	        $periods[$j].= "s";
	    }
	   
	    return "$difference $periods[$j] {$tense}";
	}
		
		function remove_null_values($a){
			return(!empty($a));
		}
		
		function strip_html($string){
			if(is_array($string) || is_object($string)){
				$array = $string;
				$string = '';
				foreach($array AS $k => $v){
					$string .= $k.': '.$v.'<br/>'."\n";
				}
			}
			return preg_replace("/<\/?(?i:script|embed|object|frameset|frame|iframe|meta|link|style)(.|\\\n)*?>/i", "", $string); 
		}
		
		function increment_slug($test_slug,$table){
			if(!$this->slug_exists($test_slug,$table)){
				return $test_slug;
			}
			$i = 0;
			do {
				$new_slug = $test_slug.'-'.$i;
				$i++;
			} while($this->slug_exists($new_slug,$table));
			return $new_slug;
		}
		
		function slug_exists($test_slug,$table){
			$query = $this->db->get_where($table,array('slug'=>$test_slug));
			if($query->num_rows()>0){
				return TRUE;
			} else {
				return FALSE;
			}
		}
	
	function object_from_array($array_of_object,$key,$value,$unique = TRUE){
		if($unique){
			foreach($array_of_object AS $obj){
				if($obj->$key == $value){
					return $obj;
				}
			}
			return FALSE;
		} else {
			foreach($array_of_object AS $obj){
				if($obj->$key == $value){
					$new_array[] = $obj;
				}
			}
			if(!empty($new_array)){
				return $new_array;
			} else {
				return FALSE;
			}
		}
		
	}
	
}
/* End of file common.php */
/* Location: ./application/models/common.php */