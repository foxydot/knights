<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for user login and authentication
 */
Class Ajax_model extends CI_Model {
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	        $this->cookie_domain = $_SERVER['SERVER_NAME'];
	    }
}
/* End of file ajax.php */
/* Location: ./application/models/ajax.php */