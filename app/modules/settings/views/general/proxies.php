<div class="row">
    <div class="col-md-12">
    	<h3 class="head-title"><i class="ft-shield"></i> <?=lang('proxies')?></h3>

        <div class="form-group">
            <span class="text"> <?=lang('users_can_add_proxies')?></span> <br/>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_user_proxy_enable" name="user_proxy" class="filled-in chk-col-red" <?=get_option('user_proxy', 1)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_user_proxy_enable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('enable')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_user_proxy_disable" name="user_proxy" class="filled-in chk-col-red" <?=get_option('user_proxy', 1)==0?"checked":""?> value="0">
                <label class="p0 m0" for="md_checkbox_user_proxy_disable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('disable')?></span>
            </div>
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('users_can_use_the_system_proxy')?></span> <br/>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_system_proxy_enable" name="system_proxy" class="filled-in chk-col-red" <?=get_option('system_proxy', 1)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_system_proxy_enable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('enable')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_system_proxy_disable" name="system_proxy" class="filled-in chk-col-red" <?=get_option('system_proxy', 1)==0?"checked":""?> value="0">
                <label class="p0 m0" for="md_checkbox_system_proxy_disable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('disable')?></span>
            </div>
        </div>

    </div>
</div>