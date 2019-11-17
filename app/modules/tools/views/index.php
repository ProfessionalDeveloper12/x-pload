<div class="wrap-content container tab-list">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card watermark-box">
                <form action="<?=cn("tools/ajax_upload_watermark")?>" class="actionForm">
                <div class="card-header">
                    <div class="card-title">
                        <i class="ft-award" aria-hidden="true"></i> <?=lang("watermark")?>
                        <div class="pull-right" style="position: relative; top: -7px;">
                            <div class="upload-btn-wrapper">
                                <button class="btn btn-primary"><i class="ft-upload"></i> <?=lang("upload_image")?></button>
                                <input type="file" class="form-control-file upload-watermark" id="upload_watermark" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-block p0">
                    <div class="tab-content p15">
                        <div class="row">
                            <div class="col-md-5 col-sm-5 mb15">
                                <div class="wt-image">
                                    <img src="<?=BASE?>assets/img/bg-watermark.jpg">
                                    <?php 
                                        $watermark = get_setting("watermark_image", "", session("uid"));
                                        $size = get_setting("watermark_size", 30, session("uid"));
                                        $opacity = get_setting("watermark_opacity", 70, session("uid"));
                                        $position = get_setting("watermark_position", "lb", session("uid"));
                                    ?>
                                    <img class="wt-render" src="<?=$watermark!=""?$watermark:BASE."assets/img/watermark.png?<?=ids()?>"?>" >
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-7">
                                <div class="wt-option">
                                    <form>
                                        
                                        <div class="form-group wt-position-box">
                                            <span><?=lang("position")?></span>
                                            <div class="wt-positions">
                                                <div class="wt-position-item pos-lt <?=$position=="lt"?"active":""?>" data-direction="lt"></div>
                                                <div class="wt-position-item pos-ct <?=$position=="ct"?"active":""?>" data-direction="ct"></div>
                                                <div class="wt-position-item pos-rt <?=$position=="rt"?"active":""?>" data-direction="rt"></div>
                                                <div class="wt-position-item pos-lc <?=$position=="lc"?"active":""?>" data-direction="lc"></div>
                                                <div class="wt-position-item pos-cc <?=$position=="cc"?"active":""?>" data-direction="cc"></div>
                                                <div class="wt-position-item pos-rc <?=$position=="rc"?"active":""?>" data-direction="rc"></div>
                                                <div class="wt-position-item pos-lb <?=$position=="lb"?"active":""?>" data-direction="lb"></div>
                                                <div class="wt-position-item pos-cb <?=$position=="cb"?"active":""?>" data-direction="cb"></div>
                                                <div class="wt-position-item pos-rb <?=$position=="rb"?"active":""?>" data-direction="rb"></div>
                                                <input type="hidden" class="wt-position form-control" name="position" value="<?=$position?>">
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="wt-custom-box">
                                            <div class="form-group">
                                                <span><?=lang("size")?></span>
                                                <input type="range" name="size" class="rangeslider hide wt-size" min="0" max="100" step="1" value="<?=$size?>" data-rangeslider data-orientation="vertical" >
                                            </div>
                                            <div class="form-group">
                                                <span><?=lang("transparent")?></span>
                                                <input type="range" name="opacity" class="rangeslider hide wt-transparent" min="0" max="100" step="1" value="<?=$opacity?>" data-orientation="vertical" >
                                            </div> 
                                        </div>     
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?=cn("tools/ajax_delete_watermark")?>" data-redirect="<?=current_url()?>" class="btn btn-danger actionItem"> <?=lang("delete")?></a>
                    <button type="submit" class="btn btn-primary btnAction btnUploadWatermark"> <?=lang("apply")?></button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>