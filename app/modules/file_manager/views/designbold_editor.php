<?php if(get_option('designbold_app_id', '') != ""){?>
<script type="text/javascript">var BASE = "<?=BASE?>"; var token = '<?=$this->security->get_csrf_hash()?>';</script>
<script type="text/javascript" src="<?=BASE."assets/plugins/jquery/jquery.min.js"?>"></script>
<div class="db-btn-design-me" data-db-image="<?=get_link_file($image->file_name)?>"></div>
<script>
    window.DBSDK_Cfg = {
        export_mode: ['publish'],
        export_callback: function (resultUrl, documentId ,options) {
            $.ajax({
                type: 'POST',
                url: '<?=cn("file_manager/save_image")?>',
                data: {
                    token: token,
                    image: resultUrl 
                }
            }).done(function(_result) {
                parent.reload();
            });
        }
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://sdk.designbold.com/button.js#app_id=<?=get_option('designbold_app_id', '')?>";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'db-js-sdk'));

    $(document).on("click", ".db-close-lightbox", function(){
        setTimeout(function(){
            parent.jQuery.fancybox.getInstance().close();
        }, 3000);
    });
    setTimeout(function(){
        $(".db-btn-designit")[0].click();
    }, 2000);
</script>

<style type="text/css">
    .db-btn-designit{
        display: none;
    }

    .db-overlay{
        background: transparent!important;
    }
</style>
<?php }?>