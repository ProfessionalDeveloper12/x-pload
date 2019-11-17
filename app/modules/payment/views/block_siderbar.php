 <?=Modules::run("coupon/menu");?>
<li class="nav-item <?=(segment(1) == 'payment_history')?"active":""?>">
    <a href="<?=cn("payment_history")?>">
        <i class="ft-credit-card" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('payment_history')?>"></i>
        <span class="name"> <?=lang('payment_history')?></span>
    </a>
</li>