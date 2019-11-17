<?php if(!empty($user)){?>
<div class="row">
	<div class="col-md-6 mb15">
		<strong><?=$user->full_name?></strong><br/>
		<div><?=$user->biography?></div>
		<div class="mb15"><a href="<?=$user->external_url?>" target="_blank"><?=$user->external_url?></a></div>
	</div>
	<div class="col-md-6">
		<div class="profile-info-counter row">
			<div class="col-md-4 mb15">
				<?php
        	$media_count = get_value($result->settings, "media_count");
        	$media_posted = $user->media_count - $media_count;
        	if($media_count == 0 || $media_posted == 0){
        		$media_posted = "";
        	}
        	?>
				<div class="item">
					<div class="number"><?=$user->media_count?> 
						<span class="small <?=$media_posted<0?"danger":"success"?>"><?=$media_posted>0?"+":""?><?=$media_posted?></span>
					</div>
					<div class="text"> <?=lang('Posts')?></div>
				</div>
			</div>
			<div class="col-md-4 mb15">
				<?php
        	$follower_count = get_value($result->settings, "follower_count");

        	$followers_gained = $user->follower_count - $follower_count;
        	if($follower_count == 0 || $followers_gained == 0){
        		$followers_gained = "";
        	}
        	?>
				<div class="item">
					<div class="number"><?=$user->follower_count?>
						<span class="small <?=$followers_gained<0?"danger":"success"?>"><?=$followers_gained>0?"+":""?><?=$followers_gained?></span>
					</div>
					<div class="text"> <?=lang('Followers')?></div>
				</div>
			</div>
			<div class="col-md-4 mb15">
			<?php
        	$following_count = get_value($result->settings, "following_count");
        	$followings_gained = $user->following_count - $following_count;
        	if($following_count == 0 || $followings_gained == 0){
        		$followings_gained = "";
        	}
        	?>
				<div class="item">
					<div class="number"><?=$user->following_count?>
						<span class="small <?=$followings_gained<0?"danger":"success"?>"><?=$followings_gained>0?"+":""?><?=$followings_gained?></span>
					</div>
					<div class="text"> <?=lang('Followings')?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }?>