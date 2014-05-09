<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Basic functions
 */

Class Users extends CI_Model {
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
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
		$this->db->select('user.ID AS ID,email,firstname,lastname,terms_accepted,user.accesslevel AS accesslevel,user.dateremoved AS dateremoved, user.group_id AS group_id, user_group.name AS group_name,user_group.accesslevel AS group_accesslevel');
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
			$result[0]->meta = $this->get_user_metas($uid);
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
	 
	 function edit_user_meta($data){
	 	$meta_id = $this->get_user_meta($data);
	 	if($meta_id){
			$this->db->where('ID',$meta_id);
	 		$this->db->update('user_meta',$data);
	 	} else {
	 		$this->add_user_meta($data);
	 	}
	 }
	 
	 function add_user_meta($data){
		$db_data = $data;
		$db_data['dateadded'] = time();
		$this->db->insert('user_meta',$db_data);
		return $this->db->insert_id();
	 }
	 
	 function get_user_meta($data){
	 	$this->db->select('ID');
	 	$this->db->where('user_id',$data['user_id']);
	 	$this->db->where('org_id',$data['org_id']);
	 	$this->db->where('meta_key',$data['meta_key']);
	 	$this->db->where('dateremoved', 0);
	 	$query = $this->db->get('user_meta');
	 	$result = $query->result();
	 	if($result){
	 		return $result[0]->ID;
	 	}
	 }
	 
	 function get_user_metas($ID){
	 	$this->db->select('ID,org_id,meta_key,meta_value,dateremoved');
	 	$this->db->from('user_meta');
	 	$this->db->where('dateremoved',0);
	 	$this->db->where('user_id',$ID);
		$query = $this->db->get();
		$result = $query->result();
        if($result){
    		foreach($result AS $r){
    			$metas[$r->meta_key] = $r;
    		}
    		return $metas;
        }
	 }
     
     function add_user_org($data){
        $db_data = $data;
        $db_data['dateadded'] = time();
        $this->db->insert('user2org',$db_data);
        return $this->db->insert_id();
     }
     
     function edit_user_org($data){
         
     }
     
     function get_user_orgs($ID){
        $this->db->select('ID,user_id,org_id,access_level,terms_accepted');
        $this->db->from('user2org');
        $this->db->where('dateremoved',0);
        $this->db->where('user_id',$ID);
        $query = $this->db->get();
        $result = $query->result();
        if($result){
            return $result;
        }
     }
     
     function delete_user_orgs($ID){
        $this->db->where('user_id',$ID);
        $this->db_update(array('dateremoved'=>time()));
     }
}
/* End of file users.php */
/* Location: ./application/models/users.php */