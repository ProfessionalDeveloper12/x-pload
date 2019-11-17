<div class="wrap-content instagram-app container schedules-list" data-action="<?=cn(segment(1)."/activity/load_log/".segment(4))."/".segment(5)?>" data-content="ajax-activity-log-list" data-append_content="1" data-result="html" data-page="0" data-hide-overplay="0">
	<div class="row">
	  	<div class="col-sm-12">
	  		<form action="<?=cn("instagram/activity/save_settings/".segment("4"))?>" class="activityForm" data-hide-overplay="">
	    	<div class="card">
		  		<div class="card-block">
		  			<div class="activity-header pb0">

		  				<div class="activity-nav mb0 b0">
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
	  					<?php if(get_option('igac_save_log', 7) != 0){?>
	    				<div class="activity-notification danger text-center"><?=sprintf(lang('Notice_Log_just_saved_within_x_days'),get_option('igac_save_log', 7))?></div>
	    				<?php }?>
		  			</div>
		  			
			    	<div class="card-body">
			    		<ul class="activity-menu-log">
			    			<li class="grey"> <?=lang('show')?> </li>
			    			<li class=""><a class="<?=segment(5)==""?"active":""?>" href="<?=cn("instagram/activity/log/".segment(4)."/")?>"> <?=lang('all')?></a></li>
			    			<li class=""><a class="<?=segment(5)=="likes"?"active":""?>" href="<?=cn("instagram/activity/log/".segment(4)."/likes")?>"> <?=lang('likes')?></a></li>
			    			<li class=""><a class="<?=segment(5)=="comments"?"active":""?>" href="<?=cn("instagram/activity/log/".segment(4)."/comments")?>"> <?=lang('comments')?></a></li>
			    			<li class=""><a class="<?=segment(5)=="followers"?"active":""?>" href="<?=cn("instagram/activity/log/".segment(4)."/followers")?>"> <?=lang('follows')?></a></li>
			    			<li class=""><a class="<?=segment(5)=="unfollows"?"active":""?>" href="<?=cn("instagram/activity/log/".segment(4)."/unfollows")?>"> <?=lang('unfollows')?></a></li>
			    			<li class=""><a class="<?=segment(5)=="direct_messages"?"active":""?>" href="<?=cn("instagram/activity/log/".segment(4)."/direct_messages")?>"> <?=lang('direct_messages')?></a></li>
			    			<li class=""><a class="<?=segment(5)=="repost_medias"?"active":""?>" href="<?=cn("instagram/activity/log/".segment(4)."/repost_medias")?>"> <?=lang('repost_medias')?></a></li>
			    		</ul>

			    		<div class="activity-log row ajax-activity-log-list">
			    			
			    		</div>
			    	</div>
			  	</div>
			</div>
			</form>
	    </div>
  	</div>
</div>