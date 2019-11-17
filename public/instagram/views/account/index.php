<div class="col-md-3 col-sm-4">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fa fa-instagram" aria-hidden="true"></i> <?=$module_name?>
                <div class="pull-right card-option">
                    <a href="<?=cn($module."/popup_add_account")?>" class="ajaxModal" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?=lang("add_account")?>"><i class="ft-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-block p0">
            <div class="account-manager-list scrollbar scrollbar-dynamic">
                <?php if(!empty($list_account)){
                    foreach ($list_account as $key => $row) {
                ?> 
                <div class="item">
                    <div class="am-img">
                        <img class="img-circle" src="<?=$row->avatar?>">
                    </div>
                    <a class="am-info" href="https://www.instagram.com/<?=$row->username?>" target="_blank">
                        <div class="username"><?=$row->username?> 
                            <?php if($row->status == 0){ ?>
                            <span class="small error"><?=lang("re_login")?></span>
                            <?php }?>
                        </div>
                    </a>
                    <div class="am-option">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="ft-more-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="<?=cn($module."/popup_add_account/$row->ids")?>" class="ajaxModal" data-id="<?=$row->ids?>"><?=lang("edit")?></a></li>
                                <li><a href="<?=cn($module."/clear_cookies/$row->ids")?>" class="actionItem" data-id="<?=$row->ids?>"><?=lang("Clear cookies")?></a></li>
                                <li><a href="<?=cn($module."/ajax_delete_item")?>" data-redirect="<?=cn("account_manager")?>" class="actionItem" data-id="<?=$row->ids?>"><?=lang("delete")?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php }}else{?>
                    <div class="empty">
                        <span><?=lang("add_an_account_to_begin")?></span>
                        <a href="<?=cn($module."/popup_add_account")?>" class="btn btn-primary ajaxModal"><?=lang("add_account")?></a>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>