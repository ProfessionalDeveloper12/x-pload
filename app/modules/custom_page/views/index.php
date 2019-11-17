<div class="row pn-mode pn-mode-users">
    <a href="javascript:void(0);" class="pn-toggle-open"><i class="ft-file-text" aria-hidden="true"></i></a>
    <div class="pn-sidebar pn-scroll">
        <div class="pn-box-sidebar">

            <h3 class="head-title"><?=lang("custom_page")?> <a href="<?=cn("custom_page/index/add")?>" class="pull-right text-primary" title="<?=lang("add_new")?>"><i class="ft-plus-circle"></i></a></h3>

            <div class="box-search">
                <div class="input-group">
                  <input type="text" class="form-control pn-search" placeholder="<?=lang("Search")?>" aria-describedby="basic-addon2">
                  <span class="input-group-addon" id="basic-addon2"><i class="ft-search"></i></span>
                </div>
            </div>

            <?php if(!empty($custom_pages)){
            foreach ($custom_pages as $custom_page) {
            ?>
            <div class="item item-2">
                <a href="<?=cn("custom_page/index/edit/".$custom_page->ids)?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("custom_page/index/edit/".$custom_page->ids)?>');">
                    <div class="icon bg-success white"><i class="ft-file-text"></i></div>
                    <div class="content content-1">
                        <div class="title"><?=$custom_page->name?></div>
                    </div>
                </a>
                <?php if($custom_page->status == 1){?>
                <div class="option">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="ft-more-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?=cn("custom_page/ajax_delete_item/")?>" data-id="<?=$custom_page->ids?>" data-redirect="<?=cn("custom_page")?>" class="actionItem"><?=lang("delete")?></a></li>
                        </ul>
                    </div>
                </div>
                <?php }?>
            </div>
            <?php }}?>
        </div>
    </div>
    <div class="pn-content pn-scroll">
        <form action="<?=cn("custom_page/ajax_update")?>" data-redirect="<?=cn("custom_page")?>" class="actionForm" method="POST">
            <div class="pn-ajax-content">
                <?=$view?>
            </div>
        </form>
    </div>
</div>

<style type="text/css">

</style>