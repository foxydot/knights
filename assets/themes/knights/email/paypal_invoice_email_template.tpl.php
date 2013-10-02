<?php
/**
 * Use the following keys for replacement
 * __POST_TITLE__
 * __BUYER_FIRSTNAME__
 * __BUYER_LASTNAME__
 * __SELLER_FIRSTNAME__
 * __SELLER_LASTNAME__
 * __LISTING_FEE__
 * __ORGANIZATION_NAME__
 */

$subject = 'Purchase of __POST_TITLE__';
$message_plaintext = 'Good News!
        __BUYER_FIRSTNAME__ __BUYER_LASTNAME__ has shown an intent to purchase __POST_TITLE__. 
        Please check your email and/or PayPal. If the purchase is completed, please remit __LISTING_FEE__ to __ORGANIZATION_NAME__ as soon as possible.';
