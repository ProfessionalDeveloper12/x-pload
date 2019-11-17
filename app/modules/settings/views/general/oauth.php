<div class="row">
    <div class="col-md-12">
    	<h3 class="head-title"><i class="ft-lock"></i> <?=lang('oauth')?></h3>

        <div class="form-group">
            <span class="text"> <?=lang('enable_signup')?></span> <br/>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_singup_enable" name="singup_enable" class="filled-in chk-col-red" <?=get_option('singup_enable', 1)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_singup_enable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('enable')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_singup_enable_disable" name="singup_enable" class="filled-in chk-col-red" <?=get_option('singup_enable', 1)==0?"checked":""?> value="0">
                <label class="p0 m0" for="md_checkbox_singup_enable_disable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('disable')?></span>
            </div>
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('verify_account_via_email')?></span> <br/>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_singup_verify_email_enable" name="singup_verify_email_enable" class="filled-in chk-col-red" <?=get_option('singup_verify_email_enable', 1)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_singup_verify_email_enable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('enable')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_singup_verify_email_disable" name="singup_verify_email_enable" class="filled-in chk-col-red" <?=get_option('singup_verify_email_enable', 1)==0?"checked":""?> value="0">
                <label class="p0 m0" for="md_checkbox_singup_verify_email_disable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('disable')?></span>
            </div>
        </div>
        <div class="lead"> <?=lang('Google reCaptcha')?></div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_google_captcha_enable" name="google_captcha_enable" class="filled-in chk-col-red" <?=get_option('google_captcha_enable', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_google_captcha_enable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('enable')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_google_captcha_enable_disable" name="google_captcha_enable" class="filled-in chk-col-red" <?=get_option('google_captcha_enable', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_google_captcha_enable_disable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('disable')?></span>
        </div>

        <div class="form-group">
            <span class="text"> <?=lang('Site key')?></span> 
            <input type="text" class="form-control" name="google_captcha_client_id" value="<?=get_option('google_captcha_client_id', '')?>">
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('Site secret key')?></span> 
            <input type="text" class="form-control" name="google_captcha_client_secret" value="<?=get_option('google_captcha_client_secret', '')?>">
        </div>

        <div class="lead"> <?=lang('google_login')?></div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_google_oauth_enable" name="google_oauth_enable" class="filled-in chk-col-red" <?=get_option('google_oauth_enable', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_google_oauth_enable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('enable')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_google_oauth_enable_disable" name="google_oauth_enable" class="filled-in chk-col-red" <?=get_option('google_oauth_enable', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_google_oauth_enable_disable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('disable')?></span>
        </div>

        <div class="form-group">
            <span class="text"> <?=lang('client_id')?></span> 
            <input type="text" class="form-control" name="google_oauth_client_id" value="<?=get_option('google_oauth_client_id', '')?>">
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('client_secret_key')?></span> 
            <input type="text" class="form-control" name="google_oauth_client_secret" value="<?=get_option('google_oauth_client_secret', '')?>">
        </div>
        <div class="lead"> <?=lang('facebook_login')?></div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_facebook_oauth_enable" name="facebook_oauth_enable" class="filled-in chk-col-red" <?=get_option('facebook_oauth_enable', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_facebook_oauth_enable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('enable')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_facebook_oauth_enable_disable" name="facebook_oauth_enable" class="filled-in chk-col-red" <?=get_option('facebook_oauth_enable', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_facebook_oauth_enable_disable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('disable')?></span>
        </div> 
        <div class="form-group">
            <span class="text"> <?=lang('app_id')?></span> 
            <input type="text" class="form-control" name="facebook_oauth_app_id" value="<?=get_option('facebook_oauth_app_id', '')?>">
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('app_secret')?></span> 
            <input type="text" class="form-control" name="facebook_oauth_app_secret" value="<?=get_option('facebook_oauth_app_secret', '')?>">
        </div>

       
        <div class="lead"> <?=lang('twitter_login')?></div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_twitter_oauth_enable" name="twitter_oauth_enable" class="filled-in chk-col-red" <?=get_option('twitter_oauth_enable', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_twitter_oauth_enable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('enable')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_twitter_oauth_enable_disable" name="twitter_oauth_enable" class="filled-in chk-col-red" <?=get_option('twitter_oauth_enable', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_twitter_oauth_enable_disable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('disable')?></span>
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('Consumer key (api key)')?></span> 
            <input type="text" class="form-control" name="twitter_oauth_client_id" value="<?=get_option('twitter_oauth_client_id', '')?>">
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('Consumer secret (api secret)')?></span> 
            <input type="text" class="form-control" name="twitter_oauth_client_secret" value="<?=get_option('twitter_oauth_client_secret', '')?>">
        </div>
    </div>
</div>