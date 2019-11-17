<?php if(get_option("stripe_enable", 0) == 1){?>
<div class="item">
    <a class="actionItem" href="<?=cn("payment/stripe?pid=".$package->ids)?>" data-content="payment-checkout" data-result="html">
        <i class="fa fa-credit-card-alt" aria-hidden="true"></i>  <?=lang('credit_card')?>
    </a>
</div>
<?php }?>