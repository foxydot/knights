<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	public function __construct()
       {
            parent::__construct();
       }
	public function index()
	{
	}
		
	public function unpublish_attachment(){
		$this->load->model('Posts');
		if($data = $this->input->post('infoArray')) {
			$this->Posts->detach($data);
			}
	}
    
    public function buy_item(){
        $this->load->model('Posts');
        if($data = $this->input->post('infoArray')) {
            $this->Posts->buy($data);
            }
    }
}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */