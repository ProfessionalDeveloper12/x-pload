<div class="section-4" id="pricing">
    <div class="container content">
        <?php if(!empty($package)){
            $price_monthly = $package->price_monthly;
            $price_annually = $package->price_annually;
            $coupon_code = "";

            if(session("coupon")){
                $coupon = (object)session("coupon");
                $coupon_code = $coupon->code;
                if(in_array((int)$package->id, $coupon->package)){
                    if($coupon->type == 1){
                        $price_monthly = number_format($price_monthly - $coupon->price, 2);
                        $price_annually = number_format($price_annually - $coupon->price, 2);
                    }else{
                        $price_monthly = number_format($price_monthly*(100 - $coupon->price)/100, 1);
                        $price_annually = number_format($price_annually*(100 - $coupon->price)/100, 2);
                    }
                }

            }
        ?>
        <div class="title">  <?=lang('plan')?> <?=$package->name?></div>
        <div class="desc"><?=$package->description?></div>
        <div class="payment-wrap">
            <div class="payment-plan">
                <div class="item">
                    <a href="javascript:void(0);">
                        <div class="pure-checkbox grey mr15 mb15">
                            <input type="radio" id="plan1" name="plan" class="filled-in chk-col-red" value="1" <?=$type==1?'checked=""':""?>>
                            <label class="p0 m0" for="plan1">&nbsp;</label>
                            <span class="checkbox-text-right"><span class="bold"> <?=lang('monthly')?>:</span> <?=get_option('payment_currency','USD')." ".$price_monthly?> / <?=lang('month')?></span>
                        </div>
                    </a>
                </div>
                <div class="item active">
                    <a href="javascript:void(0);">
                        <div class="pure-checkbox grey mr15 mb15">
                            <input type="radio" id="plan2" name="plan" class="filled-in chk-col-red" value="2" <?=$type==2?'checked=""':""?>>
                            <label class="p0 m0" for="plan2">&nbsp;</label>
                            <span class="checkbox-text-right"><span class="bold"> <?=lang('annually')?>:</span> 
                                <div class="price"><?=get_option('payment_currency','USD')." ".$price_annually?> /  <?=lang('month')?>
                                    <div class="bill"><?=sprintf(lang('billed_x_annually'), get_option('payment_currency','USD')." ".($price_annually*12))?></div>
                                </div>
                            </span>
                            <?php if($price_monthly - $price_annually > 0){?>
                            <span class="save">  <?=lang('you_save')?><br/> <?=get_option('payment_currency','USD')?> <?=($price_monthly - $price_annually)*12?></span>
                            <?php }?>
                        </div>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <?=Modules::run("coupon/view", $coupon_code)?>
            <div class="payment-method">
                <div class="payment-tabs">
                    <?=Modules::run("payment/block_payments")?>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="payment-checkout">
            </div>
            
        </div>
        <?php }?>
        <div class="text-center mt15"><a href="<?=PATH?>" style="color: #c7c7c7;"><i class="fa fa-angle-double-left" aria-hidden="true"></i>  <?=lang('back_to_home')?></a></div>
    </div>
</div>


