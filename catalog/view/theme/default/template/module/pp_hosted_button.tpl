<!--
/*
 * @support
 * http://www.opensourcetechnologies.com/contactus.html
 * sales@opensourcetechnologies.com
* */
-->
<form action="<?php echo $action; ?>" method="post" id="pro-paypal-hosted-form">
	  <?php foreach ($fields as $key => $value) { ?>
		<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
	  <?php } ?>
	<input type=hidden name=custom value='' id=pp-hosted-custom>
	<div class="pull-right">
	<?php if ($mobile) { ?>
    <img id='hosted-button' src="catalog/view/theme/default/image/paypal_express_mobile.png" style="margin:10px; float:right;" alt="PayPal Express Checkout" title="PayPal Hosted Checkout" />
    <?php }else{ ?>
    <img id='hosted-button' src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png" alt="Check out with PayPal Hosted" />
    <?php } ?> 
    </div>
  </form> 
<script type="text/javascript"><!--
$(document).delegate('#hosted-button', 'click', function() {
    $.ajax({
        url: 'index.php?route=payment/pp_hosted_button/addOrder',
        type: 'post',
        success: function(orderid) {
        $('#pp-hosted-custom').val(orderid);
        $('#pro-paypal-hosted-form').submit();
        }
});
}
);
-->
</script>
