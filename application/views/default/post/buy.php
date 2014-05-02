<?php setlocale(LC_MONETARY, 'en_US'); 
if(isset($seller->meta['use_paypal'])){
    $use_paypal = $seller->meta['use_paypal']->meta_value;
} else {
    $use_paypal = 'no';
}

if(isset($seller->meta['paypal'])){
    $paypal = $seller->meta['paypal']->meta_value;
} else {
    $paypal = FALSE;
}

?>
<div class="container-fluid post">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
		<h1><?php print $post->title; ?>
		<div class="price pull-right">
			<col-md-><?php print money_format('%#1.2n', (float) $post->cost); ?><?php print stripos($post->type,'service')!==FALSE?' per hour':''; ?></col-md->
		</div>
		</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
		<?php print form_open_multipart($urls['check'],array('id'=>'buyform','class'=>'smallform')); ?>
            <input type="hidden" id="paypal_action" value="<?php print $urls['paypal']; ?>">
            <input type="hidden" id="check_action" value="<?php print $urls['check']; ?>">
            <input type="hidden" id="buyer_id" value="<?php print $user['ID']; ?>">
		<?php print form_fieldset(); ?>
		<?php if($use_paypal == 'yes' && $paypal): ?>
		<div class="row payment_options">
			<label>Payment Options</label>
			<input type="radio" name="payment_option" id="payment_option_paypal" value="PayPal"> Pay securely with PayPal <br/>
    			<div class="row payment_info hide" id="paypal_info">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="<?php print $paypal; ?>">
                    <input type="hidden" name="lc" value="US">
                    <input type="hidden" name="item_name" value="<?php print $post->title; ?>">
                    <input type="hidden" name="item_number" value="<?php print $post->post_id; ?>">
                    <input type="hidden" name="amount" value="<?php print $post->cost; ?>">
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
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit_btn" alt="PayPal - The safer, easier way to pay online!" value="PayPal">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </div>
			<input type="radio" name="payment_option" id="payment_option_check" value="Cash/Check"> Pay by cash or check 
        		<div class="row payment_info hide" id="check_info">
        			You have elected to pay via cash or check. Please make arrangements with the seller to exchange goods and funds using the message box below.
        
                    <label>Send message to seller</label>
                    <input name="ID" id="ID" type="hidden" value="<?php print $post->post_id; ?>" />
                    <input name="author" id="author" type="hidden" value="<?php print $post->firstname.' '.$post->lastname.'<'.$post->email.'>'; ?>" />
                    <input name="sender" id="sender" type="hidden" value="<?php print $user['name'].'<'.$user['email'].'>'; ?>" />
                    <input name="subject" id="subject" type="hidden" value="<?php print $post->title; ?>" />
                    <textarea name="message" id="message" class="tinymce"></textarea>
                    <input class="btn btn-default btn-sm" name="submit" id="submit" type="submit" value="Send" />
        		</div>
        </div>
		<?php else: ?>
		<div class="row payment_info" id="check_info">
			The seller has elected to accept payment via cash or check. Please make arrangements with the seller to exchange goods and funds using the message box below.

            <label>Send message to seller</label>
            <input name="ID" id="ID" type="hidden" value="<?php print $post->post_id; ?>" />
            <input name="author" id="author" type="hidden" value="<?php print $post->firstname.' '.$post->lastname.'<'.$post->email.'>'; ?>" />
            <input name="sender" id="sender" type="hidden" value="<?php print $user['name'].'<'.$user['email'].'>'; ?>" />
            <input name="subject" id="subject" type="hidden" value="<?php print $post->title; ?>" />
            <textarea name="message" id="message" class="tinymce"></textarea>
            <input class="btn btn-default btn-sm" name="submit_btn" id="submit_btn" type="submit" value="Buy Now" />
		</div>
		<?php endif; ?>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
	</div>
	</div>
</div>