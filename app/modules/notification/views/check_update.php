<?php
$new_updates = array();
foreach ($result as $row) {
	foreach ($purchases as $value) {
		$version_compare = version_compare($row->version, $value->version);
		if($version_compare > 0 && $value->pid == $row->pid) {
			$new_updates[] = "<strong>".$row->name." Version ".$row->version."</strong>";
		}
	}
}
?>

<?php if(!empty($new_updates)){?>
<div class="notification">
	<div class="notification-board" style="background: #ffe0e0;">
		<ul>
			<li class="danger"><i class="ft-alert-circle"></i> <?=sprintf(lang("Have a new update for %s"), implode(", ", $new_updates))?> <a href="<?=cn("module")?>" style="background: #ff5959; color: white; padding: 3px 13px; border-radius: 19px;"><?=lang("Update now")?></a></li>
		</ul>
	</div>
</div>
<?php }?>