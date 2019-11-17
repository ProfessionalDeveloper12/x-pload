<div class="row">
    <div class="col-md-12">
    	<h3 class="head-title"><i class="ft-monitor"></i> <?=lang('general')?></h3>

        <span class="text"> <?=lang('dark_menu')?></span><br/>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_dark_menu_enable" name="dark_menu" class="filled-in chk-col-red" <?=get_option('dark_menu', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_dark_menu_enable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('on')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_dark_menu_disable" name="dark_menu" class="filled-in chk-col-red" <?=get_option('dark_menu', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_dark_menu_disable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('off')?></span>
        </div>
        
        <br/>
        <span class="text"> <?=lang('full_menu')?></span><br/>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_full_menu_enable" name="full_menu" class="filled-in chk-col-red" <?=get_option('full_menu', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_full_menu_enable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('on')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_full_menu_disable" name="full_menu" class="filled-in chk-col-red" <?=get_option('full_menu', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_full_menu_disable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('off')?></span>
        </div>

        <br/>
        <span class="text"> <?=lang('Sidebar icons color')?></span><br/>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_sidebar_icons_color_default" name="sidebar_icons_color" class="filled-in chk-col-red" <?=get_option('sidebar_icons_color', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_sidebar_icons_color_default">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('default')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_sidebar_icons_color" name="sidebar_icons_color" class="filled-in chk-col-red" <?=get_option('sidebar_icons_color', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_sidebar_icons_color">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('Color')?></span>
        </div>

        <br/>
        <span class="text"> <?=lang('Show subscription expires on header')?></span><br/>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_show_subscription_default" name="show_subscription" class="filled-in chk-col-red" <?=get_option('show_subscription', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_show_subscription_default">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('on')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_show_subscription" name="show_subscription" class="filled-in chk-col-red" <?=get_option('show_subscription', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_show_subscription">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('off')?></span>
        </div>

        <br/>
        <span class="text"> <?=lang('GDPR Cookie Consent')?></span><br/>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_gdpr_cookie_consent_default" name="gdpr_cookie_consent" class="filled-in chk-col-red" <?=get_option('gdpr_cookie_consent', 1)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_gdpr_cookie_consent_default">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('on')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_gdpr_cookie_consent" name="gdpr_cookie_consent" class="filled-in chk-col-red" <?=get_option('gdpr_cookie_consent', 1)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_gdpr_cookie_consent">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('off')?></span>
        </div>

        <br/>
        <span class="text"> <?=lang('Disable Landing Page')?></span><br/>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_disable_landing_page_default" name="disable_landing_page" class="filled-in chk-col-red" <?=get_option('disable_landing_page', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_disable_landing_page_default">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('Yes')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_disable_landing_page" name="disable_landing_page" class="filled-in chk-col-red" <?=get_option('disable_landing_page', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_disable_landing_page">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('No')?></span>
        </div>


      <!--  <div class="form-group">
            <?php
            $themes = scandir(APPPATH."../themes");
            ?>
            <span class="text"> <?=lang("theme")?></span> 
            <select name="theme" class="form-control">
                <?php foreach ($themes as $key => $theme) {
                if(strpos($theme,".") === FALSE){
                ?>
                <option value="<?=$theme?>" <?=get_theme()==$theme?"selected":""?>><?=ucfirst($theme)?></option>
                <?php }}?>
            </select>
        </div>
-->
        <div class="form-group">
            <span class="text"> <?=lang('website_title')?></span> 
            <input type="text" class="form-control" name="website_title" value="<?=get_option("website_title", 'X-Pload - Social Marketing Tool')?>">
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('website_description')?></span> 
            <input type="text" class="form-control" name="website_description" value="<?=get_option("website_description", 'save time, do more, manage multiple social networks at one place')?>">
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('website_keyword')?></span> 
            <input type="text" class="form-control" name="website_keyword" value="<?=get_option("website_keyword", 'social marketing tool, social planner, automation, social schedule')?>">
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('website_favicon')?></span>
     
            <div class="input-group p0">
                <input type="text" class="form-control" name="website_favicon" id="website_favicon" value="<?=get_option("website_favicon", BASE.'assets/img/favicon.png')?>">
                <span class="input-group-btn" id="button-addon">
                    <a class="btn btn-primary btnOpenFileManager" href="<?=PATH?>file_manager/popup_add_files?id=website_favicon">
                        <i class="ft-folder"></i>
                    </a>
                </span>
            </div>
        </div>
        <div class="form-group">
            <span class="text"> <?=lang('website_logo_white')?></span>
     
            <div class="input-group p0">
                <input type="text" class="form-control" name="website_logo_white" id="website_logo_white" value="<?=get_option("website_logo_white", BASE.'assets/img/logo-white.png')?>">
                <span class="input-group-btn" id="button-addon">
                    <a class="btn btn-primary btnOpenFileManager" href="<?=PATH?>file_manager/popup_add_files?id=website_logo_white">
                        <i class="ft-folder"></i>
                    </a>
                </span>
            </div>
        </div>
        <div class="form-group">
            <span class="text"><?=lang('website_logo_black')?></span>
     
            <div class="input-group p0">
                <input type="text" class="form-control" name="website_logo_black" id="website_logo_black" value="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>">
                <span class="input-group-btn" id="button-addon">
                    <a class="btn btn-primary btnOpenFileManager" href="<?=PATH?>file_manager/popup_add_files?id=website_logo_black">
                        <i class="ft-folder"></i>
                    </a>
                </span>
            </div>
        </div>
        <div class="form-group">
            <span class="text"><?=lang('logo_mark')?></span>
     
            <div class="input-group p0">
                <input type="text" class="form-control" name="website_logo_mark" id="website_logo_mark" value="<?=get_option("website_logo_mark", BASE.'assets/img/logo-mark.png')?>">
                <span class="input-group-btn" id="button-addon">
                    <a class="btn btn-primary btnOpenFileManager" href="<?=PATH?>file_manager/popup_add_files?id=website_logo_mark">
                        <i class="ft-folder"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
.pure-checkbox {
    min-width: 100px;
}
</style>