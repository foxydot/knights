<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organizations extends CI_Model {
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
	    
	    function get_org($ID){
	    	$query = $this->db->get_where('organization', array('ID' => $ID), 1);
	    	$result = $query->result();
	    	if(isset($result[0])){
	    		$result[0]->meta = $this->get_org_meta($ID);
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
	    
	    function add_org($db_data){
	    	unset($db_data['ID']);
	    	unset($db_data['submit_btn']);
	    	$slug = $this->common->increment_slug(post_slug($db_data['name']),'organization');
	    	$db_data['slug'] = $slug;
	    	$db_data['dateadded'] = time();
	    
	    	$this->db->insert('organization',$db_data);
	    	return $this->db->insert_id();
	    }
	    
	    function edit_org($db_data){
	    	unset($db_data['submit_btn']);
	    	$this->db->where('ID',$db_data['ID']);
	    	$this->db->update('organization',$db_data);
	    }
	    
	    function add_org_meta($db_data){
	    	$this->db->insert('org_meta',$db_data);
	    	return $this->db->insert_id();
	    }
	    
	    function edit_org_meta($db_data){
	        if(isset($db_data['ID'])){
    	    	$this->db->where('ID',$db_data['ID']);
    	    	$this->db->update('org_meta',$db_data);
            } else {
                $this->add_org_meta($db_data);
            }
	    }
	    
	    function get_org_meta($org_id,$field = false){
	    	$this->db->from('org_meta');
	    	$this->db->where('org_id',$org_id);
	    	if($field){
	    		$this->db->where('meta_key',$field);
	    	}
	    	$query = $this->db->get();
	    	if($result = $query->result()){
		    	foreach($result AS $k=>$v){
		    		$sortedresult[$v->meta_key]=$v;
		    	}
		    	return $sortedresult;
	    	} else {
	    	    return FALSE;
	    	}
	    }
		    
}
/* End of file organizations.php */
/* Location: ./application/models/organizations.php */