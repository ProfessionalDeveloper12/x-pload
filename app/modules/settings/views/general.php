<?php
$general_settings = block_general_settings();
?>
<div class="wrap-content container tab-list">
    <div class="lead"><?=lang('general_settings')?></div>
    <form action="<?=PATH?>settings/ajax_general_settings" method="POST" class="actionForm">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p0">
                        <ul class="nav nav-tabs">
                        	<?php $setting_lists = json_decode($general_settings->setting_lists);
                        	if(!empty($setting_lists)){
                        		foreach ($setting_lists as $key => $name) {
                        	?>
                            <li class="<?=$key==0?"active":""?>"><a data-toggle="tab" href="#<?=$name?>"><i class="fa fa-<?=$name?>"></i> <?=ucfirst($name)?></a></li>
                            <?php }}?>
                        </ul>
                    </div>
                    <div class="card-block p0">
                        <div class="tab-content p15">
                    		<?=$general_settings->data?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"> <?=lang('save_changes')?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
