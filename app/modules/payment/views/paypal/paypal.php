<div class="paypal-method">
	<?php if(get_option('paypal_type', 0) == 0){?>
	<div class="pure-checkbox grey mr15 mb15">
        <input type="radio" id="md_checkbox_payment_method enable" name="paypal_method" class="filled-in chk-col-red paypal_method" checked="" value="1">
        <label class="p0 m0" for="md_checkbox_payment_method enable">&nbsp;</label>
        <span class="checkbox-text-right"> <?=lang('Recurring Payment')?></span>
    </div>

    <div class="pure-checkbox grey mr15 mb15">
        <input type="radio" id="md_checkbox_payment_method disable" name="paypal_method" class="filled-in chk-col-red paypal_method" value="0">
        <label class="p0 m0" for="md_checkbox_payment_method disable">&nbsp;</label>
        <span class="checkbox-text-right"> <?=lang('One-Time Payment')?></span>
    </div>
	<?php }?>

	<?php if(get_option('paypal_type', 0) == 0){?>
    <a href="<?=cn('payment/paypal/recurring_process/'.$package->ids)?>" class="btn btn-dark btn-lg btn-block mt15 btnPaypalPayment btnPaypalRecurring"><?=lang('submit_payment')?></a>
    <a href="<?=cn('payment/paypal/process/'.$package->ids)?>" class="btn btn-dark btn-lg btn-block mt15 btnPaypalPayment btnPaypalOneTime" style="display: none;"><?=lang('submit_payment')?></a>
    <div class="alert alert-secondary paypal-recurring-notice pb0" role="alert">
	  <?=lang('The system will take a few minutes to update your package when you payment with recurring payment method.')?>
	</div>
    <?php }elseif(get_option('paypal_type', 0) == 1){?>
    <a href="<?=cn('payment/paypal/recurring_process/'.$package->ids)?>" class="btn btn-dark btn-lg btn-block mt15 btnPaypalPayment btnPaypalRecurring"><?=lang('submit_payment')?></a>
    <div class="alert alert-secondary paypal-recurring-notice pb0" role="alert">
	  <?=lang('The system will take a few minutes to update your package when you payment with recurring payment method.')?>
	</div>
    <?php }else{?>
    <a href="<?=cn('payment/paypal/process/'.$package->ids)?>" class="btn btn-dark btn-lg btn-block mt15 btnPaypalPayment btnPaypalOneTime"><?=lang('submit_payment')?></a>
    <?php }?>
    
</div>	

<script type="text/javascript">
	$(function(){
		$('input[type=radio][name=paypal_method]').change(function() {
		    if (this.value == 1) {
		        $('.btnPaypalRecurring').show();
		        $('.btnPaypalOneTime').hide();
		        $('.paypal-recurring-notice').show();
		    }
		    else if (this.value == 0)
		    {
		        $('.btnPaypalRecurring').hide();
		        $('.btnPaypalOneTime').show();
		        $('.paypal-recurring-notice').hide();
		    }
		});


		var _plan = $("input[name='plan']:checked").val();
			var _btnPaypalRecurring = $('.btnPaypalRecurring');
			var _btnPaypalOneTime = $('.btnPaypalOneTime');

			var _hrefRecurring = _btnPaypalRecurring.attr("href");
			var _hrefOneTime = _btnPaypalOneTime.attr("href");
			
			_btnPaypalRecurring.attr("href", _hrefRecurring+"/"+_plan);
			_btnPaypalOneTime.attr("href", _hrefOneTime+"/"+_plan);


		$(document).on("click", ".payment-plan a", function(){
            _plan = $(this).find("input").val();
            _btnPaypalRecurring.attr("href", _hrefRecurring+"/"+_plan);
            _btnPaypalOneTime.attr("href", _hrefOneTime+"/"+_plan);
        });
	});
</script>

