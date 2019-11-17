<?php if(!empty($files)){
foreach ($files as $key => $row) {
?>
<div class="item" style="background-image: url(<?=BASE?>assets/img/default_image.png);" data-file="<?=get_link_file($row->file_name)?>" data-type="<?=$row->file_ext?>">
    <div class="pure-checkbox">
        <input type="checkbox" name="id[]" id="md_checkbox_<?=$row->ids?>" class="filled-in chk-col-red checkItem" value="<?=$row->ids?>">
        <label class="p0 m0" for="md_checkbox_<?=$row->ids?>">&nbsp;</label>
    </div>
    <?php if($row->file_ext == "mp4"){?>
        <div class="btn-play"><i class="fa fa-play" aria-hidden="true"></i></div>
        <video src="<?=get_link_file($row->file_name)?>" playsinline="" muted="" loop=""></video>
    <?php }else{?>
        <?php if(permission("image_editor") && get_option('designbold_app_id', '') != ""){?>
        <a href="javascript:void(0);" class="db-fancybox db-btn-designit" data-type="iframe" data-src="<?=cn("file_manager/designbold_editor/".$row->ids)?>" data-file="<?=get_link_file($row->file_name)?>"><?=lang("edit")?></a>
        <?php }?>
        <img class="lazy" src="<?=BASE?>assets/img/default_image.png" data-src="<?=get_link_file($row->file_name)?>">
    <?php }?>
    <img class="transparent" id="transparent" src="<?=BASE?>assets/img/transparent.png">
    <div class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
            <i class="ft-more-vertical"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
            <?php if($row->file_ext == "mp4"){?>
                <li><a href="<?=get_link_file($row->file_name)?>" data-type="ajax" data-src="<?=PATH."file_manager/view_video?video=".get_link_file($row->file_name)?>" data-fancybox=""><?=lang('view')?></a></li>
            <?php }else{?>
                <?php if(permission("image_editor")){?>
                <li><a href="javascript:void(0);" class="db-fancybox" data-type="iframe" data-src="<?=cn("file_manager/editor/".$row->ids)?>" data-file="<?=get_link_file($row->file_name)?>"><?=lang("edit")?></a></li>
                <?php }?>
                <li><a href="<?=get_link_file($row->file_name)?>" data-fancybox="group"><?=lang('view')?></a></li>
            <?php }?>
            <li><a href="<?=PATH?>file_manager/delete_file" class="deleteSingleFile" data-id="<?=$row->ids?>"><?=lang('delete')?></a></li>
        </ul>
    </div>
</div>
    
<?php }?>

    <?php if(count($files) + ($page - 1)*$limit  < $total_item){?>
    <div class="file-manager-load-more">
        <div class="clearfix"></div>
        <div class="btn btn-load file-manager-button-load-more" data-page="<?=$page?>"><?=lang('load_more')?></div>
    </div>
    <?php }else{?>
    <div class="clearfix"></div>
    <?php }?>

<?php }else{?>
    <?php if($page == 1){?>
    <div class="file-manager-empty">
        <?=lang('let_start_first_files')?>
    </div>
    <?php }else{?>
    <div class="clearfix"></div>
    <?php }?>
<?php }?>

<script type="text/javascript">
$(function(){
    $(".db-fancybox").fancybox({
        width: "100%",
        margin: [0, 0, 0, 0], // top, right, bottom, left
        iframe : {
            css : {
                width : '90%',
                height : '100%',
            }
        }
    });
});
</script>