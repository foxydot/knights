<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
			$this->authenticate->check_auth('administrators',true);
			$this->load->model('Administration','Admin');
            $this->load->model('Organizations','Orgs');
            $this->common->get_org_info_from_subdomain();
       }
	
	function index(){
        $this->authenticate->check_auth('administrators',true);
            $data = array(
                'page_title' => SITENAME.' Admin',
                'body_class' => 'list admin',
                'user' => $this->session->userdata,
                'orgs' => $this->Orgs->get_orgs(),
            );
            $data['footer_js'][] = 'jquery/list';
        if($this->authenticate->check_auth('super-administrators',false)){
            $this->load->model('sysadmin');
            $data['system_info'] = $this->common->getSystemInfo();
            $data['update_database_version'] = $this->sysadmin->get_update_version();
            $data['dashboard'] = 'default/sysadmin/maintenance';
            if(empty($_POST)){
                $this->load->view('default.tpl.php',$data);
            } else {
                $this->sysadmin->upgrade();
            }
        } else {
            //load panel for admin level admin.
        }
    }
    
    public function backup_db(){
        $this->authenticate->check_auth('administrators',true);
        if($this->session->userdata['ID'] == 1){
            $this->load->model('sysadmin');
            $this->sysadmin->backup_db();
        }
    }
    
    public function edit_post_types(){
        $this->authenticate->check_auth('administrators',true);
        if($this->session->userdata['ID'] == 1){
            $this->load->model('sysadmin');
            if(!empty($_POST)){
                $types = array_filter(array_combine($_POST['key'],$_POST['value']));
                $this->sysadmin->update_types(serialize($types));
            }
            $the_types = $this->common->get_sysadmin_item('post_types',TRUE);
            $data = array(
                    'body_class' => 'edit admin-edit',
                    'user' => $this->session->userdata,
                    'types' => unserialize($the_types->sysinfo_value),
                    'form' => 'default/sysadmin/edit_post_types',
            );
            $this->load->view('login/login.tpl.php',$data);
        }
    }
    
    
    ///OLD STUFF BELOW, MAYBE REMOVE?
	
	function edit_section($section_id,$story_id){
		if($this->input->post()){
			$db_data = array(
				'content' => $this->input->post('editorContent'),
				'story_id' => $story_id,
			);
			$this->Admin->create_history($story_id);
			$this->Admin->edit_section($section_id,$db_data);
			$this->Admin->set_updated_time_on_story($story_id);
			$this->load->helper('url');
			redirect('/admin/edit/'.$story_id.'#id'.$section_id);		
		}
	}
	
	function textedit($datastr){
		preg_match_all("/([^\:]+)\:([^\:]+)/", $datastr, $pairs);
		$input = array_combine($pairs[1], $pairs[2]);
		$data = array(
				'page_title' => 'Inline Editor',
				'body_class' => 'inlineEditor',
				'user' => $this->session->userdata,
				'story' => $this->Admin->get_story($input['story_id']),
				'section' => $this->Admin->get_section($input['section_id']),
			);
		$this->load->view('admin/texteditor.tpl.php',$data);
	}
	
	function upload($datastr){
		preg_match_all("/([^\:]+)\:([^\:]+)/", $datastr, $pairs);
		$input = array_combine($pairs[1], $pairs[2]);
		$data = array(
				'page_title' => 'Upload Attachment',
				'body_class' => 'uploadAttachment',
				'user' => $this->session->userdata,
				'story' => $this->Admin->get_story($input['story_id']),
				'section' => $this->Admin->get_section($input['section_id']),
				'attachments' => $this->Admin->get_attachments($input['section_id']),
				'attachment_types' => $this->Admin->get_attachment_types(),
				'dashboard' => 'admin/uploadattachment',
			);
		$data['footer_js'][] = 'jquery/media';	
		if($this->input->post()){
			$this->Admin->create_history($input['story_id']);
			$this->load->helper('url');
			//ts_data($this->input->post());
			if($this->input->post('attachment_type') == 3 && $this->input->post('embed_url')){
				$attachment_url = $this->input->post('embed_url');
			} else {
				$uploads_dir = SITEPATH.'uploads/';
				$uploads_url = site_url('uploads/');
				$project_slug = post_slug($data['story']->name);
				$story_slug = $data['story']->slug;
				$project_dir = $uploads_dir.$project_slug;
				//create the upload folder
				if(!is_dir($project_dir)){
					mkdir($project_dir,0777);
				}
				$upload_dir = $project_dir.'/'.$story_slug;
				//create the upload folder
				if(!is_dir($upload_dir)){
					mkdir($upload_dir,0777);
				}
				//upload the file
				$config['upload_path'] = $upload_dir;
				$config['allowed_types'] = 'pdf|gif|jpeg|jpg|png';
				$config['max_size'] = '100000';

				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload())
				{	
					$this->session->set_flashdata('err',$this->upload->display_errors());
					//redirect('/admin/edit/'.$input['story_id']);
					redirect('/admin/edit/'.$input['story_id'].'#id'.$input['section_id']);					
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
					$attachment_url = $uploads_url.'/'.$project_slug.'/'.$story_slug.'/'.$data['upload_data']['file_name'];
				}
			}
			//insert the info about the attachment
			$attachment_url = $this->clean_url($attachment_url);
			$db_data = array(
				'attachment_url' => $attachment_url,
				'attachment_type' => $this->input->post('attachment_type'),
				'title' => $this->input->post('title'),
				'modal' => $this->input->post('modal'),
			);
			if(!($attachment_id = $this->Admin->add_attachment($db_data))){
				die('attachment not added.');
			}
			//add attachment/section info
			$db_data = array(
				'attachment_id' => $attachment_id,
				'section_id' => $this->input->post('section'),
			);
			if(!$this->Admin->attachment_to_section($db_data)){
				die('Attachment cannot be added to section');
			}
			
			$this->Admin->set_updated_time_on_story($input['story_id']);
			$this->session->set_flashdata('msg',$attachment_url.' attached!');
			//redirect('/admin/edit/'.$input['story_id']);
			redirect('/admin/edit/'.$input['story_id'].'#id'.$input['section_id']);					
			
		} else {
			$this->load->view('default.tpl.php',$data);
		}
	}
	
	function edit_media($attachment_id){
		$data = array(
				'page_title' => 'Edit Attachment',
				'body_class' => 'editAttachment',
				'user' => $this->session->userdata,
				'attachment' => $this->Admin->get_attachment($attachment_id),
				'attachment_types' => $this->Admin->get_attachment_types(),
				'dashboard' => 'admin/editattachment',
			);
		$data['footer_js'][] = 'jquery/media';	
		if($this->input->post()){
			$db_data = $this->input->post(NULL, TRUE);
			$this->Admin->edit_attachment($attachment_id,$db_data);
		}		
		$this->load->view('default.tpl.php',$data);
	}
	
	
	
	function edit_story($story_id){
		$this->load->model('Users');
		$story_data = $this->Admin->get_story($story_id);
		$data = array(
				'page_title' => 'Story Settings',
				'body_class' => 'story popup',
				'story_data' => $story_data,
				'author_data' => $this->Users->get_user($story_data->author_id),
				'author_options' => $this->Users->get_users_by_level('administrators'),
				'user' => $this->session->userdata,
				'dashboard' => 'admin/add',
				'action' => 'admin/edit_story/'.$story_id,
				'is_edit' => TRUE,
			);
		$data['footer_js'][] = 'jquery/add';	
		if($this->input->post()){
			if(!$this->input->post('project_id')){
				//check project name against exisiting
				$result = $this->Admin->get_project_by_name($this->input->post('name'));
				if($result){
					$project_id = $result->ID;
				} else {
				//if not exist, add, get id.
					$db_data = array(
						'name' => $this->input->post('name'),
					);
					$project_id = $this->Admin->add_project($db_data);
				}
			} else {
				$project_id = $this->input->post('project_id');
			}
			//add story info, get id
			$db_data = array(
				'ID' => $story_id,
				'title' => $this->input->post('title'),
				'password' => $this->input->post('password'),
				'author_id' => $this->input->post('author_id'),
				'datepresented' => strtotime($this->input->post('datepresented')),
			);
			if(isset($_FILES['logo_url'])||isset($_FILES['banner_url'])){
				$story = $this->Admin->get_story($story_id);
				$uploads_dir = SITEPATH.'uploads/';
				$uploads_url = site_url('uploads/');
				$project_slug = post_slug($story->name);
				$story_slug = $story->slug;
				$project_dir = $uploads_dir.$project_slug;
				//create the upload folder
				if(!is_dir($project_dir)){
					mkdir($project_dir,0777);
				}
				chmod($project_dir,0777);
				$upload_dir = $project_dir.'/'.$story_slug;
				//create the upload folder
				if(!is_dir($upload_dir)){
					mkdir($upload_dir,0777);
				}
				chmod($upload_dir,0777);
				//upload the file
				$config['upload_path'] = $upload_dir;
				$config['allowed_types'] = 'gif|jpeg|jpg|png';
				$config['max_size'] = '100000';

				$this->load->library('upload', $config);
				foreach($_FILES AS $k=>$v){
					if ( ! $this->upload->do_upload($k))
					{	
						$this->session->set_flashdata('err',$this->upload->display_errors());			
					}
					else
					{
						$data = array('upload_data' => $this->upload->data());
						$db_data[$k] = $uploads_url.'/'.$project_slug.'/'.$story_slug.'/'.$data['upload_data']['file_name'];
					}
				}
			}
			$this->Admin->create_history($story_id);
			$this->Admin->edit_story($story_id,$db_data);
			//add project/story info
			$db_data = array(
				'project_id' => $project_id,
				'story_id' => $story_id,
			);
			$this->Admin->edit_story_to_project($db_data);
			//add a bunch of empty section fields
			$this->load->helper('url');
			redirect('/admin/edit/'.$story_id);		
		}
		$this->load->view('default.tpl.php',$data);
	}
	
	function clone_story($story_id){
			$this->Admin->clone_story($story_id);
			$this->load->helper('url');
			redirect('/admin');		
	}
	
	function undo_edit($story_id){
		$this->Admin->restore_from_history($story_id);
		$this->load->helper('url');
		redirect('/admin/edit/'.$story_id);		
	}
	
	
	function listarchive()
		{
			$data = array(
				'page_title' => 'Welcome to '.SITENAME,
				'body_class' => 'list',
				'user' => $this->session->userdata,
				'projects' => $this->Admin->get_projects_and_stories('only'),
				'archive' => TRUE,
			);
			$data['footer_js'][] = 'jquery/index';
			$this->load->view('default.tpl.php',$data);
		}
	function clean_url($url){
		return preg_replace('/[^a-zA-Z0-9\_\-\?\&\+\.\/\:]/i','',$url);
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */