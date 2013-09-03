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
	
	/**
	 * Send the site admins an email
	 */
	function notify_admins($message,$org=NULL,$superadmin=TRUE){
		$this->load->model('Users');
		if(is_array($message)){
			extract($message);
		} else {
			$subject = "Message from ".SITENAME;
		}
		$users = $this->Users->get_users_by_level('administrators');
		if($superadmin){
			if(is_array($users)){
				array_push($users, $this->Users->get_users_by_level(1));
			} else {
				$users = $this->Users->get_users_by_level(1);
			}
		} 
		foreach($users AS $user){
			mail($user->email,$subject,$message);
		}
	}
	
	/**
	 * Do upload
	 */
	function upload($data,$field){	
		$uploads_dir = SITEPATH.'uploads/';
		$uploads_url = site_url('uploads/');
		$org_slug = post_slug($data['org']->name);
		$org_dir = $uploads_dir.$org_slug;
		//create the upload folder
		if(!is_dir($org_dir)){
			mkdir($org_dir,0777);
		}
		//upload the file
		$config['file_name'] = $_FILES[$field]['name'];
		//$config['file_name'] = $_FILES[$field]['tmp_name'];

		$config['upload_path'] = $org_dir;
		$config['allowed_types'] = 'pdf|gif|jpeg|jpg|png|doc|docx|pdf|txt|rtf|csv';
		$config['max_size'] = '100000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($field)) {
			$this->session->set_flashdata('err', $this->upload->display_errors());
			return false;
		} else {
			$data = array('upload_data' => $this->upload->data());
			$attachment_url = $uploads_url.'/'.$org_slug.'/'.$data['upload_data']['file_name'];
			return $attachment_url;
		}
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