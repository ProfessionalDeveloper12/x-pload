<?php
$load_social_list = load_social_list();
$social_first = strtolower(reset($load_social_list));
$social_first = str_replace(" ", "_", $social_first);
$type = get("type")?get("type"):$social_first;
$report = block_report($type);
$report_lists = json_decode($report->report_lists);
$module_name = "dashboard";
?>

<div class="wrap-content <?=$module_name?>-app row app-mod">
    <ul class="am-mobile-menu">
        <li><a href="javascript:void(0);" class="active" data-am-open="account"><?=lang("Social Network")?></a></li>
        <li><a href="javascript:void(0);" data-am-open="content"><?=lang("Report")?></a></li>
    </ul>
    <div class="clearfix"></div>

    <div class="am-sidebar active">
        <?php if(!empty($report_lists)){?>
        <div class="box-search">
            <div class="input-group">
              <input type="text" class="form-control am-search" placeholder="<?=lang("search")?>" aria-describedby="basic-addon2">
              <span class="input-group-addon" id="basic-addon2"><i class="ft-search"></i></span>
            </div>
        </div>
        <ul class="box-list am-scroll">
            <?php 
                foreach ($report_lists as $key => $row) {
            ?>
            <li class="item <?=$type==$row->permission?"active":""?>">
                <a href="<?=cn("dashboard/report/".$row->permission)?>" data-content="report-content" data-result="html" class="actionItem" onclick="history.pushState(null, '', '<?=cn("dashboard?type=".$row->permission)?>'); openContent();">
                    <div class="box-img">
                        <div class="icon-social" style="font-size: 20px; width: 40px; background: <?=$row->color?>; height: 40px; color: #fff; text-align: center; line-height: 41px;">
                            <i class="<?=$row->icon?>"></i>
                        </div>
                        <div class="checked"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="pure-checkbox grey mr15">
                        <input type="radio" name="account[]" class="filled-in chk-col-red" value="<?=$row->title?>" <?=$type==$row->permission?"checked":""?>>
                        <label class="p0 m0" for="md_checkbox_<?=$row->title?>">&nbsp;</label>
                    </div>
                    <div class="box-info">
                        <div class="title"><?=ucfirst(lang(strtolower(str_replace(" ", "_", $row->title))))?></div>
                        <div class="desc"><?=lang("Report")?> </div>
                    </div>
                </a> 
            </li>
            <?php }?>
        </ul>
        <?php }?>
    </div>
    <div class="am-wrapper">

        <div class="am-content col-md-12 am-scroll p0">
            <div class="head-title">
                <div class="name">
                    <i class="ft-bar-chart-2" aria-hidden="true"></i> <?=lang("Report")?>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php if(!empty($report_lists)){?>
            <div class="" style="max-width: 1170px; margin: auto;">
                <div class="card" style="padding-top: 50px;">
                    <div class="card-block p0">
                        <div class="tab-content p15 report-content">
                            <?php
                            $data = $report->data;
                            if($data != ""){
                            ?>
                                <?=$data?>
                            <?php }else{?>
                                <div class="ml15 mr15 bg-white dataTables_empty"></div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <?php }else{?>
            <div class="ml15 mr15 bg-white dataTables_empty"></div>
            <?php }?>
        </div>
       
    </div>

</div>

<script type="text/javascript">
    function openContent(){
        if($(window).width() <= 768){
            $(".am-mobile-menu li a[data-am-open='content']").click();
        }
    }
</script>

<style type="text/css">
.am-content .head-title .name{
    display: inline-block;
}

.am-content .head-title .btn-group{
    margin-top: 14px;
}

.am-content .head-title {
    padding: 10px;
    position: fixed;
    width: calc(100% - 370px);
    background: #fff;
    margin-bottom: 0;
    padding: 0 15px;
    height: 65px;
    line-height: 64px;
    border-bottom: 1px solid #f5f5f5;
    background: #fff;
    z-index: 10;
}

.lead{
    font-size: 20px;
    font-weight: 500;
    color: #424242;
    margin-top: 30px;
}

@media (max-width: 768px){
    .am-mobile-menu li{
        width: 50%;
    }

    .am-content .head-title{
        width: 100%;
    }
}
</style>