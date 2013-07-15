<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for administration of data
 */
Class Administration extends CI_Model {
	private $cookie_domain;
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	        $this->cookie_domain = $_SERVER['SERVER_NAME'];
	        $this->load->model('Organizations','Orgs');
	    }
	
	function add_post($data){
		$slug = $this->increment_slug(post_slug($data['title']),'post');
		$db_data = array(
				'title' => $data['title'],
				'slug' => $slug,
				'author_id' => $data['author_id'],
				'cost' => $data['cost'],
				'content' => $data['content'],
				'lastedit' => time(),
				'dateadded' => time(),
		);
		$this->db->insert('post',$db_data);
		return $this->db->insert_id();
	}
	
	
	
	/*
	 * Gets all sections for a given story
	 */
	function get_sections($story_id){
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
		foreach($result AS $k => $v){
			$result[$k]->attachments = $this->get_attachments($v->section_id);
		}
		return $result;
	}
	
	function get_section($section_id){
		$this->db->select('section.ID AS section_id,story_section,story_subsection,section_type,type,content,lastedit,dateadded');
		$this->db->from('section');
		$this->db->join('section_type','section.section_type = section_type.ID');
		$this->db->where('section.id',$section_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	function edit_story($ID,$data){
		$db_data = $data;
		$db_data['slug'] = $this->increment_slug(post_slug($data['title'].'_'.date('m-d',$data['datepresented'])),'story');
		$db_data['lastedit'] = time();
		
		$this->db->where('ID', $ID);
		$this->db->update('story',$db_data);		
	}
	
	function edit_section($ID,$data){
		$db_data = $data;
		$db_data['lastedit'] = time();
		$this->db->where('ID', $ID);
		$this->db->update('section',$db_data);	
	}
	
	function set_updated_time_on_story($ID){
		$db_data['lastedit'] = time();
		$this->db->where('ID', $ID);
		$this->db->update('story',$db_data);
	}
	
	function create_section($data){
		extract($data);
		//fill in basic sections as placeholders.
		$insert_batch = array();
		$insert_data = array(
			'story_id' => $story_id,
			'story_section' => $story_section,
			'story_subsection' => 0,
			'section_type' => 1,
			'content' => '',
			'lastedit' => time(),	
			'dateadded' => time(),	
			'dateremoved' => 0,
		);
		$insert_batch[] = $insert_data;
		//do main section stuff
		for($j=1;$j<=3;$j++){
			for($k=2;$k<=4;$k++){
				//do subsection stuff
				$insert_data = array(
					'story_id' => $story_id,
					'story_section' => $story_section,
					'story_subsection' => $j,
					'section_type' => $k,
					'content' => '',
					'lastedit' => time(),	
					'dateadded' => time(),	
					'dateremoved' => 0,
				);
				$insert_batch[] = $insert_data;
			}
		}
		if($this->db->insert_batch('section', $insert_batch))
			print TRUE;
	}
	
	
	function upload(){
		
	}
	
	function get_attachment_types(){
		$query = $this->db->get('attachment_type');
		$result = $query->result();
		return $result;
	}
	
	function get_attachment_type_id($attachment_type_name){
		$this->db->select('ID');
		$this->db->from('attachment_type');
		$this->db->where('type', strtolower(trim($attachment_type_name)));
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	function add_attachment($data){
		$db_data = array(
			'attachment_url' => $data['attachment_url'], ///check CI uploader function http://codeigniter.com/user_guide/libraries/file_uploading.html
			'attachment_type' => $data['attachment_type'], 
			'title' => $data['title'], 
			'modal'	=> $data['modal'],
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
	
	function attachment_to_section($data){
		$db_data = array(
			'attachment_id' => $data['attachment_id'],
			'section_id' => $data['section_id'],
			'dateadded' => time(),	
			'dateremoved' => 0,
		);
		if($this->db->insert('attachment2section',$db_data)){
			return true;
		} else {
			return false;
		}
	}
	
	function get_attachment($ID){
		$this->db->select('attachment.ID AS ID, attachment_url, attachment_type.type AS attachment_type, title, modal');
		$this->db->from('attachment2section');
		$this->db->join('attachment','attachment.ID = attachment2section.attachment_id');
		$this->db->join('attachment_type','attachment.attachment_type = attachment_type.ID');
		$this->db->where('attachment.ID',$ID);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	function get_attachments($section_id){
		$attachments = array();
		$this->db->select('attachment.ID AS ID, attachment_url, attachment_type.type AS attachment_type, title, modal');
		$this->db->from('attachment2section');
		$this->db->join('attachment','attachment.ID = attachment2section.attachment_id');
		$this->db->join('attachment_type','attachment.attachment_type = attachment_type.ID');
		$this->db->where('attachment2section.section_id',$section_id);
		$this->db->where('attachment2section.dateremoved <=',0);
		$this->db->where('attachment.dateremoved <=',0);
		$query = $this->db->get();
		$result = $query->result();
		foreach($result AS $r){
			$attachments[$r->attachment_type][] = $r;
		}
		return $attachments;
	}
	
	function detach($data){
		//data should include the sectio nand hte attachment to detach from it. thsi way we can potentially keep a library of all attachments and reusethem even if they are not attached to anything at the time.
		$db_data = array(
			'dateremoved' => time()
		);
		$this->db->where('attachment_id',$data['attachment_id']);
		$this->db->where('section_id',$data['section_id']);
		if($this->db->update('attachment2section',$db_data)){
			$this->set_updated_time_on_story($data['story_id']);
			print 1;
		}
	}
	
	function add_quote($data){
		$db_data = array(
			'story_id' => $data['story_id'], 
			'after_section' => $data['after_section'], 
			'after_subsection'	=> $data['after_subsection'],
			'content'	=> $data['content'],
			'lastedit' => time(),	
		);
		if($data['quote_id']){
			$this->db->where('ID',$data['quote_id']);
			$this->db->update('quote_ribbon',$db_data);
			$this->set_updated_time_on_story($data['story_id']);
		} else {
			$db_data['dateadded'] = time();
			$db_data['dateremoved'] = 0;
			$this->db->insert('quote_ribbon',$db_data);
			$this->set_updated_time_on_story($data['story_id']);
			return $this->db->insert_id();		
		}
	}
	
	function get_quote($quote_id){
		$query = $this->db->get_where('quote_ribbon',array('ID'=>$quote_id,'dateremoved'=>0));
		$result = $query->result();
		return $result[0];
	}
	
	function get_quotes($story_id){
		$query = $this->db->get_where('quote_ribbon',array('story_id'=>$story_id,'dateremoved'=>0));
		$result = $query->result();
		return $result;
	}
	
	function unpublish_quote($quote_id){
		$db_data['lastedit'] = time();
		$db_data['dateremoved'] = time();
		$this->db->where('ID', $quote_id);
		if($this->db->update('quote_ribbon',$db_data))
			print TRUE;	
	}
	
	function story_to_project($data){
		$db_data = array(
			'project_id' => $data['project_id'],
			'story_id' => $data['story_id'],
		);
		$this->db->insert('story2project',$db_data);
	}	
	
	function edit_story_to_project($data){
		$db_data = array(
			'project_id' => $data['project_id']
		);
		$this->db->where('story_id', $data['story_id']);
		$this->db->update('story2project',$db_data);
	}
	
	function getSuggestions($queryString){
		$this->db->select('name');
		$this->db->from('project');
		$this->db->like('name',$queryString);
		$this->db->limit(10);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function archive_story($ID,$data){	
		$db_data = $data;	
		$db_data['lastedit'] = time();
		$db_data['dateremoved'] = time();
		$this->db->where('ID', $ID);
		$this->db->update('story',$db_data);	
	}
	
	function unarchive_story($ID,$data){	
		$db_data = $data;	
		$db_data['lastedit'] = time();
		$db_data['dateremoved'] = NULL;
		$this->db->where('ID', $ID);
		$this->db->update('story',$db_data);	
	}
	
	function publish_story($ID,$data){	
		$db_data = $data;	
		$db_data['lastedit'] = time();
		$db_data['datepublished'] = time();
		$this->db->where('ID', $ID);
		$this->db->update('story',$db_data);	
	}
	
	function unpublish_story($ID,$data){	
		$db_data = $data;	
		$db_data['lastedit'] = time();
		$db_data['datepublished'] = NULL;
		$this->db->where('ID', $ID);
		$this->db->update('story',$db_data);	
	}
	
	function create_history($story_id){
		//grab all pertinent story data
		$history_data = array(
			'story' => $this->get_story($story_id),
			'sections' => $this->get_sections($story_id),
			'quotes' => $this->get_quotes($story_id),
		);
		foreach($history_data['sections'] AS $k => $v){
			$history_data['sections'][$k]->attachments = $this->get_attachments($v->section_id);
		}
		//serialize
		$db_data = array(
			'story_id' => $story_id,
			'user_id' => $this->session->userdata['ID'],
			'data' => serialize($history_data),
			'timestamp' => time()
		);
		//push to history DB with a timestamp
		if($this->db->insert('history', $db_data))
			return TRUE;	
	}
	
	function has_history($story_id){
		$this->db->where('restored',0);
		$this->db->where('story_id',$story_id);
		$count = $this->db->count_all_results('history');
		if($count >= 1){
			return TRUE;
		}
		return FALSE;
	}
	
	function restore_from_history($story_id,$timestamp = FALSE){
		$timestamp = !$timestamp?time():$timestamp;
		//find history for this story with timestamp closest before $timestamp.
		$this->db->where('restored',0);
		$this->db->where('story_id',$story_id);
		$this->db->order_by('timestamp','desc');
		$this->db->limit(1);
		$query = $this->db->get('history');
		foreach ($query->result() as $row){
			$history_id = $row->ID;
			$data = unserialize($row->data);
		}
		//update all affected areas with data from the history.
		//update the story
		$story_data = toArray($data['story']);
		unset($story_data['project_id']);
		unset($story_data['story_id']);
		unset($story_data['name']);
		$this->edit_story($story_id,$story_data);		
		//update each section
		foreach($data['sections'] AS $section){
			$section_data = toArray($section);
			unset($section_data['section_id']);
			unset($section_data['type']);
			unset($section_data['attachments']);
			$this->edit_section($section->section_id,$section_data);
			//do all the attachments
			foreach($section->attachments AS $type){
				foreach($type AS $attachment){
					$attachment_data = toArray($attachment);
					$this->edit_attachment($attachment->ID,$attachment_data);
				}
			}
		}
		//update each quote
		foreach($data['quotes'] AS $quote){
			$quote_data = toArray($quote);
			$quote_data['quote_id'] = $quote_data['ID'];
			unset($quote_data['ID']);
			$this->add_quote($quote_data);
		}
		//mark that history as restored.
		$db_data = array('restored' => time());
		$this->db->where('ID',$history_id);
		$this->db->update('history',$db_data);
	}
}