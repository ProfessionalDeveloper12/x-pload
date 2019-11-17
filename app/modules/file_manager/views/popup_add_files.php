<div id="load_popup_modal_contant" class="" role="dialog">
    <div class="modal-dialog modal-md">
        <form action="javascript:void(0)" data-type-message="text" role="form" class="form-horizontal actionForm" role="form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title"><i class="fa fa-laptop" aria-hidden="true"></i> <?=lang("file_manager")?></div>
            </div>
            <div class="modal-body file-manager-content file-manager-content-popup file-manager-loader file-manager-scrollbar" data-type="<?=$type?>">
                <!--Ajax Load Files-->
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <div class="btn-group">
                        <div class="btn btn-default fileinput-button" >
                            <i class="ft-upload"></i> <span> <?=lang('upload')?></span>
                            <input id="fileuploadpopup" type="file" name="files[]" multiple>
                        </div>
                        <?php if(get_option('dropbox_api_key', '') != "" &&  permission("dropbox")){?>
                        <button type="button" class="btn btn-default" id="chooser-image">
                            <i class="fa fa-dropbox"></i>
                        </button>
                        <?php }?>
                        <?php if(get_option('google_drive_api_key', '') != "" && get_option('google_drive_client_id', '') != "" && permission("google_drive")){?>
                        <button type="button" class="btn btn-default" id="show-docs-picker" onclick="onApiLoad()">
                            <i class="fa fa-google-drive"></i>
                        </button>
                        <?php }?>
                    </div>
                </div>
                <input name="submit_popup" id="submit_popup" type="submit" value="<?=lang('add')?>" data-transfer="<?=$id?>" class="btn btn-primary file-manager-btn-add-images" data-dismiss="modal"/>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang("close")?></button>
            </div>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        FileManager.uploadFile("#fileuploadpopup");
    });

    function reload(){
        FileManager.loadFile(0);
        $.fancybox.close();
    }

    function overplay(){
        Main.overplay();
    }

    function hide_overplay(){
        FileManager.hide_overplay();
    }
</script>

<style type="text/css">
    .db-btn-designit{
        position: absolute;
        content: '';
        max-width: 24px;
        height: 24px;
        overflow: hidden;
        bottom: 9px;
        right: 10px;
        padding: 0;
        border-radius: 6px;
        text-align: center;
        line-height: 22px;
        border: 1px solid #fff;
        background: #000;
        z-index: 0;
    }

    .item:hover .db-btn-designit,
    .item:focus .db-btn-designit{
        display: block;
    }

    .db-btn-designit:before{
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        content: "\f040";
        color: #fff;
    }

    .fancybox-slide--iframe .fancybox-content{
        background: transparent!important;
        max-width: calc(100%);
        max-height: calc(100%);
    }

    .fancybox-iframe{
        background: transparent!important;
    }

    body .fancybox-container {
        z-index: 2000!important;
    }

    .fancybox-slide--iframe .fancybox-content {
        width: 100%!important;
        height: 100%!important;
        max-width  : 100%;
        max-height : 100%;
        margin: 0;
    }
</style>