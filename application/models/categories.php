<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for administration of data
 */
Class Categories extends CI_Model {
	private $cookie_domain;
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	        $this->cookie_domain = $_SERVER['SERVER_NAME'];
	        $this->load->model('Organizations','Orgs');
	    }
		
	function get_cats($orgs = array(),$archive = FALSE){
		$orgs = $this->Orgs->make_org_array($orgs);
		$this->db->from('category');
		if(!$archive){
			$this->db->where('dateremoved <=',0);
		}
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	 
	function get_cat($cat_id){
		$this->db->from('category');
		$this->db->where('ID',$cat_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	function add_cat($db_data){
		unset($db_data['ID']);
		unset($db_data['submit']);
	 	$slug = $this->common->increment_slug(post_slug($db_data['title']),'category');
		$db_data['slug'] = $slug;
		$db_data['dateadded'] = time();

	 	$this->db->insert('category',$db_data);
	 	return $this->db->insert_id();
	 }	
	 
	 function edit_cat($db_data){
		unset($db_data['submit']);
		$this->db->where('ID',$db_data['ID']);
	 	$this->db->update('category',$db_data);
	 }
	 

	 function get_post_cats($post_id){
	 	$this->db->from('post2cat');
	 	$this->db->join('category','post2cat.cat_id=category.ID');
	 	$this->db->where('post2cat.post_id',$post_id);
	 	$query = $this->db->get();
	 	$result = $query->result();
	 	return $result;
	 }
	 
	 function get_post_cats_ids($post_id){
	 	$postcats = $this->get_post_cats($post_id);
	 	foreach($postcats AS $cat){
	 		$ids[] = $cat->cat_id;
	 	}
	 	$postcats['ids'] = $ids;
	 	return $postcats;
	 }
}