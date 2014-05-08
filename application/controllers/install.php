<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {
    //TODO: Rename to maintenance and do a runaround for install
	public function index()
	{
		$data = array();
		if($this->common->checkinstallation()){
			die('Application is already installed.');
		}
		if(empty($_POST)){
			$data = array(
				'form' => 'default/sysadmin/install',
			);
			$this->load->view('login/login.tpl.php',$data);
		} else {
			if($_POST['user_pwd'] != $_POST['user_pwd_chk']){
			$data = array(
				'form' => 'default/sysadmin/install',
				'msg' => 'passwords do not match',
			);
			$this->load->view('login/login.tpl.php',$data);
			} else {
				$this->load->model('sysadmin');
				$this->sysadmin->install();
			}
		}		
	}
	
	public function uninstall(){
		$this->authenticate->check_auth('administrators',true);
		if($this->session->userdata['ID'] == 1){
			$data['form'] = 'default/sysadmin/uninstall';
			if(empty($_POST)){
				$this->load->view('login/login.tpl.php',$data);
			} else {
				$this->load->model('sysadmin');
				$this->sysadmin->uninstall();
				$this->session->sess_destroy();
				$this->load->helper('url');
				redirect('/install');
			}
		}
    }
}

/* End of file install.php */
/* Location: ./application/controllers/install.php */