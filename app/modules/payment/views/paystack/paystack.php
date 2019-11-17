<script src="https://js.paystack.co/v1/inline.js"></script>

<div class="paypal-method paystack-payment">
	<a href="javascript:void(0);" onclick="payWithPaystack();" class="btn btn-dark btn-lg btn-block mt15 btnPaypalPayment"><?=lang('submit_payment')?></a>
</div>	

<?php 
$price_monthly = $package->price_monthly;
$price_annually = $package->price_annually*12;
if(session("coupon")){
    $coupon = (object)session("coupon");
    $coupon_code = $coupon->code;
    if(in_array((int)$package->id, $coupon->package)){
        if($coupon->type == 1){
            $price_monthly = number_format($price_monthly - $coupon->price, 2);
            $price_annually = number_format($price_annually - $coupon->price, 2)*12;
        }else{
            $price_monthly = number_format($price_monthly*(100 - $coupon->price)/100, 1);
            $price_annually = number_format($price_annually*(100 - $coupon->price)/100, 2)*12;
        }

    }
}

$price_monthly *= 100;
$price_annually *= 100;
?>
<script type="text/javascript">
	function payWithPaystack(){
		var price = ['<?=$price_monthly?>', '<?=$price_annually?>'];
		var _plan    = $("input[name='plan']:checked").val();

		var handler = PaystackPop.setup({
		  	key: '<?=get_option('paystack_public_key', '')?>',
		  	email: '<?=$user->email?>',
		  	amount: price[_plan-1],
		  	ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
		  	callback: function(response){
	            var _that    = $(".paystack-payment");
	            var _action  = "<?=cn("payment/paystack/process/")?>"+response.reference+"/"+_plan;
	            var _data    = $.param({token:token});
	            Main.ajax_post(_that, _action, _data, function(_result){
	            	window.location.assign("<?=cn("thank_you")?>");
	            });
		  	},
		  	onClose: function(){
		      	
		  	}
		});
		handler.openIframe();
	}
</script>

