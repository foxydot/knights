<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {
    public function __construct()
       {
            parent::__construct();
            if(!$this->common->checkinstallation()){
                $this->load->helper('url');
                redirect('/install');
            }
            $this->load->model('Invoices');
       }
       
    function index(){
        $data = array(
                'page_title' => 'Thank you for using '.SITENAME,
                'body_class' => 'list invoice',
                'dashboard' => 'default/invoice/list',
                'user' => $this->session->userdata,
                'invoices' => $this->Invoices->get_invoices($this->session->userdata['ID'])
        );
        $data['footer_js'][] = 'jquery/list';
        $this->load->view('default.tpl.php',$data);
    }
    
    function view($ID){
        
        $this->load->model('Organizations','Orgs');
        $invoice = $this->Invoices->get_invoice($ID);
        $data = array(
                'page_title' => 'Thank you for using '.SITENAME,
                'body_class' => 'list invoice',
                'dashboard' => 'default/invoice/view',
                'user' => $this->session->userdata,
                'invoice' => $invoice,
                'org' => $this->Orgs->get_org($invoice->org_id),
                'urls' => array('check' => 'http://'. $_SERVER['SERVER_NAME'].'/invoice/view/'.$ID,'paypal' => 'https://www.paypal.com/cgi-bin/webscr','return' => 'http://'. $_SERVER['SERVER_NAME'].'/invoice/postpay','cancel' => 'http://'. $_SERVER['SERVER_NAME'].'/invoice/cancel'),
        );
        $data['footer_js'][] = 'jquery/list';
        $this->load->view('default.tpl.php',$data);
    }
    
    function postpay(){
        
    }
    function cancel(){
        
    }
}

/* End of file post.php */
/* Location: ./application/controllers/post.php */