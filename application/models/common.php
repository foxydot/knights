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

		function get_story_by_slug($slug)
		{
			$this->db->select('story.ID AS ID,title,lastedit,datepresented,datepublished,datearchived,project.ID AS project_id,name');
			$this->db->from('story');
			$this->db->join('project','story.project_id=project.ID','left');
			$this->db->where('slug = \''.$slug.'\'');
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				$result = $query->result();
				return $result[0];
			}else{
				return 'Project not found.';
			}	
		}
		
		function get_story_by_id($id)
		{
			$this->db->select('title,slug,lastedit,datepresented,datepublished,datearchived,project.ID AS project_id,name');
			$this->db->from('story');
			$this->db->join('project','story.project_id=project.ID','left');
			$this->db->where('ID = \''.$id.'\'');
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				$result = $query->result();
				return $result[0];
			}else{
				return 'Project not found.';
			}	
		}		
}
/* End of file common.php */
/* Location: ./application/models/common.php */