<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presentation extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
			$this->load->model('Administration','Admin');
			$this->load->model('Display');
       }
	function index($story_id = NULL)
		{
			//if a project id isn't provided, forward to an unknown dashboard.
			if(!$story_id){
				$this->load->helper('url');
				redirect('/login');
			} else {
				$allow_unpublished = $this->authenticate->check_auth();
				$story_id = $this->Display->get_numeric_story_id($story_id);
				$story = $this->Display->get_story($story_id,$allow_unpublished);
				if(!$story){
					$this->session->set_flashdata('err', 'The story you are trying to view is not available or unpublished.');
					$this->load->helper('url');
					redirect('/login');
				}
				//check to see if the user has logged in
				$cookie_name = $story->slug;
				$exp = time() + (24*60*60);
				$mycookie = isset($_COOKIE[$cookie_name])?$_COOKIE[$cookie_name] : FALSE;
				if($this->authenticate->check_auth()){
					setcookie($cookie_name,TRUE,$exp);
					$logged_in = TRUE;
				} else {
					if(!$mycookie && !$this->input->post()){
					//if not, display a login
						$logged_in = FALSE;
					} elseif(!$mycookie && $this->input->post()){
					//if loggin, cookie it and let through
						$logged_in = $this->Display->dostorylogin($story,$this->input->post());
						if($logged_in && $this->input->post('remember')){
							setcookie($cookie_name,TRUE,$exp);
						}
					} else {				
						//if cookied, let through//get the data for the project
						$logged_in = $_COOKIE[$cookie_name];
					}
				}
				if($logged_in){
					foreach($story->sections AS $sectionkey => $section){
						for($i=1;$i<count($section);$i++){
						$page_jquery[] = render_section_jquery($section[$i]);
						}
					}
					$data = array(
						'page_title' => 'Presentation Name',
						'css_class' => 'presentation',
						'story' => $story,
						'quotes' => $this->Display->get_quotes($story_id),
						'image_upload_dir' => '/uploads/'.$story_id.'/',
						'page_jquery' => $page_jquery,
					);
				} else {
					$data = array(
						'action' => $this->uri->uri_string(),
						'dashboard' => 'login/dashboard',
						'form' => 'login/storylogin',
						'page_css' => '/assets/frontend/css/login.css',
					);
				}
			}
			$this->load->view('primary.tpl.php',$data);
		}
		
	function pdf($story_id){
		$this->load->helper(array('dompdf', 'file'));
	     // page info here, db calls, etc.     
	     $html = $this->load->view('defaults/pdf', $data, true);
	     pdf_create($html, 'filename');
	     /*or
	     $data = pdf_create($html, '', false);
	     write_file('name', $data);
	     //if you want to write it to disk and/or send it as an attachment    */
	}
	
	function ppt($story_id){
		
	}
}

/* End of file presentation.php */
/* Location: ./application/controllers/presentation.php */