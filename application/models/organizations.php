<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Basic functions
 */

Class Organizations extends CI_Model {
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	    }
	    
	    function make_org_array($orgs){
	    	if(!is_array($orgs)){
	    		if($this->authenticate->check_auth() && $orgs =='all'){
	    			$orgs = $this->get_orgs();
	    		} else {
	    			return FALSE;
	    		}
	    	}
	    	return $orgs;
	    }

	    function get_orgs($archive = FALSE){
	    	$this->db->from('organization');
	    	if(!$archive){
	    		$this->db->where('dateremoved <=',0);
	    	}
	    	$query = $this->db->get();
	    	$result = $query->result();
	    	return $result;
	    }
	    
	    function get_org_by_id($ID){
	    	$query = $this->db->get_where('organization', array('ID' => $ID), 1);
	    	$result = $query->result();
	    	if(isset($result[0])){
	    		return $result[0];
	    	} else {
	    		return FALSE;
	    	}
	    }
	    
	    function get_org_by_name($name){
	    	$query = $this->db->get_where('organization', array('name' => $name), 1);
	    	$result = $query->result();
	    	if(isset($result[0])){
	    		return $result[0];
	    	} else {
	    		return FALSE;
	    	}
	    }
	    
	    function add_org($data){
	    	$db_data = array(
	    			'name' => $data['name'],
	    			'slug' => $this->increment_slug(post_slug($data['name']),'organization'),
	    			'description' => $data['description'],
	    			'dateadded' => time(),
	    	);
	    	$this->db->insert('organization',$db_data);
	    	return $this->db->insert_id();
	    }
	    
	    function edit_org($ID,$data){
	    	$db_data = $data;
	    	$this->db->where('ID', $ID);
	    	$this->db->update('organization',$db_data);
	    }
	    
	    
	    
	    
	    
	 function get_all_users($suspended = FALSE){
	 	$this->db->select('user.ID AS ID,email,firstname,lastname,user.accesslevel AS accesslevel,user.dateadded AS dateadded,user.dateremoved AS dateremoved,user_group.name AS group_name,user_group.accesslevel AS group_accesslevel');
		$this->db->from('user');
		$this->db->join('user_group','user.group_id=user_group.ID','left');
		if(!$suspended){
			$this->db->where('user.dateremoved <=',0);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->result();
			$i=0;
			foreach($result AS $row){
				$useraccess = $this->authenticate->levelinfo($row->accesslevel);
				$groupaccess = $this->authenticate->levelinfo($row->group_accesslevel);
				$result[$i]->access = ucwords($useraccess['name']);
				$result[$i]->group_access = ucwords($groupaccess['name']);
				$i++;
			}
			return $result;
		}
	 }	

	
	function get_users_by_level($level,$suspended = FALSE){
		$levels = $this->authenticate->get_levels();
		if(!is_numeric($level)){
			$level = array_search($level,$levels);
		} 
		$this->db->select('user.ID AS ID,email,firstname,lastname,user_group.name AS group_name,user_group.accesslevel AS group_accesslevel');
		$this->db->from('user');
		$this->db->join('user_group','user.group_id=user_group.ID','left');
		if(!$suspended){
			$this->db->where('user.dateremoved <=',0);
		}
		$this->db->where('user.accesslevel',$level);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->result();
			return $result;
		}else{
			return 'There are no users'; //this should never happen
		}
	}
	/*
	 * Get user: identical to login except doesn't require a password.
	 */
	function get_user($uid){ 
		$this->db->select('user.ID AS ID,email,firstname,lastname,user.accesslevel AS accesslevel,user.dateremoved AS dateremoved, user.group_id AS group_id, user_group.name AS group_name,user_group.accesslevel AS group_accesslevel');
		$this->db->from('user');
		$this->db->join('user_group','user.group_id=user_group.ID','left');
		$this->db->where('user.ID = \''.$uid.'\'');
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() == 1){
			$result = $query->result();
			if($result[0]->dateremoved > 0){
				return 'Account Suspended';
			}
			return $result[0];
		}else{
			return 'User does not exist';
		}	
	}
	 function add_user($data){
		$db_data = $data;
		$db_data['dateadded'] = time();
		
		$this->db->insert('user',$db_data);
		return $this->db->insert_id();
	 }
	 function edit_user($ID,$data){
		$db_data = $data;
		$this->db->where('ID',$ID);
		$this->db->update('user',$db_data);
	 }
	 
	 function get_all_user_groups(){
	 	$this->db->select('ID,name');
	 	$query = $this->db->get('user_group');
	 	$result = $query->result();
	 	return $result;
	 }
}
/* End of file users.php */
/* Location: ./application/models/users.php */