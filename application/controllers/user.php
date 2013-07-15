<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
			$this->authenticate->check_auth('administrators',true);
			$this->load->model('Users');
       }
	
	function index()
		{
			$data = array(
				'page_title' => SITENAME.' Administrative users',
				'body_class' => 'list userlist',
				'user' => $this->session->userdata,
				'users' => $this->Users->get_all_users(),
				'dashboard' => 'admin/users',
			);
			$data['footer_js'][] = 'jquery/userindex';
			
			$this->load->view('default.tpl.php',$data);
		}
	
	function edit($ID)
		{
			$data = array(
				'page_title' => SITENAME.' Administrative users',
				'body_class' => 'list',
				'user' => $this->session->userdata,
				'the_user' => $this->Users->get_user($ID),
				'access' => $this->authenticate->get_levels(),
				'groups' => $this->Users->get_all_user_groups(),
				'dashboard' => 'admin/adduser',
				'action' => 'user/edit/'.$ID,
				'is_edit' => TRUE,
			);
			if($this->input->post()){
				$db_data = $this->input->post();
				if(isset($_FILES['userfile'])){
					$uploads_dir = SITEPATH.'uploads/';
					$uploads_url = site_url('uploads/');
					$user_slug = post_slug($this->input->post('lastname').'-'.$this->input->post('firstname'));
					$upload_dir = $uploads_dir.$user_slug;
					//create the upload folder
					if(!is_dir($upload_dir)){
						if(!mkdir($upload_dir,0777)){
						die('Could not create dir');
						}
					}
					//upload the file
					$config['upload_path'] = $upload_dir;
					$config['allowed_types'] = 'gif|jpeg|jpg|png';
					$config['max_size'] = '100000';
	
					$this->load->library('upload', $config);
	
					if ( ! $this->upload->do_upload())
					{	
						$this->session->set_flashdata('err',$this->upload->display_errors());	
						redirect('/user');			
					}
					else
					{
						$data = array('upload_data' => $this->upload->data());
						$db_data['avatar'] = $uploads_url.'/'.$user_slug.'/'.$data['upload_data']['file_name'];
					}
				}
				if($this->input->post('password')||$this->input->post('passwordtest')){
					if($this->input->post('password')!=$this->input->post('passwordtest')){
						//escape
						$this->session->set_flashdata('err', 'Passwords do not match');
					} else {
						unset($db_data['submit']);
						unset($db_data['passwordtest']);
						$db_data['password'] = md5($db_data['password']);
					}
				} else {
					unset($db_data['submit']);
					unset($db_data['password']);
					unset($db_data['passwordtest']);
					$this->Users->edit_user($ID,$db_data);
				}	
				$this->load->helper('url');
				redirect('/user');	
			}
			$this->load->view('default.tpl.php',$data);
		}
	
	function add()
		{
			$data = array(
				'page_title' => SITENAME.' Administrative users',
				'body_class' => 'list',
				'user' => $this->session->userdata,
				'access' => $this->authenticate->get_levels(),
				'groups' => $this->Users->get_all_user_groups(),
				'dashboard' => 'admin/adduser',
				'action' => 'user/add',
				'is_edit' => FALSE,
			);
			if($this->input->post()){
				if($this->input->post('password')!=$this->input->post('passwordtest')){
					//escape
					$this->session->set_flashdata('err', 'Passwords do not match');
				} else {
					$db_data = $this->input->post();
					unset($db_data['submit']);
					unset($db_data['passwordtest']);
					$db_data['password'] = md5($db_data['password']);
					$this->Users->add_user($db_data);
				}	
				$this->load->helper('url');
				redirect('/user');	
			}
			
			$this->load->view('default.tpl.php',$data);
		}
		
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */