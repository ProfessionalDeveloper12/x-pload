<div class="lead"> <?=lang('Auto_activity')?></div>

<div class="row">
    <div class="col-md-8">
        <div class="card-body box-analytic">
            <canvas id="ig-activity-line-stacked-area" height="300"></canvas>
            <script type="text/javascript">
            $(function(){
                Layout.lineChart(
                    "ig-activity-line-stacked-area",
                    <?=$stats_like->date?>, 
                    [
                        <?=$stats_like->value?>,
                        <?=$stats_comment->value?>,
                        <?=$stats_follow->value?>,
                        <?=$stats_unfollow->value?>,
                        <?=$stats_direct_message->value?>,
                        <?=$stats_repost_media->value?>
                    ],
                    [
                        "<?=lang('likes')?>",
                        "<?=lang('comments')?>",
                        "<?=lang('follows')?>",
                        "<?=lang('unfollows')?>",
                        "<?=lang('direct_messages')?>",
                        "<?=lang('repost_medias')?>"
                    ]
                , "line");
            });
            </script>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body box-analytic">
            <canvas id="ig-activity-chart-area" height="283"></canvas>
            <script type="text/javascript">
                $(function(){
                    <?php $total = $counter->like + $counter->comment + $counter->follow + $counter->unfollow + $counter->direct_message?>
                    Layout.pieChart(
                        "ig-activity-chart-area",
                        ["<?=lang('likes')?>", "<?=lang('comments')?>", "<?=lang('follows')?>", "<?=lang('unfollows')?>", "<?=lang('direct_messages')?>", "<?=lang('repost_medias')?>"], 
                        [
                            <?=$counter->like!=0?round($counter->like/$total, 3)*100:0?>,
                            <?=$counter->comment!=0?round($counter->comment/$total, 3)*100:0?>,
                            <?=$counter->follow!=0?round($counter->follow/$total, 3)*100:0?>,
                            <?=$counter->unfollow!=0?round($counter->unfollow/$total, 3)*100:0?>,
                            <?=$counter->direct_message!=0?round($counter->direct_message/$total, 3)*100:0?>,
                            <?=$counter->repost_media!=0?round($counter->repost_media/$total, 3)*100:0?>
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
                    <h3 class=""><?=$counter->like?></h3>
                    <span><?=lang('likes')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="ft-thumbs-up blue font-large-2 float-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body box-analytic">
            <div class="media">
                <div class="media-body text-left w-100">
                    <h3 class=""><?=$counter->comment?></h3>
                    <span><?=lang('comments')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="ft-message-square blue font-large-2 float-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body box-analytic">
            <div class="media">
                <div class="media-body text-left w-100">
                    <h3 class=""><?=$counter->follow?></h3>
                    <span><?=lang('follows')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="ft-user-plus blue font-large-2 float-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body box-analytic">
            <div class="media">
                <div class="media-body text-left w-100">
                    <h3 class=""><?=$counter->unfollow?></h3>
                    <span><?=lang('unfollows')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="ft-user-x blue font-large-2 float-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body box-analytic">
            <div class="media">
                <div class="media-body text-left w-100">
                    <h3 class=""><?=$counter->direct_message?></h3>
                    <span><?=lang('direct_messages')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="ft-message-circle blue font-large-2 float-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body box-analytic">
            <div class="media">
                <div class="media-body text-left w-100">
                    <h3 class=""><?=$counter->repost_media?></h3>
                    <span><?=lang('repost_medias')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="ft-message-circle blue font-large-2 float-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>