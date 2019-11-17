<div class="row pn-mode pn-mode-users">
    <a href="javascript:void(0);" class="pn-toggle-open"><i class="ft-package" aria-hidden="true"></i></a>
    <div class="pn-sidebar pn-scroll">
        <div class="pn-box-sidebar">

            <h3 class="head-title"><?=lang("Package manager")?> <a href="<?=cn("packages/index/add")?>" class="pull-right text-primary" title="<?=lang("add_new")?>"><i class="ft-plus-circle"></i></a></h3>

            <div class="box-search">
                <div class="input-group">
                  <input type="text" class="form-control pn-search" placeholder="<?=lang("Search")?>" aria-describedby="basic-addon2">
                  <span class="input-group-addon" id="basic-addon2"><i class="ft-search"></i></span>
                </div>
            </div>

            <?php if(!empty($packages)){
            foreach ($packages as $package) {
            ?>
            <div class="item item-3">
                <a href="<?=cn("packages/index/edit/".$package->ids)?>" data-content="pn-ajax-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("packages/index/edit/".$package->ids)?>');">
                    <div class="icon bg-black white"><i class="ft-package"></i></div>
                    <div class="content content-2">
                        <div class="title"><?=$package->name?></div>
                        <div class="desc"><span class="<?=$package->status?"text-success":"text-danger"?>" title="<?=$package->status?lang("enable"):lang("disable")?>"><?=$package->status?lang("enable"):lang("disable")?></span></div>
                    </div>
                </a>
                <?php if($package->type != 1){?>
                <div class="option">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="ft-more-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?=cn("packages/ajax_delete_item/")?>" data-id="<?=$package->ids?>" data-redirect="<?=cn("package")?>" class="actionItem"><?=lang("delete")?></a></li>
                        </ul>
                    </div>
                </div>
                <?php }?>

            </div>
            <?php }}?>
        </div>
    </div>
    <div class="pn-content pn-scroll">
        <form action="<?=cn("packages/ajax_update")?>" data-redirect="<?=cn($module)?>" class="actionForm" method="POST">
            <div class="pn-ajax-content">
                <?=$view?>
            </div>
        </form>
    </div>
</div>

<style type="text/css">
    .item.active .desc *{
        color: #fff!important;
    }
</style>