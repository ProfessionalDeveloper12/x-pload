<?php 
$permission = array();

if(!empty($result)){
    $permission = (array)json_decode($result->permission);
}
$permission_list = permission_list();
?>

<div class="wrap-content container">
	<form action="<?=cn($module."/ajax_update")?>" data-redirect="<?=cn($module)?>" class="actionForm" method="POST">
	<input type="hidden" name="ids" value="<?=!empty($result)?$result->ids:""?>">

	<div class="row">
		<div class="col-md-12">
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
			  				<div class="col-md-6">
                                <?php if(!empty($result)){?>
                                    <?php if($result->type==2){?>
                                    <div class="form-group">
                                        <label for="name"><?=lang("name")?></label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?=!empty($result)?$result->name:""?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="description"> <?=lang('description')?></label>
                                        <input type="text" class="form-control" name="description" id="description" value="<?=!empty($result)?$result->description:""?>">
                                    </div>
                                    <?php }else{?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="trial_day">  <?=lang('trial_days')?></label>
                                                <input type="number" class="form-control" name="trial_day" id="trial_day" value="<?=!empty($result)?(int)$result->trial_day:"0"?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>

                                <?php }else{?>
                                <div class="form-group">
                                    <label for="name"><?=lang("name")?></label>
                                    <input type="text" class="form-control" name="name" id="name" value="<?=!empty($result)?$result->name:""?>">
                                </div>
                                <div class="form-group">
                                    <label for="description"><?=lang("description")?></label>
                                    <input type="text" class="form-control" name="description" id="description" value="<?=!empty($result)?$result->description:""?>">
                                </div>
                                <?php }?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_storage_size"><?=lang("max_storage_size")?></label>
                                            <input type="text" class="form-control" name="max_storage_size" id="max_storage_size" value="<?=(!empty($permission) && isset($permission['max_storage_size']))?(float)$permission['max_storage_size']:"0"?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_file_size"><?=lang("max_file_size")?></label>
                                            <input type="text" class="form-control" name="max_file_size" id="max_file_size" value="<?=(!empty($result) && isset($permission['max_file_size']))?(float)$permission['max_file_size']:"0"?>">
                                        </div>
                                    </div>
                                </div>

                                <?php if(empty($result) || $result->type==2 && get_payment()){?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price_monthly">  <?=lang('price_monthly')?></label>
                                            <input type="text" class="form-control" name="price_monthly" id="price_monthly" value="<?=!empty($result)?(float)$result->price_monthly:"0"?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price_annually">  <?=lang('price_annually')?></label>
                                            <input type="text" class="form-control" name="price_annually" id="price_annually" value="<?=!empty($result)?(float)$result->price_annually:"0"?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="number_accounts"><?=lang('sort')?></label>
                                    <input type="number" class="form-control" name="sort" id="sort" value="<?=!empty($result)?$result->sort:"0"?>">
                                </div>
                                <?php }?>
                                
                                <div class="form-group">
                                    <label for="number_accounts"> <?=lang('number_of_social_accounts_on_each_platform')?></label>
                                    <input type="number" class="form-control" name="number_accounts" id="number_accounts" value="<?=!empty($result)?$result->number_accounts:"0"?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort">  <?=lang('file_pickers')?></label><br/>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="checkbox" id="md_checkbox_google_drive" name="file_pickers[]" class="filled-in chk-col-red" value="google_drive" <?=in_array('google_drive',$permission)?"checked":""?>>
                                                <label class="p0 m0" for="md_checkbox_google_drive">&nbsp;</label>
                                                <span class="checkbox-text-right">  <?=lang('google_drive')?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="checkbox" id="md_checkbox_dropbox" name="file_pickers[]" class="filled-in chk-col-red" value="dropbox" <?=in_array('dropbox',$permission)?"checked":""?>>
                                                <label class="p0 m0" for="md_checkbox_dropbox">&nbsp;</label>
                                                <span class="checkbox-text-right">  <?=lang('dropbox')?></span>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="checkbox" id="md_checkbox_onedrive" name="file_pickers[]" class="filled-in chk-col-red" value="onedrive" <?=in_array('onedrive',$permission)?"checked":""?>>
                                                <label class="p0 m0" for="md_checkbox_onedrive">&nbsp;</label>
                                                <span class="checkbox-text-right">  <?=lang('onedrive')?></span>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sort"> <?=lang('file_type')?></label><br/>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="checkbox" id="md_checkbox_photo_type" name="file_types[]" class="filled-in chk-col-red" value="photo_type" <?=in_array('photo_type',$permission)?"checked":""?>>
                                                <label class="p0 m0" for="md_checkbox_photo_type">&nbsp;</label>
                                                <span class="checkbox-text-right">  <?=lang('photo')?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="checkbox" id="md_checkbox_video_type" name="file_types[]" class="filled-in chk-col-red" value="video_type" <?=in_array('video_type',$permission)?"checked":""?>>
                                                <label class="p0 m0" for="md_checkbox_video_type">&nbsp;</label>
                                                <span class="checkbox-text-right">  <?=lang('video')?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sort"> <?=lang('advance_option')?></label><br/>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="checkbox" id="md_checkbox_watermark" name="watermark" class="filled-in chk-col-red" value="watermark" <?=in_array('watermark',$permission)?"checked":""?>>
                                                <label class="p0 m0" for="md_checkbox_watermark">&nbsp;</label>
                                                <span class="checkbox-text-right">  <?=lang('watermark')?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="checkbox" id="md_checkbox_image_editor" name="image_editor" class="filled-in chk-col-red" value="image_editor" <?=in_array('image_editor',$permission)?"checked":""?>>
                                                <label class="p0 m0" for="md_checkbox_image_editor">&nbsp;</label>
                                                <span class="checkbox-text-right">  <?=lang('image_editor')?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
			  			</div>

                        <div class="row tab-list">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header p0">
                                            <ul class="nav nav-tabs">
                                                <?php
                                                if(!empty($permission_list)){
                                                    $count = 0;
                                                    foreach ($permission_list as $key => $row) {
                                                ?>
                                                <li class="<?=$count==0?"active":""?>"><a data-toggle="tab" href="#<?=$key?>"><i class="fa fa-<?=$key?>"></i> <?=str_replace("_", " ", ucfirst($key))?></a></li>
                                                <?php $count++; }}?>
                                            </ul>
                                        </div>
                                        <div class="card-block p0">
                                            <div class="tab-content p15">
                                                <?php
                                                if(!empty($permission_list)){
                                                    $count = 0;
                                                    foreach ($permission_list as $key => $permissions) {
                                                ?>
                                                <div id="<?=$key?>" class="row tab-pane fade in <?=$count==0?"active":""?>">
                                                    <div class="col-md-12">
                                                        <div class="pure-checkbox grey mr15 mb15 pb15">
                                                            <input type="checkbox" id="md_checkbox_<?=$key?>_enable" name="permission[]" class="filled-in chk-col-red" value="<?=$key?>_enable" <?=in_array($key.'_enable',$permission)?"checked":""?>>
                                                            <label class="p0 m0" for="md_checkbox_<?=$key?>_enable">&nbsp;</label>
                                                            <span class="checkbox-text-right"><?=lang('enable/disable')?></span>
                                                        </div>
                                                    </div>
                                                <?php
                                                    foreach ($permissions as $row) {
                                                ?>
                                                <div class="col-md-3">
                                                    <div class="pure-checkbox grey mr15 mb15">
                                                        <input type="checkbox" id="md_checkbox_<?=$row['link']?>" name="permission[]" class="filled-in chk-col-red" value="<?=$row['link']?>" <?=in_array($row['link'],$permission)?"checked":""?>>
                                                        <label class="p0 m0" for="md_checkbox_<?=$row['link']?>">&nbsp;</label>
                                                        <span class="checkbox-text-right"><?=lang(strtolower(str_replace(" ", "_", $row['name'])))?></span>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                </div>
                                                <?php $count++; }}?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
			  		</div>
			  		<div class="card-footer">
	  					<a href="<?=cn($module)?>" class="btn btn-default"><?=lang('cancel')?></a>
                        <button type="submit" class="btn btn-primary pull-right"><?=lang('update')?></button>
                        <?php if(!empty($result)){?>
	                    <a href="<?=cn($module."/ajax_update")?>" class="btn btn-default pull-right mr15 actionMultiItem" data-params="subscribers=1" > <?=lang('save_and_update_subscribers')?></a>
                        <?php }?>
	                    <div class="clearfix"></div>
			  		</div>
			  	</div>
			</div>
		</div>
	</div>
	</form>
</div>