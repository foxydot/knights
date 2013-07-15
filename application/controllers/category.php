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
			$this->load->view('default.tpl.php',$data);
		}
}

/* End of file category.php */
/* Location: ./application/controllers/category.php */