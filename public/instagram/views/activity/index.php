<div class="wrap-content container instagram-app">
	<div class="activity-filter">
		<form class="form-inline pull-right">
		  	<div class="form-group">
		  		<label>&nbsp; <?=lang('sort:')?> </label>
		    	<select class="form-control activityFilterAction" name="type">
		    		<option value="" <?=get("type")==""?"selected":""?>>-</option>
		    		<option value="username" <?=get("type")=="username"?"selected":""?>> <?=lang('username')?></option>
		    		<option value="time" <?=get("type")=="time"?"selected":""?>> <?=lang('time')?></option>
		    	</select>
		  	</div>
		  	<div class="form-group">
		  		<label>&nbsp; <?=lang('filter:')?> </label>
		    	<select class="form-control activityFilterAction" name="time">
		    		<option value="">-</option>
		    		<option value="started" <?=get("time")=="started"?"selected":""?>> <?=lang('Started')?></option>
		    		<option value="stoped" <?=get("time")=="stoped"?"selected":""?>> <?=lang('Stopped')?></option>
		    		<option value="none" <?=get("time")=="none"?"selected":""?>> <?=lang('No_time')?></option>
		    	</select>
		  	</div>
		  	<div class="form-group">
		  		<label>&nbsp; Search </label>
		    	<div class="input-group">
			      	<input type="text" class="form-control" name="q" placeholder="<?=lang('enter_keyword')?>" value="<?=get("q")?>">
			      	<span class="input-group-btn">
			        	<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> <?=lang('search')?></button>
			      	</span>
			    </div>
		  	</div>
		</form>
		<div class="clearfix"></div>
	</div>
	<div class="row">
		<?php if(!empty($activities)){
		foreach ($activities as $key => $row) {
		?>
		<div class="col-lg-4 col-md-4 mb15">
			<div class="activity-profile">
				<div class="activity-profile-header">
					<div class="info">
						<img src="<?=$row->avatar?>" class="img-rounded">
						<span class="brand">instagram</span>
						<span class="username"><?=$row->username?></span>
					</div>
					<div class="clearfix"></div>
					<i class="fa fa-instagram" aria-hidden="true"></i>
				</div>
				<div class="activity-profile-content">
					<div class="status">
						<?=lang('status')?> <?=igas($row)?>
					</div>
					<ul class="list-group">
					  	<li class="list-group-item"> <?=lang('like')?>  
					  		<?php if(ig_get_setting("like_block", "", $row->id) != ""){?>
			      			<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("like_block", "", $row->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
			      			<?php }?>
					  		<span class="badge"><?=igac("like", $row->settings)?></span>
					  	</li>
					  	<li class="list-group-item"> <?=lang('comment')?> 
					  		<?php if(ig_get_setting("comment_block", "", $row->id) != ""){?>
					  		<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("comment_block", "", $row->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
			      			<?php }?>
					  		<span class="badge"><?=igac("comment", $row->settings)?></span>
					  	</li> 
					  	<li class="list-group-item"> <?=lang('follow')?> 
					  		<?php if(ig_get_setting("follow_block", "", $row->id) != ""){?>
					  		<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("follow_block", "", $row->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
			      			<?php }?>
					  		<span class="badge"><?=igac("follow", $row->settings)?></span>
					  	</li> 
					  	<li class="list-group-item"> <?=lang('unfollow')?> 
					  		<?php if(ig_get_setting("unfollow_block", "", $row->id) != ""){?>
					  		<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("unfollow_block", "", $row->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
			      			<?php }?>
					  		<span class="badge"><?=igac("unfollow", $row->settings)?></span>
					  	</li> 
					  	<li class="list-group-item"> <?=lang('direct_message')?>
					  		<?php if(ig_get_setting("direct_message_block", "", $row->id) != ""){?>
					  		<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("direct_message_block", "", $row->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
			      			<?php }?>
					  		<span class="badge"><?=igac("direct_message", $row->settings)?></span>
					  	</li> 
					  	<li class="list-group-item"> <?=lang('repost_medias')?>
					  		<?php if(ig_get_setting("direct_message_block", "", $row->id) != ""){?>
					  		<i class="activity-option-help webuiPopover fa fa-exclamation-circle warning" data-content="<?=ig_get_setting("repost_media_block", "", $row->id);?>" data-delay-show="300" data-title="<span class='warning'><?=lang("Warning")?><span>"></i>
			      			<?php }?>
					  		<span class="badge"><?=igac("repost_media", $row->settings)?></span>
					  	</li> 
					</ul>
				</div>
				<div class="activity-profile-footer">
					<div class="btn-group btn-group-justified">
					<?php if($row->status != ""  && $row->status != 2){?>
						<?php if($row->status == 1){?>
						<a href="<?=cn("instagram/activity/stop/".$row->ids)?>" class="btn btn-grey btnActivityStop"> <?=lang('stop')?></a>
						<?php }else{?>
						<a href="<?=cn("instagram/activity/start/".$row->ids)?>" class="btn btn-primary btnActivityStart"> <?=lang('start')?></a>
						<?php }?>
						<a href="<?=cn("instagram/activity/settings/".$row->ids)?>" class="btn btn-grey"> <?=lang('settings')?></a>
						<div class="btn-group">
							<button type="button" class="btn btn-grey dropdown-toggle" data-toggle="dropdown"> <?=lang('more')?> <span class="caret"></span></button>
							<ul class="dropdown-menu  dropdown-menu-right" role="menu">
								<li><a href="<?=cn("instagram/activity/log/".$row->ids)?>"> <?=lang('log')?></a></li>
								<li><a href="<?=cn("instagram/activity/profile/".$row->ids)?>"> <?=lang('profile')?></a></li>
							</ul>
						</div>
					<?php }else{?>
						<a href="<?=cn("instagram/activity/settings/".$row->ids)?>" class="btn btn-grey"> <?=lang('settings')?></a>
					<?php }?>
					</div>
				</div>	
			</div>
		</div>
		<?php }}else{?>

		<div class="dataTables_empty"></div>

		<?php }?>
	</div>
</div>