<section class="pricing-one" id="pricing">
    <div class="container">
        <div class="block-title text-center">
            <div class="block-title__text"><span><?=lang("pricing")?></span> <br> <span><?=lang('pick_the_best_plan_for_you')?></span></div><!-- /.block-title__text -->
        </div><!-- /.block-title -->
        <!-- <ul class="nav nav-tabs tab-title" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-month-tab" data-toggle="pill" href="#pills-month" role="tab" aria-controls="pills-month" aria-selected="true"><?=lang("monthly")?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-year-tab" data-toggle="pill" href="#pills-year" role="tab" aria-controls="pills-year" aria-selected="false"><?=lang("yearly")?></a>
            </li>
        </ul> -->
        <div class="tab-content">
	        <div class="tab-pane fade show active" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab">
		        <div class="row">
			        <?php if(!empty($package)){
					$i = 0;
			        $social_list = load_social_list();
			        foreach ($package as $key => $row) {
			            $pricing_monthly = number_format($row->price_monthly,2);
			            $pricing_monthly_explode = explode(".", $pricing_monthly);
			            $pricing_anually = number_format($row->price_annually,2);
			            $pricing_discount = number_format(($row->price_monthly - $row->price_annually)*12, 2);
			            $permission = (array)json_decode($row->permission);
			
			            $social_list_permission = array();
			            foreach ($social_list as $name) {
			                $name = str_replace(" ", "_", strtolower($name));
			                if((in_array(strtolower($name)."_enable",$permission))){
			                    $social_list_permission[] = $name;
			                }
			            }
						$social_count = count($social_list_permission);
						$i++;
			         ?>
		            <div class="col-lg-4">
		                <div class="pricing-one__single">
		                    <div class="pricing-one__top">
								<h3 class="pricing-one__title">$<?=$pricing_monthly_explode[0]?>.<?=$pricing_monthly_explode[1]?> <sup><?=get_option('payment_symbol','$')?></h3>
								<p class="switch-block">
									<span class="pricing-pill-radio">
										<label><input type="radio" name="pricing-switch-radio-<?=$i?>" checked >Monthly</label>
									</span>
									<span class="pricing-pill-radio">
										<label><input type="radio" name="pricing-switch-radio-<?=$i?>">Yearly</label>
									</span>
								</p>
		                        <p class="pricing-one__pack"><?=$row->name?></p><!-- /.pricing-one__pack -->
		                        <small><?=lang("per_active_user_monthly")?></small>
		                        <small class="text-warning"><?=sprintf(lang("save_x_on_annually"), $pricing_discount." ".get_option('payment_currency'));?></small>
		                    </div><!-- /.pricing-one__top -->
		                    <div class="price-info">
		                        <?=sprintf(lang('add_up_to_social_accounts'),$social_count*$row->number_accounts)?> <br/>
			                    <div class="small">(<?=sprintf(lang('social_account_on_each_platform'),$row->number_accounts)?>)</div>
		                    </div>
		                    <ul class="pricing-one__feature">
			                    <?php 
			                    if(!empty($social_list)){
			                        foreach ($social_list as $key => $name) {
			                            $name = str_replace(" ", "_", strtolower($name));
			                    ?>
			                    <li class="pricing-one__feature-item <?=in_array($name, $social_list_permission)?"":"no"?>"><b><?=lang(strtolower($name))?></b> <?=lang('scheduling_automation')?></li>
			                    <?php }}?>
			                    <li class="pricing-one__feature-item"> <?=lang('premium_support')?></li>
			                    <li class="pricing-one__feature-item"> <?=lang('spintax_support')?></li>
			                    <li class="pricing-one__feature-item <?=in_array("watermark", $permission)?"":"no"?>"> <?=lang('watermark_support')?></li>
			                    <li class="pricing-one__feature-item <?=in_array("image_editor", $permission)?"":"no"?>"> <?=lang("image_editor_support")?></li>
			                    <li class="pricing-one__feature-item"> <?=lang('cloud_import')?>: 
			                        <?php if(in_array("google_drive",$permission) || in_array("dropbox",$permission)){?>
			                        <strong class="filetype note <?=in_array("google_drive",$permission)?"text-primary":"text-muted"?>"><?=lang("google_drive")?></strong>, 
			                        <strong class="filetype note <?=in_array("dropbox", $permission)?"text-primary":"text-muted"?>"><?=lang("dropbox")?></strong>
			                        <?php }else{?>
			                        <span class="note"><?=lang('not_available')?></span>
			                        <?php }?>
			                    </li>
			
			                    <li class="pricing-one__feature-item"> <?=lang('file_type_support')?>:
			                        <?php if(in_array("photo_type",$permission) || in_array("video_type",$permission)){?>
			                        <strong class="filetype note <?=in_array("photo_type",$permission)?"text-primary":"text-muted"?>"><?=lang("photo")?></strong>, 
			                        <strong class="filetype note <?=in_array("video_type", $permission)?"text-primary":"text-muted"?>"><?=lang("video")?></strong>
			                        <?php }else{?>
			                        <span class="note"><?=lang('not_available')?></span>
			                        <?php }?>
			                    </li>
			                    <li class="pricing-one__feature-item"> <?=lang('max_storage_size_ouput')?> <strong class="text-primary"><?=get_value($permission, "max_storage_size")?> <?=lang("mb")?></strong></li>
								<li class="pricing-one__feature-item"> <?=lang('max_file_size_output')?> <strong class="text-primary"><?=get_value($permission, "max_file_size")?> <?=lang("mb")?></strong></li>
								<li class="pricing-one__feature-item"> <?=lang('add_new_followers_per_day')?> <strong class="text-primary"><?=get_value($permission, "add_new_followers_per_day")?> </strong></li>
								<?php //if ($i == 3) { ?>
									<li class="pricing-one__feature-item"> <?=lang('image_library')?> <strong class="text-primary"> </strong></li>
									<li class="pricing-one__feature-item"> <?=lang('private_group_live_training')?> <strong class="text-primary"> </strong></li>
								<?php //}?>
		                    </ul><!-- /.pricing-one__feature -->
		                    <a href="<?=(session("uid"))?cn('payment/'.$row->ids.'?type=1'):cn("auth/login?redirect=payment/".$row->ids.'?type=1')?>" class="pricing-one__btn"><?=lang('start_now')?></a>
		                </div><!-- /.pricing-one__single -->
		            </div><!-- /.col-lg-4 -->
		            <?php }}?>
		        </div><!-- /.row -->
		    </div>
		    <div class="tab-pane fade" id="pills-year" role="tabpanel" aria-labelledby="pills-year-tab">
			    <div class="row">
				    <?php if(!empty($package)){
	                $social_list = load_social_list();
	                foreach ($package as $key => $row) {
	                    $pricing_monthly = number_format($row->price_monthly,2);
	                    $pricing_monthly_explode = explode(".", $pricing_monthly);
	                    $pricing_anually = number_format($row->price_annually,2);
	                    $pricing_discount = number_format(($row->price_monthly - $row->price_annually)*12, 2);
	                    $permission = (array)json_decode($row->permission);
	
	                    $social_list_permission = array();
	                    foreach ($social_list as $name) {
	                        $name = str_replace(" ", "_", strtolower($name));
	                        if((in_array(strtolower($name)."_enable",$permission))){
	                            $social_list_permission[] = $name;
	                        }
	                    }
	                    $social_count = count($social_list_permission);
	                 ?>
			            <div class="col-lg-4">
			                <div class="pricing-one__single">
			                    <div class="pricing-one__top">
			                        <h3 class="pricing-one__title"><?=$pricing_anually?> <sup><?=get_option('payment_symbol','$')?></h3>
			                        <p class="pricing-one__pack"><?=$row->name?></p><!-- /.pricing-one__pack -->
			                        <small><?=lang("per_active_user_monthly")?></small>
			                        <small class="text-warning"><?=sprintf(lang("save_x_on_annually"), $pricing_discount." ".get_option('payment_currency'));?></small>
			                    </div><!-- /.pricing-one__top -->
			                    <div class="price-info">
			                        <?=sprintf(lang('add_up_to_social_accounts'),$social_count*$row->number_accounts)?> <br/>
				                    <div class="small">(<?=sprintf(lang('social_account_on_each_platform'),$row->number_accounts)?>)</div>
			                    </div>
			                    <ul class="pricing-one__feature">
				                    <?php 
	                                if(!empty($social_list)){
	                                    foreach ($social_list as $key => $name) {
	                                        $name = str_replace(" ", "_", strtolower($name));
	                                ?>
				                    <li class="pricing-one__feature-item <?=in_array($name, $social_list_permission)?"":"no"?>"><b><?=lang(strtolower($name))?></b> <?=lang('scheduling_automation')?></li>
				                    <?php }}?>
				                    <li class="pricing-one__feature-item"> <?=lang('premium_support')?></li>
				                    <li class="pricing-one__feature-item"> <?=lang('spintax_support')?></li>
				                    <li class="pricing-one__feature-item <?=in_array("watermark", $permission)?"":"no"?>"> <?=lang('watermark_support')?></li>
				                    <li class="pricing-one__feature-item <?=in_array("image_editor", $permission)?"":"no"?>"> <?=lang("image_editor_support")?></li>
				                    <li class="pricing-one__feature-item"> <?=lang('cloud_import')?>: 
				                        <?php if(in_array("google_drive",$permission) || in_array("dropbox",$permission)){?>
				                        <strong class="filetype note <?=in_array("google_drive",$permission)?"text-primary":"text-muted"?>"><?=lang("google_drive")?></strong>, 
				                        <strong class="filetype note <?=in_array("dropbox", $permission)?"text-primary":"text-muted"?>"><?=lang("dropbox")?></strong>
				                        <?php }else{?>
				                        <span class="note"><?=lang('not_available')?></span>
				                        <?php }?>
				                    </li>
				
				                    <li class="pricing-one__feature-item"> <?=lang('file_type_support')?>:
				                        <?php if(in_array("photo_type",$permission) || in_array("video_type",$permission)){?>
				                        <strong class="filetype note <?=in_array("photo_type",$permission)?"text-primary":"text-muted"?>"><?=lang("photo")?></strong>, 
				                        <strong class="filetype note <?=in_array("video_type", $permission)?"text-primary":"text-muted"?>"><?=lang("video")?></strong>
				                        <?php }else{?>
				                        <span class="note"><?=lang('not_available')?></span>
				                        <?php }?>
				                    </li>
				                    <li class="pricing-one__feature-item"> <?=lang('max_storage_size_ouput')?> <strong class="text-primary"><?=get_value($permission, "max_storage_size")?> <?=lang("mb")?></strong></li>
				                    <li class="pricing-one__feature-item"> <?=lang('max_file_size_output')?> <strong class="text-primary"><?=get_value($permission, "max_file_size")?> <?=lang("mb")?></strong></li>
			                    </ul><!-- /.pricing-one__feature -->
			                    <a href="<?=(session("uid"))?cn('payment/'.$row->ids.'?type=2'):cn("auth/login?redirect=payment/".$row->ids.'?type=2')?>" class="pricing-one__btn btn btn-dark btn-lg btn-block"><?=lang('upgrade_now')?></a>
			                </div><!-- /.pricing-one__single -->
			            </div><!-- /.col-lg-4 -->
	                 <?php }}?>
			    </div>
		    </div>
	    </div>
    </div><!-- /.container -->
</section><!-- /.pricing-one -->