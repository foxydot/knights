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
        __BUYER_FIRSTNAME__ __BUYER_LASTNAME__ has shown an intent to purchase your __POST_TITLE__. 
        Please contact __BUYER_FIRSTNAME__ __BUYER_LASTNAME__ at __BUYER_EMAIL__ to make arrangements regarding the exchange of your payment and the item. 
        
        To avoid any kind of confusion, please DELETE your item from the Knights List, following these steps:

    * Please log into your Knights List account
    * Go into "My Postings"
    * Click on the sold item
    * Choose "Edit"
    * Choose "Delete" at the bottom of the page

Once you deleted your item, please check your e-mail to pay your Listing Fee to The __ORGANIZATION_NAME__. 100% of your Listing Fee will go to The __ORGANIZATION_NAME__, benefiting the school and your child(ren). 

Thank you so much for supporting __ORGANIZATION_NAME__! ';