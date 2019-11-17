<?php if(get_option("pagseguro_enable", 0)){?>
<div class="item">
    <a class="actionItem" href="<?=cn("payment/pagseguro?pid=".$package->ids)?>" data-content="payment-checkout" data-result="html">
        <i class="fa fa-credit-card" aria-hidden="true"></i> Pagseguro
    </a>
</div>
<?php }?>