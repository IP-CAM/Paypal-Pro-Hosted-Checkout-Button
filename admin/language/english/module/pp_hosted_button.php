<?php
/*
 * @support
 * http://www.opensourcetechnologies.com/contactus.html
 * sales@opensourcetechnologies.com
* */
// Heading
$_['heading_title']							= 'PayPal Hosted Checkout Button(Q)';

// Text
$_['text_module']							= 'Module';
$_['text_success']							= 'Success: You have modified PayPal Hosted Checkout Button account details!';
$_['text_pp_hosted_button']						= '<a onclick="window.open(\'https://www.paypal.com/uk/mrb/pal=W9TBB5DTD6QJW\');"><img src="view/image/payment/paypal.png" alt="PayPal" title="PayPal" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization']					= 'Authorization';
$_['text_sale']								= 'Sale';
$_['text_edit']								= 'Edit PP Hosted Button';
// Entry
$_['entry_email']							= 'Paypal Email or Merchant ID:';
$_['entry_test']							= 'Sandbox Mode:';
$_['entry_transaction']						= 'Transaction Method:';
$_['entry_geo_zone']						= 'Geo Zone:';
$_['entry_status']							= 'Status:';
$_['entry_sort_order']						= 'Sort Order:';
$_['entry_total']                    		= 'Minimum Total:';
$_['help_total']='The checkout total the order must reach before this payment method becomes active.';
$_['entry_fees']							= 'Fees:';
$_['entry_fees_type']						= 'Fee Type:';
$_['entry_pdt_token']						= 'PDT Token:';
$_['help_pdt_token']						= 'Payment Data Transfer Token is used for additional security and reliability. Find out how to enable PDT <a href="https://cms.paypal.com/us/cgi-bin/?&cmd=_render-content&content_ID=developer/howto_html_paymentdatatransfer" alt="">here</a>';
$_['entry_itemized']						= 'Itemize Products:';
$_['help_itemized']						= 'Show itemized list of products on Paypal invoice instead of store name.';
$_['entry_debug']							= 'Debug Mode:';
$_['help_debug']							= 'Logs additional information to the system log.';
$_['entry_order_status']					= 'Order Status Completed:';
$_['help_order_status']					= 'This is the status set when the payment has been completed successfully.';
$_['entry_order_status_pending']			= 'Order Status Pending:';
$_['help_order_status_pending']			= 'The payment is pending; see the pending_reason variable for more information. Please note, you will receive another Instant Payment Notification when the status of the payment changes to Completed, Failed, or Denied.';
$_['entry_order_status_denied']				= 'Order Status Denied:';
$_['help_order_status_denied']				= 'You, the merchant, denied the payment. This will only happen if the payment was previously pending due to one of the following pending reasons.';
$_['entry_order_status_failed']				= 'Order Status Failed:';
$_['help_order_status_failed']				= 'The payment has failed. This will only happen if the payment was attempted from your customers bank account.';
$_['entry_order_status_refunded']			= 'Order Status Refunded:';
$_['help_order_status_refunded']			= 'You, the merchant, refunded the payment.';
$_['entry_order_status_canceled_reversal']	= 'Order Status Canceled Reversal:';
$_['help_order_status_canceled_reversal']	= 'This means a reversal has been canceled; for example, you, the merchant, won a dispute with the customer and the funds for the transaction that was reversed have been returned to you.';
$_['entry_order_status_reversed']			= 'Order Status Reversed:';
$_['help_order_status_reversed']			= 'This means that a payment was reversed due to a chargeback or other type of reversal. The funds have been debited from your account balance and returned to the customer. The reason for the reversal is given by the reason_code variable.';
$_['entry_order_status_unspecified']		= 'Order Status Unspecified Error:';

// Error
$_['error_permission']						= 'Warning: You do not have permission to modify payment PayPal Hosted!';
$_['error_email']							= 'E-Mail required!';
?>
