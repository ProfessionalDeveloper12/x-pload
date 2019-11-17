<div class="row">
    <div class="col-md-4">
        <h3 class="head-title"><i class="ft-package"></i> <?=lang('package')?></h3>

        <div class="tab-content report-content">
            <div id="profile" class="tab-pane fade in active">
                <ul class="list-group">
                  <li class="list-group-item"><span class="name"><?=lang("your_package")?></span> <span class="pull-right"><?=(!empty($account) && $account->package_name != "")?$account->package_name:"None"?></span></li>
                  <li class="list-group-item"><span class="name"><?=lang("expire_date")?></span> <span class="pull-right"><?=(!empty($account) && $account->package_name != "")?convert_date($account->expiration_date):"None"?></span></li>
                </ul>
            </div>
        </div>

        <?php if(get_payment()){?>
        <div class="card-footer pl0 pr0">
            <a href="<?=cn("pricing")?>" class="btn btn-primary"> <?=lang("renew_account")?></a>
        </div>
        <?php }?>
    </div>
</div>

<style type="text/css">
.pure-checkbox {
    min-width: 100px;
}
</style>

