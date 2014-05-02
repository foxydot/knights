<div id="invoice-list" class="container-fluid list panel-group">
      <div class="header row">
        <div class="col-md-1">
            <h4>Listing Number</h4>
        </div><!-- end col-md-3 -->
        <div class="col-md-3">
            <h4>Title</h4>
        </div><!-- end col-md-3 -->
        <div class="col-md-1">
            <h4>Price</h4>
        </div><!-- end col-md-1 -->
        <div class="col-md-2">
            <h4>Date Added</h4>
        </div><!-- end col-md-2 -->
        <div class="col-md-2">
            <h4>Fee</h4>
        </div><!-- end col-md-2 -->
        <div class="col-md-1">
            <h4></h4>
        </div><!-- end col-md-1 -->
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
        <div class="stripe invoice clicky row" href="/invoice/view/'.$invoice->invoice_id.'">
            <div class="col-md-1 id">
                '.str_pad((string)$invoice->post_id,8,'0',STR_PAD_LEFT).'
            </div>
            <div class="col-md-3 title">
                '.$invoice->title.'
            </div>
            <div class="col-md-1 price">
                '.money_format('%#1.2n', (float) $invoice->cost).'
            </div>
            <div class="col-md-2 date-added">
                '.date("F j, Y",$invoice->dateadded).'
            </div>
            <div class="col-md-2 fee">
                <ul>'.money_format('%#1.2n', (float) $invoice->fee).'</ul>
            </div>
            <div class="col-md-1 edit">
            </div>
        </div>';
    return $display;
}?>