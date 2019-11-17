<?php
$general_settings = block_general_settings();
?>
<h3 class="head-title"><i class="fa fa-user-circle-o"></i> <?=lang('social_settings')?></h3>

<div class="tab-list">
    <div class="card">
        <div class="card-header p0">
            <ul class="nav nav-tabs">
            	<?php $setting_lists = json_decode($general_settings->setting_lists);
            	if(!empty($setting_lists)){
            		foreach ($setting_lists as $key => $name) {
            	?>
                <li class="<?=$key==0?"active":""?>"><a data-toggle="tab" href="#<?=$name?>"><i class="fa fa-<?=$name?>"></i> <?=str_replace("_", " ", ucfirst($name))?></a></li>
                <?php }}?>
            </ul>
        </div>
        <div class="card-block p0">
            <div class="tab-content pt15">
        		<?=$general_settings->data?>
            </div>
        </div>
    </div>
</div>
