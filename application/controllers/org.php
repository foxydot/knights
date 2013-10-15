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
            $this->common->get_org_info_from_subdomain();
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
                $org_meta = $db_data['meta'];
                unset($db_data['meta']);
				unset($db_data['change_img']);
				$ID = $this->Orgs->add_org($db_data);
				
				$db_data['org'] = $this->Orgs->get_org($ID);
				if(isset($_FILES['logo_url'])){
					$this->load->model('Administration','Admin');
					$logo_url = $this->Admin->upload($db_data,'logo_url');
				}
				if($logo_url){
					$db_data = array(
							'org_id'=>$ID,
							'meta_key'=>'logo_url',
							'meta_value'=>$logo_url,
							'dateadded'=>time()
					);
					$this->Orgs->add_org_meta($db_data);
				}
		        if(count($org_meta>0)){
                    foreach($org_meta AS $k=>$v){
                        $meta_data = array(
                            'org_id' => $ID,
                            'meta_key' => $k,
                            'meta_value' => $v
                            );
                        $this->Orgs->edit_org_meta($meta_data);
                    }
                }
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
					'org' => $this->Orgs->get_org($ID),
					'dashboard' => 'default/org/edit',
					'action' => 'org/edit/'.$ID,
					'is_edit' => TRUE,
			);
			if($this->input->post()){
				$db_data = $this->input->post();
                $org_meta = $db_data['meta'];
                unset($db_data['meta']);
				unset($db_data['change_img']);
				$db_data['org'] = $this->Orgs->get_org($ID);
				if(isset($_FILES['logo_url'])){
					$this->load->model('Administration','Admin');
					$logo_url = $this->Admin->upload($db_data,'logo_url');
				}
                if(isset($_FILES['test_csv'])){
                    $this->load->model('Administration','Admin');
                    $test_csv = $this->Admin->upload($db_data,'test_csv');
                }
				unset($db_data['org']);
                unset($db_data['logo_url']);
                unset($db_data['test_csv']);
				$this->Orgs->edit_org($db_data);
                if($logo_url){
                    $db_data = array(
                            'org_id'=>$ID,
                            'meta_key'=>'logo_url',
                            'meta_value'=>$logo_url,
                            'dateadded'=>time()
                    );
                    if(!isset($data['org']->meta['logo_url'])){
                        $this->Orgs->add_org_meta($db_data);
                    } else {
                        $db_data['ID'] = $data['org']->meta['logo_url']->ID;
                        $this->Orgs->edit_org_meta($db_data);
                    }
                }
                if($test_csv){
                    $db_data = array(
                            'org_id'=>$ID,
                            'meta_key'=>'test_csv',
                            'meta_value'=>$test_csv,
                            'dateadded'=>time()
                    );
                    if(!isset($data['org']->meta['test_csv'])){
                        $this->Orgs->add_org_meta($db_data);
                    } else {
                        $db_data['ID'] = $data['org']->meta['test_csv']->ID;
                        $this->Orgs->edit_org_meta($db_data);
                    }
                }
		
                if(count($org_meta>0)){
                    foreach($org_meta AS $k=>$v){
                        $meta_data = array(
                            'org_id' => $ID,
                            'meta_key' => $k,
                            'meta_value' => $v
                            );
                        $this->Orgs->edit_org_meta($meta_data);
                    }
                }
				$this->load->helper('url');
				redirect('/org');
			}
		
			$this->load->view('default.tpl.php',$data);
		}	
			
	function delete($ID)
		{
			$data = array(
					'page_title' => SITENAME.' Edit Organization',
					'body_class' => 'edit org-edit',
					'user' => $this->session->userdata,
					'org' => $this->Orgs->get_org($ID),
					'dashboard' => 'default/org/edit',
					'action' => 'org/edit/'.$ID,
					'is_edit' => TRUE,
			);
			if($this->input->post()){
				$db_data = $this->input->post();
				unset($db_data['change_img']);
				unset($db_data['logo_url']);
				$db_data['dateremoved'] = time();
				$this->Orgs->edit_org($db_data);
				
				$this->load->helper('url');
				redirect('/org');
			}
		
			$this->load->view('default.tpl.php',$data);
		}	
}

/* End of file org.php */
/* Location: ./application/controllers/org.php */