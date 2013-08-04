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
	    	unset($db_data['submit']);
	    	$slug = $this->common->increment_slug(post_slug($db_data['title']),'organization');
	    	$db_data['slug'] = $slug;
	    	$db_data['dateadded'] = time();
	    
	    	$this->db->insert('organization',$db_data);
	    	return $this->db->insert_id();
	    }
	    
	    function edit_org($db_data){
	    	unset($db_data['submit']);
	    	$this->db->where('ID',$db_data['ID']);
	    	$this->db->update('organization',$db_data);
	    }
	    
	    function add_org_meta($db_data){
	    	$this->db->insert('org_meta',$db_data);
	    	return $this->db->insert_id();
	    }
	    
	    function edit_org_meta(){}
	    
}
/* End of file organizations.php */
/* Location: ./application/models/organizations.php */