<form action="<?=cn("profile/ajax_change_password")?>" class="actionForm">
<div class="row">
    <div class="col-md-6">
        <h3 class="head-title"><i class="ft-lock"></i> <?=lang('change_password')?></h3>

        <div class="tab-content report-content">
            <div id="profile" class="tab-pane fade in active">
                <div class="form-group">
                    <label for="password"><?=lang("password")?></label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="confirm_password"><?=lang("confirm_password")?></label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                </div>
            </div>
        </div>

        <div class="card-footer pl0 pr0">
            <button type="submit" class="btn btn-primary"> <?=lang("Update")?></button>
        </div>
    </div>
</div>
</form>

<style type="text/css">
.pure-checkbox {
    min-width: 100px;
}
</style>