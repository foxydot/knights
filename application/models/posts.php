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
	    		$cat[$i]->post = $this->get_posts($cat->ID,$archive);
	    		$i++;
	    	}
	    	return $cats;
	    }
	    
	function get_posts($cat_id,$archive=FALSE){
		
	}
}