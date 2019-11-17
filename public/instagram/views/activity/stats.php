<div class="wrap-content instagram-app container">
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
		  			</div>
		  			
			    	<div class="card-body">
			    		<div class="row">
			    			<div class="col-md-4">
								<div class="card-body box-analytic">
						            <div class="media">
						                <div class="media-body text-left w-100">
						                    <h3 class="analytic-text"><?=igac("like", $result->settings)?></h3>
						                    <span> <?=lang('Total_Like_actions')?></span>
						                </div>
						                <div class="media-right media-middle">
						                    <i class="ft-thumbs-up analytic-text font-large-2 float-right"></i>
						                </div>
						            </div>
						        </div>
							</div>
							<div class="col-md-4">
								<div class="card-body box-analytic">
						            <div class="media">
						                <div class="media-body text-left w-100">
						                    <h3 class="analytic-text"><?=igac("comment", $result->settings)?></h3>
						                    <span> <?=lang('Total_Comment_actions')?></span>
						                </div>
						                <div class="media-right media-middle">
						                    <i class="ft-message-square analytic-text font-large-2 float-right"></i>
						                </div>
						            </div>
						        </div>
							</div>
							<div class="col-md-4">
								<div class="card-body box-analytic">
						            <div class="media">
						                <div class="media-body text-left w-100">
						                    <h3 class="analytic-text"><?=igac("follow", $result->settings)?></h3>
						                    <span> <?=lang('Total_Follow_actions')?></span>
						                </div>
						                <div class="media-right media-middle">
						                    <i class="ft-user-plus analytic-text font-large-2 float-right"></i>
						                </div>
						            </div>
						        </div>
							</div>
							<div class="col-md-4">
								<div class="card-body box-analytic">
						            <div class="media">
						                <div class="media-body text-left w-100">
						                    <h3 class="analytic-text"><?=igac("unfollow", $result->settings)?></h3>
						                    <span> <?=lang('Total_Unfollow_actions')?></span>
						                </div>
						                <div class="media-right media-middle">
						                    <i class="ft-user-x analytic-text font-large-2 float-right"></i>
						                </div>
						            </div>
						        </div>
							</div>
							<div class="col-md-4">
								<div class="card-body box-analytic">
						            <div class="media">
						                <div class="media-body text-left w-100">
						                    <h3 class="analytic-text"><?=igac("direct_message", $result->settings)?></h3>
						                    <span> <?=lang('Total_Direct_message_actions')?></span>
						                </div>
						                <div class="media-right media-middle">
						                    <i class="ft-message-circle analytic-text font-large-2 float-right"></i>
						                </div>
						            </div>
						        </div>
							</div>
			    		</div>
			    		<div class="row">
			    			<div class="col-md-4">
								<div class="card-body box-analytic">
						            <div class="media">
						                <div class="media-body text-left w-100">
						                    <h3 class="analytic-text"><?=($result->changed!="")?time_elapsed_string($result->changed):"No time"?></h3>
						                    <span> <?=lang('Time_started')?></span>
						                </div>
						                <div class="media-right media-middle">
						                    <i class="ft-clock analytic-text font-large-2 float-right"></i>
						                </div>
						            </div>
						        </div>
							</div>
							
							<div class="col-md-4">
								<div class="card-body box-analytic">
						            <div class="media">
						                <div class="media-body text-left w-100">

						                	<?php
						                	$follower_count = get_value($result->settings, "follower_count");
						                	$followers_gained = $follower - $follower_count;
						                	if($follower_count == 0){
						                		$followers_gained = 0;
						                	}
						                	?>
						                    <h3 class="analytic-text"><?=($follower <= -1)?0:$followers_gained?></h3>
						                    <span> <?=lang('Total_Followers_gained')?></span>
						                </div>
						                <div class="media-right media-middle">
						                    <i class="ft-user-plus analytic-text font-large-2 float-right"></i>
						                </div>
						            </div>
						        </div>
							</div>
			    		</div>
			    	</div>
			  	</div>
			</div>
			</form>
	    </div>
  	</div>
</div>