
<div class="lead"> <?=lang('post')?></div>
<div class="row">
	<div class="col-md-3">
        <div class="form-group">
            <span class="text"> <?=lang('enable_advance_option')?></span> <br/>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_enable_advance_option" name="enable_advance_option" class="filled-in chk-col-red" <?=get_option('enable_advance_option', 1)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_enable_advance_option">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('enable')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_enable_advance_option_disable" name="enable_advance_option" class="filled-in chk-col-red" <?=get_option('enable_advance_option', 1)==0?"checked":""?> value="0">
                <label class="p0 m0" for="md_checkbox_enable_advance_option_disable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('disable')?></span>
            </div>
        </div>
	</div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <span class="text"> <?=lang('Optimize image before post')?></span> <br/>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_enable_ig_optimize_option" name="enable_ig_optimize_option" class="filled-in chk-col-red" <?=get_option('enable_ig_optimize_option', 0)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_enable_ig_optimize_option">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('enable')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_enable_ig_optimize_option_disable" name="enable_ig_optimize_option" class="filled-in chk-col-red" <?=get_option('enable_ig_optimize_option', 0)==0?"checked":""?> value="0">
                <label class="p0 m0" for="md_checkbox_enable_ig_optimize_option_disable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('disable')?></span>
            </div>
        </div>
    </div>
</div>