<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoices extends CI_Model {
    function __construct()
        {
            // Call the Model constructor
            parent::__construct();
        }
        
    function create_invoice($post){
        global $org_id;
        $db_data = array(
            'org_id' => $org_id,
            'author_id' => $post->author_id,
            'post_id' => $post->post_id,
            'fee' => get_the_fee($post),
            'dateadded' => time()
        );
        $this->db->insert('invoice',$db_data);
        $invoice_id = $this->db->insert_id();
        $this->email_invoice($invoice_id);
        return $invoice_id;
    }    
    
    function email_invoice($invoice_id){
        $invoice = $this->get_invoice($invoice_id);
        $this->load->model('Organizations','Orgs');
        $organization = $this->Orgs->get_org($invoice->org_id);
        $this->common->get_org_info_from_subdomain();
        //prep email
        switch($invoice->type){
            case 'service':
            case 'student-service':
            case 'request':
            case 'business-student':
            case 'business-personal':
            case 'business-professional':
            case 'businesses-student':
            case 'businesses-personal':
            case 'businesses-professional':
                $email = $this->Orgs->get_org_emails($invoice->org_id,'service-invoice');
                break;
            case 'product':
            default:
                $email = $this->Orgs->get_org_emails($invoice->org_id,'product-invoice');
                break;
        }
        

        setlocale(LC_MONETARY, 'en_US');
        $fee = money_format('%#1.2n', (float) $invoice->fee);
        //include_once(SITEPATH.THEMEURL.'email/email_template.php');
        $pattern = array(
            '/__POST_TITLE__/',
            '/__BUYER_FIRSTNAME__/',
            '/__BUYER_LASTNAME__/',
            '/__SELLER_FIRSTNAME__/',
            '/__SELLER_LASTNAME__/',
            '/__LISTING_FEE__/',
            '/__ORGANIZATION_LOGO__/',
            '/__ORGANIZATION_NAME__/',
            '/__INVOICE_URL__/',
            '/__SITE_TITLE__/',
            '/__LISTING_CODE__/'
        );
        $replacement = array(
            preg_quote($invoice->title),
            '',
            '',
            preg_replacement_quote($invoice->firstname),
            preg_replacement_quote($invoice->lastname),
            preg_replacement_quote($fee),
            preg_replacement_quote($organization->meta['logo_url']->meta_value),
            preg_replacement_quote($organization->name),
            preg_replacement_quote(site_url('invoice/view/'.$invoice_id)),
            preg_replacement_quote(str_pad((string)SITENAME,8,'0',STR_PAD_LEFT)),
            preg_replacement_quote($invoice->post_id),
        );
        //TODO: set this up to grab the info out of hte array
        $message_subject = preg_replace($pattern, $replacement, $email['subject']);
        $message_plaintext = preg_replace($pattern, $replacement, $email['text']);
        $message_html = preg_replace($pattern, $replacement, $email['html']);
        //send email
        $this->load->library('email');
        
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        
        $this->email->from('knights@communitylist.us', SITENAME);
        //$this->email->from('test@msdlab.com', $organization->name.' List');
        $this->email->to($invoice->email);
        //TODO: Set this to use admin emails.
        $this->email->bcc('knights@communitylist.us');
        $this->email->bcc('mirja@aristogroup.com');
        $this->email->subject($message_subject);
        $this->email->message($message_html);
        $this->email->set_alt_message($message_plaintext);
        
        $this->email->send();
        
        //echo $this->email->print_debugger();
    }
    
    function get_invoice($invoice_id){
        $this->db->select('org_id, invoice.author_id as author_id, post_id, fee, title, slug, type, cost, content, email, firstname, lastname, accesslevel, group_id');
        $this->db->from('invoice');
        $this->db->join('post','invoice.post_id=post.ID');
        $this->db->join('user','invoice.author_id=user.ID');
        $this->db->where('invoice.ID',$invoice_id);
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->result();
        $result = $result[0];
        return $result;
    }
    
    
    function get_invoices($author_id){
        $this->db->select('invoice.ID as invoice_id, org_id, invoice.author_id as author_id, post_id, fee, title, slug, type, cost, content, post.dateadded as dateadded, email, firstname, lastname, accesslevel, group_id');
        $this->db->from('invoice');
        $this->db->join('post','invoice.post_id=post.ID');
        $this->db->join('user','invoice.author_id=user.ID');
        $this->db->where('invoice.author_id',$author_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
}
/* End of file invoices.php */
/* Location: ./application/models/invoices.php */