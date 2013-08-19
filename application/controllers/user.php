<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
			$this->load->model('Users');
       }
	
	function index()
		{
			$this->authenticate->check_auth('administrators',true);
			$data = array(
				'page_title' => SITENAME.' All Users',
				'body_class' => 'list userlist',
				'user' => $this->session->userdata,
				'users' => $this->Users->get_all_users(),
				'dashboard' => 'default/user/list',
			);
			$data['footer_js'][] = 'jquery/list';
			
			$this->load->view('default.tpl.php',$data);
		}
	
	function edit($ID)
		{
			if(!$this->common->is_author($this->session->userdata['ID'],$ID)){$this->authenticate->check_auth('administrators',true);}
			$data = array(
				'page_title' => SITENAME.' Administrative Users',
				'body_class' => 'edit user-edit',
				'user' => $this->session->userdata,
				'the_user' => $this->Users->get_user($ID),
				'access' => $this->authenticate->get_levels(),
				'groups' => $this->Users->get_all_user_groups(),
				'dashboard' => 'default/user/edit',
				'action' => 'user/edit/'.$ID,
				'is_edit' => TRUE,
			);
			if($this->input->post()){
				$db_data = $this->input->post();
				$user_meta = $db_data['meta'];
				unset($db_data['meta']);
				if(!empty($_FILES['userfile']['name'])){
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
						unset($db_data['submit_btn']);
						unset($db_data['passwordtest']);
						$db_data['password'] = md5($db_data['password']);
					}
				} else {
					unset($db_data['submit_btn']);
					unset($db_data['password']);
					unset($db_data['passwordtest']);
					
					$this->Users->edit_user($ID,$db_data);
				}	
				if(count($user_meta>0)){
					foreach($user_meta AS $k=>$v){
						$meta_data = array(
							'user_id' => $ID,
							'org_id' => 1,
							'meta_key' => $k,
							'meta_value' => $v
							);
						$this->Users->edit_user_meta($meta_data);
					}
				}
				$this->load->helper('url');
				redirect('/user');	
			}
			$this->load->view('default.tpl.php',$data);
		}
	
	function add()
		{
			$this->authenticate->check_auth('administrators',true);
			$user_meta = $db_data['meta'];
			unset($db_data['meta']);
			$data = array(
				'page_title' => SITENAME.' Administrative Users',
				'body_class' => 'add user-add',
				'user' => $this->session->userdata,
				'access' => $this->authenticate->get_levels(),
				'groups' => $this->Users->get_all_user_groups(),
				'dashboard' => 'default/user/edit',
				'action' => 'user/add',
				'is_edit' => FALSE,
			);
			if($this->input->post()){
				if($this->input->post('password')!=$this->input->post('passwordtest')){
					//escape
					$this->session->set_flashdata('err', 'Passwords do not match');
				} else {
					$db_data = $this->input->post();
					unset($db_data['submit_btn']);
					unset($db_data['passwordtest']);
					$db_data['password'] = md5($db_data['password']);
					$this->Users->add_user($db_data);
				}		
				if(count($user_meta>0)){
					foreach($user_meta AS $k=>$v){
						$meta_data = array(
							'user_id' => $ID,
							'org_id' => 1,
							'meta_key' => $k,
							'meta_value' => $v
							);
						$this->Users->edit_user_meta($meta_data);
					}
				}
				$this->load->helper('url');
				redirect('/user');	
			}
			
			$this->load->view('default.tpl.php',$data);
		}
		
		function delete($ID)
		{
			if(!$this->common->is_author($this->session->userdata['ID'],$ID)){$this->authenticate->check_auth('administrators',true);}
			if($this->input->post()){
				$db_data = $this->input->post();
				$user_meta = $db_data['meta'];
				unset($db_data['meta']);
				$db_data['dateremoved'] = time();
				unset($db_data['submit_btn']);
				unset($db_data['password']);
				unset($db_data['passwordtest']);
					
				$this->Users->edit_user($ID,$db_data);
				
				if(count($user_meta>0)){
					foreach($user_meta AS $k=>$v){
						$meta_data = array(
								'user_id' => $ID,
								'org_id' => 1,
								'meta_key' => $k,
								'meta_value' => $v,
								'dateremoved' => time()
						);
						$this->Users->edit_user_meta($meta_data);
					}
				}
				$this->load->helper('url');
				redirect('/user');
			}
			$this->load->view('default.tpl.php',$data);
		}
		
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */