<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for presentation of data
 */
Class Display extends CI_Model {
	private $cookie_domain;
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	        $this->cookie_domain = $_SERVER['SERVER_NAME'];
	    }
	function get_story($ID,$allow_unpublished = FALSE){
		$this->db->select('story.ID AS story_id,title,slug,story.password AS password,logo_url,banner_url,datepresented,name,firstname,lastname,email,avatar');
		$this->db->from('story');
		$this->db->join('story2project','story2project.story_id = story.ID');
		$this->db->join('project','story2project.project_id = project.ID');
		$this->db->join('user','story.author_id = user.ID');
		$this->db->where('story.ID',$ID);
		if(!$allow_unpublished){
			$this->db->where('story.datepublished >',0);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->result();
			$result[0]->sections = $this->get_sections($ID);
			return $result[0];
		}else{
			//$this->session->set_flashdata('err', 'Story not found');
			return FALSE;
		}	
	}
	function get_numeric_story_id($story_id){
		if(is_numeric($story_id)){
			return $story_id;
		} else {
			$this->db->select('ID');
			$this->db->from('story');
			$this->db->where('slug',$story_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$result = $query->result();
				return $result[0]->ID;
			}else{
				$this->session->set_flashdata('err', 'Story ID "'.$story_id.'" not found');
				return FALSE;
			}	
		}
	}

	function get_sections($story_id){
		$section = array();
		$this->db->select('section.ID AS section_id,story_section,story_subsection,section_type,type,content,lastedit,dateadded');
		$this->db->from('section');
		$this->db->join('section_type','section.section_type = section_type.ID');
		$this->db->where('story_id',$story_id);
		$this->db->where('dateremoved <=',0);
		$this->db->order_by('story_section','ASC');
		$this->db->order_by('story_subsection','ASC');
		$this->db->order_by('section.section_type','ASC');
		$query = $this->db->get();
		$result = $query->result();
		foreach($result AS $r){
			$section[$r->story_section][$r->story_subsection][$r->type] = $r;
			$section[$r->story_section][$r->story_subsection][$r->type]->attachments = $this->get_attachments($r->section_id);
		}
		return $section;
	}
	
	function get_attachments($section_id){
		$params = array('maxwidth' => '600');
		$this->load->library('oembed',$params);
		$attachments = array();
		$this->db->select('attachment_url, attachment_type.type AS attachment_type, title, modal');
		$this->db->from('attachment2section');
		$this->db->join('attachment','attachment.ID = attachment2section.attachment_id');
		$this->db->join('attachment_type','attachment.attachment_type = attachment_type.ID');
		$this->db->where('attachment2section.section_id',$section_id);
		$this->db->where('attachment2section.dateremoved <=',0);
		$query = $this->db->get();
		$result = $query->result();
		foreach($result AS $r){
			if($r->attachment_type == 'video'){
				$r->oembed = $this->oembed->call(trim($r->attachment_url));
			}
			$attachments[$r->attachment_type][] = $r;
		}
		return $attachments;
	}
		
	function get_quotes($story_id){
		$ci =& get_instance();
		$ci->load->model('Administration','Admin');
		$quote_ribbons = $ci->Admin->get_quotes($story_id);
		//rearrange quotes to make testing easier
		$quotes = array();
		foreach($quote_ribbons AS $qr){
			$quotes[$qr->after_section][$qr->after_subsection] = $qr;
		}
		return $quotes;
	}
	/**
	 * Does a special routine for testing basic login on story and tracking user's emails
	 */
	function dostorylogin($story,$post){
		if($story->password == $post['password']){
			$this->trackview($story->story_id,$post['email']);
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function trackview($story_id,$email){
		$data = array(
			'story_id' => $story_id,
			'email' => $email,
			'dateadded' => time(),
		);
		$this->db->insert('view_log', $data);
	}
}