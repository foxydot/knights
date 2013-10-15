<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
			$this->authenticate->check_auth('users',true);
			$this->load->model('Posts');
            $this->common->get_org_info_from_subdomain();
       }
       
	function index(){
		$data = array(
				'page_title' => 'Welcome to '.SITENAME,
				'body_class' => 'list dashboard',
				'dashboard' => 'default/post/list-cats',
				'user' => $this->session->userdata,
				'catsposts' => $this->Posts->get_cats_and_posts(array('orgs' => 'all')),
				'archive' => FALSE,
		);
		$data['footer_js'][] = 'jquery/list';
		$this->load->view('default.tpl.php',$data);
	}
	
	function user($user_id){
		$data = array(
				'page_title' => 'Welcome to '.SITENAME,
				'body_class' => 'list dashboard',
				'dashboard' => 'default/post/list',
				'user' => $this->session->userdata,
				'posts' => $this->Posts->get_user_posts(array('orgs' => 'all','user_id'=>$user_id)),
				'archive' => FALSE,
		);
		$data['footer_js'][] = 'jquery/list';
		$this->load->view('default.tpl.php',$data);	
	}

	function add(){
		global $user;
		$this->load->model('Categories','Cats');
		$this->load->model('Users');
		$this->load->model('Organizations','Orgs');
		$the_user = $this->Users->get_user($this->session->userdata['ID']);
        $the_types = $this->common->get_sysadmin_item('post_types',TRUE);
		$data = array(
				'page_title' => SITENAME.': Add Post',
				'body_class' => 'add post-add',
				'user' => $this->session->userdata,
				'cats' => $this->Cats->group_cats_by_parent($this->Cats->get_cats()),
				'types' => unserialize($the_types->sysinfo_value),
				'dashboard' => 'default/post/edit',
				'action' => 'post/add/',
				'is_edit' => FALSE,
		);
		if($this->input->post()){
			$the_user = $this->Users->get_user($this->session->userdata['ID']);
            if(isset($the_user->meta['use_paypal']) && isset($the_user->meta['paypal'])){
    			if($the_user->meta['use_paypal']->meta_value != 'no' && $the_user->meta['paypal']->meta_value==''){
    				$this->session->set_flashdata('err','Please visit your user setting to set your Paypal address or decline using Paypal to accept payment.');
    			}
			} else {
			    $this->session->set_flashdata('err','Please visit your user setting to set your Paypal address or decline using Paypal to accept payment.');
			}

			$db_data = $this->input->post();
			unset($db_data['cat']);
			$db_data['org'] = $this->Orgs->get_org($this->input->post('org_id'));
			$attachment_url = FALSE;
			if(!empty($_FILES['attachment_url']['name'])){
				$this->load->model('Administration','Admin');
				$attachment_url = $this->Admin->upload($db_data,'attachment_url');
			}
			unset($db_data['org']);
			unset($db_data['org_id']);
			unset($db_data['attachment_url']);
			$post_id = $this->Posts->add_post($db_data);
			foreach($this->input->post('cat') AS $cat_id){
				$this->Posts->post_to_cat(array('post_id' => $post_id,'cat_id' => $cat_id));
			}
			if($attachment_url){
				$db_data = array(
						'attachment_url'=>'attachment_url',
						'title' => $this->input->post('title'),
						'attachment_url'=>$attachment_url,
						'dateadded'=>time()
				);
				$attachment_id = $this->Posts->add_attachment($db_data);
				$db_data = array(
						'attachment_id' => $attachment_id,
						'post_id' => $post_id,
				);
				$this->Posts->attachment_to_post($db_data);
			}
            //Invoice
            $post = $this->Posts->get_post($post_id);
            if(stripos($post->type,'product')===FALSE){
                $this->load->model('Invoices');
                $this->Invoices->create_invoice($post);
            }
			$this->load->helper('url');
			redirect('/post');
		}
		$this->load->view('default.tpl.php',$data);
	}

	function edit($ID){
		$this->load->model('Categories','Cats');
		$this->load->model('Users');
		$this->load->model('Organizations','Orgs');
        $the_types = $this->common->get_sysadmin_item('post_types',TRUE);
        
		$data = array(
				'page_title' => SITENAME.': Edit Post',
				'body_class' => 'edit post-edit',
				'user' => $this->session->userdata,
				'post' => $this->Posts->get_post($ID),
				'cats' => $this->Cats->group_cats_by_parent($this->Cats->get_cats()),
                'types' => unserialize($the_types->sysinfo_value),
				'dashboard' => 'default/post/edit',
				'action' => 'post/edit/'.$ID,
				'is_edit' => TRUE,
		);
		if($this->input->post()){
			$db_data = $this->input->post();
			unset($db_data['cat']);
			$db_data['org'] = $this->Orgs->get_org($this->input->post('org_id'));
			$attachment_url = FALSE;
			if(!empty($_FILES['attachment_url']['name'])){
				$this->load->model('Administration','Admin');
				$attachment_url = $this->Admin->upload($db_data,'attachment_url');
			}
			unset($db_data['org']);
			unset($db_data['org_id']);
			unset($db_data['attachment_url']);
			$this->Posts->edit_post($db_data);
			$this->Posts->clear_post_to_cats($db_data['ID']);
			if($this->input->post('cat')){
				foreach($this->input->post('cat') AS $cat_id){
					$this->Posts->post_to_cat(array('post_id' => $db_data['ID'],'cat_id' => $cat_id));
				}
			}
			if($attachment_url){
				$db_data = array(
						'attachment_url'=>'attachment_url',
						'title' => $this->input->post('title'),
						'attachment_url'=>$attachment_url,
						'dateadded'=>time()
				);
				$attachment_id = $this->Posts->add_attachment($db_data);
				$db_data = array(
						'attachment_id' => $attachment_id,
						'post_id' => $ID,
				);
				$this->Posts->attachment_to_post($db_data);
			}
			
			$this->load->helper('url');
			redirect('/post');
		}
		$this->load->view('default.tpl.php',$data);
	}
	

	function delete($ID){
		$this->load->model('Categories','Cats');
		$this->load->model('Users');
        $this->load->model('Organizations','Orgs');
        
        $post = $this->Posts->get_post($ID);
        
		$data = array(
				'page_title' => SITENAME.': Edit Post',
				'body_class' => 'edit post-edit',
				'user' => $this->session->userdata,
				'post' => $post,
				'cats' => $this->Cats->group_cats_by_parent($this->Cats->get_cats()),
				'dashboard' => 'default/post/edit',
				'action' => 'post/edit/'.$ID,
				'is_edit' => TRUE,
		);
		if($this->input->post()){
			$db_data = $this->input->post();
			unset($db_data['cat']);
			$db_data['org'] = $this->Orgs->get_org($this->input->post('org_id'));
			$attachment_url = FALSE;
			if(!empty($_FILES['attachment_url']['name'])){
				$this->load->model('Administration','Admin');
				$attachment_url = $this->Admin->upload($db_data,'attachment_url');
			}
			unset($db_data['org']);
			unset($db_data['org_id']);
			unset($db_data['attachment_url']);
			$db_data['dateremoved'] = time();
			$this->Posts->edit_post($db_data);
			$this->Posts->clear_post_to_cats($db_data['ID']);
			if(stripos($post->type,'product')!==FALSE){
			    $this->load->model('Invoices');
                $this->Invoices->create_invoice($post);
			}
            	
			$this->load->helper('url');
			redirect('/post');
		}
		$this->load->view('default.tpl.php',$data);
	}
	
	function view($ID){
		$this->load->model('Categories','Cats');
		$this->load->model('Users');
		$post = $this->Posts->get_post($ID);
		$data = array(
				'page_title' => SITENAME.': '.$post->title,
				'body_class' => 'add post-add',
				'user' => $this->session->userdata,
				'post' => $post,
				'cats' => $this->Cats->get_cats(),
				'dashboard' => 'default/post/view',
				'action' => array('buy' => '/post/buy/'.$ID,'contact' => '/post/email/'.$ID),
				'is_edit' => TRUE,
		);
		$this->load->view('default.tpl.php',$data);
	}
	
	function email($ID){
		$this->load->model('Users');
		if($this->input->post()){
			$to      = $this->input->post('author');
			$subject = 'Message about '.$this->input->post('subject');
			$message = $this->input->post('message');
			$headers = 'From: '. $this->input->post('sender') . "\r\n" ;
			
			if(mail($to, $subject, $message, $headers)){
				$this->session->set_flashdata('msg','Message Sent!');
			} else {
				$this->session->set_flashdata('err','There was a problem with your message. Please try again later.');
			}
		}
		$this->load->helper('url');
		redirect('/post/view/'.$ID);
	}
	
	function buy($ID){
		$this->load->model('Categories','Cats');
		$this->load->model('Users');
		$post = $this->Posts->get_post($ID);
		$data = array(
				'page_title' => SITENAME.': Buy '.$post->title,
				'body_class' => 'buy post-buy',
				'user' => $this->session->userdata,
				'post' => $post,
				'seller' => $this->Users->get_user($post->author_id),
				'cats' => $this->Cats->get_cats(),
				'dashboard' => 'default/post/buy',
				'is_edit' => TRUE,
				'urls' => array('check' => 'http://'. $_SERVER['SERVER_NAME'].'/post/buy/'.$ID, 'paypal' => 'https://www.paypal.com/cgi-bin/webscr','return' => 'http://'. $_SERVER['SERVER_NAME'].'/post/postpay','cancel' => 'http://'. $_SERVER['SERVER_NAME'].'/post/cancel'),
		);
        
        if($this->input->post()){  
            $to      = $this->input->post('author');
            $subject = 'Message from buyer about '.$this->input->post('subject');
            $message = $this->input->post('message');
            $headers = 'From: '. $this->input->post('sender') . "\r\n" ;
            
            //send an email if needed
            if(!empty($message)):
                if(mail($to, $subject, $message, $headers)){
                    $this->session->set_flashdata('msg','Message Sent!');
                } else {
                    $this->session->set_flashdata('err','There was a problem with your message. Please try again later.');
                }
            endif;
        }
		$this->load->view('default.tpl.php',$data);
	}

    function postpay(){
        print "Thank you for your purchase";
    }
    
    function cancel(){
        print "You have canceled your purchase";
    }
}

/* End of file post.php */
/* Location: ./application/controllers/post.php */