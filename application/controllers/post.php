<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
			$this->authenticate->check_auth('users',true);
			$this->load->model('Posts');
       }
       
	function index(){
		$data = array(
				'page_title' => 'Welcome to '.SITENAME,
				'body_class' => 'list dashboard',
				'dashboard' => 'default/post/list',
				'user' => $this->session->userdata,
				'catsposts' => $this->Posts->get_cats_and_posts(array('orgs' => 'all')),
				'archive' => FALSE,
		);
		$data['footer_js'][] = 'jquery/list';
		$this->load->view('default.tpl.php',$data);
	}
	
	function user($user_id){
		$data = array(
				'page_title' => 'Welcome to '.SITENAME,
				'body_class' => 'list dashboard',
				'dashboard' => 'default/post/list',
				'user' => $this->session->userdata,
				'catsposts' => $this->Posts->get_cats_and_posts(array('orgs' => 'all','user_id'=>$user_id)),
				'archive' => FALSE,
		);
		$data['footer_js'][] = 'jquery/list';
		$this->load->view('default.tpl.php',$data);	
	}

	function add(){
		$this->load->model('Categories','Cats');
		$this->load->model('Users');
		$this->load->model('Organizations','Orgs');
		$data = array(
				'page_title' => SITENAME.' Add Post',
				'body_class' => 'add post-add',
				'user' => $this->session->userdata,
				'cats' => $this->Cats->group_cats_by_parent($this->Cats->get_cats()),
				'dashboard' => 'default/post/edit',
				'action' => 'post/add/',
				'is_edit' => FALSE,
		);
		if($this->input->post()){
			$db_data = $this->input->post();
			unset($db_data['cat']);
			$db_data['org'] = $this->Orgs->get_org($this->input->post('org_id'));
			$attachment_url = FALSE;
			if(!empty($_FILES['attachment_url']['name'])){
				$this->load->model('Administration','Admin');
				$attachment_url = $this->Admin->upload($db_data,'attachment_url');
			}
			unset($db_data['org']);
			unset($db_data['org_id']);
			unset($db_data['attachment_url']);
			$post_id = $this->Posts->add_post($db_data);
			foreach($this->input->post('cat') AS $cat_id){
				$this->Posts->post_to_cat(array('post_id' => $post_id,'cat_id' => $cat_id));
			}
			if($attachment_url){
				$db_data = array(
						'attachment_url'=>'attachment_url',
						'title' => $this->input->post('title'),
						'attachment_url'=>$attachment_url,
						'dateadded'=>time()
				);
				$attachment_id = $this->Posts->add_attachment($db_data);
				$db_data = array(
						'attachment_id' => $attachment_id,
						'post_id' => $post_id,
				);
				$this->Posts->attachment_to_post($db_data);
			}
			$this->load->helper('url');
			redirect('/post');
		}
		$this->load->view('default.tpl.php',$data);
	}

	function edit($ID){
		$this->load->model('Categories','Cats');
		$this->load->model('Users');
		$this->load->model('Organizations','Orgs');
		$data = array(
				'page_title' => SITENAME.' Edit Post',
				'body_class' => 'add post-add',
				'user' => $this->session->userdata,
				'post' => $this->Posts->get_post($ID),
				'cats' => $this->Cats->group_cats_by_parent($this->Cats->get_cats()),
				'dashboard' => 'default/post/edit',
				'action' => 'post/edit/'.$ID,
				'is_edit' => TRUE,
		);
		if($this->input->post()){
			$db_data = $this->input->post();
			unset($db_data['cat']);
			$db_data['org'] = $this->Orgs->get_org($this->input->post('org_id'));
			$attachment_url = FALSE;
			if(!empty($_FILES['attachment_url']['name'])){
				$this->load->model('Administration','Admin');
				$attachment_url = $this->Admin->upload($db_data,'attachment_url');
			}
			unset($db_data['org']);
			unset($db_data['org_id']);
			unset($db_data['attachment_url']);
			$this->Posts->edit_post($db_data);
			$this->Posts->clear_post_to_cats($db_data['ID']);
			if($this->input->post('cat')){
				foreach($this->input->post('cat') AS $cat_id){
					$this->Posts->post_to_cat(array('post_id' => $db_data['ID'],'cat_id' => $cat_id));
				}
			}
			if($attachment_url){
				$db_data = array(
						'attachment_url'=>'attachment_url',
						'title' => $this->input->post('title'),
						'attachment_url'=>$attachment_url,
						'dateadded'=>time()
				);
				$attachment_id = $this->Posts->add_attachment($db_data);
				$db_data = array(
						'attachment_id' => $attachment_id,
						'post_id' => $ID,
				);
				$this->Posts->attachment_to_post($db_data);
			}
			
			$this->load->helper('url');
			redirect('/post');
		}
		$this->load->view('default.tpl.php',$data);
	}
	
	function view($ID){
		$this->load->model('Categories','Cats');
		$this->load->model('Users');
		$post = $this->Posts->get_post($ID);
		$data = array(
				'page_title' => SITENAME.$post->title,
				'body_class' => 'add post-add',
				'user' => $this->session->userdata,
				'post' => $post,
				'cats' => $this->Cats->get_cats(),
				'dashboard' => 'default/post/view',
				'action' => array('buy' => '','contact' => ''),
				'is_edit' => TRUE,
		);
		$this->load->view('default.tpl.php',$data);
	}
}

/* End of file post.php */
/* Location: ./application/controllers/post.php */