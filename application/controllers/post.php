<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
			$this->authenticate->check_auth('authors',true);
       }
       
	function index(){
		
	}
	
	function add(){
		$this->load->model('Users');
		$data = array(
				'page_title' => 'Welcome to '.SITENAME,
				'body_class' => 'addPost',
				'user' => $this->session->userdata,
				'dashboard' => 'admin/post',
				'action' => 'post/add/',
				'is_edit' => FALSE,
		);
		$data['footer_js'][] = 'jquery/add';
		if($this->input->post()){
			//add story info, get id
			$db_data = array(
					'title' => $this->input->post('title'),
					'author_id' => $this->input->post('author_id'),
					'content' => $this->input->post('content'),
					'cost' => $this->input->post('cost'),
			);
			$post_id = $this->Admin->add_post($db_data);
				
				
			/****************************************
				*****************************************
			****************************************/
				
				
				
				
			//add project/story info
			$db_data = array(
					'project_id' => $project_id,
					'story_id' => $story_id,
			);
			$this->Admin->story_to_project($db_data);
			//add a bunch of empty section fields
			$this->Admin->story_section_boilerplate($story_id);
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
				$upload_dir = $project_dir.'/'.$story_slug;
				//create the upload folder
				if(!is_dir($upload_dir)){
					mkdir($upload_dir,0777);
				}
				//upload the file
				$config['upload_path'] = $upload_dir;
				$config['allowed_types'] = 'gif|jpeg|jpg|png';
				$config['max_size'] = '100000';
	
				$this->load->library('upload', $config);
				$db_data = array(
						'title' => $this->input->post('title'),
						'password' => $this->input->post('password'),
						'author_id' => $this->input->post('author_id'),
						'datepresented' => strtotime($this->input->post('datepresented')),
				);
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
				//do the db stuff
				$this->Admin->edit_story($story_id,$db_data);
			}
			$this->load->helper('url');
			redirect('/admin/');
		}
		$this->load->view('admin.tpl.php',$data);
	}
	
	
}

/* End of file post.php */
/* Location: ./application/controllers/post.php */