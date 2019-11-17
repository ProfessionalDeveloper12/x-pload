<div class="section-tk">
    <div class="text-center">
        <div class="icon error"><i class="fa fa-frown-o" aria-hidden="true"></i></div>
        <p class="title"> <?=lang('payment_unsuccessfully')?></p>
        <p class="desc"><?=(get("message"))?get("message"):lang('the_payment_could_not_be_completed')?></p>
        <p class="sign"><strong> <?=lang('website_name')?></strong>, <i><?=lang('marketting_tools')?></i></p>
        <a href="<?=cn('pricing')?>" class="btn btn-success btn-lg"> <?=lang('try_to_again')?></a>
    </div>
</div>