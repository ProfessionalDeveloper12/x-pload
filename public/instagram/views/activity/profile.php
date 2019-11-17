<div class="wrap-content instagram-app container schedules-list" data-action="<?=cn(segment(1)."/activity/load_profile/".segment(4))?>" data-content="ajax-activity-profile-list" data-append_content="1" data-result="html" data-page="0" data-hide-overplay="0">
	<div class="row">
	  	<div class="col-sm-12">
	  		<form action="<?=cn("instagram/activity/save_settings/".segment("4"))?>" class="activityForm" data-hide-overplay="">
	    	<div class="card">
		  		<div class="card-block">
		  			<div class="activity-header">

		  				<div class="activity-nav">
		  					<a href="<?=cn("instagram/activity/settings/".segment("4"))?>" class="activity-info-account">
			  						<img src="<?=$result->avatar?>" width="80">
			  						<div class="text"><span class="brand"><?=lang("instagram")?></span><span class="username"><?=$result->username?></span></div>
			  					</a>

		  					<ul class="activity-menu">
						      	<li class="<?=segment(3)=="settings"?"active":""?>"><a href="<?=cn("instagram/activity/settings/".segment("4"))?>"> <?=lang('activity')?></a></li>
						      	<li class="<?=segment(3)=="log"?"active":""?>"><a href="<?=cn("instagram/activity/log/".segment("4"))?>"> <?=lang('log')?></a></li>
						      	<li class="<?=segment(3)=="stats"?"active":""?>"><a href="<?=cn("instagram/activity/stats/".segment("4"))?>"> <?=lang('stats')?></a></li>
						      	<li class="<?=segment(3)=="profile"?"active":""?>"><a href="<?=cn("instagram/activity/profile/".segment("4"))?>"> <?=lang('profile')?></a></li>
						    </ul>
	  					</div>

	  					<div class="ajax_load_profile_info" data-result="html" data-hide-overplay="">
	  						<div class="text-center"><button class="btn btn-grey"> <?=lang('Loading')?></button></div>
	  					</div>
		  			</div>
		  			
			    	<div class="card-body">
			    		<div class="activity-profile row ajax-activity-profile-list p0">
			    			<div class="instagram-profile-loading">
			    				<div class="clearfix"></div>
			    			</div>
			    		</div>
			    	</div>
			  	</div>
			</div>
			</form>
	    </div>
  	</div>
</div>

<script type="text/javascript">
	$(function(){
		setTimeout(function(){
			_that = $(".ajax_load_profile_info");
			Main.ajax_post(_that, "<?=cn("instagram/activity/load_profile_info/".segment(4))?>", {token: token}, function(_result){
				_that.html(_result);
	        });
		}, 500);
	});
</script>