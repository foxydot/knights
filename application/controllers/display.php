<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Display extends CI_Controller {
    public function __construct()
       {
            parent::__construct();
            if(!$this->common->checkinstallation()){
                $this->load->helper('url');
                redirect('/install');
            }
            $this->load->model('Organizations','Orgs');
            $this->common->get_org_info_from_subdomain();
       }
    
    function index()
        {
            $data['org'] = $this->Orgs->get_org($this->common->get_org_info_from_subdomain());
            $this->load->view('css.tpl.php',$data);
        }
}

/* End of file display.php */
/* Location: ./application/controllers/display.php */