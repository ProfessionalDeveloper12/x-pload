<div class="lead"><?=lang('paypal')?></div>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_paypal_enable" name="paypal_enable" class="filled-in chk-col-red" <?=get_option('paypal_enable', 0)==1?"checked":""?> value="1">
    <label class="p0 m0" for="md_checkbox_paypal_enable">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('enable')?></span>
</div>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_paypal_enable_disable" name="paypal_enable" class="filled-in chk-col-red" <?=get_option('paypal_enable', 0)==0?"checked":""?> value="0">
    <label class="p0 m0" for="md_checkbox_paypal_enable_disable">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('disable')?></span>
</div><br/>
<span class="text"> <?=lang('Payment type')?></span><br/>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_paypal_type" name="paypal_type" class="filled-in chk-col-red" <?=get_option('paypal_type', 0)==1?"checked":""?> value="1">
    <label class="p0 m0" for="md_checkbox_paypal_type">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('Recurring Payment')?></span>
</div>
<div class="pure-checkbox grey mr15 mb15">  
    <input type="radio" id="md_checkbox_paypal_type_disable" name="paypal_type" class="filled-in chk-col-red" <?=get_option('paypal_type', 0)==2?"checked":""?> value="2">
    <label class="p0 m0" for="md_checkbox_paypal_type_disable">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('One-Time Payment')?></span>
</div>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_paypal_type_both" name="paypal_type" class="filled-in chk-col-red" <?=get_option('paypal_type', 0)==0?"checked":""?> value="0">
    <label class="p0 m0" for="md_checkbox_paypal_type_both">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('Both')?></span>
</div>
<div class="form-group">
    <span class="text"> <?=lang('client_id')?></span> 
    <input type="text" class="form-control" name="paypal_client_id" value="<?=get_option('paypal_client_id', '')?>">
</div>
<div class="form-group">
    <span class="text"> <?=lang('client_secret_key')?></span> 
    <input type="text" class="form-control" name="paypal_client_secret" value="<?=get_option('paypal_client_secret', '')?>">
</div>  