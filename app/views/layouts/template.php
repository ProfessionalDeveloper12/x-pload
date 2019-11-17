<!DOCTYPE html>
<html>
<head>
    <title><?=get_option("website_title", "X-Pload - Social Marketing Tool")?></title>
    <meta name="description" content="<?=get_option("website_description", "save time, do more, manage multiple social networks at one place")?>" />
    <meta name="keywords" content="<?=get_option("website_keyword", 'social marketing tool, social planner, automation, social schedule')?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?=get_option("website_favicon", BASE.'assets/img/favicon.png')?>" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
<?php 
    $version = "?v5.5";
    $css_files = array(
        "assets/plugins/bootstrap/css/bootstrap.min.css",
        "assets/plugins/bootstrap/css/bootstrap-extended.min.css",
        "assets/plugins/font-awesome/css/font-awesome.min.css",
        "assets/plugins/font-feather/feather.min.css",
        "assets/plugins/simple-line-icons/css/simple-line-icons.css",
        "assets/plugins/font-ps/css/pe-icon-7-stroke.css",
        "assets/plugins/webui-popover/css/jquery.webui-popover.css",
        "assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css",
        "assets/plugins/jquery-scrollbar/css/jquery-scrollbar.css",
        "assets/plugins/emojionearea/emojionearea.min.css",
        
        "assets/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css",
        "assets/plugins/datetimepicker/jquery-ui.css",
        "assets/plugins/datetimepicker/jquery-ui-timepicker-addon.css",


        "assets/plugins/file-upload/css/jquery.fileupload.css",
        "assets/plugins/fancybox/dist/jquery.fancybox.css",
        "assets/plugins/owlcarousel/css/owl.carousel.min.css",
        "assets/plugins/izitoast/css/iziToast.min.css",
        "assets/plugins/izimodal/css/iziModal.css",
        "assets/plugins/bootstrap-select/css/bootstrap-select.min.css",
        "assets/plugins/datatable/extensions/responsive/css/dataTables.responsive.css",
        "assets/plugins/monthly/css/monthly.css",
        "assets/plugins/flags/css/flag-icon.min.css",
        "assets/plugins/trumbowyg/dist/ui/trumbowyg.min.css",
        "assets/plugins/rangeslider/css/ion.rangeSlider.css",
        "assets/plugins/rangeslider/css/ion.rangeSlider.skinFlat.css",
        "assets/plugins/vtdropdown/css/vtdropdown.css"
    );
?>

<?php if(ENVIRONMENT == "p"){?>
    <?php get_css($css_files)?>
    
<?php }else{?>
    
    <?php foreach($css_files as $css){?>
        <link rel="stylesheet" type="text/css" href="<?=BASE.$css.$version?>">
    <?php }?>
<?php }?>


    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/colors.min.css<?=$version?>">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/layout.css<?=$version?>">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/style.css<?=$version?>">
    <?php load_css();?>
    <script type="text/javascript" src="<?=BASE?>assets/plugins/jquery/jquery.min.js<?=$version?>"></script>
    <script type="text/javascript">
        var token = '<?=$this->security->get_csrf_hash()?>',
            PATH  = '<?=PATH?>',
            BASE  = '<?=BASE?>',
            AVIARY_API_KEY  = '<?=get_option('aviary_api_key', '')?>';

        var lang  = { 
                complete: "<?=lang("published")?>"
            };
        var GOOGLE_API_KEY   = '<?=get_option('google_drive_api_key', '')?>';
        var GOOGLE_CLIENT_ID = '<?=get_option('google_drive_client_id', '')?>';
        var enter_keyword_to_search = '<?=lang('enter_keyword_to_search')?>';

        document.onreadystatechange = function () {
            var state = document.readyState
            if (state == 'complete') {
                setTimeout(function(){
                    document.getElementById('interactive');
                    document.getElementById('loading-overplay').style.opacity ="0";
                },500);

                setTimeout(function(){
                    document.getElementById('loading-overplay').style.display ="none";
                    document.getElementById('loading-overplay').style.opacity ="1";
                },1000);
            }
        }
    </script>
    <?php if(get_option('enable_headwayapp', 0) == 1 && get_option('headwayapp_account_id', '') != ""){?>
    <script>
        let HW_config = {
            selector: ".badgeCont",
            trigger:  ".toggleWidget",
            account: "<?=get_option('headwayapp_account_id', '')?>",
            callbacks: {},
            // debug: true
        };
    </script>
    <script async src="https://cdn.headwayapp.co/widget.js"></script>
    <?php }?>
</head>
<body class="<?=get_option('full_menu', 0)==1?"menu-full":""?> <?=get_option('dark_menu', 0)==1?"dark-menu":""?>" id="body-main">
<div class="loading-overplay" id="loading-overplay"><div class='loader loader1'><div><div><div><div><div><div></div></div></div></div></div></div></div></div>

<div class="wrap-main">
    <?=Modules::run("blocks/header");?>
    <div class="fix-sidebar"></div>
    <?=Modules::run("blocks/sidebar");?>

    <div class="app-content open container-fluid">
        <?=Modules::run("notification/get")?>
        <?=$template['body']?>
    </div>
</div>

<div class="box-right"></div>

<div id="mainModal" class="modal fade"></div>
<div id="menucontentwebuiPopover">
    
</div>
<?php 
    $js_files = array(
        "assets/js/moment.js",
        "assets/js/tether.min.js",
        "assets/plugins/bootstrap/js/bootstrap.min.js",
        "assets/plugins/bootstrap-notify/bootstrap-notify.min.js",
        "assets/plugins/classie/classie.js",
        "assets/plugins/webui-popover/js/jquery.webui-popover.min.js",
        "assets/plugins/perfect-scrollbar/js/perfect-scrollbar.min.js",
        "assets/plugins/jquery-scrollbar/js/jquery-scrollbar.min.js",
        "assets/plugins/nicescroll/jquery.nicescroll.min.js",
        "assets/plugins/emojionearea/emojionearea.min.js",
        

        "assets/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.min.js",
        "assets/plugins/datetimepicker/jquery-ui.js",
        "assets/plugins/datetimepicker/jquery-ui-sliderAccess.js",
        "assets/plugins/datetimepicker/jquery-ui-timepicker-addon.js",


        "assets/plugins/jquery-lazy/jquery.lazy.min.js",
        "assets/plugins/izitoast/js/iziToast.min.js",
        "assets/plugins/izimodal/js/iziModal.js",
        "assets/plugins/monthly/js/monthly.js",
        "assets/plugins/bootstrap-select/js/bootstrap-select.min.js",
        "assets/plugins/owlcarousel/owl.carousel.min.js",
        "assets/plugins/mask/jquery.mask.js",
        "assets/plugins/vtdropdown/js/vtdropdown.js",

        //Chart
        "assets/plugins/chartjs/chart.bundle.min.js",
        "assets/plugins/echarts/echarts.min.js",

        //Datatable
        "assets/plugins/datatable/jquery.dataTables.js",
        "assets/plugins/datatable/extensions/responsive/js/dataTables.responsive.min.js",
        "assets/plugins/datatable/extensions/export/buttons.html5.min.js",
        "assets/plugins/datatable/extensions/export/buttons.print.min.js",
        "assets/plugins/datatable/extensions/export/dataTables.buttons.min.js",
        "assets/plugins/datatable/extensions/export/jszip.min.js",
        "assets/plugins/datatable/extensions/export/pdfmake.min.js",
        "assets/plugins/datatable/extensions/export/vfs_fonts.js",
        "assets/plugins/rangeslider/js/ion.rangeSlider.min.js",


        //Plugins File Manager
        "assets/plugins/file-upload/js/vendor/jquery.ui.widget.js",
        "assets/plugins/file-upload/js/jquery.iframe-transport.js",
        "assets/plugins/file-upload/js/jquery.fileupload.js",
        "assets/plugins/fancybox/dist/jquery.fancybox.min.js",
        
        //Editor
        "assets/plugins/trumbowyg/dist/trumbowyg.min.js"
    );
?>

<?php if(ENVIRONMENT == "p"){?>
    <script type="text/javascript" src="<?php get_js($js_files)?>"></script>
<?php }else{?>
    
    <?php foreach($js_files as $js){?>
        <script type="text/javascript" src="<?=BASE.$js.$version?>"></script>
    <?php }?>

<?php }?>

<script type="text/javascript" src="https://apis.google.com/js/api.js"></script>
<script type="text/javascript" src="<?=BASE?>assets/js/file_manager.js<?=$version?>"></script>
<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="<?=get_option('dropbox_api_key', '')?>"></script>
<script type="text/javascript" src="<?=BASE?>assets/js/layout.js<?=$version?>"></script>
<script type="text/javascript" src="<?=BASE?>assets/js/main.js<?=$version?>"></script>
<?php load_js();?>
<?=htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES)?>
</body>
</html>