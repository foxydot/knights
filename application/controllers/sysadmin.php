<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sysadmin extends CI_Controller {
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
            $this->load->model('Systemadmin','sysadmin');
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
            $this->sysadmin->backup_db();
        }
    }
    
    public function edit_post_types(){
        $this->authenticate->check_auth('super-administrators',true);
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

/* End of file sysadmin.php */
/* Location: ./application/controllers/sysadmin.php */