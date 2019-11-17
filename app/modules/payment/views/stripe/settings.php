<div class="lead"><?=lang('stripe')?></div>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_stripe_enable" name="stripe_enable" class="filled-in chk-col-red" <?=get_option('stripe_enable', 0)==1?"checked":""?> value="1">
    <label class="p0 m0" for="md_checkbox_stripe_enable">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('enable')?></span>
</div>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_stripe_enable_disable" name="stripe_enable" class="filled-in chk-col-red" <?=get_option('stripe_enable', 0)==0?"checked":""?> value="0">
    <label class="p0 m0" for="md_checkbox_stripe_enable_disable">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('disable')?></span>
</div><br/>
<span class="text"> <?=lang('Payment type')?></span><br/>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_stripe_type" name="stripe_type" class="filled-in chk-col-red" <?=get_option('stripe_type', 0)==1?"checked":""?> value="1">
    <label class="p0 m0" for="md_checkbox_stripe_type">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('Recurring Payment')?></span>
</div>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_stripe_type_disable" name="stripe_type" class="filled-in chk-col-red" <?=get_option('stripe_type', 0)==2?"checked":""?> value="2">
    <label class="p0 m0" for="md_checkbox_stripe_type_disable">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('One-Time Payment')?></span>
</div>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_stripe_type_both" name="stripe_type" class="filled-in chk-col-red" <?=get_option('stripe_type', 0)==0?"checked":""?> value="0">
    <label class="p0 m0" for="md_checkbox_stripe_type_both">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('Both')?></span>
</div>
<div class="form-group">
    <span class="text"> <?=lang('publishable_key')?></span> 
    <input type="text" class="form-control" name="stripe_publishable_key" value="<?=get_option('stripe_publishable_key', '')?>">
</div>
<div class="form-group">
    <span class="text"> <?=lang('secret_key')?></span> 
    <input type="text" class="form-control" name="stripe_secret_key" value="<?=get_option('stripe_secret_key', '')?>">
</div>