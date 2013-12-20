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
		$this->db->select('category.ID AS ID,title,slug,description,category.dateadded AS dateadded,parent_cat_id');
		$this->db->from('category');
		$this->db->join('cat2org','category.ID=cat2org.cat_id','left outer');
        $this->db->order_by("category.title", "asc"); 
		if(!$archive){
			$this->db->where('category.dateremoved <=',0);
		}
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	 
	function get_cat($cat_id){
		$this->db->select('category.ID AS ID,title,slug,description,category.dateadded AS dateadded,parent_cat_id');
		$this->db->from('category');
		$this->db->join('cat2org','category.ID=cat2org.cat_id','left outer');
		$this->db->where('category.ID',$cat_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	function add_cat($db_data){
		unset($db_data['ID']);
		unset($db_data['submit_btn']);
	 	$slug = $this->common->increment_slug(post_slug($db_data['title']),'category');
		$db_data['slug'] = $slug;
		$db_data['dateadded'] = time();

	 	$this->db->insert('category',$db_data);
	 	return $this->db->insert_id();
	 }	
	 
	 function edit_cat($db_data){
		unset($db_data['submit_btn']);
		$this->db->where('ID',$db_data['ID']);
	 	$this->db->update('category',$db_data);
	 }
	 

	 function get_post_cats($post_id){
	 	$this->db->from('post2cat');
	 	$this->db->join('category','post2cat.cat_id=category.ID');
	 	$this->db->join('cat2org','category.ID = cat2org.cat_id');
	 	$this->db->where('post2cat.post_id',$post_id);
	 	$this->db->where('cat2org.org_id',1);
	 	$query = $this->db->get();
	 	$result = $query->result();
	 	if($result){
	 		foreach($result AS $k=>$cat){
	 			$result[$k]->catpath = implode('/',array_reverse($this->create_catpath($cat)));
	 		}
	 	}
	 	return $result;
	 }
	 
	 function get_post_cats_ids($post_id){
	 	$postcats = $this->get_post_cats($post_id);
	 	$ids = array();
	 	if($postcats){
		 	foreach($postcats AS $cat){
		 		$ids[] = $cat->cat_id;
		 	}
	 	}
	 	$postcats['ids'] = $ids;
	 	return $postcats;
	 }

	 function cat_to_org($db_data){
	 	unset($db_data['submit_btn']);
	 	$this->db->insert('cat2org',$db_data);
	 }
	 	
	 function clear_cat_to_org($cat_id){
	 	$this->db->where('cat_id',$cat_id);
	 	$this->db->delete('cat2org');
	 }
	 
	 function group_cats_by_parent($cats){
	 	$allcats = array();
	 	if($cats){
		 	foreach($cats AS $cat){
		 		$allcats[$cat->parent_cat_id][$cat->ID] = $cat;
                $allcats[$cat->parent_cat_id][$cat->ID]->isparent = $this->cat_has_children($cat);
		 	}
	 	}
	 	return $allcats;
	 }
	 
	 function cat_has_children($cat,$org_id = 1){
	 	$this->db->from('cat2org');
	 	$this->db->where('org_id',$org_id);
	 	$this->db->where('parent_cat_id',$cat->ID);
	 	$query = $this->db->get();
	 	$result = $query->result();
	 	if($result){
	 		return true;
	 	} else {
	 		return false;
	 	}
	 }
	 
	 /**
	  * TODO: Maybe alter this to provide a breadcrumb like feature for posting if we create individual listing pages for categories
	  * 
	  */
	 function create_catpath($cat,$path=array()){
	 	$path[] = $cat->title;
	 	if($cat->parent_cat_id != 0){
	 		$parent = $this->get_cat($cat->parent_cat_id);
	 		$path = $this->create_catpath($parent,$path);
	 	} 
	 	return $path;
	 }
}