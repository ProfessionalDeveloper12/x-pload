<div class="row pn-mode pn-mode-settings">
    <a href="javascript:void(0);" class="pn-toggle-open"><i class="ft-target" aria-hidden="true"></i></a>
    <div class="pn-sidebar pn-scroll">
        <div class="pn-box-sidebar">

            <h3 class="head-title"><?=lang("Group manager")?> <a href="<?=cn("group_manager/index/add")?>" class="pull-right text-primary" title="<?=lang("add_new")?>"><i class="ft-plus-circle"></i></a></h3>

            <div class="box-search">
                <div class="input-group">
                  <input type="text" class="form-control pn-search" placeholder="<?=lang("Search")?>" aria-describedby="basic-addon2">
                  <span class="input-group-addon" id="basic-addon2"><i class="ft-search"></i></span>
                </div>
            </div>

            <?php if(!empty($groups)){
                foreach ($groups as $group) {
            ?>
            <div class="item item-3 border <?=segment(4)==$group->ids?"active":""?>">
                <a href="<?=cn("group_manager/index/edit/".$group->ids)?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("group_manager/index/edit/".$group->ids)?>');">
                    <div class="icon bg-success white"><i class="ft-target"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=$group->name?></div>
                    </div>
                </a>
                <div class="option">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="ft-more-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?=cn("group_manager/ajax_delete_item/")?>" data-id="<?=$group->ids?>" data-redirect="<?=cn("group_manager")?>" class="actionItem"><?=lang("delete")?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php }}else{?>
                <div class="text-center">
                    <div class="dataTables_empty"></div>
                </div>  
            <?php }?>
        </div>
    </div>
    <div class="pn-content pn-scroll">
        <div class="pn-ajax-content">
            <?=$view?>
        </div>
    </div>
</div>

<style type="text/css">
.pn-box-content{
    padding: 0!important;
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