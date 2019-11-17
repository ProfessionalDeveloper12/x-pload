<div class="wrap-content">
	<form action="<?=cn($module."/ajax_update")?>" data-redirect="<?=cn($module)?>" class="actionForm" method="POST">
	<input type="hidden" name="ids" value="<?=!empty($result)?$result->ids:""?>">

	<div class="row">
		<div class="col-md-5">
			<div class="users">
			  	<div class="card">
			  		<div class="card-header">
			  			<div class="card-title">
	                        <i class="<?=$module_icon?>" aria-hidden="true"></i> <?=$module_name?>
	                    </div>
	                    <div class="clearfix"></div>
			  		</div>
			  		<div class="card-body pl15 pr15">
			  			<div class="row">
			  				<div class="col-md-12">
                                <div class="form-group">
                                    <label for="fullname"><?=lang("fullname")?></label>
                                    <input type="text" class="form-control" name="fullname" id="fullname" value="<?=!empty($result)?$result->fullname:""?>">
                                </div>
                                <div class="form-group">
                                    <label for="email"><?=lang("email")?></label>
                                    <input type="text" class="form-control" name="email" id="email" value="<?=!empty($result)?$result->email:""?>">
                                </div>
                                <div class="form-group">
                                    <label for="password"><?=lang("password")?></label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password"><?=lang("confirm_password")?></label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                                </div>
                                <div class="form-group">
                                    <label for="package"><?=lang("package")?></label>
                                    <select class="form-control" name="package" id="package">
                                  		<option value="0"><?=lang("select_package")?></option>
	                                	<?php if(!empty($packages)){
                                		foreach ($packages as $package) {
	                                	?>
	                                      <option value="<?=$package->ids?>" <?=(!empty($result) && $package->id == $result->package)?"selected":""?>><?=$package->name?></option>
	                                     <?php }}?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="expiration_date"><?=lang("expiration_date")?></label>
                                    <input type="text" class="form-control date" name="expiration_date" id="expiration_date" value="<?=!empty($result)?convert_date($result->expiration_date):""?>">
                                </div>
                             	<div class="form-group">
				                    <label for="pwd"> <?=lang('select_your_timezone')?>:</label>
				                    <select name="timezone" class="form-control <?=empty($result)?"auto-select-timezone":""?>">
				                        <?php if(!empty(tz_list())){
				                        $info_client = info_client_ip();
				                        foreach (tz_list() as $value) {
				                        ?>
				                        <option value="<?=$value['zone']?>" <?=(!empty($result) && $value['zone'] == $result->timezone)?"selected":""?> ><?=$value['time']?></option>
				                        <?php }}?>
				                    </select>
				                </div>
                            </div>
			  			</div>
			  		</div>
			  		<div class="card-footer">
	  					<a href="<?=cn($module)?>" class="btn btn-default"><?=lang('cancel')?></a>
	                    <button type="submit" class="btn btn-primary pull-right"><?=lang('update')?></button>
	                    <div class="clearfix"></div>
			  		</div>
			  	</div>
			</div>
		</div>
	</div>
	</form>
</div>