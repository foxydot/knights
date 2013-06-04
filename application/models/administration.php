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
	    }
	
	private function make_org_array($orgs){
		if(!is_array($orgs)){
			if($this->authenticate->check_auth() && $orgs =='all'){
				$org_data = $this->get_orgs();
				foreach($org_data AS $od){
					$orgs[] = $od->ID;
				}
			} else {
				return FALSE;
			}
		}
		return $orgs;
	}
	function get_orgs($archive = FALSE){
		$this->db->from('oranization');
		if(!$archive){
			$this->db->where('dateremoved <=',0);
		} 
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function get_cats($orgs = array(),$archive = FALSE){
		$orgs = $this->make_org_array($orgs);
		$this->db->from('category');
		if(!$archive){
			$this->db->where('dateremoved <=',0);
		}
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function get_stories($project_id,$archive = FALSE){
		$this->db->from('story2project');
		$this->db->join('story','story2project.story_id = story.ID');
		$this->db->join('user','story.author_id = user.ID');
		$this->db->where('story2project.project_id',$project_id);
		if(!$archive){
			$this->db->where('story.dateremoved <=',0);
		} elseif ($archive == 'only'){
			$this->db->where('story.dateremoved >',0);
		}
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function get_cats_and_posts($orgs = array(),$archive = FALSE){
		$orgs = $this->make_org_array($orgs);
		$cats = $this->get_cats($orgs);
		$i = 0;
		foreach($cats AS $cat){
			$cat[$i]->post = $this->get_posts($cat->ID,$archive);
			$i++;
		}
		return $cats;
	}

	function get_project($ID){
		
	}
	
	function get_project_by_name($name){
		$query = $this->db->get_where('project', array('name' => $name), 1);
		$result = $query->result();
		if(isset($result[0])){
			return $result[0];
		} else {
			return FALSE;
		}
	}
	
	function add_project($data){
		$db_data = array(
			'name' => $data['name'],
			'dateadded' => time(),
		);
		$this->db->insert('project',$db_data);
		return $this->db->insert_id();
	}
	
	function edit_project($ID,$data){
		$db_data = $data;
		$this->db->where('ID', $ID);
		$this->db->update('project',$db_data);
	}
	
	function get_story($ID){
		$this->db->select('title,slug,password,author_id,logo_url,banner_url,story.lastedit AS lastedit,datepresented,story.dateadded AS dateadded,datepublished,story.dateremoved AS dateremoved,project_id,story_id,name');
		$this->db->from('story');
		$this->db->join('story2project','story2project.story_id = story.ID');
		$this->db->join('project','story2project.project_id = project.ID');
		$this->db->where('story.ID',$ID);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	function add_story($data){
		$slug = $this->increment_slug(post_slug($data['title'].'_'.date('m-d',$data['datepresented'])));
		$db_data = array(
			'title' => $data['title'],
			'password' => $data['password'],
			'slug' => $slug,
			'author_id' => $data['author_id'],
			'lastedit' => time(),
			'datepresented' => $data['datepresented'],
			'dateadded' => time(),
		);
		$this->db->insert('story',$db_data);
		return $this->db->insert_id();
	}
	
	function story_section_boilerplate($story_id){
		//fill in basic sections as placeholders.
		$insert_batch = array();
		for($i=1;$i<=3;$i++){
			$insert_data = array(
				'story_id' => $story_id,
				'story_section' => $i,
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
						'story_section' => $i,
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
		}
		$this->db->insert_batch('section', $insert_batch);
	}
	
	function clone_story($original_story_id){
		$old_story = $this->get_story($original_story_id);
		//create new story with old data
		$slug = $this->increment_slug($old_story->slug);
		$data = array(
			'title' => $old_story->title.' Copy',
			'slug' => $slug,
			'password' => $old_story->password,
			'author_id' => $old_story->author_id,
			'logo_url' => $old_story->logo_url,
			'banner_url' => $old_story->banner_url,
			'datepresented' => $old_story->datepresented,
		);
		$new_story_id = $this->add_story($data);
		//connect to the original project
		$data = array(
				'project_id' => $old_story->project_id,
				'story_id' => $new_story_id,
			);
		$this->story_to_project($data);
		//get all the sections and clone them
		$old_story_sections = $this->get_sections($original_story_id);
		foreach($old_story_sections AS $old_section){
			$data = array(
				'story_id' => $new_story_id,
				'story_section' => $old_section->story_section,
				'story_subsection' => $old_section->story_subsection,
				'section_type' => $old_section->section_type,
				'content' => $old_section->content,
			);
			$new_section_id = $this->add_subsection_for_clone($data);
			//get the old section's attachemnts and attach to the new section	
			$old_attachments = $this->get_attachments($old_section->section_id);
			foreach($old_attachments AS $old_attachment_typegrp){
				foreach($old_attachment_typegrp AS $old_attachment){
					$data = array(
						'attachment_id' => $old_attachment->ID,
						'section_id' => $new_section_id,
					);
					$this->attachment_to_section($data);
				}
			}
		}	
	}
	
	function increment_slug($test_slug){
		if(!$this->slug_exists($test_slug)){
			return $test_slug;
		}
		$i = 0;
		do {
			$new_slug = $test_slug.'-'.$i;
			$i++;
		} while($this->slug_exists($new_slug));
		return $new_slug;
	}
	
	function slug_exists($test_slug){
		$query = $this->db->get_where('story',array('slug'=>$test_slug));
		if($query->num_rows()>0){
			return TRUE;
		} else {
			return FALSE;
		}
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
		$db_data['slug'] = $this->increment_slug(post_slug($data['title'].'_'.date('m-d',$data['datepresented'])));
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
	
	function unpublish_subsection($data){
		$db_data['lastedit'] = time();
		$db_data['dateremoved'] = time();
		$this->db->where('story_id',$data['story_id']);
		$this->db->where('story_section',$data['story_section']);
		if($data['story_subsection'] != 0){
			$this->db->where('story_subsection',$data['story_subsection']);
		} 
		if($this->db->update('section',$db_data)){
			$this->set_updated_time_on_story($data['story_id']);
			print "TRUE";
		} else {
			print "FALSE";
		}
	}
	
	function create_subsection($data){
		for($k=2;$k<=4;$k++){
			//do subsection stuff
			$insert_data = array(
				'story_id' => $data['story_id'],
				'story_section' => $data['story_section'],
				'story_subsection' => $data['story_subsection']+1,
				'section_type' => $k,
				'content' => '',
				'lastedit' => time(),	
				'dateadded' => time(),	
				'dateremoved' => 0,
			);
			$insert_batch[] = $insert_data;
		}
		if($this->db->insert_batch('section', $insert_batch)){
			$this->set_updated_time_on_story($data['story_id']);
			print "TRUE";
		} else {
			print "FALSE";
		}
	}
	
	function add_subsection_for_clone($data){
		//do subsection stuff
			$insert_data = array(
				'story_id' => $data['story_id'],
				'story_section' => $data['story_section'],
				'story_subsection' => $data['story_subsection'],
				'section_type' => $data['section_type'],
				'content' => $data['content'],
				'lastedit' => time(),	
				'dateadded' => time(),	
				'dateremoved' => 0,
		);
	
		if($this->db->insert('section', $insert_data)){
			return $this->db->insert_id();
		} 
	}
	
	function renumber_down($data){
		$update_batch = array();
		$this->db->select('ID,story_subsection');
		$this->db->from('section');
		$this->db->where('story_id',$data['story_id']);
		$this->db->where('story_section',$data['story_section']);
		$this->db->where('story_subsection > ',$data['story_subsection']);
		$this->db->where('dateremoved <=',0);
		$query = $this->db->get();
		$result = $query->result();
		foreach($result AS $item){
			$update_data = array(
				'ID' => $item->ID,
				'story_subsection' => $item->story_subsection-1,
			);
			$update_batch[] = $update_data;
		}
		if(count($update_batch)==0){
			print "TRUE";
			return TRUE;
		}
		$this->db->update_batch('section', $update_batch, 'ID');
		if($this->db->affected_rows()>0){
			print "TRUE";
			return TRUE;
		} else {
			print $this->db->last_query();
			return FALSE;
		}
	}	
	
	function renumber_up($data){
		$update_batch = array();
		$this->db->select('ID,story_subsection');
		$this->db->from('section');
		$this->db->where('story_id',$data['story_id']);
		$this->db->where('story_section',$data['story_section']);
		$this->db->where('story_subsection > ',$data['story_subsection']);
		$this->db->where('dateremoved <=',0);
		$query = $this->db->get();
		$result = $query->result();
		foreach($result AS $item){
			$update_data = array(
				'ID' => $item->ID,
				'story_subsection' => $item->story_subsection+1,
			);
			$update_batch[] = $update_data;
		}
	if(count($update_batch)==0){
			print "TRUE";
			return TRUE;
		}
		$this->db->update_batch('section', $update_batch, 'ID');
		if($this->db->affected_rows()>0){
			print "TRUE";
			return TRUE;
		} else {
			print $this->db->last_query();
			return FALSE;
		}
	}	
	
	function renumber_for_drag($data){
		$story_id = $data['story_id'][0];
		$this->create_history($story_id);
		if(isset($data['quote_id'])){
			$neworder = $data['neworder'];
			$quote = 'quote'.$data['quote_id'][0];
			$key = array_search($quote, $neworder);
			$after_subsection = (int) preg_replace('/subsection/i','',$neworder[$key-1]);
			$this->db->where('ID',$data['quote_id'][0]);
			$update_data = array(
				'after_subsection' => $after_subsection
			);
			$this->db->update('quote_ribbon',$update_data);
		} else {
			$update_batch = array();
			foreach($data['neworder'] AS $k => $v){
				if(strpos($v,'quote')!==FALSE){
					continue;
				}
				$key = $k + 1;
				$val = (int) preg_replace('/subsection/i','',$v);
				print $key.' '.$val;
				if($key != $val){
					$this->db->select('ID');
					$this->db->from('section');
					$this->db->where('story_id',$story_id);
					$this->db->where('story_section',$data['story_section'][0]);
					$this->db->where('story_subsection',$val);
					$query = $this->db->get();
					$result = $query->result();
					foreach($result AS $item){
						$update_data = array(
							'ID' => $item->ID,
							'story_subsection' => $key
						);
						$update_batch[] = $update_data;
					}
				}
			}
			if(count($update_batch)==0){
				print "TRUE";
				return TRUE;
			}
			$this->db->update_batch('section', $update_batch, 'ID');
		}
		if($this->db->affected_rows()>0){
			$this->set_updated_time_on_story($story_id);
			print "TRUE";
			return TRUE;
		} else {
			print $this->db->last_query();
			return FALSE;
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