<?php
$name = "";
$ids = "";
$data = array();

if(!empty($group)){
    $name = $group->name;
    $ids = $group->ids;
    $data = json_decode($group->data);
}

?>
<div class="pn-box-content">
    <div class="pn-groups">
        <div class="head-box">
            <div class="form-group">
                <label><?=lang("Group name")?></label>
                <input type="text" class="form-control group_name" value="<?=$name?>">
            </div>
            <div class="text-center text-primary">
                <?=lang("Drag and drop to right to select and to left to unselect")?>
            </div>
        </div>

        <div class="row m0" style="height: 100%">
            <div class="col-md-6 col-xs-6 m0 p0" style="height: 100%">
                <div class="pn-group-panel">
                    <div class="pn-group-header"><?=lang("All accounts")?></div>
                    <ul class="pn-group-list connected-sortable draggable-left pn-group-scroll">
                        <?php if(!empty($accounts)){
                        foreach ($accounts as $row) {
                            if(!in_array($row->pid, $data)){
                        ?>
                        <li class="pn-group-item">
                            <div class="pic">
                                <img src="<?=$row->avatar?>">
                            </div>
                            <div class="detail">
                                <div class="title"><?=$row->username?></div>
                                <div class="desc"><?=sprintf(lang("%s ".$row->type) , str_replace("_", " ", ucfirst($row->category)) )?></div>
                                <input type="hidden" name="id[]" value="<?=$row->pid?>">
                            </div>
                        </li>
                        <?php }}}?>
                    </ul>
                </div>
            </div>
            <form action="<?=PATH?>group_manager/ajax_save" data-redirect="<?=PATH?>group_manager" method="POST" class="actionForm saveFormGroups col-md-6 col-xs-6 m0 p0" style="height: 100%">
                <input type="hidden" name="name" value="<?=$name?>">
                <input type="hidden" name="ids" value="<?=$ids?>">
                <div class="pn-group-panel">
                    <div class="pn-group-header"><?=lang("Selected accounts")?></div>
                    <ul class="pn-group-list connected-sortable draggable-right pn-group-scroll">
                        <?php if(!empty($accounts)){
                        foreach ($accounts as $row) {
                            if(in_array($row->pid, $data)){
                        ?>
                        <li class="pn-group-item">
                            <div class="pic">
                                <img src="<?=$row->avatar?>">
                            </div>
                            <div class="detail">
                                <div class="title"><?=$row->username?></div>
                                <div class="desc"><?=sprintf(lang("%s ".$row->type) , str_replace("_", " ", ucfirst($row->category)) )?></div>
                                <input type="hidden" name="id[]" value="<?=$row->pid?>">
                            </div>
                        </li>
                        <?php }}}?>
                    </ul>
                </div>
            </form>
        </div>  
    </div>
</div>

<?php if(segment(3) != ""){?>
    <div class="card-footer p15">
        <button type="button" class="btn btn-primary saveGroups"> <?=lang('save')?></button>
        <a href="<?=cn("group_manager")?>" class="btn btn-default"> <?=lang('cancel')?></a>
    </div>
<?php }?>

<script type="text/javascript" src="<?=BASE."assets/plugins/jquery-ui/jquery-ui.min.js"?>"></script>
<script type="text/javascript" src="<?=BASE."assets/plugins/jquery-ui/jquery.ui.touch-punch.min.js"?>"></script>

<script type="text/javascript">
    $(function(){
        $(".draggable-left, .draggable-right").sortable({
            connectWith: ".connected-sortable",
            stack: ".connected-sortable ul"
        }).disableSelection();

        _he = $(window).height();
        $(".pn-groups").height(_he - 121);
        if($(".pn-group-scroll").length > 0){
            $('.pn-group-scroll').niceScroll({cursorcolor:"#ddd", cursorwidth: "10px"});
        }

        $(".group_name").keyup(function(){
            console.log($(this).val());
            $("input[name='name']").val($(this).val());
        });

        $(window).resize(function(){
            _he = $(window).height();
            $(".pn-groups").height(_he - 121);
        });

        $(document).on("click", ".saveGroups", function(){
            $(".saveFormGroups").submit();
        });
    });
</script>

