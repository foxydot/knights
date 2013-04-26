<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for exporting documents
 */
Class Export_Model extends CI_Model {
	private $cookie_domain;
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	        $this->cookie_domain = $_SERVER['SERVER_NAME'];
	    }
}	