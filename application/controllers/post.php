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
				'catsposts' => $this->Posts->get_cats_and_posts('all'),
				'archive' => FALSE,
		);
		$data['footer_js'][] = 'jquery/index';
		$this->load->view('default.tpl.php',$data);
	}
	
	function add(){
		$this->load->model('Categories','Cats');
		$this->load->model('Users');
		$data = array(
				'page_title' => 'Welcome to '.SITENAME,
				'body_class' => 'addPost',
				'user' => $this->session->userdata,
				'cats' => $this->Cats->get_cats(),
				'dashboard' => 'default/post/edit',
				'action' => 'post/add/',
				'is_edit' => FALSE,
		);
		$data['footer_js'][] = 'jquery/add';
		if($this->input->post()){
			$db_data = array(
					'title' => $this->input->post('title'),
					'author_id' => $this->input->post('author_id'),
					'content' => $this->input->post('content'),
					'cost' => $this->input->post('cost'),
			);
			$post_id = $this->Admin->add_post($db_data);
			foreach($this->input->post('categories') AS $cat_id){
				
			}
		}
		$this->load->view('default.tpl.php',$data);
	}
	
}

/* End of file post.php */
/* Location: ./application/controllers/post.php */