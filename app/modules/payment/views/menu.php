<div class="item item-2 border <?=segment(3)=="payment"?"active":""?>">
    <a href="<?=cn("settings/general/payment")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("settings/general/payment")?>');">
        <div class="icon"><i class="ft-credit-card"></i></div>
        <div class="content content-1">
            <div class="title"><?=lang('payment')?></div>
        </div>
    </a>
</div>