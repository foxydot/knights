<?php setlocale(LC_MONETARY, 'en_US'); ?>
<div class="container-fluid post">
    <div class="row-fluid">
        <div class="span6 offset3">
        <h1>Invoice for post: <?php print $invoice->title; ?>
        <div class="fee pull-right">
            <span><?php print money_format('%#1.2n', (float) $invoice->fee); ?></span>
        </div>
        </h1>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6 offset3">
        <?php print form_open_multipart($urls['paypal'],array('id'=>'invoiceform','class'=>'smallform')); ?>
            <input type="hidden" id="paypal_action" value="<?php print $urls['paypal']; ?>">
            <input type="hidden" id="check_action" value="<?php print $urls['check']; ?>">
            <input type="hidden" id="buyer_id" value="<?php print $user['ID']; ?>">
        <?php print form_fieldset(); ?>
        <div class="row-fluid payment_options">
            <label>Payment Options</label>
            <input type="radio" name="payment_option" id="payment_option_paypal" value="PayPal"> Pay securely with PayPal <br/>
                <div class="row-fluid payment_info hide" id="paypal_info">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="<?php print $org->meta['paypal']->meta_value; ?>">
                    <input type="hidden" name="lc" value="US">
                    <input type="hidden" name="item_name" value="<?php print $invoice->title; ?>">
                    <input type="hidden" name="item_number" value="<?php print $invoice->post_id; ?>">
                    <input type="hidden" name="amount" value="<?php print $invoice->fee; ?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="button_subtype" value="services">
                    <input type="hidden" name="no_note" value="0">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="rm" value="1">
                    <input type="hidden" name="return" value="<?php print $urls['return']; ?>">
                    <input type="hidden" name="cancel_return" value="<?php print $urls['cancel']; ?>">
                    <input type="hidden" name="tax_rate" value="0.000">
                    <input type="hidden" name="shipping" value="0.00">
                    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
                    <input type="image" src="/assets/themes/knights/img/paynow.png" border="0" name="submit_btn" alt="PayPal - The safer, easier way to pay online!" value="PayPal">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </div>
            <input type="radio" name="payment_option" id="payment_option_check" value="Cash/Check"> Pay by check 
                <div class="row-fluid payment_info hide" id="check_info">
                    You have elected to pay via check. <br /><br />
                    
                    If paying by check, please
                    <ul>
                        <li>Make out to “<strong> Parent Association – Knights List</strong>”</li>
                        <li>Memo Line: <?php print str_pad((string)$invoice->post_id,8,'0',STR_PAD_LEFT); ?>: <?php print $invoice->title; ?></li>
                        <li>Mail to:
                            <address>Summit Parent Association, attn: Treasurer<br />
                  2161 Grandin Road<br />
                  Cincinnati, OH 45208</address></li>
                   </ul>
                </div>
        </div>

        <?php
        print form_fieldset_close();
        print form_close();
        ?>
    </div>
    </div>
</div>