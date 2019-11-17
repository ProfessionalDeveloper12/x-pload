<div class="wrap-content pt0">
	<div class="caption-page app-table">
		<div class="card card-caption-title">
	  		<div class="card-header">
	  			<div class="card-title" style="display: inline-block;">
	                <i class="<?=$module_icon?>" aria-hidden="true"></i> <?=lang("caption")?>
	                <div class="clearfix"></div>
		  		</div>
                <div class="pull-right">
                	<div class="btn-group" role="group" aria-label="export" style="position: relative; top: -7px;">
				    	<a href="<?=cn("caption/update")?>" class="btn btn-black"><i class="fa fa-plus"></i> <?=lang("add_new")?></a>
				   	</div>
                </div>
		  	</div>
	  	</div>
		<div class="row m0">
			<?php if(!empty($result) && !empty($columns)){
            foreach ($result as $key => $row) {
            ?>
            <div class="col-lg-3 col-md-4">
              	<div class="card card-caption-item">
                	<div class="card-content">
	                  	<div class="card-body p15">
		                    <h4 class="card-title primary mt0" style="font-size: 20px;">#<?=$page + $key + 1?></h4>
		                    <div class="dropdown pull-right">
						        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
						            <i class="ft-more-vertical"></i>
						        </button>
						        <ul class="dropdown-menu dropdown-menu-right">
			                        <li><a href="<?=cn("caption/update/".$row->ids)?>"><?=lang("edit")?></a></li>
			                        <li><a href="<?=cn("caption/ajax_delete_item")?>" data-redirect="<?=cn("caption")?>" class="actionItem" data-id="<?=$row->ids?>"><?=lang("delete")?></a></li>
						        </ul>
						    </div>
		                    <div class="caption-text caption-scrollbar scrollbar scrollbar-dynamic"><?=specialchar_decode(nl2br($row->content))?></div>
	                  	</div>
                	</div>
              	</div>
            </div>
            <?php }}else{?>
			<div class="ml15 mr15 bg-white dataTables_empty"></div>
            <?php }?>


            <?php if(!empty($result) && !empty($columns) && $this->pagination->create_links() != ""){?>
            <div class="clearfix"></div>
	  		<div class="card-footer">
				<?=$this->pagination->create_links();?>
	  		</div>
	  		<?php }?>
      	</div>
    </div>
</div>

<style type="text/css">
.wrap-content{
	margin-right: -15px;
	margin-left: -15px;
}

.card-caption-title{
	border-bottom: 1px solid #e5e5e5;
	border-radius: 0!important;
	-webkit-box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
    box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
}

.card-caption-item{
	border: 1px solid #e5e5e5;
    min-height: 152px;
    -webkit-box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
    box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
}
</style>