<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoices extends CI_Model {
    function __construct()
        {
            // Call the Model constructor
            parent::__construct();
        }
        
    function create_invoice($post){
        $db_data = array(
            'org_id' => 1,
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
        //prep email
        //send email
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
    
    function make_paypal_button($data){
        $button = '
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="bills@madsciencedept.com">
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="item_name" value="test item">
            <input type="hidden" name="item_number" value="id">
            <input type="hidden" name="amount" value="5.00">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="button_subtype" value="services">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="rm" value="1">
            <input type="hidden" name="return" value="http://knights.local/finish.php">
            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
        ';
    }     
}
/* End of file invoices.php */
/* Location: ./application/models/invoices.php */