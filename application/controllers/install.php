<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {
	public function index()
	{
		$data = array();
		if($this->common->checkinstallation()){
			die('Application is already installed.');
		}
		if(empty($_POST)){
			$data = array(
				'form' => 'admin/install',
				'dashboard' => 'login/dashboard',
			);
			$this->load->view('admin.tpl.php',$data);
		} else {
			if($_POST['user_pwd'] != $_POST['user_pwd_chk']){
			$data = array(
				'form' => 'admin/install',
				'msg' => 'passwords do not match',
				'dashboard' => 'login/dashboard',
			);
			$this->load->view('admin.tpl.php',$data);
			} else {
				$this->load->model('sysadmin');
				$this->sysadmin->install();
			}
		}		
	}
	
	public function uninstall(){
		$this->authenticate->check_auth('administrators',true);
		if($this->session->userdata['ID'] == 1){
			$data['form'] = 'admin/uninstall';
			$data['dashboard'] = 'login/dashboard';
			if(empty($_POST)){
				$this->load->view('admin.tpl.php',$data);
			} else {
				$this->load->model('sysadmin');
				$this->sysadmin->uninstall();
				$this->session->sess_destroy();
				$this->load->helper('url');
				redirect('/install');
			}
		}
	}
	public function maintenance(){
		$this->authenticate->check_auth('administrators',true);
		if($this->session->userdata['ID'] == 1){
			$this->load->model('sysadmin');
			$data['system_info'] = $this->common->getSystemInfo();
			$data['update_database_version'] = $this->sysadmin->get_update_version();
			$data['form'] = 'admin/maintenance';
			$data['dashboard'] = 'login/dashboard';
			if(empty($_POST)){
				$this->load->view('admin.tpl.php',$data);
			} else {
				$this->sysadmin->upgrade();
			}
		}
	}
	public function backup_db(){
		$this->authenticate->check_auth('administrators',true);
		if($this->session->userdata['ID'] == 1){
			$this->load->model('sysadmin');
			$this->sysadmin->backup_db();
		}
	}

}

/* End of file install.php */
/* Location: ./application/controllers/install.php */