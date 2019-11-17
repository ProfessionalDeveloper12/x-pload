<div class="lead"><?=lang('Paystack')?></div>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_paystack_enable" name="paystack_enable" class="filled-in chk-col-red" <?=get_option('paystack_enable', 0)==1?"checked":""?> value="1">
    <label class="p0 m0" for="md_checkbox_paystack_enable">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('enable')?></span>
</div>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_paystack_enable_disable" name="paystack_enable" class="filled-in chk-col-red" <?=get_option('paystack_enable', 0)==0?"checked":""?> value="0">
    <label class="p0 m0" for="md_checkbox_paystack_enable_disable">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('disable')?></span>
</div>

<div class="form-group">
    <span class="text"> <?=lang('Paystack Public Key')?></span> 
    <input type="text" class="form-control" name="paystack_public_key" value="<?=get_option('paystack_public_key', '')?>">
</div>
<div class="form-group">
    <span class="text"> <?=lang('Paystack Secret Key')?></span> 
    <input type="text" class="form-control" name="paystack_secret_key" value="<?=get_option('paystack_secret_key', '')?>">
</div>