<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for administration of data
 */
Class Tags extends CI_Model {
    private $cookie_domain;
    function __construct()
        {
            // Call the Model constructor
            parent::__construct();
            $this->cookie_domain = $_SERVER['SERVER_NAME'];
        }
        
    function get_tags($orgs = array(),$archive = FALSE){
        $orgs = $this->Orgs->make_org_array($orgs);
        $this->db->select('tag.ID AS ID,title,slug,description,tag.dateadded AS dateadded,parent_tag_id');
        $this->db->from('tag');
        $this->db->order_by("tag.title", "asc"); 
        if(!$archive){
            $this->db->where('tag.dateremoved <=',0);
        }
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
     
    function get_tag($tag_title){
        $this->db->select('tag.ID AS ID,title,slug,description,tag.dateadded AS dateadded,parent_tag_id');
        $this->db->from('tag');
        $this->db->where('tag.title',$tag_title);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }
    
    function get_tag_by_id($tag_id){
        $this->db->select('tag.ID AS ID,title,slug,description,tag.dateadded AS dateadded,parent_tag_id');
        $this->db->from('tag');
        $this->db->where('tag.ID',$tag_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }
    
    function add_tag($db_data){
        $slug = $this->common->increment_slug(post_slug($db_data['title']),'tag');
        $db_data['slug'] = $slug;
        $db_data['dateadded'] = time();

        $this->db->insert('tag',$db_data);
        return $this->db->insert_id();
     }  
     
     function edit_tag($db_data){
        unset($db_data['submit_btn']);
        $this->db->where('ID',$db_data['ID']);
        $this->db->update('tag',$db_data);
     }
     
     function get_post_tags($post_id,$orgs = array()){
        $this->db->from('post2tag');
        $this->db->join('tag','post2tag.tag_id=tag.ID');
        $this->db->where('post2tag.post_id',$post_id);
        $query = $this->db->get();
        $result = $query->result();
        if($result){
            foreach($result AS $k=>$tag){
                $result[$k]->tagpath = implode('/',array_reverse($this->create_tagpath($tag)));
            }
        }
        return $result;
     }
     
     function get_post_tags_ids($post_id){
        $posttags = $this->get_post_tags($post_id);
        $ids = array();
        if($posttags){
            foreach($posttags AS $tag){
                $ids[] = $tag->tag_id;
            }
        }
        $posttags['ids'] = $ids;
        return $posttags;
     }
     
    function post_to_tag($db_data){
        unset($db_data['submit_btn']);
        $this->db->insert('post2tag',$db_data);
    }
            
    function clear_post_to_tags($post_id){
        $this->db->where('post_id',$post_id);
        $this->db->delete('post2tag');
    }

     
     /**
      * TODO: Maybe alter this to provide a breadcrumb like feature for posting if we create individual listing pages for tags
      * 
      */
     function create_tagpath($tag,$path=array()){
        $path[] = $tag->title;
        if($tag->parent_tag_id != 0){
            $parent = $this->get_tag($tag->parent_tag_id);
            $path = $this->create_tagpath($parent,$path);
        } 
        return $path;
     }
}