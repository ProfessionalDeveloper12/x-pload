<section class="pricing-one" id="pricing">
    <div class="container">
        <div class="block-title text-center">
            <div class="block-title__text"><span><?=lang("pricing")?></span> <br> <span><?=lang('pick_the_best_plan_for_you')?></span></div><!-- /.block-title__text -->
        </div><!-- /.block-title -->
        
        <div class="tab-content">
	        <div class="tab-pane fade show active" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab">
		        <div class="row">
			        <?php if(!empty($package)){
					$i = 0;
			        $social_list = load_social_list();
			        foreach ($package as $key => $row) {

						$package_name = strtolower($row->name);
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
					 
					 <div class="col-lg-4 pricing-relative">
							<ul class="nav nav-tabs tab-title" id="<?=$package_name?>-package-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="<?=$package_name?>-monthly-tab" data-toggle="pill" href="#<?=$package_name?>-monthly" role="tab" aria-controls="<?=$package_name?>-monthly" aria-selected="true"><?=lang("monthly")?></a>
								</li>
								<li class="nav-item">
									<a class="nav-link " id="<?=$package_name?>-anually-tab" data-toggle="pill" href="#<?=$package_name?>-anually" role="tab" aria-controls="<?=$package_name?>-anually" aria-selected="true"><?=lang("yearly")?></a>
								</li>
							</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active" id="<?=$package_name?>-monthly" role="tabpanel" aria-labelledby="<?=$package_name?>-monthly">
								<div class="pricing-one__single <?=$package_name?>-package">
									<div class="pricing-one__top">
										<h3 class="pricing-one__title">$<?=$pricing_monthly_explode[0]?>.<?=$pricing_monthly_explode[1]?> <sup><?=get_option('payment_symbol','$')?></h3>
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
										<li class="pricing-one__feature-item"> <?=lang('add_new_followers_per_day')?> <strong class="text-primary"><?=get_value($permission, "add_followers")?> </strong></li>
										<li class="pricing-one__feature-item <?=in_array("image_library", $permission)?"":"no"?>"> <?=lang('image_library')?> </li>
										<li class="pricing-one__feature-item <?=in_array("private_group", $permission)?"":"no"?>"> <?=lang('private_group')?></li>
										<li class="pricing-one__feature-item <?=in_array("growth_building_webinar", $permission)?"":"no"?>"> <?=lang('private_weekly_growth_building_webinar')?></li>

									</ul><!-- /.pricing-one__feature -->
									<a href="<?=(session("uid"))?cn('payment/'.$row->ids.'?type=1'):cn("auth/login?redirect=payment/".$row->ids.'?type=1')?>" class="pricing-one__btn"><?=lang('start_now')?></a>
								</div><!-- /.pricing-one__single -->
							</div>
							<!-- ----------------------------------------------- -->
							<div class="tab-pane fade" id="<?=$package_name?>-anually"  role="tabpanel" aria-labelledby="<?=$package_name?>-anually">
								<div class="pricing-one__single <?=$package_name?>-package">
									<div class="pricing-one__top">
									<h3 class="pricing-one__title">$<?=$pricing_anually?> <sup><?=get_option('payment_symbol','$')?></h3>
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
										<li class="pricing-one__feature-item"> <?=lang('add_new_followers_per_day')?> <strong class="text-primary"><?=get_value($permission, "add_followers")?> </strong></li>
										<li class="pricing-one__feature-item <?=in_array("image_library", $permission)?"":"no"?>"> <?=lang('image_library')?> </li>
										<li class="pricing-one__feature-item <?=in_array("private_group", $permission)?"":"no"?>"> <?=lang('private_group')?></li>
										<li class="pricing-one__feature-item <?=in_array("growth_building_webinar", $permission)?"":"no"?>"> <?=lang('private_weekly_growth_building_webinar')?></li>

									</ul><!-- /.pricing-one__feature -->
									<a href="<?=(session("uid"))?cn('payment/'.$row->ids.'?type=2'):cn("auth/login?redirect=payment/".$row->ids.'?type=2')?>" class="pricing-one__btn "><?=lang('start_now')?></a>
								</div><!-- /.pricing-one__single -->
							</div>
						</div>
					 </div>
		            <?php }}?>
		        </div><!-- /.row -->
		    </div>
	    </div>
    </div><!-- /.container -->
</section><!-- /.pricing-one -->