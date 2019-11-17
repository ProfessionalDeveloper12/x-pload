<?php 
$successed = get_schedule_report(INSTAGRAM_POSTS, 2);
$failed = get_schedule_report(INSTAGRAM_POSTS, 3);
?>

<div class="lead"> <?=lang('post')?></div>

    <div class="row">
    <div class="col-md-8">
        <div class="card-body box-analytic">
            <canvas id="ig-post-line-stacked-area" height="300"></canvas>
            <script type="text/javascript">
            $(function(){
                Layout.lineChart(
                    "ig-post-line-stacked-area",
                    <?=$successed->date?>, 
                    [
                        <?=$successed->value?>,
                        <?=$failed->value?>
                    ],
                    [
                        "<?=lang('successed')?>",
                        "<?=lang('failed')?>"
                    ]
                );
            });
            </script>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body box-analytic">
            <canvas id="ig-post-chart-area" height="283"></canvas>
            <script type="text/javascript">
                $(function(){
                    Layout.pieChart(
                        "ig-post-chart-area",
                        ["<?=lang('photo')?>", "<?=lang('story_photo')?>", "<?=lang('carousel')?>"], 
                        [
                            <?=get_setting("ig_post_photo_count", 0)?>,
                            <?=get_setting("ig_post_story_count", 0)?>,
                            <?=get_setting("ig_post_carousel_count", 0)?>
                        ]
                    );
                });
            </script>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card-body box-analytic">
            <div class="media">
                <div class="media-body text-left w-100">
                    <h3 class="success"><?=get_setting("ig_post_success_count", 0)?></h3>
                    <span><?=lang('successed')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="ft-check-square success font-large-2 float-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body box-analytic">
            <div class="media">
                <div class="media-body text-left w-100">
                    <h3 class="danger"><?=get_setting("ig_post_error_count", 0)?></h3>
                    <span><?=lang('failed')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="ft-x-square danger font-large-2 float-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body box-analytic">
            <div class="media">
                <div class="media-body text-left w-100">
                    <h3 class="primary"><?=get_setting("ig_post_error_count", 0) + get_setting("ig_post_success_count", 0)?></h3>
                    <span><?=lang('completed')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="ft-pocket primary font-large-2 float-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>