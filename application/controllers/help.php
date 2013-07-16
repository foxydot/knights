<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
			$this->authenticate->check_auth('users',true);
       }
       
	function index(){
		$data = array(
				'page_title' => 'Welcome to '.SITENAME,
				'body_class' => 'list dashboard',
				'dashboard' => 'default/help/list',
				'user' => $this->session->userdata,
				'archive' => FALSE,
		);
		$data['footer_js'][] = 'jquery/list';
		$this->load->view('default.tpl.php',$data);
	}
}

/* End of file help.php */
/* Location: ./application/controllers/help.php */