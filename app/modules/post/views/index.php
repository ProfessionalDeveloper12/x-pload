<form action="<?=PATH?>post/ajax_post" data-type="html" method="POST" class="actionPostAllForm">
<div class="row all-post">
    <ul class="ap-mobile-menu">
        <li><a href="javascript:void(0);" class="active" data-ap-open="account"><?=lang("Accounts")?></a></li>
        <li><a href="javascript:void(0);" data-ap-open="content"><?=lang("Content")?></a></li>
        <li><a href="javascript:void(0);" data-ap-open="preview"><?=lang("Preview")?></a></li>
    </ul>
    <div class="clearfix"></div>

    <div class="ap-left active">
        <?php if(!empty($accounts)){?>
        <div class="box-search">
            <div class="input-group">
                <input type="text" class="form-control ap-search" placeholder="<?=lang("search")?>" aria-describedby="basic-addon2">
                <span class="input-group-addon" id="basic-addon2"><i class="ft-search"></i></span>

                <div class="input-group-btn">
                    <button type="button" class="btn btn-default ap-select-all" title="<?=lang("select_all")?>"><i class="ft-check"></i></button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?=lang("Groups")?>"><i class="ft-target"></i></button>
                    <?php if(!empty( get_groups() )){?>
                    <ul class="dropdown-menu dropdown-menu-right ap-scroll">
                        <?php 
                        foreach (get_groups() as $group) {
                        ?>
                        <li><a href="javascript:void(0);" class="actionGroups" data-item='<?=$group->data?>'><?=$group->name?></a></li>
                        <?php }?>
                    </ul>
                    <?php }?>
                </div>
            </div>
        </div> 
        <ul class="box-list ap-scroll">
            <?php
            foreach ($accounts as $key => $row) {
            ?>
            <li class="item">
                <a href="javascript:void(0);">
                    <div class="box-img">
                        <img src="<?=$row->avatar?>">
                        <div class="checked"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="pure-checkbox grey mr15">
                        <input type="checkbox" name="accounts[]" class="filled-in chk-col-red" value="<?=$row->category."-".$row->pid?>">
                        <label class="p0 m0" for="md_checkbox_<?=$row->pid?>">&nbsp;</label>
                    </div>
                    <div class="box-info">
                        <div class="title"><?=$row->username?></div>
                        <div class="desc"><?=sprintf(lang("%s ".$row->type) , str_replace("_", " ", ucfirst($row->category)) )?> </div>
                    </div>
                </a>
            </li>
            <?php }?>
        </ul>

        <?php }else{?>
        <div class="empty">
            <span><?=lang("add_an_account_to_begin")?></span>
            <a href="<?=PATH?>account_manager" class="btn btn-primary"><?=lang("add_account")?></a>
        </div>
        <?php }?>
    </div>

    <div class="ap-center ap-schedule">

        <div class="col-md-6 ap-box-content ap-scroll">
            <div class="card">
                <?=modules::run("caption/popup")?>

                <div class="card-overplay"><i class="pe-7s-config pe-spin"></i></div>
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa ft-edit" aria-hidden="true"></i> <?=lang('new_post')?>
                    </div>
                </div>
                <div class="card-block pt0">

                    <div class="form-group form-caption vk-text">
                        <div class="list-icon">
                            <a href="javascript:void(0);" class="getCaption" data-toggle="tooltip" data-placement="left" title="<?=lang("get_caption")?>"><i class="ft-command"></i></a>
                            <a href="javascript:void(0);" data-toggle="tooltip" class="saveCaption" data-placement="left" title="<?=lang("save_caption")?>"><i class="ft-save"></i></a>
                        </div>
                        <textarea class="form-control post-message" name="caption" rows="3" placeholder="<?=lang('add_a_caption')?>" style="height: 114px;"></textarea>
                        <div class="list-action">
                            <ul class="action-type">
                                <li data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Text" class="active">
                                    <a href="#text" class="action-select" data-toggle="tab" data-type="text"><i class="ft-file-text"></i></a>
                                    <input type="radio" class="hide" name="type" value="text" checked="true">
                                </li>
                                <li data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Link">
                                    <a href="#link" class="action-select" data-toggle="tab" data-type="link"><i class="ft-link"></i></a>
                                    <input type="radio" class="hide" name="type" value="link">
                                </li>
                                <li data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Photos">
                                    <a href="#photo" class="action-select" data-toggle="tab" data-type="photo"><i class="ft-image"></i></a>
                                    <input type="radio" class="hide" name="type" value="photo">
                                </li>
                                <li data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Video">
                                    <a href="#video" class="action-select" data-toggle="tab" data-type="video"><i class="ft-video"></i></a>
                                    <input type="radio" class="hide" name="type" value="video">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <ul class="ap-action-option tab-content">
                        <li class="item-option-action tab-pane fade" id="text"></li>
                        <li class="item-option-action tab-pane fade" id="link">
                            <div class="ap-box-url">
                                <div class="form-group">
                                    <label for="add_link"><?=lang("LINK URL")?></label>
                                    <div class="box-bar">
                                        <div class="bar"></div>
                                        <input type="text" class="form-control add_link" id="add_link" name="link" placeholder="<?=lang("Insert the link url")?>">
                                    </div>

                                    <div class="box-img-url mt15">
                                        <label for="add_link"><?=lang("SELECT A THUMBNAIL")?></label>
                                        <div class="image-manage" data-type="single">
                                            <div class="image-manage-content">
                                                <div class="file-manager-list-images">
                                                    <div class="add-image"> <?=lang('add_images')?></div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="image-manage-footer">
                                                <a href="<?=PATH?>file_manager/popup_add_files/photo" class="item btnOpenFileManager">
                                                    <i class="fa fa-laptop" aria-hidden="true"></i> <?=lang('file_manager')?>
                                                </a>
                                                <a href="javascript:void(0);" class="item fileinput-button">
                                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                                    <input onclick="FileManager.uploadFile('#fileupload1');" id="fileupload1" type="file" name="files[]">
                                                </a>
                                                <?php if(get_option('google_drive_api_key', '') != "" && get_option('google_drive_client_id', '') != ""){?>
                                                <a href="javascript:void(0);" class="item" onclick="onApiLoad()">
                                                    <i class="fa fa-google-drive" aria-hidden="true"></i>
                                                </a>
                                                <?php }?>
                                                <?php if(get_option('dropbox_api_key', '') != ""){?>
                                                <a href="javascript:void(0);" class="item" id="chooser-image" data-multi-files="false" >
                                                    <i class="fa fa-dropbox" aria-hidden="true"></i>
                                                </a>
                                                <?php }?>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div> 
                                    </div>  
                                </div>
                            </div>
                        </li>
                        <li class="item-option-action tab-pane fade" id="photo">
                            <div class="image-manage" data-type="multi">
                                <div class="image-manage-content">
                                    <div class="file-manager-list-images">
                                        <div class="add-image"> <?=lang('add_images')?></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="image-manage-footer">
                                    <a href="<?=PATH?>file_manager/popup_add_files/photo" class="item btnOpenFileManager">
                                        <i class="fa fa-laptop" aria-hidden="true"></i> <?=lang('file_manager')?>
                                    </a>
                                    <a href="javascript:void(0);" class="item fileinput-button">
                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                        <input onclick="FileManager.uploadFile('#fileupload2');" id="fileupload2" type="file" name="files[]"> 
                                    </a>
                                    <?php if(get_option('google_drive_api_key', '') != "" && get_option('google_drive_client_id', '') != ""){?>
                                    <a href="javascript:void(0);" class="item" onclick="onApiLoad()">
                                        <i class="fa fa-google-drive" aria-hidden="true"></i>
                                    </a>
                                    <?php }?>
                                    <?php if(get_option('dropbox_api_key', '') != ""){?>
                                    <a href="javascript:void(0);" class="item" id="chooser-image" data-multi-files="false" >
                                        <i class="fa fa-dropbox" aria-hidden="true"></i>
                                    </a>
                                    <?php }?>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div> 
                        </li>
                        <li class="item-option-action tab-pane fade" id="video">
                            <div class="image-manage" data-type="single">
                                <div class="image-manage-content">
                                    <div class="file-manager-list-images">
                                        <div class="add-image"> <?=lang('add_video')?></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="image-manage-footer">
                                    <a href="<?=PATH?>file_manager/popup_add_files/video" class="item btnOpenFileManager">
                                        <i class="fa fa-laptop" aria-hidden="true"></i> <?=lang('file_manager')?>
                                    </a>
                                    <a href="javascript:void(0);" class="item fileinput-button">
                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                        <input onclick="FileManager.uploadFile('#fileupload3');" id="fileupload3" type="file" name="files[]">
                                    </a>
                                    <?php if(get_option('google_drive_api_key', '') != "" && get_option('google_drive_client_id', '') != ""){?>
                                    <a href="javascript:void(0);" class="item" onclick="onApiLoad()">
                                        <i class="fa fa-google-drive" aria-hidden="true"></i>
                                    </a>
                                    <?php }?>
                                    <?php if(get_option('dropbox_api_key', '') != ""){?>
                                    <a href="javascript:void(0);" class="item" id="chooser-image" data-multi-files="false" >
                                        <i class="fa fa-dropbox" aria-hidden="true"></i>
                                    </a>
                                    <?php }?>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div> 
                        </li>
                    </ul>

                    <div class="form-group">
                            <div class="pure-checkbox grey mr15">
                                <input type="checkbox" id="md_checkbox_schedule" name="is_schedule" class="filled-in chk-col-red enable_post_all_schedule" value="on">
                                <label class="p0 m0" for="md_checkbox_schedule">&nbsp;</label>
                                <span class="checkbox-text-right"> <?=lang('schedule')?></span>
                            </div>
                        </div>
                        
                        <div class="schedule-option collapse in" id="schedule-option">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="time_post"> <?=lang('time_post')?></label>
                                        <input type="text" name="time_post" class="form-control datetime time_post" id="time_post" disabled="true">
                                    </div>
                                </div>
                            </div>
                        </div>  
                    
                    <!-- <button type="button" class="btn btn-default pull-right btnPostNow"> Customize for each network</button> -->
                    <button type="submit" class="btn btn-primary pull-right border-circle btnPostNow"> <?=lang('post_now')?></button>
                    <button type="submit" class="btn btn-primary pull-right border-circle btnSchedulePost hide"> <?=lang('schedule_post')?></button>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ap-box-preview ap-scroll box-load-previewer">
            <div class="loading-box" id="loading-box"><div class='loader loader1'><div><div><div><div><div><div></div></div></div></div></div></div></div></div>
            <?=Modules::run("post/previewer");?>
        </div>
        
    </div>

</div>

<div id="modal-custom" class="ap-modal-confirm">
    <button data-iziModal-close class="icon-close"></button>
    <div class="card mb0">
        <div class="card-header">
            <div class="card-title">
                <i class="ft-alert-circle text-warning" aria-hidden="true"></i> <?=lang("Confirm")?>
            </div>
        </div>
        <div class="card-block pt15 ap-data-errors">
            
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-default" data-izimodal-close="" data-izimodal-transitionout="bounceOutDown"><?=lang("No, Cancel")?></button>
            <a class="btn btn-primary btnPostTry" href="<?=cn("post/ajax_post/true")?>"><?=lang("Yes, I am sure")?></a>
        </div>
    </div>
</div>
</form>