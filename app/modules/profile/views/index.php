<div class="row pn-mode pn-mode-settings">
    <a href="javascript:void(0);" class="pn-toggle-open"><i class="ft-settings" aria-hidden="true"></i></a>
    <div class="pn-sidebar pn-scroll">
        <div class="pn-box-sidebar">

            <h3 class="head-title"><?=lang("profile")?></h3>

            <div class="box-search">
                <div class="input-group">
                  <input type="text" class="form-control pn-search" placeholder="<?=lang("Search")?>" aria-describedby="basic-addon2">
                  <span class="input-group-addon" id="basic-addon2"><i class="ft-search"></i></span>
                </div>
            </div>

            <div class="item item-2 border <?=segment(3)==""?"active":""?>">
                <a href="<?=cn("profile/index")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("profile/index")?>');">
                    <div class="icon"><i class="ft-user"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('my_account')?></div>
                    </div>
                </a>
            </div>
            <div class="item item-2 border <?=segment(3)=="change_password"?"active":""?>">
                <a href="<?=cn("profile/index/change_password")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("profile/index/change_password")?>');">
                    <div class="icon"><i class="ft-lock"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('change_password')?></div>
                    </div>
                </a>
            </div>
            <div class="item item-2 border <?=segment(3)=="package"?"active":""?>">
                <a href="<?=cn("profile/index/package")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("profile/index/package")?>');">
                    <div class="icon"><i class="ft-package"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('package')?></div>
                    </div>
                </a>
            </div>

        </div>
    </div>
    <div class="pn-content pn-scroll">
        <div class="pn-box-content">
            <div class="setting-from">
                <div class="pn-ajax-content">
                    <?=$view?>
                </div>
            </div>
        </div>
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