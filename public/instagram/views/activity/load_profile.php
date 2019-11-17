<?php if(isset($feed->items) && !empty($feed->items)){
$maxId = "";
if(isset($feed->next_max_id)){
	$maxId = $feed->next_max_id;
}
foreach ($feed->items as $key => $row) {
?>
<div class="col-md-3 mb15" id="id<?=$row->id?>">
	<div class="item">
		<a href="https://www.instagram.com/p/<?=$row->code?>" target="_blank">
			<div class="box-img" style="background-image: url(https://www.instagram.com/p/<?=$row->code?>/media/?size=m)">
				<div class="icon">
					<?php switch ($row->media_type) {
						case 1:
							echo '<i class="ft-image"></i>';
							break;

						case 2:
							echo '<i class="ft-video"></i>';
							break;

						case 8:
							echo '<i class="ft-grid"></i>';
							break;
					}?>
					
				</div>
			</div>
		</a>
		<div class="item-info">
			<div class="type"><i class="ft-heart danger"></i> <?=$row->like_count?></div>
			<div class="type"><i class="ft-message-square success"></i> <?=$row->comment_count?></div>
			<a href="<?=cn("instagram/activity/delete_media/".segment(4)."/".$row->id)?>" class="type pull-right p0 actionItem" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete"><i class="ft-trash-2"></i></a>
		</div>
	</div>
</div>

<?php }}?>

<script type="text/javascript">
	setTimeout(function(){
		$('[data-toggle="tooltip"]').tooltip({container: "body", trigger : 'hover'});
		$(".schedules-list").attr("data-id", "<?=$maxId?>");
	}, 200);

	$(".ajax-activity-profile-list .instagram-profile-loading").remove();
	<?php if($maxId!=""){?>
	$(".ajax-activity-profile-list").append('<div class="instagram-profile-loading"><div class="clearfix"></div><div class="text-center"><button class="btn btn-grey">Loading...</button></div></div>');
	<?php }?>
</script>

