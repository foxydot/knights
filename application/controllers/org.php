<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Org extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
			$this->authenticate->check_auth('administrators',true);
			$this->load->model('Organizations','Orgs');
       }
	
	function index()
		{
			$data = array(
				'page_title' => SITENAME.' Organizations',
				'body_class' => 'list orglist',
				'user' => $this->session->userdata,
				'orgs' => $this->Orgs->get_orgs(),
				'dashboard' => 'default/org/list',
			);
			$data['footer_js'][] = 'jquery/list';
			
			$this->load->view('default.tpl.php',$data);
		}

	function add()
		{
			$data = array(
					'page_title' => SITENAME.' Add Organization',
					'body_class' => 'add org-add',
					'user' => $this->session->userdata,
					'dashboard' => 'default/org/edit',
					'action' => 'org/add',
					'is_edit' => FALSE,
			);
			if($this->input->post()){
				$db_data = $this->input->post();
				$this->Orgs->add_org($db_data);
		
				$this->load->helper('url');
				redirect('/org');
			}
		
			$this->load->view('default.tpl.php',$data);
		}
		
	function edit($ID)
		{
			$data = array(
					'page_title' => SITENAME.' Edit Organization',
					'body_class' => 'edit org-edit',
					'user' => $this->session->userdata,
					'organization' => $this->Orgs->get_org($ID),
					'dashboard' => 'default/org/edit',
					'action' => 'org/edit/'.$ID,
					'is_edit' => TRUE,
			);
			if($this->input->post()){
				if(isset($this->input->post('logo_url'))){
					$this->load->model('Administration','Admin');
					$logo_url = $this->Admin->upload($this->input->post('logo_url'));
				}
				$db_data = $this->input->post();
				unset($db_data['logo_url']);
				$this->Orgs->edit_org($db_data);
				$db_data = array(
						'org_id'=>$ID,
						'meta_key'=>'logo_url',
						'meta_value'=>$logo_url,
						'date_added'=>time()
						);
				$this->Orgs->add_org_meta();
				$this->load->helper('url');
				redirect('/org');
			}
		
			$this->load->view('default.tpl.php',$data);
		}	
}

/* End of file org.php */
/* Location: ./application/controllers/org.php */