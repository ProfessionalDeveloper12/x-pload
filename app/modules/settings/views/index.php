<div class="row pn-mode pn-mode-settings">
    <a href="javascript:void(0);" class="pn-toggle-open"><i class="ft-settings" aria-hidden="true"></i></a>
    <div class="pn-sidebar pn-scroll">
        <div class="pn-box-sidebar">

            <h3 class="head-title"><?=lang("General Settings")?></h3>

            <div class="box-search">
                <div class="input-group">
                  <input type="text" class="form-control pn-search" placeholder="<?=lang("Search")?>" aria-describedby="basic-addon2">
                  <span class="input-group-addon" id="basic-addon2"><i class="ft-search"></i></span>
                </div>
            </div>

            <div class="item item-2 border <?=segment(3)==""?"active":""?>">
                <a href="<?=cn("settings/general")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("settings/general")?>');">
                    <div class="icon"><i class="ft-monitor"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('general')?></div>
                    </div>
                </a>
            </div>
            <div class="item item-2 border <?=segment(3)=="social"?"active":""?>">
                <a href="<?=cn("settings/general/social")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("settings/general/social")?>');">
                    <div class="icon"><i class="fa fa-user-circle-o"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('social_settings')?></div>
                    </div>
                </a>
            </div>
            <?=Modules::run("payment/block_menu")?>

            <div class="item item-2 border <?=segment(3)=="oauth"?"active":""?>">
                <a href="<?=cn("settings/general/oauth")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("settings/general/oauth")?>');">
                    <div class="icon"><i class="ft-lock"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('oauth')?></div>
                    </div>
                </a>
            </div>

            <div class="item item-2 border <?=segment(3)=="proxies"?"active":""?>">
                <a href="<?=cn("settings/general/proxies")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("settings/general/proxies")?>');">
                    <div class="icon"><i class="ft-shield"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('proxies')?></div>
                    </div>
                </a>
            </div>

            <div class="item item-2 border <?=segment(3)=="file_manager"?"active":""?>">
                <a href="<?=cn("settings/general/file_manager")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("settings/general/file_manager")?>');">
                    <div class="icon"><i class="ft-folder"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('file_manager')?></div>
                    </div>
                </a>
            </div>

            <div class="item item-2 border <?=segment(3)=="mail"?"active":""?>">
                <a href="<?=cn("settings/general/mail")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("settings/general/mail")?>');">
                    <div class="icon"><i class="fa fa-envelope-o"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('mail')?></div>
                    </div>
                </a>
            </div>

            <div class="item item-2 border <?=segment(3)=="social_page"?"active":""?>">
                <a href="<?=cn("settings/general/social_page")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("settings/general/social_page")?>');">
                    <div class="icon"><i class="ft-share-2"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('social_page')?></div>
                    </div>
                </a>
            </div>

            <div class="item item-2 border <?=segment(3)=="other"?"active":""?>">
                <a href="<?=cn("settings/general/other")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("settings/general/other")?>');">
                    <div class="icon"><i class="ft-sliders"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('other')?></div>
                    </div>
                </a>
            </div>

            <!-- <div class="item item-3 active">
                <a href="">
                    <div class="icon"><i class="ft-monitor"></i></div>
                    <div class="content content-1">
                        <div class="title">General</div>
                    </div>
                </a>
                <div class="option">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="ft-more-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="javascript:void(0);">View</a></li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="item item-3">
                <a href="">
                    <div class="icon"><i class="ft-monitor"></i></div>
                    <div class="content content-2">
                        <div class="title">General Just One Laguage Just One Laguage</div>
                        <div class="desc">Just One Laguage Just One Laguage</div>
                    </div>
                </a>
                <div class="option">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="ft-more-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="javascript:void(0);">View</a></li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="item item-2">
                
                <a href="">
                    <div class="icon"><i class="ft-monitor"></i></div>
                    <div class="content content-1">
                        <div class="title">General</div>
                    </div>
                </a>

            </div>


            <div class="item item-4">
                <a href="">
                    <div class="content content-1">
                        <div class="title">General</div>
                    </div>
                </a>

                <div class="option">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="ft-more-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="javascript:void(0);">View</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="item item-4">
                
                <a href="">
                    <div class="content content-1">
                        <div class="title">General</div>
                    </div>
                </a>

            </div> -->

        </div>
    </div>
    <div class="pn-content pn-scroll">
        <form action="<?=PATH?>settings/ajax_settings" method="POST" class="actionForm">
            <div class="pn-box-content">
                <div class="setting-from">
                    <div class="pn-ajax-content">
                        <?=$view?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"> <?=lang('save_changes')?></button>
            </div>
        </form>
    </div>
</div>

<style type="text/css">
.pn-mode-settings .lead{
    font-size: 18px;
    border-left: 3px solid #2196f3;
    padding-left: 10px;
}

.pn-mode-settings .tab-list .card-header .nav-tabs>li>a{
    margin: 15px 15px 0 0;
    color: #000!important;
    background: transparent!important;
}

.pn-mode-settings .tab-list .card-header .nav-tabs>li.active>a::before{
    content: '';
    border-bottom: 2px solid #0089cf;
    position: absolute;
    width: 100%;
    top: 37px;
    left: 0;
}
</style>