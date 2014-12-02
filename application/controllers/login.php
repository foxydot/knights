<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {	
	public function __construct()
	{
		parent::__construct();
		if(!$this->common->checkinstallation()){
			$this->load->helper('url');
			redirect('/install');
		}
        $this->common->get_org_info_from_subdomain();
	}
	
	function index()
	{
		//check session existance and age
		if($this->authenticate->check_auth('users')){
			$this->load->helper('url');
			redirect('/post');
		} else {
			$data = array(
				'page_css' => 'login',
			);
			$this->load->view('login/login.tpl.php',$data);
		}
	}

	function verify($msgarr = false){
 		if($this->input->post('email')){ //checks whether the form has been submited
 			$this->load->library('form_validation');//Loads the form_validation library class
			$rules = array(
			array('field'=>'email','label'=>'email','rules'=>'required'),
			array('field'=>'password','label'=>'password','rules'=>'required')
			);//validation rules
			$this->form_validation->set_rules($rules);//Setting the validation rules inside the validation function
			if($this->form_validation->run() == FALSE){ //Checks whether the form is properly sent
				$data = array(
					'form' => 'login/login',
					'error' => 'Please complete the login form properly',
					'page_css' => 'login',
				);
				$this->load->view('login/login.tpl.php',$data); //If validation fails load the login form again
			}else{
				$userResult = $this->authenticate->login($this->input->post('email'),$this->input->post('password')); //If validation success then call the login function inside the common model and pass the arguments
				if(is_object($userResult)){ //if admin access
					$this->authenticate->userdata_to_session($userResult);
					//remember me cookie
					if($this->input->post('remember')){
						$this->authenticate->userdata_to_cookie();
					}
					$login = true;
                    //TODO: Redirect to requested page.
                    redirect($this->input->post('redirect'));
				} else { // If validation fails.
					$data = array(
						'form' => 'login/login',
						'error' => $userResult,
						'page_css' => 'login',
					);
					$this->load->view('login/login.tpl.php',$data); //Load the login page and pass the error message
					$login = false;
				}
			}
		}else{
			$data = array(
				'page_css' => 'login',
			);
			switch($msgarr){
				case 'session':
					$data['error'] = isset($this->session->userdata['msgarr']['error'])?$this->session->userdata['msgarr']['error']:false;
					break;
				default:
					break;
			}
			$this->load->view('login/login.tpl.php',$data);
		}
	}

	function logout(){
		$this->authenticate->logout();
		$data = array(
			'message' => 'You have been logged out.',
			'page_css' => 'login',
		);
		$this->load->view('login/login.tpl.php',$data);
	}

	function denied($msgarr=false){
		$data = array(
			'page_css' => 'login',
		);
		switch($msgarr){
			case 'session':
				$data['error'] = $this->session->userdata['msgarr']['error'];
				break;
			default:
				break;
		}
		$data['page_title'] = 'Permission Denied';
		$data['form'] = 'login/denied';
		$this->load->view('login/login.tpl.php',$data);
	}


	function forgot(){
	    global $org_id;
        
		$data['infosent'] = false;
		$data['form_inner'] = false;
		$data['page_css'] = 'login';
		if($this->input->post('username')){
			//see if the username is an email address or a birthdate
			$username = $this->input->post('username');
			$usertype = preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $username)?'email':'invalid';
			$data['infosent'] = true;
			switch($usertype){
				case 'email':
					//if the username is an email, check that it exists in the user db
					$query = $this->db->query('SELECT id FROM user WHERE email = \''.$username.'\'');
					if($query->num_rows() == 1){
						//if it does, send a password reset key.
						//generate key
						$reset_key = md5($username.time());
						if($key = $this->db->query('UPDATE user SET resetkey = \''.$reset_key.'\' WHERE email = \''.$username.'\'')){
							//create & send email
							$codelink = 'http://';
							$codelink .= $_SERVER['SERVER_NAME'];
							$codelink .= $_SERVER['SERVER_PORT']!=='80' ? ':'.$_SERVER['SERVER_PORT'] : '';
							$codelink .= '/login/resetpass/'.$reset_key;
                            
                            $codelink = '<a href="'.$codelink.'">'.$codelink.'</a>';
                            //get the org
                            $this->load->model('Organizations','Orgs');
                            $this->common->get_org_info_from_subdomain();
                            $organization = $this->Orgs->get_org($org_id);
                            $email = $this->Orgs->get_org_emails($org_id,'password-reset');
                            
                            $pattern = array(
                                '/__ORGANIZATION_LOGO__/',
                                '/__ORGANIZATION_NAME__/',
                                '/__INVOICE_URL__/',
                                '/__SITE_TITLE__/',
                                '/__CODE_LINK__/'
                            );
                            $replacement = array(
                                preg_replacement_quote($organization->meta['logo_url']->meta_value),
                                preg_replacement_quote($organization->name),
                                preg_replacement_quote(site_url('invoice/view/'.$invoice_id)),
                                preg_replacement_quote(str_pad((string)SITENAME,8,'0',STR_PAD_LEFT)),
                                $codelink
                            );
                            //TODO: set this up to grab the info out of hte array
                            $message_subject = preg_replace($pattern, $replacement, $email['subject']);
                            $message_plaintext = preg_replace($pattern, $replacement, $email['text']);
                            $message_html = preg_replace($pattern, $replacement, $email['html']);
                            
							$body = preg_replace('/\*\*\*CODELINK\*\*\*/i',$codelink,$email);
                            
                            $org_email = $organization->meta['org_email']->meta_value != ''?$organization->meta['org_email']->meta_value:'knights@communitylist.us';
                            
							$config['mailtype'] = 'html';
							$this->load->library('email');
							$this->email->initialize($config);
							$this->email->from($org_email, $organization->meta['site_title']->meta_value);
							$this->email->to($username);

							$this->email->subject('Reset Password');
							$this->email->message($body);
							if(!$this->email->send()){
								$data['error'] = 'There was an error sending an email reset. Please contact your representative.';								$data['buttontxt'] = 'Return to Login';
								$data['buttontxt'] = 'Return to Login';
							} else {
								$data['message'] = 'Password reset information has been sent to your email on file.';
								$data['buttontxt'] = 'Return to Login';
							}
						}
					} else {
						$data['message'] = 'User cannot be found! Please contact your representative.';
						$data['buttontxt'] = 'Return to Login';
					}
					break;
				case 'invalid':
				default:
					$data['error'] = 'This email is invalid. Please try a valid email address.';
					$data['buttontxt'] = 'Return to Login';
					break;
			}

		}
			$data['page_title'] = 'Reset Password';
			$data['form'] = 'login/forgot';
			$this->load->view('login/login.tpl.php',$data);
	}


	public function resetpass(){
		$data['infosent'] = false;
		$data['page_css'] = 'login';
		if($this->input->post('user_password')){
			if($this->input->post('user_password') == $this->input->post('password_valid')){
				$this->db->where('resetkey',$this->input->post('reset_key'));
				$this->db->where('email',$this->input->post('username'));
				$query = $this->db->get('user');
				if($query->num_rows() == 1){
					$password = md5(trim($this->input->post('user_password')));
					$query = $this->db->query("UPDATE user SET password = '".$password."', resetkey = NULL WHERE email = '".$this->input->post('username')."' AND resetkey = '".$this->input->post('reset_key')."'");
					$data['infosent'] = true;
					$data['message'] = 'Your password has been updated!';
					$data['buttontxt'] = 'Return to Login';
				} else {
					$data['infosent'] = true;
					$data['error'] = 'There was an error resetting your password. Please contact your representative.';
					$data['buttontxt'] = 'Return to Login';
				}
			} else {
				//print "passmatchfail | ";
				$this->db->where('resetkey',$this->input->post('reset_key'));
				$query = $this->db->get('user');
				$data['form_inner'] = 'reset';
				$data['error'] = 'Passwords do not match.';
				$data['buttontxt'] = 'Return to Login';
				$data['user'] = $user;
			}
		} else {
			$reset_key = $this->uri->segment(3);
			$this->db->where('resetkey',$reset_key);
			$query = $this->db->get('user');
			if($query->num_rows() == 1){
				$user = $query->result();
				$data['form_inner'] = 'reset';
				$data['user'] = $user;
				$data['buttontxt'] = 'Reset Password';
			} else {
				$data['infosent'] = true;
				$data['error'] = 'There was an error resetting your password. Please contact your representative.';
				$data['buttontxt'] = 'Return to Login';
			}
		}
		$data['page_title'] = 'Reset Password';
		$data['form'] = 'login/forgot';
		$this->load->view('login/login.tpl.php',$data);
	}
	
	public function register(){
		global $org_id;
		$this->load->model('Organizations','Orgs');
		$data = array(
				'page_css' => 'login',
				'form' => 'login/register',
				'organization' => $this->Orgs->get_org($org_id),
		);
		if($this->input->post()){
			$this->load->library('form_validation');//Loads the form_validation library class
			$rules = array(
			array('field'=>'firstname','label'=>'First Name','rules'=>'required|min_length[2]|max_length[20]'),
			array('field'=>'lastname','label'=>'Last Name','rules'=>'required|min_length[2]|max_length[20]'),
			array('field'=>'email','label'=>'Email','rules'=>'required|valid_email|is_unique[user.email]'),
			array('field'=>'password','label'=>'Password','rules'=>'required|matches[passwordtest]'),
			array('field'=>'passwordtest','label'=>'Password Confirmation','rules'=>'required'),
			//array('field'=>'studentfirstname','label'=>'Student First Name','rules'=>'required|min_length[2]|max_length[20]'),
			//array('field'=>'studentlastname','label'=>'Student Last Name','rules'=>'required|min_length[2]|max_length[20]'),						
			);//validation rules
			$this->form_validation->set_message('is_unique', '%s is already in use. Did you <a href="http://knights.local/login/forgot">forget your password?</a>');
			$this->form_validation->set_rules($rules);//Setting the validation rules inside the validation function
			if($this->form_validation->run() == FALSE){ //Checks whether the form is properly sent
				$data['form'] = 'login/register';
				$data['error'] = 'Please complete the registration form properly';
				$data['values'] = $this->input->post();
			} else {
				$this->load->model('Users');
				$db_data = $this->input->post();
				$username = $db_data['firstname'].' '.$db_data['lastname'];
				$student['firstname'] = $db_data['studentfirstname'];
				$student['lastname'] = $db_data['studentlastname'];
				//add any automated testing here
				$approved = FALSE;
				if($this->Orgs->get_org_meta($org_id,'test_csv')){
                    $this->load->helper('msd_csv_helper');
                    $test_csv = $this->Orgs->get_org_meta($org_id,'test_csv');
                    $test_path = preg_replace('@'.base_url().'@i',SITEPATH,$test_csv['test_csv']->meta_value);
                    $test_array = parse_csvfile($test_path);
                    foreach($test_array AS $ta){
                        if(empty($student['firstname'])||empty($student['lastname'])){
                            continue;
                        }
                        if($ta['StudentLastName'] == $student['lastname']){
                            if(trim(strtolower($ta['StudentFirstName'])) == trim(strtolower($student['firstname'])) || trim(strtolower($ta['StudentPreferredName'])) == trim(strtolower($student['firstname']))){
                                if((trim(strtolower($ta['Par1FirstName']))==trim(strtolower($db_data['firstname'])) && trim(strtolower($ta['Par1LastName']))==trim(strtolower($db_data['lastname']))) || (trim(strtolower($ta['Par2FirstName']))==trim(strtolower($db_data['firstname'])) && trim(strtolower($ta['Par2LastName']))==trim(strtolower($db_data['lastname'])))){                                    
                                   $approved = TRUE;
                                    continue;
                                }
                            }
                        }
                    }
                } 
                if($approved){
                    $subject = 'New User: Auto-approved';
                    $message = $username.' has registered with '.SITENAME.'. The application has been approved automatically. You do not need to take any action.';
                } else {
                    $subject = 'New User: Action Required!';
                    $message = $username.' has registered with '.SITENAME.', but the application could not be approved automatically. Please review and approve this application.';
                }
				//after testing
				unset($db_data['submit']);
				unset($db_data['passwordtest']);
				unset($db_data['studentfirstname']);
				unset($db_data['studentlastname']);
				$db_data['password'] = md5($db_data['password']);
                $db_data['accesslevel'] = 0;
                if($approved){
                    $db_data['accesslevel'] = 100;
                }
				$user_id = $this->Users->add_user($db_data);
                $org_data = array(
                    'user_id' => $user_id,
                    'org_id' => $org_id, 
                    'accesslevel' => $db_data['accesslevel'],
                    'dateadded' => time(),
                );
                $this->Users->add_user_org($org_data);
				$db_data = array(
						'user_id' => $user_id,
						'org_id' => $org_id,
						'meta_key' => 'student',
						'meta_value' => serialize($student),
				);
				$this->Users->add_user_meta($db_data);
                //get all the categories and auto subscribe new registrants to them
                $this->load->model('Categories','Cats');
                $cats = $this->Cats->get_cats();
                foreach($cats AS $cat){
                    $catids[] = $cat->ID;
                }
                $db_data = array(
                        'user_id' => $user_id,
                        'org_id' => $org_id,
                        'meta_key' => 'subscribe',
                        'meta_value' => serialize($catids),
                );
                $this->Users->add_user_meta($db_data);
                //end subscription register
				$this->load->model('Administration','Admin');
				$this->Admin->notify_admins(array('subject'=>$subject,'message'=>$message));
				$data['approved'] = $approved;
				$data['form'] = 'login/register_complete';
			}
		} 
		$this->load->view('login/login.tpl.php',$data);
	}
	
	public function terms(){
		global $org_id;
		$this->load->model('Organizations','Orgs');
		$this->load->model('Users');
		$data = array(
				'page_css' => 'login',
				'form' => 'login/terms',
				'organization' => $this->Orgs->get_org($org_id),
				'org_meta' => $this->Orgs->get_org_meta($org_id),
		);
		if($this->input->post('terms_accepted')=='true'){
			$this->Users->edit_user($this->session->userdata['ID'],array('terms_accepted'=>1));
			$this->authenticate->userdata_to_session($this->Users->get_user($this->session->userdata['ID']));
            $this->Users->edit_user_org($this->session->userdata['ID'],array('terms_accepted'=>1));
			$login = true;
			redirect('/');
		}
		$data['error'] = 'You must accept the terms of this site to participate.';
		$this->load->view('login/login.tpl.php',$data);
	}
}

/* End of file login.php */