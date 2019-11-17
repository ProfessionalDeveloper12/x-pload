<div class="lead"><?=lang('pagseguro')?></div>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_pagseguro_enable" name="pagseguro_enable" class="filled-in chk-col-red" <?=get_option('pagseguro_enable', 0)==1?"checked":""?> value="1">
    <label class="p0 m0" for="md_checkbox_pagseguro_enable">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('enable')?></span>
</div>
<div class="pure-checkbox grey mr15 mb15">
    <input type="radio" id="md_checkbox_pagseguro_enable_disable" name="pagseguro_enable" class="filled-in chk-col-red" <?=get_option('pagseguro_enable', 0)==0?"checked":""?> value="0">
    <label class="p0 m0" for="md_checkbox_pagseguro_enable_disable">&nbsp;</label>
    <span class="checkbox-text-right"> <?=lang('disable')?></span>
</div>

<div class="form-group">
    <span class="text"> <?=lang('email')?></span> 
    <input type="text" class="form-control" name="pagseguro_email" value="<?=get_option('pagseguro_email', '')?>">
</div>
<div class="form-group">
    <span class="text"> <?=lang('token')?></span> 
    <input type="text" class="form-control" name="pagseguro_token" value="<?=get_option('pagseguro_token', '')?>">
</div>