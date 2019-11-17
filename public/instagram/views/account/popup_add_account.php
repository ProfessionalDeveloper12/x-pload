<div id="load_popup_modal_contant" class="" role="dialog">
    <div class="modal-dialog modal-md">
        <form action="<?=BASE?>instagram/ajax_add_account" data-type-message="text" data-redirect="<?=cn("account_manager")?>" data-async role="form" class="form-horizontal actionForm" role="form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title"><i class="fa fa-instagram"></i> <?=lang("add_instagram_account")?></div>
            </div>
            <div class="modal-body m15">
                <div class="row">
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="row form-notify"></div>
                        <div class="form-group">
                            <label class="control-label" for="username"><?=lang("instagram_username")?></label>
                                <input type="text" name="username" class="form-control" id="username" value="<?=!empty($result)?$result->username:""?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password"><?=lang("instagram_password")?></label>
                            <input type="password" name="password" class="form-control" id="password" value="">
                        </div>
                        <?php if(get_option('user_proxy', 1) == 1){?>
                        <div class="form-group">
                            <label class="control-label" for="proxy"><?=lang("proxy")?></label>
                            <input type="text" name="proxy" class="form-control" id="proxy" value="<?=!empty($result)?$result->proxy:""?>">
                        </div>
                        <?php }?>
                        <div class="form-group form-verification_code hide">
                            <label class="control-label" for="code"><?=lang("verification_code")?></label>
                            <input type="text" name="code" class="form-control" id="code">
                        </div>
                        <div class="form-group form-security_code hide">
                            <label class="control-label" for="security_code"> <?=lang('security_code')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="security_code" id="security_code">
                                <span class="input-group-btn">
                                    <a href="<?=BASE?>instagram/ajax_add_account/resend" class="btn btn-default actionMultiItem"><?=lang('get_new_code')?></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input name="submit_popup" id="submit_popup" type="submit" value="<?=lang('add_account')?>" class="btn btn-primary" />
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang("close")?></button>
            </div>
        </div>
        </form>
    </div>
</div>