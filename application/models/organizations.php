<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organizations extends CI_Model {
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	    }
	    //TODO: Change name to org_ID_array
	    function make_org_array($orgs){
	    	if(!is_array($orgs)){
	    		if($this->authenticate->check_auth() && $orgs =='all'){
	    		    $orgs = array();
                    foreach($this->get_orgs() AS $org){
                        $orgs[]=$org->ID;
                    }
	    		} else {
	    			return FALSE;
	    		}
	    	} else {
	    	    if(count($orgs)==0){
	    	        global $org_id;
                    $orgs[] = $org_id;
	    	    }
	    	}
	    	return $orgs;
	    }

	    function get_orgs($archive = FALSE){
	    	$this->db->from('organization');
	    	if(!$archive){
	    		$this->db->where('dateremoved <=',0);
	    	}
            $this->db->order_by('ID');
	    	$query = $this->db->get();
	    	$result = $query->result();
            $i = 0;
            foreach($result AS $r){
                $result[$i]->meta = $this->get_org_meta($r->ID);
                $i++;
            }
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
	        ts_data($db_data);
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
                $this->db->where('org_id',$db_data['org_id']);
                $this->db->where('meta_key',$db_data['meta_key']);
                $this->db->update('org_meta',$db_data);
                if($this->db->affected_rows()<1){
                    $this->add_org_meta($db_data);
                }
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
        
        function get_org_emails($org_id,$email){
            $email_meta = $this->get_org_meta($org_id,'email');
            $all_emails = unserialize($email_meta['email']->meta_value);
            $email_info = $all_emails[$email];
            if(isset($email_info['default'])){
                require_once(SITEPATH.DEFAULT_THEME_URL.'/textfile/'.$email.'.php');
                return $default_email;
            } else {
                return $email_info;
            }
        }
        
     function copy_feature($org_id,$dupe_id,$feature){
         switch($feature){
             case 'emails':
                 $email_meta = $this->get_org_meta($dupe_id,'email');
                 //object to array
                 $db_data = (array) $email_meta['email'];
                 //unset ID
                 unset($db_data['ID']);
                 //reset org_id, date_added
                 $db_data['org_id'] = $org_id;
                 $db_data['dateadded'] = time();
                 $this->edit_org_meta($db_data);
                 break;
             case 'categories':
                 $this->load->model('Categories','Cats');
                 //get all the categories
                 $cats = $this->Cats->get_cats(array($dupe_id));
                 //make a handy replacement array for the parents
                 $replacements = array();
                 //reorder array by ID (this should put parents before children);
                 usort($cats, array(&$this,'sort_by_id'));
                 foreach($cats as $cat){
                     //unset/reset as needed
                     $db_data = (array) $cat;
                     $old_id = $db_data['ID'];
                     unset($db_data['ID']);
                     $db_data['dateadded'] = time();
                     $old_parent = $db_data['parent_cat_id'];
                     $parent_cat_id = isset($replacements[$old_parent])?$replacements[$old_parent]:0;
                     unset($db_data['parent_cat_id']);
                     //copy them
                     $cat_id = $this->Cats->add_cat($db_data);
                     //connect to org
                     $db_data = array(
                        'cat_id' => $cat_id,
                        'parent_cat_id' => $parent_cat_id,
                        'org_id' => $org_id
                     );
                     $this->Cats->cat_to_org($db_data);
                     //save to array
                     $replacements[$old_id] = $cat_id;
                 }
                 break;
             case 'help':
                 $this->load->model('Articles');
                 $articles = $this->Articles->get_articles(array($dupe_id));
                 $replacements = array();
                 //reorder array by ID (this should put parents before children);
                 usort($articles, array(&$this,'sort_by_id'));
                 foreach($articles as $article){
                     //unset/reset as needed
                     $db_data = (array) $article;
                     $old_id = $db_data['ID'];
                     unset($db_data['ID']);
                     $db_data['dateadded'] = time();
                     $old_parent = $db_data['parent_art_id'];
                     $parent_art_id = isset($replacements[$old_parent])?$replacements[$old_parent]:0;
                     unset($db_data['parent_art_id']);
                     //copy them
                     $art_id = $this->Articles->add_article($db_data);
                     //connect to org
                     $db_data = array(
                        'art_id' => $art_id,
                        'parent_art_id' => $parent_art_id,
                        'org_id' => $org_id
                     );
                     $this->Articles->art_to_org($db_data);
                     //save to array
                     $replacements[$old_id] = $art_id;
                 }
                 break;
         }
     }

    private function sort_by_id($a,$b){
        if ($a->ID == $b->ID) {
            return 0;
        }
        return ($a->ID < $b->ID) ? -1 : 1;
    }
		    
}
/* End of file organizations.php */
/* Location: ./application/models/organizations.php */