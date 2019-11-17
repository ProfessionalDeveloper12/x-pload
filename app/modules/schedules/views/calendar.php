<?php $ids = ids(); ?>

<div class="monthly" style="display: none;" id="mycalendar-<?=$ids?>"></div>
<script type="text/javascript">
	$(function(){
		$('#mycalendar-<?=$ids?>').monthly({
			mode: 'event',
  			xmlUrl: '<?=PATH?>schedules/xml/<?=$type?>/<?=!empty($socials)?strtolower(implode(".", $socials)):""?>',
		});
		
		setTimeout(function(){
			$(".monthly").fadeIn();
		}, 200);
	});
</script>