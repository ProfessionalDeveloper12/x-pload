<?php
$module_name = "language";
?>

<div class="wrap-content <?=$module_name?>-app row app-mod">
    <ul class="am-mobile-menu">
        <li><a href="javascript:void(0);" class="active" data-am-open="account"><?=lang("Language")?></a></li>
        <li><a href="javascript:void(0);" data-am-open="content"><?=lang("Content")?></a></li>
    </ul>
    <div class="clearfix"></div>

    <div class="am-sidebar active">
        <?php if(!empty($language_category)){?>
        <div class="box-search">
            <div class="input-group">
              <input type="text" class="form-control am-search" placeholder="<?=lang("search")?>" aria-describedby="basic-addon2">
              <span class="input-group-addon" id="basic-addon2"><i class="ft-search"></i></span>
            </div>
        </div>
        <ul class="box-list am-scroll">
            <?php 
                foreach ($language_category as $key => $row) {
            ?>
            <li class="item item-3 <?=segment(3)==$row->code?"active":""?>">
                <a href="<?=cn("language/index/".$row->code)?>" data-content="box-ajax-language" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("language/index/".$row->code)?>'); openContent();">
                    <div class="box-img">
                        <div class="icon-social" style="font-size: 20px; width: 40px; background: #fff; height: 40px; color: #fff; text-align: center; line-height: 41px; border: 1px solid #cccccc; border-radius: 6px;">
                            <i class="<?=$row->icon?>"></i>
                        </div>
                        <div class="checked"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="pure-checkbox grey mr15">
                        <input type="radio" name="account[]" class="filled-in chk-col-red" value="<?=$row->name?>" <?=segment(3)==$row->code?"checked":""?>>
                        <label class="p0 m0" for="md_checkbox_<?=$row->name?>">&nbsp;</label>
                    </div>
                    <div class="box-info">
                        <div class="title"><?=ucfirst(lang(strtolower($row->name)))?></div>
                        <div class="desc"><?=lang("Language")?> </div>
                    </div>
                </a> 
                <div class="option">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="ft-more-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?=cn("language/export/".$row->code)?>"><?=lang("Export")?></a></li>
                            <li><a href="<?=cn("language/ajax_delete_item")?>" data-id="<?=$row->ids?>" class="actionItem" data-redirect="<?=cn("language")?>"><?=lang("delete")?></a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <?php }?>
        </ul>
        <?php }else{?>

        <div class="empty">
            <a href="<?=cn("language/add")?>" class="btn btn-primary"><?=lang("Add language")?></a>
        </div>

        <?php }?>
    </div>
    <div class="am-wrapper">

        <div class="am-content col-md-12 am-scroll p0">
            <div class="head-title">
                <div class="name">
                    <i class="fa fa-language" aria-hidden="true"></i> <?=lang("Language")?></div>
                <div class="btn-group pull-right" role="group">
                    <a href="<?=cn("language/add")?>" class="btn btn-default">
                        <i class="ft-plus"></i> <span> <?=lang("add_new")?></span>
                    </a>
                    <div class="btn btn-default fileinput-button">
                        <i class="ft-share"></i> <span> <?=lang("Import")?></span>
                        <input id="import_language" type="file" name="files[]" multiple="">
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="box-ajax-language">
                <?=$view?>
            </div>
        </div>
       
    </div>

</div>

<script type="text/javascript">
    function openContent(){
        if($(window).width() <= 768){
            $(".am-mobile-menu li a[data-am-open='content']").click();
        }
    }

    $(function(){
        $(document).on("change", ".language-app table .lang-item", function(){
            var _code = $("#code").val();
            var _key = $(this).attr("name");
            var _value = $(this).val();
            var _data     = $.param({token:token, code: _code, key: _key, value: _value});

            $.post(PATH+"language/update_language_item", _data, function(_resut){
                Main.notify(_resut.message, _resut.status);
            },'json');
        });
        
        var url = PATH + "language/ajax_import";
        $("#import_language").fileupload({
            url: url,
            dataType: 'json',
            formData: { token: token },
            done: function (e, data) {
                if(data.result.status == "success"){
                    Main.notify(data.result.message, data.result.status);
                    setTimeout("location.reload(true);", 3000);
                }else{
                    FileManager.hide_overplay();
                    Main.notify(data.result.message, data.result.status);
                }
            },
            progressall: function (e, data) {
                Main.overplay();
            }
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

</script>

<style type="text/css">
.am-content .head-title .name{
    display: inline-block;
}

.am-content .head-title .btn-group{
    margin-top: 14px;
}

.am-content .head-title {
    padding: 10px;
    position: fixed;
    width: calc(100% - 370px);
    background: #fff;
    margin-bottom: 0;
    padding: 0 15px;
    height: 65px;
    line-height: 64px;
    border-bottom: 1px solid #f5f5f5;
    background: #fff;
    z-index: 10;
}

.lead{
    font-size: 20px;
    font-weight: 500;
    color: #424242;
    margin-top: 30px;
}

@media (max-width: 768px){
    .am-mobile-menu li{
        width: 50%;
    }

    .am-content .head-title{
        width: 100%;
    }
}
</style>