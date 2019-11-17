<?php
$act = $result->data;
?>

<form action="<?=cn("instagram/activity/save_settings/".segment("4"))?>" class="activityForm" data-hide-overplay="">
<div class="wrap-content instagram-app">
	<div class="container">
		<div class="row">
		  	<div class="col-sm-12">
		    	<div class="card mt15">
			  		<div class="card-block">
			  			<div class="activity-header">

			  				<div class="activity-nav">
			  					<a href="<?=cn("instagram/activity/settings/".segment("4"))?>" class="activity-info-account">
			  						<img src="<?=$result->avatar?>" width="80">
			  						<span><?=$result->username?></span>
			  					</a>

			  					<ul class="activity-menu">
							      	<li class="<?=segment(3)=="settings"?"active":""?>"><a href="<?=cn("instagram/activity/settings/".segment("4"))?>"><?=lang('activity')?></a></li>
							      	<li class="<?=segment(3)=="log"?"active":""?>"><a href="<?=cn("instagram/activity/log/".segment("4"))?>"> <?=lang('log')?></a></li>
							      	<li class="<?=segment(3)=="stats"?"active":""?>"><a href="<?=cn("instagram/activity/stats/".segment("4"))?>"> <?=lang('stats')?></a></li>
							      	<li class="<?=segment(3)=="profile"?"active":""?>"><a href="<?=cn("instagram/activity/profile/".segment("4"))?>"> <?=lang('profile')?></a></li>
							    </ul>
		  					</div>

			  				<div class="row">
			  					<div class="col-md-4">

				  					<div class="activity-proccess">
				  						<?php if($result->status == 1){?>
				  						<i class='fa ft-clock primary pe-spin'></i>
										<?php }else{?>
				  						<i class='fa ft-stop-circle danger'></i>
										<?php }?>
				  					</div>
				  					<div class="activity-infos">
				  						<div class="item">
				  							<span><?=lang('status')?></span>
				  							<div class="pull-right"><?=igas($result, "text")?></div>
				  						</div>
				  						<div class="item">
				  							<span><?=lang('started_on')?></span>
				  							<div class="pull-right"><?=($result->created!="" && $result->status != 2)?convert_datetime($result->created):"--:--"?></div>
				  						</div>
				  					</div>

				  					<div class="btn-group btn-group-justified activity-action-update">
										<?php if($result->status == 1){?>
										<a href="<?=cn("instagram/activity/stop/".segment("4"))?>" class="btn btn-grey btnActivityStop"> <?=lang('stop')?></a>
										<?php }else{?>
										<a href="<?=cn("instagram/activity/start/".segment("4"))?>" class="btn btn-primary btnActivityStart"> <?=lang('start')?></a>
										<?php }?>
										<a href="#" class="btn btn-grey open_schedule_days" data-toggle="tooltip" data-target="#schedule_days" data-placement="top" title="" data-original-title="<?=lang('schedule')?>"><i class="ft-grid"></i></a>
									</div>
				  				</div>
				  				<div class="col-md-4">
				  					<div class="activity-todo">
				  						<div class="head_title"> <?=lang('Select_what_you_want_to_do')?></div>
					  					<div class="item">
							      			<span class="text"> <?=lang('likes')?></span>
							      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Turn_this_switch_on_to_automate_your_Likes_activity_The_counter_shows_how_many_photos_and_videos_you_have_liked_since_your_last_activity_start')?>
									  		" data-delay-show="300" data-title="<?=lang('likes')?>"></i>
							      			<?php if(ig_get_setting("like_block", "", $result->id) != ""){?>
							      			<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("like_block", "", $result->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
							      			<?php }?>
							      			<div class="activity-option-switch">
											    <input class="tgl tgl-ios actionSaveActivity collapseAction" data-type="likes" id="cb_todo_like" name="todo[like]" <?=igav("todo", $act, "like")?"checked":"";?> type="checkbox">
											    <label class="tgl-btn" for="cb_todo_like"></label>
		            						</div>
		            						<div class="number pull-right"><?=igac("like", $result->settings)?></div>
							      		</div>
							      		<div class="item">
							      			<span class="text"> <?=lang('comments')?></span>
							      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Turn_this_switch_on_to_automate_your_Comments_activity_The_counter_shows_how_many_photos_and_videos_you_have_commented_since_your_last_activity_start')?>" data-delay-show="300" data-title="<?=lang('comments')?>"></i>
							      			<?php if(ig_get_setting("comment_block", "", $result->id) != ""){?>
							      			<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("comment_block", "", $result->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
							      			<?php }?>
							      			<div class="activity-option-switch">
											    <input class="tgl tgl-ios actionSaveActivity collapseAction" data-type="comments" id="cb_todo_comment" name="todo[comment]" <?=igav("todo", $act, "comment")?"checked":"";?> type="checkbox">
											    <label class="tgl-btn" for="cb_todo_comment"></label>
	                						</div>
	                						<div class="number pull-right"><?=igac("comment", $result->settings)?></div>
							      		</div>
							      		<div class="item">
							      			<span class="text"> <?=lang('follows')?></span>
							      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Turn_this_switch_on_to_automate_your_Follows_activity_The_counter_shows_how_many_users_you_have_followed_since_your_last_activity_start')?>" data-delay-show="300" data-title="<?=lang('follows')?>"></i>
							      			<?php if(ig_get_setting("follow_block", "", $result->id) != ""){?>
							      			<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("follow_block", "", $result->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
							      			<?php }?>
							      			<div class="activity-option-switch">
											    <input class="tgl tgl-ios actionSaveActivity collapseAction" data-type="follow" id="cb_todo_follow" name="todo[follow]" <?=igav("todo", $act, "follow")?"checked":"";?> type="checkbox">
											    <label class="tgl-btn" for="cb_todo_follow" name="todo[follow]"></label>
                    						</div>
                    						<div class="number pull-right"><?=igac("follow", $result->settings)?></div>
							      		</div>
							      		<div class="item">
							      			<span class="text"><?=lang('unfollows')?></span>
							      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Turn_this_switch_on_to_automate_your_Unfollows_activity_The_counter_shows_how_many_users_you_have_unfollowed_since_your_last_activity_start')?>" data-delay-show="300" data-title="<?=lang('unfollows')?>"></i>
							      			<?php if(ig_get_setting("unfollow_block", "", $result->id) != ""){?>
							      			<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("unfollow_block", "", $result->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
							      			<?php }?>
							      			<div class="activity-option-switch">
											    <input class="tgl tgl-ios actionSaveActivity collapseAction" data-type="unfollow" id="cb_todo_unfollow" name="todo[unfollow]" <?=igav("todo", $act, "unfollow")?"checked":"";?> type="checkbox">
											    <label class="tgl-btn" for="cb_todo_unfollow"></label>
                    						</div>
                    						<div class="number pull-right"><?=igac("unfollow", $result->settings)?></div>
							      		</div>
							      		<div class="item">
							      			<span class="text"><?=lang('direct_messages')?></span>
							      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Turn_this_switch_on_to_automate_your_direct_messages_activity_The_counter_shows_how_many_users_you_have_sent_direct_messages_since_your_last_activity_start')?>" data-delay-show="300" data-title="<?=lang('direct_messages')?>"></i>
							      			<?php if(ig_get_setting("direct_message_block", "", $result->id) != ""){?>
							      			<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("direct_message_block", "", $result->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
							      			<?php }?>
							      			<div class="activity-option-switch">
											    <input class="tgl tgl-ios actionSaveActivity collapseAction" data-type="direct_messages" id="cb_todo_direct_message" name="todo[direct_message]" <?=igav("todo", $act, "direct_message")?"checked":"";?> type="checkbox">
											    <label class="tgl-btn" for="cb_todo_direct_message"></label>
                    						</div>
                    						<div class="number pull-right"><?=igac("direct_message", $result->settings)?></div>
							      		</div>
							      		<div class="item">
							      			<span class="text"><?=lang('repost_medias')?></span>
							      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Turn_this_switch_on_to_automate_your_repost_medias_activity_The_counter_shows_how_many_medias_you_have_posted_since_your_last_activity_start')?>" data-delay-show="300" data-title="<?=lang('repost_medias')?>"></i>
							      			<?php if(ig_get_setting("repost_media_block", "", $result->id) != ""){?>
							      			<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("repost_media_block", "", $result->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
							      			<?php }?>
							      			<div class="activity-option-switch">
											    <input class="tgl tgl-ios actionSaveActivity collapseAction" data-type="repost_media" id="cb_todo_repost_media" name="todo[repost_media]" <?=igav("todo", $act, "repost_media")?"checked":"";?> type="checkbox">
											    <label class="tgl-btn" for="cb_todo_repost_media"></label>
                    						</div>
                    						<div class="number pull-right"><?=igac("repost_media", $result->settings)?></div>
							      		</div>
						      		</div>
				  				</div>
				  				<div class="col-md-4 recent_log_box">
									<div class="head_title"> <?=lang('Recent_activities')?></div>
									<div class="recent_log scrollbar scrollbar-dynamic">
										<?php if(!empty($recent_log)){
											foreach ($recent_log as $key => $row) {
												$data = json_decode($row->data);
										?>
										<div class="item">
											<a href="https://www.instagram.com/<?=is_numeric($data->id)?$data->username:"p/".$data->id?>" target="_blank">
												<div class="image-box">
													<img src="<?=is_numeric($data->id)?$data->image:"https://www.instagram.com/p/".$data->id."/media/?size=m"?>">
												</div>
												<div class="info-box">
													<div class="type"><?=igaa($row->action)->text?> <div class="id"><?=$data->id?></div></div>
													<div class="time"><?=time_elapsed_string($row->created)?></div>
												</div>
											</a>
										</div>
										<?php }}else{?>
										<div class="dataTables_empty"></div>
										<?php }?>
									</div>
				  				</div>
			  				</div>
			  			</div>
			  			
			  			<div class="activity-settings">
			  				<div class="headline">
			  					<h3>Instagram activity settings</h3>
			  					<hr>
			  				</div>
			  				<div class="row">
			  				<div class="col-md-3">
			  					<ul class="nav nav-pills nav-stacked" id="activity-tabs" role="tablist">
				  					<li class="nav-item active"><a href="#step-1" aria-controls="step-1" id="step-tab-1" class="nav-link" data-toggle="tab" role="tab" aria-selected="true"><i class="ft-target panel-dropdown-icon"></i><?=lang('Targeting')?></a></li>
				  					<!--<li class="nav-item"><a href="#step-2" aria-controls="step-2" id="step-tab-2" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-play-circle panel-dropdown-icon"></i> <?=lang('Speed')?></a></li>-->
				  					<li class="nav-item"><a href="#step-3" aria-controls="step-3" id="step-tab-3" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-filter panel-dropdown-icon"></i> <?=lang('Filters')?></a></li>

				  					<li class="nav-item" data-content="todo[comment]" style="display: none;"><a href="#step-4" aria-controls="step-4" id="step-tab-4" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-message-square panel-dropdown-icon"></i> <?=lang('comments')?></a></li>

				  					<li class="nav-item" data-content="todo[direct_message]" style="display: none;"><a href="#step-5" aria-controls="step-5" id="step-tab-5" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-message-circle panel-dropdown-icon"></i> <?=lang('direct_message')?></a></li>

				  					<li class="nav-item" data-content="todo[follow]" style="display: none;"><a href="#step-6" aria-controls="step-6" id="step-tab-6" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-user-plus panel-dropdown-icon"></i> <?=lang('follow')?></a></li>

				  					<li class="nav-item" data-content="todo[unfollow]" style="display: none;"><a href="#step-7" aria-controls="step-7" id="step-tab-7" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-user-x panel-dropdown-icon"></i> <?=lang('unfollow')?></a></li>

				  					<li class="nav-item" data-content="todo[repost_media]" style="display: none;"><a href="#step-8" aria-controls="step-8" id="step-tab-8" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-share panel-dropdown-icon"></i> <?=lang('repost_media')?></a></li>

				  					<li class="nav-item"><a href="#step-9" aria-controls="step-9" id="step-tab-9" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-tag panel-dropdown-icon"></i> <?=lang('tags')?></a></li>
				  					<li class="nav-item"><a href="#step-10" aria-controls="step-10" id="step-tab-10" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-map-pin panel-dropdown-icon"></i> <?=lang('locations')?></a></li>
				  					<li class="nav-item"><a href="#step-11" aria-controls="step-11" id="step-tab-11" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-user panel-dropdown-icon"></i> <?=lang('usernames')?></a></li>
				  					<li class="nav-item"><a href="#step-12" aria-controls="step-12" id="step-tab-12" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-slash panel-dropdown-icon"></i> <?=lang('Blacklists')?></a></li>
				  					<li class="nav-item"><a href="#step-13" aria-controls="step-13" id="step-tab-13" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="ft-stop-circle panel-dropdown-icon"></i> <?=lang('Auto_Stop')?></a></li>
			  					</ul>
			  				</div>
			  				<div class="col-md-9">
			  					<div class="tab-content" id="activity-tab-content">
						    	<div id="step-1" class="tab-pane fade in active" role="tabpanel" aria-labelledby="step-tab-1">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('tags')?></span> 
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Targeting_tags_desc')?>" data-delay-show="300" data-title="<?=lang('tags')?>"></i>
								      			<div class="pure-checkbox black activity-option-checkbox">
								      				<input type="checkbox" id="cb_target_tags" name="target[tag]" class="filled-in chk-col-red actionSaveActivity collapseAction" data-type="tags" <?=igav("target", $act, "tag")?"checked":"";?> value="on">
	                    							<label class="p0 m0" for="cb_target_tags">&nbsp;</label>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('locations')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Targeting_locations_desc')?>" data-delay-show="300" data-title="<?=lang('locations')?>"></i>
								      			<div class="pure-checkbox black activity-option-checkbox">
								      				<input type="checkbox" id="cb_target_locations" name="target[location]" class="filled-in chk-col-red actionSaveActivity collapseAction" data-type="locations" <?=igav("target", $act, "location")?"checked":"";?> value="on">
	                    							<label class="p0 m0" for="cb_target_locations">&nbsp;</label>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Followers')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Targeting_followers_desc')?>" data-delay-show="300" data-title="<?=lang('Followers')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity" name="target[follower]">
								      					<option value="">-</option>
														<option value="user" <?=igav("target", $act, "follower")=="user"?"selected":"";?>><?=lang('usernames')?></option>
														<option value="me" <?=igav("target", $act, "follower")=="me"?"selected":"";?>><?=lang('My_account')?></option>
														<option value="all" <?=igav("target", $act, "follower")=="all"?"selected":"";?>><?=lang('all')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Followings')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Targeting_followings_desc')?>" data-delay-show="300" data-title="<?=lang('Followings')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity" name="target[following]">
								      					<option value="">-</option>
														<option value="user" <?=igav("target", $act, "following")=="user"?"selected":"";?>><?=lang('usernames')?></option>
														<option value="me" <?=igav("target", $act, "following")=="me"?"selected":"";?>><?=lang('My_Feed')?></option>
														<option value="all" <?=igav("target", $act, "following")=="all"?"selected":"";?>><?=lang('all')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Likers')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Targeting_likers_desc')?>" data-delay-show="300" data-title="<?=lang('Likers')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity" name="target[liker]">
								      					<option value="">-</option>
														<option value="user" <?=igav("target", $act, "liker")=="user"?"selected":"";?>><?=lang('Usernames_posts')?></option>
														<option value="me" <?=igav("target", $act, "liker")=="me"?"selected":"";?>><?=lang('My_posts')?></option>
														<option value="all" <?=igav("target", $act, "liker")=="all"?"selected":"";?>><?=lang('all')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Commenters')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Targeting_commenters_desc')?>" data-delay-show="300" data-title="<?=lang('Commenters')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity" name="target[commenter]">
								      					<option value="">-</option>
														<option value="user" <?=igav("target", $act, "commenter")=="user"?"selected":"";?>><?=lang('Usernames_posts')?></option>
														<option value="me" <?=igav("target", $act, "commenter")=="me"?"selected":"";?>><?=lang('My_posts')?></option>
														<option value="all" <?=igav("target", $act, "commenter")=="all"?"selected":"";?>><?=lang('all')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>

								<!--<div id="step-2" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-2">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-12">
								      		<div class="item">
								      			<span class="text"><?=lang('Activity_speed')?></span> 
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Activity_speed_desc')?>" data-delay-show="300" data-title="<?=lang('Activity_speed')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control speedLevel" name="speed[level]">
								      					<option value="slow" <?=igav("speed", $act, "level")=="slow"?"selected":"";?> data-speed="[<?=get_option('igac_speed_slow_like', 2).",".get_option('igac_speed_slow_comment', 3).",".get_option('igac_speed_slow_follow', 3).",".get_option('igac_speed_slow_unfollow', 3).",".get_option('igac_speed_slow_direct_message', 1).",".get_option('igac_speed_slow_repost_media', 1)?>]"><?=lang('Slow')?></option>
														<option value="normal" <?=igav("speed", $act, "level")=="normal"?"selected":"";?> data-speed="[<?=get_option('igac_speed_normal_like', 4).",".get_option('igac_speed_normal_comment', 4).",".get_option('igac_speed_normal_follow', 5).",".get_option('igac_speed_normal_unfollow', 5).",".get_option('igac_speed_normal_direct_message', 2).",".get_option('igac_speed_normal_repost_media', 2)?>]"><?=lang('Normal')?></option>
														<option value="fast" <?=igav("speed", $act, "level")=="fast"?"selected":"";?> data-speed="[<?=get_option('igac_speed_fast_like', 6).",".get_option('igac_speed_fast_comment', 5).",".get_option('igac_speed_fast_follow', 7).",".get_option('igac_speed_fast_unfollow', 7).",".get_option('igac_speed_fast_direct_message', 3).",".get_option('igac_speed_fast_repost_media', 3)?>]"><?=lang('Fast')?></option>
														<option value="" disabled="" class="tab-pane fade" role="tabpanel" aria-labelledby=""><?=lang('Custom')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-primary"><?=lang('Advance')?></div>
								      			</div>
								      			<span class="text"><?=lang('Likes/hour')?></span> 
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Speed_likes_desc')?>" data-delay-show="300" data-title="<?=lang('Likes_per_hour')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control item-speed actionSaveActivity" name="speed[like]" value="<?=igav("speed", $act, "like")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-primary"><?=lang('Advance')?></div>
								      			</div>
								      			<span class="text"><?=lang('Comments/hour')?></span> 
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Speed_comments_desc')?>" data-delay-show="300" data-title="<?=lang('Comments_per_hour')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control item-speed actionSaveActivity" name="speed[comment]" value="<?=igav("speed", $act, "comment")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-primary"><?=lang('Advance')?></div>
								      			</div>
								      			<span class="text"><?=lang('Follows/hour')?></span> 
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Speed_follows_desc')?>" data-delay-show="300" data-title="<?=lang('Follows_per_hour')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control item-speed actionSaveActivity" name="speed[follow]" value="<?=igav("speed", $act, "follow")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-primary"><?=lang('Advance')?></div>
								      			</div>
								      			<span class="text"><?=lang('Unfollows/hour')?></span> 
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Speed_unfollows_desc')?>" data-delay-show="300" data-title="<?=lang('Unfollows_per_hour')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control item-speed actionSaveActivity" name="speed[unfollow]" value="<?=igav("speed", $act, "unfollow")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-primary"><?=lang('Advance')?></div>
								      			</div>
								      			<span class="text"><?=lang('Direct_messages/hour')?></span> 
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Speed_direct_messages_desc')?>" data-delay-show="300" data-title="<?=lang('Direct_messages_per_hour')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control item-speed actionSaveActivity" name="speed[direct_message]" value="<?=igav("speed", $act, "direct_message")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-primary"><?=lang('Advance')?></div>
								      			</div>
								      			<span class="text"><?=lang('Repost_medias/day')?></span> 
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Speed_repost_medias_desc')?>" data-delay-show="300" data-title="<?=lang('Repost_medias_per_hour')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control item-speed actionSaveActivity" name="speed[repost_media]" value="<?=igav("speed", $act, "repost_media")?>"/>
	                    						</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div> -->

								<?php if(get_option('igac_enable_filter', 1)){?>
								<div id="step-3" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-3">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Media_age')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Media_age_desc')?>" data-delay-show="300" data-title="<?=lang('Media_age')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity actionSaveActivity" name="filter[media_age]">
								      					<option value="new" <?=igav("filter", $act, "media_age")=="new"?"selected":"";?>> <?=lang('newest')?></option>
														<option value="1h" <?=igav("filter", $act, "media_age")=="1h"?"selected":"";?>>1 <?=lang('hour')?></option>
														<option value="12h" <?=igav("filter", $act, "media_age")=="12h"?"selected":"";?>>12 <?=lang('hours')?></option>
														<option value="1d" <?=igav("filter", $act, "media_age")=="1d"?"selected":"";?>>1 <?=lang('day')?></option>
														<option value="3d" <?=igav("filter", $act, "media_age")=="3d"?"selected":"";?>>3 <?=lang('days')?></option>
														<option value="1w" <?=igav("filter", $act, "media_age")=="1w"?"selected":"";?>>1 <?=lang('week')?></option>
														<option value="2w" <?=igav("filter", $act, "media_age")=="2w"?"selected":"";?>>2 <?=lang('weeks')?></option>
														<option value="1m" <?=igav("filter", $act, "media_age")=="1m"?"selected":"";?>>1 <?=lang('month')?></option>
														<option value="" <?=igav("filter", $act, "media_age")==""?"selected":"";?>><?=lang('any')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Media_type')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Media_type_desc')?>" data-delay-show="300" data-title="<?=lang('Media_type')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity" name="filter[media_type]">
								      					<option value=""><?=lang('any')?></option>
														<option value="image" <?=igav("filter", $act, "media_type")=="image"?"selected":"";?>><?=lang('photos')?></option>
														<option value="video" <?=igav("filter", $act, "media_type")=="video"?"selected":"";?>><?=lang('videos')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Min_likes_filter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Min_likes_filter_desc')?>" data-delay-show="300" data-title="<?=lang('Min_likes_filter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="filter[min_like]" value="<?=igav("filter", $act, "min_like")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Max_likes_filter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Max_likes_filter_desc')?>" data-delay-show="300" data-title="<?=lang('Max_likes_filter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="filter[max_like]" value="<?=igav("filter", $act, "max_like")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Min_comments_filter')?> </span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Min_comments_filter_desc')?>" data-delay-show="300" data-title="<?=lang('Min_comments_filter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="filter[min_comment]" value="<?=igav("filter", $act, "min_comment")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Max_comments_filter')?> </span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Max_comments_filter_desc')?>" data-delay-show="300" data-title="<?=lang('Max_comments_filter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="filter[max_comment]" value="<?=igav("filter", $act, "max_comment")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-warning"><?=lang('Warning')?></div>
								      			</div>
								      			<span class="text"><?=lang('User_relation_filter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('User_relation_filter_desc')?>" data-delay-show="300" data-title="<?=lang('User_relation_filter')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity" name="filter[user_relation]">
								      					<option value=""><?=lang('Off')?></option>
														<option value="followers" <?=igav("filter", $act, "user_relation")=="followers"?"selected":"";?>><?=lang('Followers')?></option>
														<option value="followings" <?=igav("filter", $act, "user_relation")=="followings"?"selected":"";?>><?=lang('Followings')?></option>
														<option value="both" <?=igav("filter", $act, "user_relation")=="both"?"selected":"";?>><?=lang('Both')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-warning"><?=lang('Warning')?></div>
								      			</div>
								      			<span class="text"><?=lang('User_profile_filter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('User_profile_filter_desc')?>" data-delay-show="300" data-title="<?=lang('User_profile_filter')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity" name="filter[user_profile]">
								      					<option value=""><?=lang('Off')?></option>
														<option value="low" <?=igav("filter", $act, "user_profile")=="low"?"selected":"";?>><?=lang('Low')?></option>
														<option value="medium" <?=igav("filter", $act, "user_profile")=="medium"?"selected":"";?>><?=lang('Medium')?></option>
														<option value="high" <?=igav("filter", $act, "user_profile")=="high"?"selected":"";?>><?=lang('High')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-warning"><?=lang('Warning')?></div>
								      			</div>
								      			<span class="text"><?=lang('Min_followers_filter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Min_followers_filter_desc')?>" data-delay-show="300" data-title="<?=lang('Min_followers_filter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="filter[min_follower]" value="<?=igav("filter", $act, "min_follower")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-warning"><?=lang('Warning')?></div>
								      			</div>
								      			<span class="text"><?=lang('Max_followers_filter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Max_followers_filter_desc')?>" data-delay-show="300" data-title="<?=lang('Max_followers_filter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="filter[max_follower]" value="<?=igav("filter", $act, "max_follower")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-warning"><?=lang('Warning')?></div>
								      			</div>
								      			<span class="text"><?=lang('Min_followings_filter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Min_followings_filter_desc')?>" data-delay-show="300" data-title="<?=lang('Min_followings_filter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="filter[min_following]" value="<?=igav("filter", $act, "min_following")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-warning"><?=lang('Warning')?></div>
								      			</div>
								      			<span class="text"><?=lang('Max_followings_filter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Max_followings_filter_desc')?>" data-delay-show="300" data-title="<?=lang('Max_followings_filter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="filter[max_following]" value="<?=igav("filter", $act, "max_following")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6 hide">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-warning"><?=lang('Warning')?></div>
								      			</div>
								      			<span class="text"><?=lang('Gender_filter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="

												<b>Off</b> — Filter is turned off.<br/><br/>
												<b>Female</b> — Interact only with users and their media
												whose gender has been determined as female.<br/><br/>
												<b>Male</b> — Interact only with users and their media
												whose gender has been determined as male.<br/><br/>
												<span class='blue'>INFO:</span> This filter analyzes full
												names of the user profiles and cannot guarantee 100% accuracy.<br/><br/>
												<span class='warning'>WARNING:</span> This filter can slow down
												or completely stop your activity if the system will not be able
												to find accounts based on the selected option.
								  
								      			" data-delay-show="300" data-title="Gender filter"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity" name="filter[gender]">
								      					<option value=""><?=lang('Off')?></option>
														<option value="f" <?=igav("filter", $act, "gender")=="f"?"selected":"";?>><?=lang('Male')?></option>
														<option value="m" <?=igav("filter", $act, "gender")=="m"?"selected":"";?>><?=lang('Female')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>
								<?php }?>

								<div id="step-4" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-4">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-12">
								      		<div class="item">
								      			<span class="text"><?=lang('Do_not_comment_same_users')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('When_checking_this_box_you_will_not_comment_more_than_one_photo_or_video_of_the_same_user')?>" data-delay-show="300" data-title="<?=lang('Do_not_comment_same_users')?>"></i>
								      			<div class="pure-checkbox black activity-option-checkbox">
								      				<input type="checkbox" name="comment[dont_spam]" id="cb_comment_dont_spam" class="filled-in chk-col-red actionSaveActivity" <?=igav("comment", $act, "dont_spam")?"checked":"";?> value="1">
	                    							<label class="p0 m0" for="cb_comment_dont_spam">&nbsp;</label>
	                    						</div>
								      		</div>
								      	</div>
						      			<div class="col-md-12">
								      		<div class="item multi-item">
								      			<div class="activity-left">
								      				<span class="text"><?=lang('comments')?></span>
								      				<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('activity_comments_desc')?>" data-delay-show="300" data-title="<?=lang('comments')?>"></i>
								      			</div>
								      			<?php
								      			$comments = get_value(json_decode($act), "comment");
								      			if(!empty($comments)){
								      			foreach ($comments as $key => $comment) {
								      			$comment = trim($comment);
							      				if(is_numeric($key)){
												?>
												<a href="javascript:void(0);" class="activity-option-item activity-option-comment">
								      				<span><?=$comment?></span>
								      				<input type="hidden" name="comment[]" value="<?=$comment?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}}?>

								      			<?php if($result->id == ""){
								      			$comments = get_option('igac_comments', "Made my day\nTotally rocks!\nVery nice\nVery sweet :)\nThis is great\nSo cool\nFascinating one\nNeat-o!\nGorgeous! Love it!\nThe cutest\nBreathtaking one\nThis is awesome :)\nOutstanding one!\nWhoopee!\nMy Goodness\nThis is awesome!");
								      			$comments = explode("\n", $comments);
												if(!empty($comments)){
													foreach ($comments as $comment) {
														$comment = trim($comment);
														if($comment != ""){
								      			?>
								      			<a href="javascript:void(0);" class="activity-option-item activity-option-comment">
								      				<span><?=$comment?></span>
								      				<input type="hidden" name="comment[]" value="<?=$comment?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}}}?>

								      			<div class="btn-group activity-add-comment">
								      				<a href="<?=cn("instagram/activity/popup/comment/".segment(4))?>" class="btn btn-grey ajaxModal"><?=lang('add')?></a>
												  	<div class="btn-group">
												    	<button type="button" class="btn btn-grey dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												    	<ul class="dropdown-menu dropdown-menu-right" role="menu">
												      		<li><a href="javascript:void(0);" class="activityDeleteAllOption"><?=lang('Delete_all_comments')?></a></li>
												    	</ul>
												  </div>
												</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>

								<div id="step-5" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-5">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-12">
								      		<div class="item">
								      			<span class="text"><?=lang('direct_message_by')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('direct_message_by_desc')?>" data-delay-show="300" data-title="<?=lang('direct_message_by')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity" name="direct_message[by]">
								      					<option value="follower" <?=igav("direct_message", $act, "by")=="follower"?"selected":"";?>><?=lang('new_followers')?></option>
														<option value="target" <?=igav("direct_message", $act, "by")=="target"?"selected":"";?>><?=lang('targets')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
						      			<div class="col-md-12">
								      		<div class="item multi-item">
								      			<div class="activity-left">
								      				<span class="text"><?=lang('direct_message')?></span>
								      				<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('activity_direct_message_desc')?>

								      				
								      				" data-delay-show="300" data-title="<?=lang('direct_message')?>"></i>
								      			</div>
								      			<?php
								      			$direct_messages = get_value(json_decode($act), "direct_message");
								      			if(!empty($direct_messages)){
								      			foreach ($direct_messages as $key => $direct_message) {
								      			$direct_message = trim($direct_message);
							      				if(is_numeric($key)){
												?>
												<a href="javascript:void(0);" class="activity-option-item activity-option-comment">
								      				<span><?=$direct_message?></span>
								      				<input type="hidden" name="direct_message[]" value="<?=$direct_message?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}}?>

								      			<?php if($result->id == ""){
								      			$direct_messages = get_option('igac_direct_messages', "Hello {{username}}, How are you?\nHi {{username}}, How are you today?\nHi {{username}}, Hey, how's it going?\nHello {{username}}, What's up?");
								      			$direct_messages = explode("\n", $direct_messages);
												if(!empty($direct_messages)){
													foreach ($direct_messages as $direct_message) {
														$direct_message = trim($direct_message);
														if($direct_message != ""){
								      			?>
								      			<a href="javascript:void(0);" class="activity-option-item activity-option-comment">
								      				<span><?=$direct_message?></span>
								      				<input type="hidden" name="direct_message[]" value="<?=$direct_message?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}}}?>

								      			<div class="btn-group activity-add-direct-message">
								      				<a href="<?=cn("instagram/activity/popup/direct_message/".segment(4))?>" class="btn btn-grey ajaxModal"><?=lang('add')?></a>
												  	<div class="btn-group">
												    	<button type="button" class="btn btn-grey dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												    	<ul class="dropdown-menu dropdown-menu-right" role="menu">
												      		<li><a href="javascript:void(0);" class="activityDeleteAllOption"><?=lang('Delete_all_direct_message')?></a></li>
												    	</ul>
												  </div>
												</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>

								<div id="step-6" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-6">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-4 hide">
								      		<div class="item">
								      			<span class="text">Follow cycle</span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="

											  	Use this setting to set up an amount of Follow actions to do before
											  	switching to Unfollow cycle when using Follow and Unfollow actions
											  	at the same time. Your activity will also switch to Unfollow cycle
											  	if there is no more space to follow.<br/><br/>
											  	Recommended values: 10-500.<br/>
											  	Allowed values: 1-7500.

								      			" data-delay-show="300" data-title="Follow cycle"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="follow[cycle]" value="<?=igav("follow", $act, "cycle")?>"/>
	                    						</div>
								      		</div>
								      	</div>
						      			<div class="col-md-12">
								      		<div class="item">
								      			<span class="text"><?=lang('Do_not_follow_same_users')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="

								      			<?=lang('When_checking_this_box_you_will_not_follow_the_same_users_twice_after_you_unfollow_them')?>

								      			" data-delay-show="300" data-title="<?=lang('Do_not_follow_same_users')?>"></i>
								      			<div class="pure-checkbox black activity-option-checkbox">
								      				<input type="checkbox" id="cb_follow_dont_spam" name="follow[dont_spam]" <?=igav("follow", $act, "dont_spam")?"checked":"";?> class="filled-in chk-col-red actionSaveActivity" value="1">
	                    							<label class="p0 m0" for="cb_follow_dont_spam">&nbsp;</label>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-12">
								      		<div class="item">
								      			<span class="text"><?=lang('Do_not_follow_private_users')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('When_checking_this_box_you_will_not_follow_private_users')?>" data-delay-show="300" data-title="<?=lang('Do_not_follow_private_users')?>"></i>
								      			<div class="pure-checkbox black activity-option-checkbox">
								      				<input type="checkbox" id="cb_follow_dont_private" name="follow[dont_private]" <?=igav("follow", $act, "dont_private")?"checked":"";?> class="filled-in chk-col-red actionSaveActivity" value="1">
	                    							<label class="p0 m0" for="cb_follow_dont_private">&nbsp;</label>
	                    						</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>

								<div id="step-7" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-7">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-12">
								      		<div class="item">
								      			<span class="text"><?=lang('Unfollow_source')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Unfollow_source_desc')?>" data-delay-show="300" data-title="<?=lang('Unfollow_source')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity" name="unfollow[source]">
								      					<option value="db" <?=igav("unfollow", $act, "source")=="db"?"selected":"";?>><?=lang('Our_source')?></option>
														<option value="all" <?=igav("unfollow", $act, "source")=="all"?"selected":"";?>><?=lang('all')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-12">
								      		<div class="item">
								      			<span class="text"><?=lang('Unfollow_user_after_day')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Unfollow_user_after_day_desc')?>" data-delay-show="300" data-title="<?=lang('Unfollow_user_after_day')?>"></i>
								      			<div class="activity-option-input">
								      				<select class="form-control actionSaveActivity" name="unfollow[after]">
								      					<?php for ($i=1; $i <= 7; $i++) {?>
								      					<option value="<?=$i?>" <?=igav("unfollow", $act, "after")==$i?"selected":"";?>><?=$i?></option>
								      					<?php }?>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-12 hide">
								      		<div class="item">
								      			<span class="text">Unfollow cycle</span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="

											  	Use this setting to set up an amount of Unfollow actions to do before
											  	switching to Follow cycle when using Follow and Unfollow actions
											  	at the same time. Your activity will also switch to Follow cycle
											  	if there are no more users to unfollow.<br/><br/>
											  	Recommended values: 10-500.<br/>
											  	Allowed values: 1-7500.
								  
								      			" data-delay-show="300" data-title="Unfollow cycle"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="unfollow[cycle]" value="<?=igav("unfollow", $act, "cycle")?>"/>
	                    						</div>
								      		</div>
								      	</div>
						      			<div class="col-md-12">
								      		<div class="item">
								      			<div class="bags">
								      				<div class="bag bg-warning"><?=lang('Warning')?></div>
								      				<div class="bag bg-primary"><?=lang('Advance')?></div>
								      			</div>
								      			<span class="text"><?=lang('Do_not_unfollow_my_followers')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Do_not_unfollow_my_followers_desc')?>" data-delay-show="300" data-title="<?=lang('Do_not_unfollow_my_followers')?>"></i>
								      			<div class="pure-checkbox black activity-option-checkbox">
								      				<input type="checkbox" id="cb_unfollow_dont_followers" name="unfollow[dont_follower]" <?=igav("unfollow", $act, "dont_follower")?"checked":"";?> class="filled-in chk-col-red actionSaveActivity" value="1">
	                    							<label class="p0 m0" for="cb_unfollow_dont_followers">&nbsp;</label>
	                    						</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>

								<div id="step-8" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-8">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-12">
								      		<div class="item">
								      			<span class="text"><?=lang('repost_media_by')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('repost_media_by_desc')?>" data-delay-show="300" data-title="<?=lang('repost_media_by')?>"></i>
								      			<div class="activity-option-select">
								      				<select class="form-control actionSaveActivity" name="repost_media[by]">
														<option value="all" <?=igav("repost_media", $act, "by")=="all"?"selected":"";?>><?=lang('all')?></option>
														<option value="tag" <?=igav("repost_media", $act, "by")=="tag"?"selected":"";?>><?=lang('tags')?></option>
														<option value="location" <?=igav("repost_media", $act, "by")=="location"?"selected":"";?>><?=lang('locations')?></option>
								      					<option value="username" <?=igav("repost_media", $act, "by")=="username"?"selected":"";?>><?=lang('usernames')?></option>
								      				</select>
	                    						</div>
								      		</div> 
								      	</div>
						      			<div class="col-md-12">
								      		<div class="item multi-item pb15">
								      			<div class="activity-left">
								      				<span class="text"><?=lang("caption")?></span>
								      			</div>

								      			<textarea class="form-control actionSaveActivity" name="repost_media[caption]"><?=get_option('igac_repost_media','{{caption}}')?></textarea>
								      			
								      			<ul class="small" style="padding-left: 20px; padding-top: 10px;">
								      				<li style="list-style: disc outside;"><?=lang("leave_empty_to_repost_without_a_caption")?></li>
								      				<li style="list-style: disc outside;">
								      					<?=lang("you_can_use_following_variables_in_the_caption_desc_note")?>
													</li>
								      			</ul>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>

								<div id="step-9" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-9">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-12">
								      		<div class="item multi-item">
								      			<div class="activity-left">
								      				<span class="text"><?=lang('tags')?></span>
								      				<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('activity_tags_desc')?>" data-delay-show="300" data-title="<?=lang('tags')?>"></i>
								      			</div>
								      			<?php
								      			$tags = get_value(json_decode($act), "tag");
								      			if(!empty($tags)){
								      			foreach ($tags as $key => $tag) {
								      				$tag = trim($tag);
												?>
												<a href="https://www.instagram.com/explore/tags/<?=$tag?>" target="_blank" class="activity-option-item activity-option-tag">
								      				<span><?=$tag?></span>
								      				<input type="hidden" name="tag[]" value="<?=$tag?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}?>

								      			<?php if($result->id == ""){
								      			$tags = get_option('igac_tags', "author\nvacation\ninstaart\nnature\ntasty\nmasterpiece\ncreative\nbestoftheday\npretty\nsiblings\nclouds\npage\nthrowbackthursday\ncuddle\ninstafollow\nlovely\nshoutout\ncute\ndraw");
								      			$tags = explode("\n", $tags);
												if(!empty($tags)){
													foreach ($tags as $tag) {
														$tag = trim($tag);
														if($tag != ""){
								      			?>
								      			<a href="https://www.instagram.com/explore/tags/<?=$tag?>" target="_blank" class="activity-option-item activity-option-tag">
								      				<span><?=$tag?></span>
								      				<input type="hidden" name="tag[]" value="<?=$tag?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}}}?>

								      			<div class="btn-group activity-add-tag">
												  	<a href="<?=cn("instagram/activity/popup/tag/".segment(4))?>" class="btn btn-grey ajaxModal"><?=lang('add')?></a>
												  	<div class="btn-group">
												    	<button type="button" class="btn btn-grey dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												    	<ul class="dropdown-menu dropdown-menu-right" role="menu">
												      		<li><a href="javascript:void(0);" class="activityDeleteAllOption"><?=lang('Delete_all_tags')?></a></li>
												    	</ul>
												  </div>
												</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>

								<div id="step-10" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-10">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-12">
								      		<div class="item multi-item">
								      			<div class="activity-left">
								      				<span class="text"><?=lang('locations')?></span>
								      				<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('activity_locations_desc')?>" data-delay-show="300" data-title="<?=lang('locations')?>"></i>
								      			</div>
								      			<?php
								      			$locations = get_value(json_decode($act), "location");
								      			if(!empty($locations)){
								      			foreach ($locations as $key => $location) {
								      				$location_array = explode("|", $location);
								      				if(count($location_array) == 2){
												?>
												<a href="https://www.instagram.com/explore/locations/<?=$location_array[0]?>" target="_blank" class="activity-option-item activity-option-location">
								      				<span><?=$location_array[1]?></span>
								      				<input type="hidden" name="location[]" value="<?=$location?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}}?>
								      			<div class="btn-group activity-add-location">
												  	<a href="<?=cn("instagram/activity/popup/location/".segment(4))?>" class="btn btn-grey ajaxModal"><?=lang('add')?></a>
												  	<div class="btn-group">
												    	<button type="button" class="btn btn-grey dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												    	<ul class="dropdown-menu dropdown-menu-right" role="menu">
												      		<li><a href="javascript:void(0);" class="activityDeleteAllOption"><?=lang('Delete_all_locations')?></a></li>
												    	</ul>
												  </div>
												</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>

								<div id="step-11" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-11">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-12">
								      		<div class="item multi-item">
								      			<div class="activity-left">
								      				<span class="text"><?=lang('usernames')?></span>
								      				<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('activity_usernames_desc')?>

													
								  
								      				" data-delay-show="300" data-title="<?=lang('usernames')?>"></i>
								      			</div>
								      			<?php
								      			$usernames = get_value(json_decode($act), "username");
								      			if(!empty($usernames)){
								      			foreach ($usernames as $key => $username) {
								      				$username_array = explode("|", $username);
								      				if(count($username_array) == 2){
												?>
												<a href="https://www.instagram.com/<?=$username_array[1]?>" target="_blank" class="activity-option-item activity-option-user">
													<img src="https://avatars.io/instagram/<?=$username_array[1]?>">
								      				<span><?=$username_array[1]?></span>
								      				<input type="hidden" name="username[]" value="<?=$username?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}}?>
								      			<div class="btn-group activity-add-username">
												  	<a href="<?=cn("instagram/activity/popup/username/".segment(4))?>" class="btn btn-grey ajaxModal"><?=lang('add')?></a>
												  	<div class="btn-group">
												    	<button type="button" class="btn btn-grey dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												    	<ul class="dropdown-menu dropdown-menu-right" role="menu">
												      		<li><a href="javascript:void(0);" class="activityDeleteAllOption"><?=lang('Delete_all_usernames')?></a></li>
												    	</ul>
												  </div>
												</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>

								<div id="step-12" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-12">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-12">
								      		<div class="item">
								      			<div class="activity-left">
								      				<span class="text"><?=lang('Tags_blacklist')?></span>
								      				<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('activity_tags_blacklist_desc')?>" data-delay-show="300" data-title="<?=lang('Tags_blacklist')?>"></i>
								      			</div>
								      			<?php
								      			$tags_blacklist = get_value(json_decode($act), "tag_blacklist");
								      			if(!empty($tags_blacklist)){
								      			foreach ($tags_blacklist as $key => $tag) {
								      				$tag = trim($tag);
												?>
												<a href="https://www.instagram.com/explore/tags/<?=$tag?>" target="_blank" class="activity-option-item activity-option-tag">
								      				<span><?=$tag?></span>
								      				<input type="hidden" name="tag_blacklist[]" value="<?=$tag?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}?>

								      			<?php if($result->id == ""){
									      			$tags_blacklist = get_option('igac_tags_blacklist', "sex\nxxx\nfuckyou\nvideoxxx\nnude");
												
								      			$tags_blacklist = explode("\n", $tags_blacklist);
												if(!empty($tags_blacklist)){
													foreach ($tags_blacklist as $tag) {
														$tag = trim($tag);
														if($tag != ""){
								      			?>
								      			<a href="https://www.instagram.com/explore/tags/<?=$tag?>" target="_blank" class="activity-option-item activity-option-tag">
								      				<span><?=$tag?></span>
								      				<input type="hidden" name="tag_blacklist[]" value="<?=$tag?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}}}?>

								      			<div class="btn-group activity-add-tag-blacklist">
												  	<a href="<?=cn("instagram/activity/popup/backlist_tag/".segment(4))?>" class="btn btn-grey ajaxModal"><?=lang('add')?></a>
												  	<div class="btn-group">
												    	<button type="button" class="btn btn-grey dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												    	<ul class="dropdown-menu dropdown-menu-right" role="menu">
												      		<li><a href="javascript:void(0);" class="activityDeleteAllOption"><?=lang('Delete_all_blacklisted_tags')?></a></li>
												    	</ul>
												  </div>
												</div>
								      		</div>
								      	</div>
								      	<div class="col-md-12">
								      		<div class="item">
								      			<div class="activity-left">
								      				<span class="text"><?=lang('Usernames_blacklist')?></span>
								      				<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('activity_usernames_blacklist_desc')?>" data-delay-show="300" data-title="<?=lang('Usernames_blacklist')?>"></i>
								      			</div>
								      			<?php
								      			$usernames_blacklist = get_value(json_decode($act), "username_blacklist");
								      			if(!empty($usernames_blacklist)){
								      			foreach ($usernames_blacklist as $key => $username) {
								      				$username_array = explode("|", $username);
								      				if(count($username_array) == 2){
												?>
												<a href="https://www.instagram.com/<?=$username_array[1]?>" target="_blank" class="activity-option-item activity-option-user">
													<img src="https://avatars.io/instagram/<?=$username_array[1]?>">
								      				<span><?=$username_array[1]?></span>
								      				<input type="hidden" name="username_blacklist[]" value="<?=$username?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}}?>
								      			<div class="btn-group activity-add-username-blacklist">
												  	<a href="<?=cn("instagram/activity/popup/backlist_username/".segment(4))?>" class="btn btn-grey ajaxModal"><?=lang('add')?></a>
												  	<div class="btn-group">
												    	<button type="button" class="btn btn-grey dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												    	<ul class="dropdown-menu dropdown-menu-right" role="menu">
												      		<li><a href="javascript:void(0);" class="activityDeleteAllOption"><?=lang('Delete_all_blacklisted_usernames')?></a></li>
												    	</ul>
												  </div>
												</div>
								      		</div>
								      	</div>
								      	<div class="col-md-12">
								      		<div class="item">
								      			<div class="activity-left">
								      				<span class="text"><?=lang('Keywords_blacklist')?></span>
								      				<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('activity_keyworks_blacklist_desc')?>" data-delay-show="300" data-title="<?=lang('Keywords_blacklist')?>"></i>
								      			</div>
								      			<?php
								      			$keywords_blacklist = get_value(json_decode($act), "keyword_blacklist");
								      			if(!empty($keywords_blacklist)){
								      			foreach ($keywords_blacklist as $key => $keyword) {
								      				$keyword = trim($keyword);
												?>
												<a href="javascript:void(0);" class="activity-option-item activity-option-keyword">
								      				<span><strike><?=$keyword?></strike></span>
								      				<input type="hidden" name="keyword_blacklist[]" value="<?=$keyword?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}?>

								      			<?php if($result->id == ""){
								      			$kewords_blacklist = get_option('igac_kewords_blacklist', "sex\nfuck now\nnude");
								      			$kewords_blacklist = explode("\n", $kewords_blacklist);
												if(!empty($kewords_blacklist)){
													foreach ($kewords_blacklist as $keyword) {
														$keyword = trim($keyword);
														if($keyword != ""){
								      			?>
								      			<a href="javascript:void(0);" class="activity-option-item activity-option-keyword">
								      				<span><strike><?=$keyword?></strike></span>
								      				<input type="hidden" name="keyword_blacklist[]" value="<?=$keyword?>">
								      				<button type="button" class="activity-button-x"><i class="ft-x"></i></button>
								      			</a>
								      			<?php }}}}?>

								      			<div class="btn-group activity-add-keyword">
								      				<a href="<?=cn("instagram/activity/popup/backlist_keyword/".segment(4))?>" class="btn btn-grey ajaxModal"><?=lang('add')?></a>
												  	<div class="btn-group">
												    	<button type="button" class="btn btn-grey dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												    	<ul class="dropdown-menu dropdown-menu-right" role="menu">
												      		<li><a href="javascript:void(0);" class="activityDeleteAllOption"><?=lang('Delete_all_blacklisted_keyworks')?></a></li>
												    	</ul>
												  </div>
												</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>

								<div id="step-13" class="tab-pane fade" role="tabpanel" aria-labelledby="step-tab-13">
						      		<div class="activity-option-list">
						      			<div class="row">
						      			<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Likes_counter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Auto_Stop_Likes_counter_desc')?>" data-delay-show="300" data-title="<?=lang('Likes_counter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="stop[like]" value="<?=igav("stop", $act, "like")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Comments_counter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Auto_Stop_Comments_counter_desc')?>" data-delay-show="300" data-title="<?=lang('Comments_counter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="stop[comment]" value="<?=igav("stop", $act, "comment")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Follows_counter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Auto_Stop_Follows_counter_desc')?>" data-delay-show="300" data-title="<?=lang('Follows_counter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="stop[follow]" value="<?=igav("stop", $act, "follow")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Unfollows_counter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Auto_Stop_Unfollows_counter_desc')?>" data-delay-show="300" data-title="<?=lang('Unfollows_counter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="stop[unfollow]" value="<?=igav("stop", $act, "unfollow")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Direct_messages_counter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Auto_Stop_Direct_messages_counter_desc')?>" data-delay-show="300" data-title="<?=lang('Direct_messages_counter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="stop[direct_message]" value="<?=igav("stop", $act, "direct_message")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('repost_media_counter')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Auto_Stop_repost_media_counter_desc')?>" data-delay-show="300" data-title="<?=lang('repost_media_counter')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="number" class="form-control actionSaveActivity" name="stop[repost_media]" value="<?=igav("stop", $act, "repost_media")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Timer')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Auto_Stop_Timer_desc')?>" data-delay-show="300" data-title="<?=lang('Timer')?>"></i>
								      			<div class="activity-option-input">
								      				<input type="text" class="form-control actionSaveActivity inpTimeLimit" name="stop[timer]" placeholder="00:00" maxlength="5" value="<?=igav("stop", $act, "timer")?>"/>
	                    						</div>
								      		</div>
								      	</div>
								      	<div class="col-md-6">
								      		<div class="item">
								      			<span class="text"><?=lang('Stop_if_no_activity')?></span>
								      			<i class="activity-option-help webuiPopover fa fa-question-circle" data-content="<?=lang('Auto_Stop_Likes_counter_desc')?>" data-delay-show="300" data-title="<?=lang('Stop_if_no_activity')?>"></i>
								      			<div class="activity-option-select">
												    <select class="form-control actionSaveActivity" name="stop[no_activity]">
								      					<option value="1h" <?=igav("stop", $act, "no_activity")=="1h"?"selected":"";?>>1 <?=lang('hour')?></option>
														<option value="3h" <?=igav("stop", $act, "no_activity")=="3h"?"selected":"";?>>3 <?=lang('hours')?></option>
														<option value="12h" <?=igav("stop", $act, "no_activity")=="12h"?"selected":"";?>>12 <?=lang('hours')?></option>
														<option value="1d" <?=igav("stop", $act, "no_activity")=="1d"?"selected":"";?>>1 <?=lang('day')?></option>
														<option value="3d" <?=igav("stop", $act, "no_activity")=="3d"?"selected":"";?>>3 <?=lang('Days_too_long')?></option>
														<option value="1w" <?=igav("stop", $act, "no_activity")=="1w"?"selected":"";?>>1 <?=lang('week_very_long_be_careful')?></option>
								      				</select>
	                    						</div>
								      		</div>
								      	</div>
						      			</div>
						      		</div>
								</div>
								</div>
							</div>
							</div>
						</div>
				  	</div>
				</div>
		    </div>
	  	</div>
	</div>	
</div>

<!--Schedule Days-->
<div id="schedule_days" class="modal fade" role="dialog">
  	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        	<h4 class="modal-title"><i class="ft-calendar" aria-hidden="true"></i> <?=lang('schedule')?></h4>
	      	</div>
	      	<div class="modal-body">

	      		<p class=""><?=lang('The_Schedule_allows_you_to_set_up_a_unique_schedule_by_time_and_day_for_your_system_activity_to_run_You_can_manually_select_individual_hours_when_your_activity_should_be_active_or_you_can_use_next_presets')?>
	      		</p>
	      		<div class="text-center day-schedule-auto">
	      			<a data-type="all" href="javascript:void(0);"><?=lang('All')?></a>
	      			<a data-type="day" href="javascript:void(0);"><?=lang('Daytime')?></a>
	      			<a data-type="night" href="javascript:void(0);"><?=lang('Nighttime')?></a>
	      			<a data-type="none" href="javascript:void(0);"><?=lang('None')?></a>

	      			<div class="type">
	      				<div class="item">
							<span class="box active"></span> <?=lang('Activity_started')?>    					
	      				</div>
	      				<div class="item">
							<span class="box"></span> <?=lang('Activity_paused')?>    					      					
	      				</div>
	      			</div>
	      		</div>

      			<div class="day-schedule-selector"></div>
      			<?php $schedule_default="[[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]]";?>
      			<input type="hidden" name="schedule_data" value='<?=($result->id != "")?get_value(json_decode($act), "schedule_days"):$schedule_default?>'>

	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-success" onclick="Instagram.saveActivity();" data-dismiss="modal"><?=lang('Save')?></button>
	        	<button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></button>
	      	</div>
	    </div>

  	</div>
</div>
</form>

<script type="text/javascript">
	$(function(){
		Instagram.ScheduleActivity();
		<?php if($result->id == ""){?>
			Instagram.saveActivity();
		<?php }?>
	});
</script>