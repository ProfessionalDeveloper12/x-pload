<div class="row pn-mode pn-mode-users">
    <a href="javascript:void(0);" class="pn-toggle-open"><i class="ft-user" aria-hidden="true"></i></a>
    <div class="pn-sidebar pn-scroll">
        <div class="pn-box-sidebar">

            <h3 class="head-title"><?=lang("User manager")?></h3>

            <div class="box-search">
                <div class="input-group">
                  <input type="text" class="form-control pn-search" placeholder="<?=lang("Search")?>" aria-describedby="basic-addon2">
                  <span class="input-group-addon" id="basic-addon2"><i class="ft-search"></i></span>
                </div>
            </div>

            <div class="item item-2 border <?=segment(3)==""?"active":""?>">
                <a href="<?=cn("users")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("users")?>');">
                    <div class="icon"><i class="ft-user"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('List users')?></div>
                    </div>
                </a>
            </div>
            <div class="item item-2 border <?=segment(3)=="social"?"active":""?>">
                <a href="<?=cn("users/index/statistics")?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("users/index/statistics")?>');">
                    <div class="icon"><i class="ft-bar-chart-2"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('User report')?></div>
                    </div>
                </a>
            </div>
            <div class="item item-2 border">
                <a href="<?=cn("users/export")?>">
                    <div class="icon"><i class="ft-upload"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('Export')?></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="pn-content pn-scroll">
        <div class="pn-box-content">
            <div class="pn-ajax-content">
                <?=$view?>
            </div>
        </div>
    </div>
</div>