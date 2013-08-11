<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
			$this->authenticate->check_auth('administrators',true);
			$this->load->model('Articles');
       }
       
	function index()
		{
			$org_id = 1;
			$data = array(
				'page_title' => SITENAME.' Help',
				'body_class' => 'list articlelist',
				'user' => $this->session->userdata,
				'articles' => $this->Articles->get_articles(),
				'dashboard' => 'default/help/list',
			);	
			$data['footer_js'][] = 'jquery/list';
			$this->load->view('default.tpl.php',$data);
		}

	function add()
		{
			$org_id = 1;
			$data = array(
					'page_title' => SITENAME.' Add Help Article',
					'body_class' => 'add article-add',
					'user' => $this->session->userdata,
					'dashboard' => 'default/help/edit',
					'action' => 'help/add',
					'is_edit' => FALSE,
			);
			if($this->input->post()){
				$db_data = $this->input->post();
				unset($db_data['parent_art_id']);
				$art_id = $this->Articles->add_article($db_data);
				$this->Articles->art_to_org(array('art_id' => $art_id,'parent_art_id' => $this->input->post('parent_art_id'),'org_id' => $org_id));
				$this->load->helper('url');
				redirect('/help');
			}
		
			$this->load->view('default.tpl.php',$data);
		}

	function edit($ID)
		{
			$org_id = 1;
			$data = array(
					'page_title' => SITENAME.' Edit Help Article',
					'body_class' => 'edit article-edit',
					'user' => $this->session->userdata,
					'article' => $this->Articles->get_article($ID),
					'dashboard' => 'default/help/edit',
					'action' => 'help/edit/'.$ID,
					'is_edit' => TRUE,
			);
			if($this->input->post()){
				$db_data = $this->input->post();
				$parent_art_id = $db_data['parent_art_id'];
				unset($db_data['parent_art_id']);
				$this->Articles->edit_article($db_data);
				$this->Articles->clear_art_to_org($db_data['ID']);
				$this->Articles->art_to_org(array('art_id' => $db_data['ID'],'parent_art_id' => $this->input->post('parent_art_id'),'org_id' => $org_id));
				$this->load->helper('url');
				redirect('/help');
			}
		
			$this->load->view('default.tpl.php',$data);
		}	
}

/* End of file article.php */
/* Location: ./application/controllers/article.php */