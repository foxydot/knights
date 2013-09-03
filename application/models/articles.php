<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for administration of articles
 */
Class Articles extends CI_Model {
	private $cookie_domain;
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	        $this->cookie_domain = $_SERVER['SERVER_NAME'];
	        $this->load->model('Organizations','Orgs');
	    }
	
	function get_articles($orgs = array(),$archive = FALSE){
		$orgs = $this->Orgs->make_org_array($orgs);
		$this->db->select('article.ID AS ID,title,slug,excerpt,content,article.dateadded AS dateadded,art2org.parent_art_id AS parent_art_id');
		$this->db->from('article');
		$this->db->join('art2org','article.ID=art2org.art_id','left outer');
		if(!$archive){
			$this->db->where('article.dateremoved <=',0);
		}
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function get_article($article_id){
		$this->db->select('article.ID AS ID,title,slug,excerpt,content,article.dateadded AS dateadded,art2org.parent_art_id AS parent_art_id');
		$this->db->from('article');
		$this->db->join('art2org','article.ID=art2org.art_id','left outer');
		$this->db->where('article.ID',$article_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	function add_article($db_data){
		unset($db_data['ID']);
		unset($db_data['submit']);
	 	$slug = $this->common->increment_slug(post_slug($db_data['title']),'article');
		$db_data['slug'] = $slug;
		$db_data['dateadded'] = time();

	 	$this->db->insert('article',$db_data);
	 	return $this->db->insert_id();
	 }	
	 
	 function edit_article($db_data){
		unset($db_data['submit']);
		$this->db->where('ID',$db_data['ID']);
	 	$this->db->update('article',$db_data);
	 }

	 function art_to_org($db_data){
	 	unset($db_data['submit']);
	 	$this->db->insert('art2org',$db_data);
	 }
	  
	 function clear_art_to_org($art_id){
	 	$this->db->where('art_id',$art_id);
	 	$this->db->delete('art2org');
	 }
}