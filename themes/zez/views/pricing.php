<?=Modules::run(get_theme()."/header")?>

    <!-- Main -->
    <main>
        
        <!--Pricing-->
        <section id="pricing" class="price pt-5">
            <div class="container">
                <div class="row justify-content-center m-45px-b md-m-25px-b">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="section-title aniview-stop" data-av-animation="pulse">
                            <h2 class="title"><?=lang("pricing")?></h2>
                            <p><?=lang('pick_the_best_plan_for_you')?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="price-tab">
                <ul class="nav justify-content-center m-15px-b" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-month-tab" data-toggle="pill" href="#pills-month" role="tab" aria-controls="pills-month" aria-selected="true"><?=lang("monthly")?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-year-tab" data-toggle="pill" href="#pills-year" role="tab" aria-controls="pills-year" aria-selected="false"><?=lang("yearly")?></a>
                    </li>
                </ul>

                <div class="container">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab">
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
                                <div class="col-md-4">
                                    <div class="price-table aniview-stop" data-av-animation="bounceInUp">
                                        <div class="price-header">
                                            <h4 class="price-title"><?=$row->name?></h4>
                                            <p><?=$row->description?></p>
                                            <div class="price-price">
                                                <div class="price-value theme2nd-color">
                                                    <?=$pricing_monthly_explode[0]?>.<?=$pricing_monthly_explode[1]?> <sup><?=get_option('payment_symbol')?></i></sup>
                                                </div>
                                                <small><?=lang("per_active_user_monthly")?></small>
                                                <small class="text-warning"><?=sprintf(lang("save_x_on_annually"), $pricing_discount." ".get_option('payment_currency'));?></small>
                                            </div>
                                        </div>
                                        <div class="price-body">
                                            <div class="price-info">
                                                <?=sprintf(lang('add_up_to_social_accounts'),$social_count*$row->number_accounts)?> <br/>
                                                <div class="small">(<?=sprintf(lang('social_account_on_each_platform'),$row->number_accounts)?>)</div>
                                            </div>
                                            <ul>
                                                <?php 
                                                if(!empty($social_list)){
                                                    foreach ($social_list as $key => $name) {
                                                        $name = str_replace(" ", "_", strtolower($name));
                                                ?>
                                                <li class="<?=in_array($name, $social_list_permission)?"":"no"?>"><b><?=lang(strtolower($name))?></b> <?=lang('scheduling_automation')?></li>
                                                <?php }}?>
                                                <li> <?=lang('premium_support')?></li>
                                                <li> <?=lang('spintax_support')?></li>
                                                <li class="<?=in_array("watermark", $permission)?"":"no"?>"> <?=lang('watermark_support')?></li>
                                                <li class="<?=in_array("image_editor", $permission)?"":"no"?>"> <?=lang("image_editor_support")?></li>
                                                <li> <?=lang('cloud_import')?>: 
                                                    <?php if(in_array("google_drive",$permission) || in_array("dropbox",$permission)){?>
                                                    <strong class="filetype note <?=in_array("google_drive",$permission)?"text-primary":"text-muted"?>"><?=lang("google_drive")?></strong>, 
                                                    <strong class="filetype note <?=in_array("dropbox", $permission)?"text-primary":"text-muted"?>"><?=lang("dropbox")?></strong>
                                                    <?php }else{?>
                                                    <span class="note"><?=lang('not_available')?></span>
                                                    <?php }?>
                                                </li>

                                                <li> <?=lang('file_type_support')?>:
                                                    <?php if(in_array("photo_type",$permission) || in_array("video_type",$permission)){?>
                                                    <strong class="filetype note <?=in_array("photo_type",$permission)?"text-primary":"text-muted"?>"><?=lang("photo")?></strong>, 
                                                    <strong class="filetype note <?=in_array("video_type", $permission)?"text-primary":"text-muted"?>"><?=lang("video")?></strong>
                                                    <?php }else{?>
                                                    <span class="note"><?=lang('not_available')?></span>
                                                    <?php }?>
                                                </li>
                                                <li> <?=lang('max_storage_size_ouput')?> <strong class="text-primary"><?=get_value($permission, "max_storage_size")?> <?=lang("mb")?></strong></li>
                                                <li> <?=lang('max_file_size_output')?> <strong class="text-primary"><?=get_value($permission, "max_file_size")?> <?=lang("mb")?></strong></li>
                                            </ul>
                                          </div>
                                        <div class="price-footer">
                                            <a href="<?=(session("uid"))?cn('payment/'.$row->ids.'?type=1'):cn("auth/login?redirect=payment/".$row->ids.'?type=1')?>" class="btn btn-dark btn-lg btn-block"><?=lang('upgrade_now')?></a>
                                        </div>
                                    </div>
                                </div>  
                                <?php }}?>

                            </div>
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
                                <div class="col-md-4">
                                    <div class="price-table aniview-stop" data-av-animation="bounceInUp">
                                        <div class="price-header">
                                            <h4 class="price-title"><?=$row->name?></h4>
                                            <p><?=$row->description?></p>
                                            <div class="price-price">
                                                <div class="price-value theme2nd-color">
                                                    <?=$pricing_anually?> <sup><?=get_option('payment_symbol')?></i></sup>
                                                </div>
                                                <small><?=lang("per_active_user_monthly")?></small>
                                                <small class="text-warning"><?=sprintf(lang("save_x_on_annually"), $pricing_discount." ".get_option('payment_currency'));?></small>
                                            </div>
                                        </div>
                                        <div class="price-body">
                                            <div class="price-info">
                                                <?=sprintf(lang('add_up_to_social_accounts'),$social_count*$row->number_accounts)?> <br/>
                                                <div class="small">(<?=sprintf(lang('social_account_on_each_platform'),$row->number_accounts)?>)</div>
                                            </div>
                                            <ul>
                                                <?php 
                                                if(!empty($social_list)){
                                                    foreach ($social_list as $key => $name) {
                                                        $name = str_replace(" ", "_", strtolower($name));
                                                ?>
                                                <li class="<?=in_array($name, $social_list_permission)?"":"no"?>"><b><?=lang(strtolower($name))?></b> <?=lang('scheduling_automation')?></li>
                                                <?php }}?>
                                                <li> <?=lang('premium_support')?></li>
                                                <li> <?=lang('spintax_support')?></li>
                                                <li class="<?=in_array("watermark", $permission)?"":"no"?>"> <?=lang('watermark_support')?></li>
                                                <li class="<?=in_array("image_editor", $permission)?"":"no"?>"> <?=lang("image_editor_support")?></li>
                                                <li> <?=lang('cloud_import')?>: 
                                                    <?php if(in_array("google_drive",$permission) || in_array("dropbox",$permission)){?>
                                                    <strong class="filetype note <?=in_array("google_drive",$permission)?"text-primary":"text-muted"?>"><?=lang("google_drive")?></strong>, 
                                                    <strong class="filetype note <?=in_array("dropbox", $permission)?"text-primary":"text-muted"?>"><?=lang("dropbox")?></strong>
                                                    <?php }else{?>
                                                    <span class="note"><?=lang('not_available')?></span>
                                                    <?php }?>
                                                </li>

                                                <li> <?=lang('file_type_support')?>:
                                                    <?php if(in_array("photo_type",$permission) || in_array("video_type",$permission)){?>
                                                    <strong class="filetype note <?=in_array("photo_type",$permission)?"text-primary":"text-muted"?>"><?=lang("photo")?></strong>, 
                                                    <strong class="filetype note <?=in_array("video_type", $permission)?"text-primary":"text-muted"?>"><?=lang("video")?></strong>
                                                    <?php }else{?>
                                                    <span class="note"><?=lang('not_available')?></span>
                                                    <?php }?>
                                                </li>
                                                <li> <?=lang('max_storage_size_ouput')?> <strong class="text-primary"><?=get_value($permission, "max_storage_size")?> <?=lang("mb")?></strong></li>
                                                <li> <?=lang('max_file_size_output')?> <strong class="text-primary"><?=get_value($permission, "max_file_size")?> <?=lang("mb")?></strong></li>
                                            </ul>
                                          </div>
                                        <div class="price-footer">
                                            <a href="<?=(session("uid"))?cn('payment/'.$row->ids.'?type=2'):cn("auth/login?redirect=payment/".$row->ids.'?type=2')?>" class="btn btn-dark btn-lg btn-block"><?=lang('upgrade_now')?></a>
                                        </div>
                                    </div>
                                </div>  
                                <?php }}?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
        <!--Pricing End-->
        
    </main>
    <!-- Main End -->

<?=Modules::run(get_theme()."/footer")?>