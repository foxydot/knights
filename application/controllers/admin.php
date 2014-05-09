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
	    global $org_id;
        $this->authenticate->check_auth('administrators',true);
            $data = array(
                'page_title' => SITENAME.' Admin',
                'body_class' => 'list admin',
                'user' => $this->session->userdata,
                'orgs' => $this->Orgs->get_orgs(),
            );
            $data['footer_js'][] = 'jquery/list';
        if($this->authenticate->check_auth('super-administrators',false) && $org_id == 1){
            //redirect to sysadmin panel
            $this->load->helper('url');
            redirect('/sysadmin');   
        } else {
            //load panel for admin level admin.
            print 'load admin level admin';
        }
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */