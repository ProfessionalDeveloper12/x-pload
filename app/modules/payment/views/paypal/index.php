<?php if(get_option("paypal_enable", 0)){?>
<div class="item">
    <a class="actionItem" href="<?=cn("payment/paypal?pid=".$package->ids)?>" data-content="payment-checkout" data-result="html">
        <i class="fa fa-cc-paypal" aria-hidden="true"></i>  <?=lang('paypal')?>
    </a>
</div>
<?php }?>