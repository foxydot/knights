<?php
$message_subject = 'Invoice for Posting of __POST_TITLE__';
$message_plaintext = 'Thank you for using __SITE_TITLE__!
This is your invoice for your posting of __POST_TITLE__. If the item has not sold, or sold for a different price than listed, please contact us at knights@communitylist.us.

100% of the Listing Fee will go to the __ORGANIZATION_NAME__ Parents Association!

Please submit your __LISTING_FEE__ fee using PayPal (__INVOICE_URL__) or by mailing a check.

If paying by check, please
. Make out to “Summit Parent Association – Knights List”
. Memo Line “please include the item’s listing number here”
. Mail to:     Summit Parent Association, attn: Treasurer
                  2161 Grandin Road
                  Cincinnati, OH 45208
';

$message_html = '
<p>Thank you for using __SITE_TITLE__!<p>
<p>This is your invoice for your posting of __POST_TITLE__(__LISTING_CODE__). If the item has not sold, or sold for a different price than listed, please contact us at knights@communitylist.us.</p>

<p><strong>100% of your Listing Fee will go to the __ORGANIZATION_NAME__ Parents Association!</strong>, benefiting the school and your child(ren)!</p>

<p>Please submit your __LISTING_FEE__ fee using <a href="__INVOICE_URL__">PayPal</a> or by mailing a check.</p>
<p><span>If <span style="text-decoration: underline;">paying by&nbsp;<strong>check</strong></span></span>, please</p>
<p>. Make out to &ldquo;Summit Parent Association &ndash; Knights List&rdquo;</p>
<p>. Memo Line &ldquo;__LISTING_CODE__&rdquo;</p>
<p><em>.</em>&nbsp;Mail to:&nbsp;&nbsp;&nbsp;&nbsp; Summit Parent Association, attn: Treasurer</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2161 Grandin Road</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cincinnati, OH 45208</p>
<p><strong>Thank you so much for supporting the __ORGANIZATION_NAME__!</strong></p>
<table border="1" cellspacing="0" cellpadding="8"><colgroup><col width="100" /><col width="431" /><col width="66" /></colgroup>
<tbody>
<tr valign="TOP">
<td width="100">
<p align="JUSTIFY"><strong>Sales Price</strong></p>
</td>
<td width="431">
<p align="JUSTIFY"><strong>Value Fee, based on the total amount of sale</strong></p>
</td>
<td width="66">
<p align="JUSTIFY"><strong>$ Fee</strong></p>
</td>
</tr>
<tr valign="TOP">
<td width="100">
<p align="JUSTIFY"><strong>$10-$100</strong></p>
</td>
<td width="431">
<p align="JUSTIFY">10% of sales price</p>
</td>
<td width="66">
<p align="JUSTIFY">$1-$10</p>
</td>
</tr>
<tr valign="TOP">
<td width="100">
<p align="JUSTIFY"><strong>$101-$1,000</strong></p>
</td>
<td width="431">
<p align="JUSTIFY">$10 for first $100 + 5% of remaining balance up to $1,000</p>
</td>
<td width="66">
<p align="JUSTIFY">$10-$55</p>
</td>
</tr>
<tr valign="TOP">
<td width="100">
<p align="JUSTIFY"><strong>Above $1,001</strong></p>
</td>
<td width="431">
<p align="JUSTIFY">$55 for first $1,000 + 2% of the remaining balance</p>
</td>
<td width="66">
<p align="JUSTIFY">$55+</p>
</td>
</tr>
</tbody>
</table>';
