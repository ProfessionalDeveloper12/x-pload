<div class="sidebar menu-scroll" id="sidebar">
    <ul class="menu-navigation">
        <?php if(session("uid_tmp")){?>
        <li class="nav-item mt15 item-btn">
            <a href="<?=cn("dashboard/remove_view_user")?>" class="bg-black actionItem" data-redirect="<?=cn("users")?>">
                <i class="fa fa-angle-double-left" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('Back to admin')?>"></i>
                <span class="name"> <?=lang('Back to admin')?></span>
            </a>
        </li>
        <?php }?>
        
        
        <li class="nav-item <?=(segment(1) == 'account_manager')?"active":""?>">
            <a href="<?=cn("account_manager")?>">
                <i class="ft-plus-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('IG Profile')?>"></i>
                <span class="name"> <?=lang('IG Profile')?></span>
            </a>
        </li>
        
      <!--  <?php if(file_exists(APPPATH."modules/post")){?>
        <li class="nav-item mt15 item-btn <?=(segment(1) == 'post')?"active":""?>">
            <a href="<?=cn("post")?>" class="bg-danger">
                <i class="fa fa-paper-plane-o" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('publish_all')?>"></i>
                <span class="name"> <?=lang('publish_all')?></span>
            </a>
        </li>
        <li class="nav-line"></li>
        <?php }?>-->

        <?php sidebar();?>
        <li class="nav-line"></li>

        <?php plugins();?>

        <li class="nav-item <?=(segment(1) == 'dashboard')?"active":""?>">
            <a href="<?=cn("dashboard")?>">
                <i class="ft-bar-chart-2" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('dashboard')?>"></i>
                <span class="name"> <?=lang('dashboard')?></span>
            </a>
        </li>
        <li class="nav-item <?=(segment(1) == 'referral_links')?"active":""?>">
            <a href="<?=cn("referral_links")?>">
                <i class="ft-bar-chart-2" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('referral_links')?>"></i>
                <span class="name"> <?=lang('referral_links')?></span>
            </a>
        </li>
        <li class="nav-item <?=(segment(1) == 'referrals')?"active":""?>">
            <a href="<?=cn("referrals")?>">
                <i class="ft-bar-chart-2" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('referrals')?>"></i>
                <span class="name"> <?=lang('referrals')?></span>
            </a>
        </li>
        <li class="nav-item <?=(segment(1) == 'schedules')?"active":""?>">
            <a href="<?=cn("schedules")?>">
                <i class="ft-calendar" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('schedules')?>"></i>
                <span class="name"> <?=lang('schedules')?></span>
            </a>
        </li>
        
        <li class="nav-item <?=(segment(1) == 'group_manager')?"active":""?>">
            <a href="<?=cn("group_manager")?>">
                <i class="ft-target" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('Group manager')?>"></i>
                <span class="name"> <?=lang('Group manager')?></span>
            </a>
        </li>
        <li class="nav-item <?=(segment(1) == 'caption')?"active":""?>">
            <a href="<?=cn("caption")?>">
                <i class="ft-command" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('caption')?>"></i>
                <span class="name"> <?=lang('caption')?></span>
            </a>
        </li>
        <?php if(permission("photo_type") || permission("video_type")){?>
        <li class="nav-item <?=(segment(1) == 'file_manager')?"active":""?>">
            <a href="<?=cn("file_manager")?>">
                <i class="ft-folder" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('file_manager')?>"></i>
                <span class="name"> <?=lang('file_manager')?></span>
            </a>
        </li>
        <?php }?>
        <?php if(permission("watermark")){?>
        <li class="nav-item <?=(segment(1) == 'tools')?"active":""?>">
            <a href="<?=cn("tools")?>">
                <i class="ft-sliders" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('tools')?>"></i>
                <span class="name"> <?=lang('tools')?></span>
            </a>
        </li>
        <?php }?>
        <?php if(get_role()){?>
        <li class="nav-line"></li>
        <li class="nav-item <?=(segment(1) == 'users')?"active":""?>">
            <a href="<?=cn("users")?>">
                <i class="ft-user" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('user_manager')?>"></i>
                <span class="name"> <?=lang('user_manager')?></span>
            </a>
        </li>
        <li class="nav-item <?=(segment(1) == 'packages')?"active":""?>">
            <a href="<?=cn("packages")?>">
                <i class="ft-package" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('packages')?>"></i>
                <span class="name"> <?=lang('packages')?></span>
            </a>
        </li>
        <?=Modules::run("payment/block_sidebar");?>
        <li class="nav-item <?=(segment(1) == 'proxies')?"active":""?>">
            <a href="<?=cn("proxies")?>">
                <i class="ft-shield" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('proxies')?>"></i>
                <span class="name"> <?=lang('proxies')?></span>
            </a>
        </li>
       <!-- <li class="nav-item <?=(segment(1) == 'language')?"active":""?>">
            <a href="<?=cn("language")?>">
                <i class="fa fa-language" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('language')?>"></i>
                <span class="name"> <?=lang('language')?></span>
            </a>
        </li>-->
        <li class="nav-item <?=(segment(1) == 'custom_page')?"active":""?>">
            <a href="<?=cn("custom_page")?>">
                <i class="ft-file-text" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('custom_page')?>"></i>
                <span class="name"> <?=lang('custom_page')?></span>
            </a>
        </li>
        <li class="nav-item <?=(segment(1) == 'settings' && segment(2) == 'general')?"active":""?>">
            <a href="<?=cn("settings/general")?>">
                <i class="ft-settings" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('general_settings')?>"></i>
                <span class="name"> <?=lang('general_settings')?></span>
            </a>
        </li>
        <!--<li class="nav-line">
            
            <li class="nav-item <?=(segment(1) == 'cron')?"active":""?>">
                <a href="<?=cn("cron")?>">
                    <i class="ft-rotate-cw" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?=lang('cronjobs')?>"></i>
                    <span class="name"> <?=lang('cronjobs')?></span>
                </a>
            </li>
        </li>-->
        <?php }?>
    </ul>
</div>
