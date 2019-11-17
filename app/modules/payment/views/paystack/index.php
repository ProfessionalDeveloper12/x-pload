<?php if(get_option("paystack_enable", 0)){?>
<div class="item">
    <a class="actionItem" href="<?=cn("payment/paystack?pid=".$package->ids)?>" data-content="payment-checkout" data-result="html">
        <i class="fa fa-credit-card-alt" aria-hidden="true"></i> <?=lang("Paystack")?>
    </a>
</div>
<?php }?>