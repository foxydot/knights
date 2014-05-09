<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for user login and authentication
 */
Class Authenticate extends CI_Model {
	private $cookie_domain;
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	        $this->cookie_domain = $_SERVER['SERVER_NAME'];
	    }
	
	/*
	 * Login
	 */
	function login($uid,$pwd){
	    global $org_id;
		$this->db->select('user.ID AS ID,email,firstname,lastname,user2org.terms_accepted AS terms_accepted,user2org.accesslevel AS accesslevel,user2org.dateremoved AS dateremoved,user_group.name AS group_name,user_group.accesslevel AS group_accesslevel');
		$this->db->from('user');
		$this->db->join('user_group','user.group_id=user_group.ID','left');
        $this->db->join('user2org','user.ID=user2org.user_id','left');
		$this->db->where('user.email = \''.$uid.'\'');
		$this->db->where('user.password = \''.md5($pwd).'\'');
        $this->db->where('user2org.org_id = \''.$org_id.'\'');
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() == 1){
			$result = $query->result();
			if($result[0]->dateremoved > 0){
				return 'Account Suspended';
			}
			return $result[0];
		}else{
			return 'Incorrect username/password';
		}	
	}
	
	/*
	 * Get User Via Email: Identical to get_user except it keys of email for facebook usage.
	 */
	
	private function get_user_via_email($email){ 
		$this->db->select('user.ID AS ID,email,firstname,lastname,user.accesslevel AS accesslevel,user.dateremoved AS dateremoved,user_group.name AS group_name,user_group.accesslevel AS group_accesslevel');
		$this->db->from('user');
		$this->db->join('user_group','user.group_id=user_group.ID','left');
		$this->db->where('user.email = \''.$email.'\'');
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() == 1){
			$result = $query->result();
			if($result[0]->dateremoved > 0){
				return 'Account Suspended';
			}
			return $result[0];
		}else{
			return 'User does not exist';
		}	
	}

	/*
	 * 
	 */
	function userdata_to_session($user){
		$this->session->set_userdata(array(
			'logged_in'=>TRUE,
			'ID'=>$user->ID,
			'email'=>$user->email,
			'firstname'=>$user->firstname,
			'lastname'=>$user->lastname,
			'name'=>$user->firstname.' '.$user->lastname,
			'time'=>time(),
			'accesslevel'=>$user->accesslevel,
			'group'=>$user->group_name,
			'group_accesslevel'=>$user->group_accesslevel,
			'terms_accepted'=>$user->terms_accepted
		)); //set the data into the session
	}
	
	/*
	 * 
	 */
	function userdata_to_cookie(){
		$data = serialize($this->session->userdata);
		$this->load->helper('cookie');
		$cookie = array(
                   'name'   => 'twuserdata',
                   'value'  => $data,
                   'expire' => 60*60*24*7,
                   'domain' => $this->cookie_domain,
               );
		set_cookie($cookie);
	}
	
	
	/*
	 * Basic authentication check with optional redirect
	 * 
	 * @param int|string $level Optional: Defaults to 1; Numeric identifier or string name of authentication level
	 * @param bool $redirect Optional: Defaults to FALSE; Whether or not to process a redirect.
	 * @return bool Pass or fail authentication test
	 * 
	 */
	function check_auth($level = 1,$redirect = FALSE){
		$access = $this->levelinfo($level);
		if($redirect){
			$this->load->helper('url');
		}
		if(!empty($access['id'])){
			if(!empty($this->session->userdata['accesslevel'])){
				$a = $access['id'];
				$u = $this->session->userdata['accesslevel'];
				$t = $this->session->userdata['terms_accepted'];
				if(empty($t)){
					if($redirect){
						redirect('/login/terms/session');
						return FALSE;  //user not allowed, redirect
					} else {
						return FALSE;  //user not allowed, no redirect
					}
				}
				if ($u <= $a){
					if($redirect){
						return TRUE;  //user allowed, redirect
					} else {
						return TRUE;  //user allowed, no redirect
					}
				} else {
					if($redirect){
						$this->session->set_userdata('msgarr',array('error' => INSUFFICIENT_PERMISSION_MSG));
						redirect('/login/denied/session');
						return FALSE;  //user not allowed, redirect
					} else {
						return FALSE;  //user not allowed, no redirect
					}
				}
			} else {
				if($redirect){
					$this->session->set_userdata('msgarr',array('error' => REQUIRE_LOGIN_MSG));
					redirect('/login/verify/session');
					return FALSE;  //user not logged in, redirect
				} else {
					return FALSE;  //user not logged in, no redirect
				}
			}
		} else {
			if($redirect){
				$this->session->set_userdata('msgarr',array('error' => PERMISSION_FUBAR_MSG));
				redirect('/login/denied/session');
				return FALSE;  //level doesn't exist, redirect
			} else {
				return FALSE;  //level doesn't exist, no redirect
			}
		}
		
	}
	/*
	 * Get user levels and names
	 * 
	 * @param int|string $level Required: Numeric identifier or string name of authentication level
	 * @return mixed Returns array of access information on success, FALSE on fail.
	 * 
	 */
	function levelinfo($level){
		$levels = $this->authenticate->get_levels();
		if(!is_numeric($level)){
			$access['id'] = array_search($level,$levels);
		} else {
			$access['id'] = $level;
		}
		if(isset($levels[$access['id']])){
			$access['name'] = $levels[$access['id']];
			return $access;
		} else {
			return FALSE;
		}	
	}	
	
	function get_levels(){
		$query = $this->db->get_where('system_info',array('sysinfo_key' => 'access_levels'),1);
		$result = $query->result();
		$access_levels = $result[0];
		$levels = unserialize($access_levels->sysinfo_value);
		return $levels;
	}
	
	/*
	 * Check user against array of ids
	 * 
	 * @param array $test_users_ids Required; An array of ids to test against
	 * @return bool Result of test
	 */
	function check_user($test_user_ids){
		if(isset($this->session->userdata['accesslevel'])){
			if($this->session->userdata['accesslevel']==1){
				return TRUE; //user is an admin, give full access
			} else {
				if(in_array($this->session->userdata['ID'],$test_user_ids)){
					return TRUE; //user id is in array
				} else {
					return FALSE; //user failed all tests
				}
			}
		} else {
			return FALSE; //user isn't logged in
		}
	}
	
	/*
	 * Create session variables for cookied users
	 */
	function cookie_to_session(){
		if(!isset($this->session->userdata['logged_in'])){
			//try to work with the facebook cookie first.
			$this->load->helper('cookie');
			if($userdata = get_cookie('twuserdata',TRUE)){
				$userdata = unserialize($userdata);
				if($user = $this->get_user($userdata['user.id'])){
					$this->session->set_userdata(array(
					'logged_in'=>TRUE,
					'user.id'=>$user->user.id,
					'user.email'=>$user->user.email,
					'user.firstname'=>$user->user.firstname,
					'user.lastname'=>$user->user.lastname,
					'user.name'=>$user->user.firstname.' '.$user->user.lastname,
					'time'=>time(),
					'user.access'=>$user->user.access,
					'user_group.name'=>$user->group.name,
					'user_group.access'=>$user->group.access
				)); //set the data into the session
				}
			}
		}
	}
	
	
	/*
	 * Logout kills session
	 */
	function logout(){
		$this->load->helper('cookie');
		delete_cookie('twuserdata',$this->cookie_domain);
		$this->session->sess_destroy();
		
	}
	
	/*
	 * Simple method for checking that input came from a form on the site, not a remote source. 
	 * To prevent spam registrations.
	 */
	function legitimize_input(){
		$this->load->library('user_agent');
		$this->load->helper('url');
		if (strpos($this->agent->referrer(),site_url())===0){
			return TRUE;
		} else {
			die("No access.");
		}
	}
}
/* End of file authenticate.php */
/* Location: ./application/models/authenticate.php */