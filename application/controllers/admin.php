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
	    $global $org_id;
        $this->authenticate->check_auth('administrators',true);
            $data = array(
                'page_title' => SITENAME.' Admin',
                'body_class' => 'list admin',
                'user' => $this->session->userdata,
                'orgs' => $this->Orgs->get_orgs(),
            );
            $data['footer_js'][] = 'jquery/list';
        if($this->authenticate->check_auth('super-administrators',false) && !$org_id){
            //redirect to sysadmin panel
            $this->load->helper('url');
            redirect('/sysadmin');   
        } else {
            //load panel for admin level admin.
        }
    }
   
    public function edit_post_types(){
        $this->authenticate->check_auth('super-administrators',true);
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
                    'dashboard' => 'default/sysadmin/edit_post_types',
            );
            $this->load->view('default.tpl.php',$data);
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */