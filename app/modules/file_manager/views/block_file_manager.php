<div class="image-manage" data-type="<?=(isset($type))?$type:"single"?>">
    <div class="image-manage-content">
        <div class="file-manager-list-images">
            <div class="add-image" <?=!empty($media)?"style='display:none'":""?>> <?=lang('add_image_or_video')?></div>

            <?php if(!empty($media)){
            foreach ($media as $image) {
            ?>
            <div class="item" style="<?=check_image($image)?"background-image: url('".$image."')":""?>">
                <?php if(!check_image($image)){?>
                <video src="<?=$image?>" playsinline="" muted="" loop=""></video>
                <?php }?>
                <input type="hidden" name="media[]" value="<?=$image?>">
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <?php }}?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="image-manage-footer">
        <a href="<?=PATH?>file_manager/popup_add_files" class="item btnOpenFileManager">
            <i class="fa fa-laptop" aria-hidden="true"></i> <?=lang('file_manager')?>
        </a>
        <a href="javascript:void(0);" class="item fileinput-button">
            <i class="fa fa-upload" aria-hidden="true"></i>
            <input id="fileupload" type="file" name="files[]">
        </a>
        <?php if(get_option('google_drive_api_key', '') != "" && get_option('google_drive_client_id', '') != "" && permission("google_drive")){?>
        <a href="javascript:void(0);" class="item" onclick="onApiLoad()">
            <i class="fa fa-google-drive" aria-hidden="true"></i>
        </a>
        <?php }?>
        <?php if(get_option('dropbox_api_key', '') != "" &&  permission("dropbox")){?>
        <a href="javascript:void(0);" class="item" id="chooser-image" data-multi-files="false" >
            <i class="fa fa-dropbox" aria-hidden="true"></i>
        </a>
        <?php }?>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div> 