<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for administration of data
 */
Class Posts extends CI_Model {
	private $cookie_domain;
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	        $this->cookie_domain = $_SERVER['SERVER_NAME'];
	        $this->load->model('Organizations','Orgs');
	        $this->load->model('Categories','Cats');
	    }
	    
	function get_cats_and_posts($orgs = array(),$archive = FALSE){
	    	$orgs = $this->Orgs->make_org_array($orgs);
	    	$cats = $this->Cats->get_cats($orgs);
	    	$i = 0;
	    	foreach($cats AS $cat){
	    		$cats[$i]->posts = $this->get_posts($cat->ID,$archive);
	    		$i++;
	    	}
	    	return $cats;
	    }

	function get_posts($cat_id=NULL,$archive=FALSE){
		if($cat_id){
			$this->db->from('post2cat');
			$this->db->join('post','post.ID=post2cat.post_id');
			$this->db->where('post2cat.cat_id',$cat_id);
		} else {
			$this->db->from('post');
		}
		$this->db->join('user','post.author_id=user.ID');
		if(!$archive){
			$this->db->where('post.dateremoved <=',0);
		}
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function get_post($post_id){
		$this->db->select('*, post.ID as post_id');
		$this->db->from('post');
		$this->db->join('user','post.author_id=user.ID');
		$this->db->where('post.ID',$post_id);
		$this->db->limit(1);
		$query = $this->db->get();
		$result = $query->result();
		$result = $result[0];
		$result->postcats = $this->Cats->get_post_cats_ids($post_id);
		return $result;
	}
	
	function add_post($db_data){
		unset($db_data['ID']);
		unset($db_data['submit']);
		$slug = $this->common->increment_slug(post_slug($db_data['title']),'post');
		$db_data['slug'] = $slug;
		$db_data['dateadded'] = time();
	
		$this->db->insert('post',$db_data);
		return $this->db->insert_id();
	}
	
	function edit_post($db_data){
		unset($db_data['submit']);
		$db_data['lastedit'] = time();
		$this->db->where('ID',$db_data['ID']);
		$this->db->update('post',$db_data);
	}	
	
	function post_to_cat($db_data){
		unset($db_data['submit']);
		$this->db->insert('post2cat',$db_data);
	}
		
	function edit_post_to_cat($db_data){
		unset($db_data['submit']);
		$this->db->where('ID', $db_data['post2cat_id']);
		$this->db->update('post2cat',$db_data);
	}
}