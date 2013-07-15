<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
			$this->authenticate->check_auth('administrators',true);
			$this->load->model('Categories','Cats');
       }
       
	function index()
		{
			$data = array(
				'page_title' => SITENAME.' Categories',
				'body_class' => 'list categorylist',
				'user' => $this->session->userdata,
				'cats' => $this->Cats->get_cats(),
				'dashboard' => 'default/cat/list',
			);	
			$data['footer_js'][] = 'jquery/list';
			$this->load->view('default.tpl.php',$data);
		}

	function add()
		{
			$data = array(
					'page_title' => SITENAME.' Add Category',
					'body_class' => 'add category-add',
					'user' => $this->session->userdata,
					'dashboard' => 'default/cat/edit',
					'action' => 'category/add',
					'is_edit' => FALSE,
			);
			if($this->input->post()){
				$db_data = $this->input->post();
				$this->Cats->add_cat($db_data);
		
				$this->load->helper('url');
				redirect('/category');
			}
		
			$this->load->view('default.tpl.php',$data);
		}

	function edit($ID)
		{
			$data = array(
					'page_title' => SITENAME.' Edit Category',
					'body_class' => 'edit category-edit',
					'user' => $this->session->userdata,
					'cat' => $this->Cats->get_cat($ID),
					'dashboard' => 'default/cat/edit',
					'action' => 'category/edit/'.$ID,
					'is_edit' => TRUE,
			);
			if($this->input->post()){
				$db_data = $this->input->post();
				$this->Cats->edit_cat($db_data);
		
				$this->load->helper('url');
				redirect('/category');
			}
		
			$this->load->view('default.tpl.php',$data);
		}	
}

/* End of file category.php */
/* Location: ./application/controllers/category.php */