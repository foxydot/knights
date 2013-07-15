<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {	
	function index()
	{
		if(!$this->common->checkinstallation()){
				$this->load->helper('url');
				redirect('/install');
			}
		//check session existance and age
		if($this->authenticate->check_auth('users')){
			$this->load->helper('url');
			redirect('/admin');
		} else {
			$data = array(
				'page_css' => 'login',
			);
			$this->load->view('login/dashboard.php',$data);
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
				$this->load->view('login/dashboard.php',$data); //If validation fails load the login form again
			}else{
				$userResult = $this->authenticate->login($this->input->post('email'),$this->input->post('password')); //If validation success then call the login function inside the common model and pass the arguments
				if(is_object($userResult)){ //if admin access
					$this->authenticate->userdata_to_session($userResult);
					//remember me cookie
					if($this->input->post('remember')){
						$this->authenticate->userdata_to_cookie();
					}
					$login = true;
				} else { // If validation fails.
					$data = array(
						'form' => 'login/login',
						'error' => $userResult,
						'page_css' => 'login',
					);
					$this->load->view('login/dashboard.php',$data); //Load the login page and pass the error message
					$login = false;
				}
				redirect('/');
			}
		}else{
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
			$this->load->view('login/dashboard.php',$data);
		}
	}

	function logout(){
		$this->authenticate->logout();
		$data = array(
			'message' => 'You have been logged out.',
			'page_css' => 'login',
		);
		$this->load->view('login/dashboard.php',$data);
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
		$this->load->view('login/dashboard.php',$data);
	}


	function forgot(){
		$data['infosent'] = false;
		$data['form_inner'] = false;
		$data['page_css'] = 'login';
		if($_POST){
			//see if the username is an email address or a birthdate
			$username = $_POST['username'];
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

							//$body = file_get_contents('application/assets/emails/forgot.html');
							//$body = preg_replace('/\*\*\*CODELINK\*\*\*/i',$codelink,$body);
							$body = $codelink;
							$config['mailtype'] = 'html';
							$this->load->library('email');
							$this->email->initialize($config);
							$this->email->from('noreply@msdlab.com', 'Website');
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
			$this->load->view('login/dashboard.php',$data);
	}


	public function resetpass(){
		$data['infosent'] = false;
		$data['page_css'] = 'login';
		if($_POST){
			if($_POST['user_password'] == $_POST['passwordValid']){
				$this->db->where('resetkey',$_POST['reset_key']);
				$this->db->where('email',$_POST['username']);
				$query = $this->db->get('user');
				if($query->num_rows() == 1){
					$password = md5(trim($this->input->post('user_password')));
					$query = $this->db->query("UPDATE user SET password = '".$password."', resetkey = NULL WHERE email = '".$_POST['username']."' AND resetkey = '".$_POST['reset_key']."'");
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
				$this->db->where('resetkey',$_POST['reset_key']);
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
		$this->load->view('login/dashboard.php',$data);
	}
	
	public function register(){
		print "register a new account";
	}
}

/* End of file login.php */