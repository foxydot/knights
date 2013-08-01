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
			$org_id = 1;
			$cats = $this->Cats->get_cats();
			$data = array(
				'page_title' => SITENAME.' Categories',
				'body_class' => 'list categorylist',
				'user' => $this->session->userdata,
				'cats' => $this->Cats->group_cats_by_parent($cats),
				'dashboard' => 'default/cat/list',
			);	
			$data['footer_js'][] = 'jquery/list';
			$this->load->view('default.tpl.php',$data);
		}

	function add()
		{
			$org_id = 1;
			$data = array(
					'page_title' => SITENAME.' Add Category',
					'body_class' => 'add category-add',
					'user' => $this->session->userdata,
					'cats' => $this->Cats->get_cats(array($org_id)),
					'dashboard' => 'default/cat/edit',
					'action' => 'category/add',
					'is_edit' => FALSE,
			);
			if($this->input->post()){
				$db_data = $this->input->post();
				unset($db_data['parent_cat_id']);
				$cat_id = $this->Cats->add_cat($db_data);
				$this->Cats->cat_to_org(array('cat_id' => $cat_id,'parent_cat_id' => $this->input->post('parent_cat_id'),'org_id' => $org_id));
				$this->load->helper('url');
				redirect('/category');
			}
		
			$this->load->view('default.tpl.php',$data);
		}

	function edit($ID)
		{
			$org_id = 1;
			$data = array(
					'page_title' => SITENAME.' Edit Category',
					'body_class' => 'edit category-edit',
					'user' => $this->session->userdata,
					'cats' => $this->Cats->get_cats(array($org_id)),
					'cat' => $this->Cats->get_cat($ID),
					'dashboard' => 'default/cat/edit',
					'action' => 'category/edit/'.$ID,
					'is_edit' => TRUE,
			);
			if($this->input->post()){
				$db_data = $this->input->post();
				$parent_cat_id = $db_data['parent_cat_id'];
				unset($db_data['parent_cat_id']);
				$this->Cats->edit_cat($db_data);
				$this->Cats->clear_cat_to_org($db_data['ID']);
				$this->Cats->cat_to_org(array('cat_id' => $db_data['ID'],'parent_cat_id' => $this->input->post('parent_cat_id'),'org_id' => $org_id));
				$this->load->helper('url');
				redirect('/category');
			}
		
			$this->load->view('default.tpl.php',$data);
		}	
}

/* End of file category.php */
/* Location: ./application/controllers/category.php */