<?php if(!check_expiration_date()){?>
<div class="notification">
	<div class="notification-board">
		<ul>
			<li class="danger"><i class="ft-alert-circle"></i> <?=lang("your_account_has_expired_Please_renew_for_further_use")?></li>
		</ul>
	</div>
</div>
<?php }?>

<?php if(segment(1) == "dashboard" && $user->admin == 1){?>
<div class="check-update"></div>

<script type="text/javascript">
	$(function(){
		var _data = $.param({token:token});
		$.post("<?=cn("notification/check_update")?>", _data, function(_result){
			$(".check-update").html(_result);
		});
	});
</script>
<?php }?>