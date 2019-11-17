<div class="paypal-method">
    <img src="<?=BASE?>assets/img/pagseguro.png">
    <a href="<?=cn('payment/pagseguro/process/'.$package->ids)?>" class="btn btn-dark btn-lg btn-block mt15 btnPaypalPayment"><?=lang('submit_payment')?></a>
</div>	

<script type="text/javascript">
	$(function(){
		var _plan = $("input[name='plan']:checked").val();
		var _btnPayment = $('.btnPaypalPayment');
		var _href = _btnPayment.attr("href");
		_btnPayment.attr("href", _href+"/"+_plan);

		$(document).on("click", ".payment-plan a", function(){
            _plan = $(this).find("input").val();
            _btnPayment.attr("href", _href+"/"+_plan);
        });
	});
</script>

