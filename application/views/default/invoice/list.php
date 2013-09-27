<div id="invoice-list" class="container-fluid list accordion">
      <div class="header row-fluid">
        <div class="span1">
            <h4>Listing Number</h4>
        </div><!-- end span3 -->
        <div class="span3">
            <h4>Title</h4>
        </div><!-- end span3 -->
        <div class="span1">
            <h4>Price</h4>
        </div><!-- end span1 -->
        <div class="span2">
            <h4>Date Added</h4>
        </div><!-- end span2 -->
        <div class="span2">
            <h4>Fee</h4>
        </div><!-- end span2 -->
        <div class="span1">
            <h4></h4>
        </div><!-- end span1 -->
      </div><!--/row-->
    <?php 
        foreach($invoices AS $invoice){
            print display_invoice($invoice);
        } //end cats ?>

    <div id="footer" class="row">
    </div><!-- end footer -->

    </div><!--/.fluid-container-->
    
<?php function display_invoice($invoice){
    $display = FALSE;
    setlocale(LC_MONETARY, 'en_US');
        $CI =& get_instance();
        $display .= '
        <div class="stripe invoice clicky row-fluid" href="/invoice/view/'.$invoice->invoice_id.'">
            <div class="span1 id">
                '.str_pad((string)$invoice->post_id,8,'0',STR_PAD_LEFT).'
            </div>
            <div class="span3 title">
                '.$invoice->title.'
            </div>
            <div class="span1 price">
                '.money_format('%#1.2n', (float) $invoice->cost).'
            </div>
            <div class="span2 date-added">
                '.date("F j, Y",$invoice->dateadded).'
            </div>
            <div class="span2 fee">
                <ul>'.money_format('%#1.2n', (float) $invoice->fee).'</ul>
            </div>
            <div class="span1 edit">
            </div>
        </div>';
    return $display;
}?>