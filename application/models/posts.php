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
	    
	function get_cats_and_posts($params,$archive = FALSE){
			$params = array_merge(
				array(
					'orgs' => array(),
				),
				$params
			);
			extract($params);
	    	$orgs = $this->Orgs->make_org_array($orgs);
	    	$cats = $this->Cats->get_cats($orgs);
	    	$i = 0;
	    	foreach($cats AS $cat){
	    		$params['cat_id'] = $cat->ID;
	    		$cats[$i]->posts = $this->get_posts($params,$archive);
	    		$cats[$i]->has_children = $this->cat_has_children_or_posts($cat,$org_id = 1);
	    		$i++;
	    	}
	    	$cats = $this->Cats->group_cats_by_parent($cats);
	    	return $cats;
	    }
   
   function cat_has_children_or_posts($cat,$org_id = 1){
       $posts = $this->get_posts(array('cat_id'=>$cat->ID));
       if(isset($posts[0])){
           return TRUE; //cat has posts, return true.
       }
        $this->db->select('cat_id AS ID');
        $this->db->from('cat2org');
        $this->db->where('org_id',$org_id);
        $this->db->where('parent_cat_id',$cat->ID);
        $query = $this->db->get();
        $result = $query->result();
        if(isset($result[0])){
            foreach($result AS $r){
                if($this->cat_has_children_or_posts($r) == TRUE){
                    return TRUE;
                }
            }
        } else {
            return FALSE; //cat has neither posts nor children, return false.
        }
     }
	    
	function get_user_posts($params,$archive=FALSE){
		$posts = $this->get_posts($params,$archive);
		$i = 0;
		foreach($posts AS $post){
			$posts[$i]->categories = $this->Cats->get_post_cats($post->post_id);
			$i++;
		}
		return $posts;
	}

	function get_posts($params,$archive=FALSE){
		$params = array_merge(
			array(
				'cat_id' => NULL,
				'user_id' => NULL
			),
			$params
		);
		extract($params);
		$this->db->select('*, post.ID as post_id,post.dateadded as dateadded');
		if($cat_id){
			$this->db->from('post2cat');
			$this->db->join('post','post.ID=post2cat.post_id');
			$this->db->where('post2cat.cat_id',$cat_id);
		} else {
			$this->db->from('post');
		}
		if($user_id){
			$this->db->where('post.author_id',$user_id);
		}
		$this->db->join('user','post.author_id=user.ID');
		if(!$archive){
			$this->db->where('post.dateremoved <=',0);
		}
		$query = $this->db->get();
		$result = $query->result();
		foreach($result AS $k=>$v){
			$result[$k]->attachments = $this->get_attachments($v->post_id);
		}
		return $result;
	}
	
	function get_post($post_id){
		$this->db->select('post.ID as post_id, title, slug, type, author_id, cost, content, post.lastedit as lastedit, post.dateadded as dateadded, datepublished, post.dateremoved as dateremoved, post.notes as notes, email, firstname, lastname, accesslevel, group_id');
		$this->db->from('post');
		$this->db->join('user','post.author_id=user.ID');
		$this->db->where('post.ID',$post_id);
		$this->db->limit(1);
		$query = $this->db->get();
		$result = $query->result();
		$result = $result[0];
		$result->postcats = $this->Cats->get_post_cats_ids($post_id);
		$result->attachments = $this->get_attachments($post_id);
		return $result;
	}
	
	function add_post($db_data){
		unset($db_data['ID']);
		unset($db_data['submit_btn']);
		$slug = $this->common->increment_slug(post_slug($db_data['title']),'post');
		$db_data['slug'] = $slug;
		$db_data['dateadded'] = time();
	
		$this->db->insert('post',$db_data);
		return $this->db->insert_id();
	}
	
	function edit_post($db_data){
		unset($db_data['submit_btn']);
		unset($db_data['postcats']);
		$db_data['lastedit'] = time();
		$this->db->where('ID',$db_data['ID']);
		$this->db->update('post',$db_data);
	}	
	
	function post_to_cat($db_data){
		unset($db_data['submit_btn']);
		$this->db->insert('post2cat',$db_data);
	}
			
	function clear_post_to_cats($post_id){
		$this->db->where('post_id',$post_id);
		$this->db->delete('post2cat');
	}
	

	function set_updated_time_on_post($ID){
		$db_data['lastedit'] = time();
		$this->db->where('ID', $ID);
		$this->db->update('post',$db_data);
	}
	
	function add_attachment($data){
		$db_data = array(
				'attachment_url' => $data['attachment_url'], ///check CI uploader function http://codeigniter.com/user_guide/libraries/file_uploading.html
				'attachment_type' => 'image',
				'title' => $data['title'],
				'lastedit' => time(),
				'dateadded' => time(),
				'dateremoved' => 0,
		);
		$this->db->insert('attachment',$db_data);
		return $this->db->insert_id();
	}
	
	function edit_attachment($ID,$data){
		$db_data = array(
				'title' => $data['title'],
				'modal'	=> $data['modal'],
				'lastedit' => time(),
		);
		$this->db->where('ID',$ID);
		$this->db->update('attachment',$db_data);
	}
	
	function attachment_to_post($data){
		$db_data = array(
				'attachment_id' => $data['attachment_id'],
				'post_id' => $data['post_id'],
				'dateadded' => time(),
				'dateremoved' => 0,
		);
		if($this->db->insert('attachment2post',$db_data)){
			return true;
		} else {
			return false;
		}
	}
	
	function get_attachment($ID){
		$this->db->select('attachment.ID AS ID, attachment_url, title');
		$this->db->from('attachment2post');
		$this->db->join('attachment','attachment.ID = attachment2section.attachment_id');
		$this->db->where('attachment.ID',$ID);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	function get_attachments($post_id){
		$attachments = array();
		$this->db->select('attachment.ID AS ID, attachment_url, title');
		$this->db->from('attachment2post');
		$this->db->join('attachment','attachment.ID = attachment2post.attachment_id');
		$this->db->where('attachment2post.post_id',$post_id);
		$this->db->where('attachment2post.dateremoved <=',0);
		$this->db->where('attachment.dateremoved <=',0);
		$query = $this->db->get();
		$result = $query->result();
	
		return $result;
	}
	
    function detach($data){
        //data should include the sectio nand hte attachment to detach from it. thsi way we can potentially keep a library of all attachments and reusethem even if they are not attached to anything at the time.
        $db_data = array(
                'dateremoved' => time()
        );
        $this->db->where('attachment_id',$data['attachment_id']);
        $this->db->where('post_id',$data['post_id']);
        if($this->db->update('attachment2post',$db_data)){
            $this->set_updated_time_on_post($data['post_id']);
            print 1;//ajax function
        }
    }

    function buy($data){
        $org_id = $this->common->get_org_info_from_subdomain();
        $org = $this->Orgs->get_org($org_id);
        $this->load->model("Users");
        //set purchase date, date removed, and purchaser id
        extract($data);
        $buyer = $this->Users->get_user($buyer_id);
        $post = $this->get_post($post_id);

        $subject = 'Purchase of '.$post->title;
        $message = 'Good News!
        '.$buyer->firstname.' '.$buyer->lastname.' has shown an intent to purchase '.$post->title.'. 
        Please check your email and/or PayPal. If the purchase is completed, please remit '.get_the_fee($post).' to '.$org->name.' as soon as possible.';
        mail($post->email,$subject,$message);
        print 'TRUE';
    }
	
}