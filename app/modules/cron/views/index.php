<div class="wrap-content container">
  <div class="lead alert alert-warning" style="font-size: 16px;">
    <?=lang('cronjob_desc')?>: 
  </div>
<?php 
$cron_list = load_cron();
if(!empty($cron_list)){
foreach ($cron_list as $key => $cron) {
	$cron = (object)$cron;
?>
	<div class="card">
  		<div class="card-header">
  			<div class="card-title">
                <?=$key+1?>. <?=$cron->name?>: <?=lang($cron->time)?></div>
            <div class="clearfix"></div>
  		</div>
  		<div class="card-body pb15  pr15 pl15">
<pre class="bg-black text-white" style="color: #fff;">
<?=$cron->link?>
</pre> 
  		</div>
  </div>
<?php }}?>
  <div class="lead" style="font-size: 14px;">
    <strong><span class="text-danger "><?=lang('note')?>:</span> </strong><?=lang('cronjob_note')?> 
  </div>
</div>
