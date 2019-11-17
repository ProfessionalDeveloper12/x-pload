<form action="<?=cn("profile/ajax_update_account")?>" class="actionForm">
<div class="row">
    <div class="col-md-6">
    	<h3 class="head-title"><i class="ft-user"></i> <?=lang('my_account')?></h3>

        <div class="tab-content report-content">
            <div id="profile" class="tab-pane fade in active">
                <div class="form-group">
                    <label for="fullname"><?=lang("fullname")?></label>
                    <input type="text" class="form-control" name="fullname" id="fullname" value="<?=!empty($account)?$account->fullname:""?>">
                </div>
                <div class="form-group">
                    <label for="email"><?=lang("email")?></label>
                    <input type="text" class="form-control" name="email" id="email" value="<?=!empty($account)?$account->email:""?>">
                </div>
                <div class="form-group">
                    <label for="email"><?=lang("timezone")?></label>
                    <select  class="form-control" name="timezone" id="timezone" >
                        <?php if(!empty(tz_list())){
                        foreach (tz_list() as $value) {
                        ?>
                        <option value="<?=$value['zone']?>" <?=(!empty($account) && $value['zone'] == $account->timezone)?"selected":""?> ><?=$value['time']?></option>
                        <?php }}?>
                    </select>
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