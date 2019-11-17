<div class="row pn-mode pn-mode-settings">
    <a href="javascript:void(0);" class="pn-toggle-open"><i class="ft-calendar" aria-hidden="true"></i></a>
    <div class="pn-sidebar pn-scroll">
        <div class="pn-box-sidebar">

            <h3 class="head-title"><?=lang("schedules")?> 
                <a href="<?=cn(segment(1)."/".segment(2)."/ajax_delete_schedules")?>" data-redirect="<?=current_url()?>" title="<?=lang("delete_all")?>" data-id="-1" class="text-danger pull-right actionItem" style="margin-left: 5px;" data-confirm="<?=lang("are_you_sure_want_delete_it")?>"><i class="ft-trash-2"></i></a>
                <a href="<?=cn(segment(1)."/".segment(2))?>" class="pull-right text-primary" title="<?=lang("add_new")?>"><i class="ft-plus-circle"></i></a>
            </h3>

            <div class="box-search">
                <div class="input-group">
                  <input type="text" class="form-control pn-search" placeholder="<?=lang("Search")?>" aria-describedby="basic-addon2">
                  <span class="input-group-addon" id="basic-addon2"><i class="ft-search"></i></span>
                </div>
            </div>

            <div class="item item-2 border <?=get("t")==""?"opened":""?>">
                <a href="<?=cn(segment(1)."/".segment(2)."/schedules/{$date}")?>" data-content="pn-ajax-content" data-result="html" class="" onclick="history.pushState(null, '', '<?=cn(segment(1)."/".segment(2)."/schedules/{$date}")?>');">
                    <div class="icon bg-primary white"><i class="fa fa-calendar"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('Queue')?></div>
                    </div>
                </a>
            </div>

            <div class="item item-2 border <?=get("t")==2?"opened":""?>">
                <a href="<?=cn(segment(1)."/".segment(2)."/schedules/{$date}?t=2")?>" data-content="pn-ajax-content" data-result="html" class="" onclick="history.pushState(null, '', '<?=cn(segment(1)."/".segment(2)."/schedules/{$date}?t=2")?>');">
                    <div class="icon bg-success white"><i class="fa fa-paper-plane"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('Published')?></div>
                    </div>
                </a>
            </div>

            <div class="item item-2 border <?=get("t")==3?"opened":""?>">
                <a href="<?=cn(segment(1)."/".segment(2)."/schedules/{$date}?t=3")?>" data-content="pn-ajax-content" data-result="html" class="" onclick="history.pushState(null, '', '<?=cn(segment(1)."/".segment(2)."/schedules/{$date}?t=3")?>');">
                    <div class="icon bg-danger white"><i class="fa fa-exclamation"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=lang('Unpublished')?></div>
                    </div>
                </a>
            </div>

            <div class="pn-sidebar-head"><?=lang("Accounts")?></div>

            <?php if(!empty($accounts)){
            $count = 0;
            foreach ($accounts as $key => $row) {
                if($row->total != 0){
                    $count++;
            ?>

            <div class="item item-2 border <?=get("t")==4?"active":""?>">
                <a href="<?=cn(segment(1)."/".segment(2)."/ajax_schedules/".$row->ids)?>" data-id="<?=get("t")?>" data-content="pn-ajax-content" data-result="html" class="actionItem">
                    <div class="icon"><img src="<?=$row->avatar?>"></div>
                    <div class="content content-2">
                        <div class="title"><?=$row->username?></div>
                        <div class="desc"><?=sprintf(lang("%s posts"), $row->total)?></div>
                    </div>
                </a>
            </div>
            <?php }}}?>

            <?php if($count == 0){?>
                <div class="dataTables_empty"></div>
            <?php }?>
        </div>
    </div>
    <div class="pn-content pn-scroll">
        <div class="pn-box-content">
            <div class="schedules schedules-list" data-content="ajax-sc-list" data-append_content="1" data-result="html" data-page="0" data-hide-overplay="0">
                <div class="sc-list">
                    <div class="pn-ajax-content">
                    <?=$view?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="<?=cn(segment(1)."/".segment(2)."/ajax_schedules")?>" data-id="<?=get("t")?>" data-content="pn-ajax-content" data-result="html" class="actionItem loadScheduleAll hide"></a>
<script type="text/javascript">
$(function(){
    setTimeout(function(){
        $(".loadScheduleAll").click();
    }, 100);
});
</script>

<style type="text/css">
.pn-sidebar-head{
    font-size: 16px;
    font-weight: 500;
    padding: 15px 15px;
    margin-top: 17px;
    margin-bottom: 17px;
    border-left: 3px solid #36a3f7;
    border-top: 1px solid #f5f5f5;
    border-bottom: 1px solid #f5f5f5;
    border-right: 1px solid #f5f5f5;
    border-radius: 6px;
    -webkit-box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
    box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
}

.pn-mode .pn-sidebar .item.active{
    background: #36a3f7;
}

.pn-mode .pn-sidebar .item.active .content .desc{
    color: #fff;
}


.pn-mode .pn-sidebar .item.opened{
    background: #36a3f7;
    border-radius: 6px;
    -webkit-box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08);
    box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08);
}

.pn-mode .pn-sidebar .item.opened .icon{
    background: rgba(231, 231, 231, 0.2);
    color: #fff;
}

.pn-mode .pn-sidebar .item.opened .content .title{
    color: #fff;
}

.pn-mode .pn-sidebar .item.opened .content .desc{
    color: #b1c1ff;
}

.pn-groups{
    height: 100%;
    overflow: hidden;
}

.head-box{
    padding: 15px;
}

.pn-groups .pn-group-panel{
    height: 100%;
    border-right: 1px solid #f5f5f5;
}

.pn-groups .pn-group-panel .pn-group-header{
    position: relative;
    padding: 0 15px;
    border-top: 1px solid #ebedf2;
    border-bottom: 1px solid #ebedf2;
    min-height: 60px;
    margin: 0;
    line-height: 60px;
    background: #fff;
    font-weight: 500;
}

.pn-groups .pn-group-panel .pn-group-list{
    margin-bottom: 0;
    height: calc(100% - 185px);
}

.pn-groups .pn-group-panel .pn-group-list .pn-group-item{
    position: relative;
    padding: 15px;
    border-bottom: 1px dashed #ebedf2;
    cursor: move;
}

.pn-groups .pn-group-panel .pn-group-list .pn-group-item.ui-sortable-helper{
    max-width: 300px!important;
    border: 1px solid #51b2fc;
    border-radius: 6px;
    background: transparent;
    background-color: #dff1ff;
}

.pn-groups .pn-group-panel .pn-group-list .pn-group-item:last-child{
}

.pn-groups .pn-group-panel .pn-group-list .pn-group-item .pic{
    position: absolute;
    border-radius: 6px;
    overflow: hidden;
    left: 15px;
}

.pn-groups .pn-group-panel .pn-group-list .pn-group-item .pic img{
    border-radius: 6px;
    border: 1px solid #efefef;
    width: 40px;
    height: 40px;
}

.pn-groups .pn-group-panel .pn-group-list .pn-group-item .detail{
    margin-left: 55px;
    height: 40px;
}

.pn-groups .pn-group-panel .pn-group-list .pn-group-item .detail .title{
    display: block;
    height: 19px;
    font-weight: 600;
    overflow: hidden;
    font-size: 13px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.pn-groups .pn-group-panel .pn-group-list .pn-group-item .detail .desc{
    font-size: 12px;
    line-height: 18px;
}
</style>