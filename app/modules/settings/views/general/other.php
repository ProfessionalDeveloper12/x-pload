<div class="row">
    <div class="col-md-12">
        <h3 class="head-title"><i class="ft-sliders"></i> <?=lang('other')?></h3>

        <span class="text"> <?=lang('enable_https')?></span><br/><span class="danger small"><?=lang("please_make_sure_your_hosting_supported_ssl_before_turn_on_it")?></span><br/>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_enable_https_enable" name="enable_https" class="filled-in chk-col-red" <?=get_option('enable_https', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_enable_https_enable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('on')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_enable_https_disable" name="enable_https" class="filled-in chk-col-red" <?=get_option('enable_https', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_enable_https_disable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('off')?></span>
        </div>
        <br/>
        <span class="text"> <?=lang('Enable Headwayapp Notification')?></span><br/>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_enable_headwayapp_enable" name="enable_headwayapp" class="filled-in chk-col-red" <?=get_option('enable_headwayapp', 0)==1?"checked":""?> value="1">
            <label class="p0 m0" for="md_checkbox_enable_headwayapp_enable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('enable')?></span>
        </div>
        <div class="pure-checkbox grey mr15 mb15">
            <input type="radio" id="md_checkbox_enable_headwayapp_disable" name="enable_headwayapp" class="filled-in chk-col-red" <?=get_option('enable_headwayapp', 0)==0?"checked":""?> value="0">
            <label class="p0 m0" for="md_checkbox_enable_headwayapp_disable">&nbsp;</label>
            <span class="checkbox-text-right"> <?=lang('disable')?></span>
        </div>

        <div class="form-group">
            <span class="text"><?=lang('Headwayapp Account ID')?></span>
            <input type="text" class="form-control" name="headwayapp_account_id" value="<?=get_option('headwayapp_account_id', '')?>">
        </div>

        <div class="form-group">
            <span class="text"><?=lang('embed_code')?></span>
            <textarea class="form-control" name="embed_javascript" id="embed_javascript"><?=get_option('embed_javascript', '')?></textarea> 
        </div>

    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?=BASE."assets/plugins/codemirror/lib/"?>codemirror.css">
<link rel="stylesheet" type="text/css" href="<?=BASE."assets/plugins/codemirror/theme/"?>lucario.css">
<script src="<?=BASE."assets/plugins/codemirror/lib/"?>codemirror.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=BASE."assets/plugins/codemirror/mode/"?>css/css.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=BASE."assets/plugins/codemirror/mode/"?>javascript/javascript.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=BASE."assets/plugins/codemirror/mode/"?>htmlmixed/htmlmixed.js" type="text/javascript" charset="utf-8"></script>
<script>
    setTimeout(function(){
        var editor = CodeMirror.fromTextArea(document.getElementById("embed_javascript"), {
          lineNumbers: true,
          theme: "lucario"
        });
    }, 200);
</script>