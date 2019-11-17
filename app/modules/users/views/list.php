<div class="head-title"><i class="ft-user"></i> <?=lang("List users")?></div>

<div class="wrap-content"> 
	<div class="users app-table">
		  	<div class="card">
		  		<div class="card-body">
		  			<form action="<?=cn($module)?>">
		  			<div class="table-filter pl0 pr0">
		  				<div class="row">
		  					<div class="col-md-9 col-sm-6 mb-mobile-15">
		  						<div class="btn-group" role="group" aria-label="export">
								    <a href="<?=cn($module."/update")?>" class="btn btn-default"><i class="fa fa-plus"></i> <?=lang("add_new")?></a>
								    <a href="<?=cn($module."/ajax_delete_item")?>" class="btn btn-default actionMultiItem" data-redirect="<?=cn($module)?>" data-confirm="<?=lang("are_you_sure_want_delete_it")?>"><i class="fa fa-trash-o"></i> <?=lang("delete")?></a>
								</div>
		  					</div>
		  					<div class="col-md-3  col-sm-6 pull-right">
		  						<div class="input-group">
								    <input type="text" class="form-control" name="k" placeholder="<?=lang("enter_keyword")?>" aria-describedby="button-addon" value="<?=get("k")?>">
								    <span class="input-group-btn" id="button-addon">
								        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
								    </span>
								</div>
		  					</div>
		  				</div>
		  			</div>
		  			<table class="table table-bordered table-datatable mb0" width="100%">
		  				<?php if(!empty($columns)){?>
		                <thead>
		                    <tr>
		                    	<th>
			                        <div class="pure-checkbox grey mr15">
			                        	<input type="checkbox" name="id[]" id="checkAll" class="filled-in chk-col-red checkAll">
            							<label class="p0 m0" for="checkAll">&nbsp;</label>
            						</div>
		                        </th>
		                        <th>
			                        <a href="javascript:void(0);">
			                        	<span class="text"><?=lang("option")?></span>
			                        </a>
		                        </th>
		                    	<th>
			                        <a href="javascript:void(0);">
			                        	<span class="text"><?=lang("#")?></span>
			                        </a>
		                        </th>
		                    	<?php 
		                    	$i = 0;
		                    	foreach ($columns as $key => $column) {?>
		                        <th>
		                        	<?php 
		                        	$sort_type = "asc";
		                        	$sort_icon = "";
		                        	if(get("c") == $i){
		                        		if(get("t") == "asc"){
		                        			$sort_type = "desc";
		                        			$sort_icon = "up";
		                        		}else{
		                        			$sort_type = "asc";
		                        			$sort_icon = "down";
		                        		}
		                        	}
		                        	
		                    		$sort_link = cn($module."?c={$i}&t={$sort_type}");
		                        	if(get("k")){
		                        		$sort_link = $sort_link."&k=".get("k");
		                        	}
		                        	?>
			                        <a href="<?=$sort_link?>">
			                        	<span class="text"><?=$column?></span>

			                        	<span class="sort-caret pull-right <?=$sort_icon?>">
			                        		<i class="asc fa fa-sort-asc" aria-hidden="true"></i>
			                        		<i class="desc fa fa-sort-desc" aria-hidden="true"></i>
			                        	</span>
			                        </a>
		                        </th>
		                        <?php 
		                        $i ++;
		                        }?>
		                    </tr>
		                </thead>
		                <?php }?>
		                <tbody>
		                <?php if(!empty($result) && !empty($columns)){
		                foreach ($result as $key => $row) {
		                ?>
		                    <tr>
		                    	<td>
		                    		<div class="pure-checkbox grey mr15">
			                        	<input type="checkbox" name="id[]" id="check_<?=$row->ids?>" class="filled-in chk-col-red checkItem" value="<?=$row->ids?>">
            							<label class="p0 m0" for="check_<?=$row->ids?>">&nbsp;</label>
            						</div>
		                    	</td>
		                    	<td>
		                        	<div class="btn-group btn-group-option <?=($key + 1 == count($result)?"dropup":"")?>">
									  	<a href="<?=cn($module."/update/".$row->ids)?>" class="btn btn-default"><i class="ft-edit"></i></a>
									  	<div class="btn-group">
									    	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									    		<span class="caret"></span>
									    	</button>
									    	<ul class="dropdown-menu dropdown-menu-left" role="menu">
									      		<li><a href="<?=cn($module."/view_user/".$row->ids)?>" data-id="<?=$row->ids?>" data-redirect="<?=cn("dashboard")?>" class="actionItem"><?=lang("View user")?></a></li>
									      		<li><a href="<?=cn($module."/ajax_delete_item")?>" data-id="<?=$row->ids?>" data-redirect="<?=cn($module)?>" data-confirm="<?=lang("are_you_sure_want_delete_it")?>" class="actionItem"><?=lang("delete")?></a></li>
									    	</ul>
									  	</div>
									</div>
		                        </td>
		                        <th scope="row"><?=$page + $key + 1?></th>
		                        <?php foreach ($columns as $column_name => $column_title){?>
		                        <td><?=custom_row($row->$column_name, $column_name, $module, $row->ids)?></td>
		                        <?php }?>
		                    </tr>
		                <?php }}?>
		                </tbody>
				  	</table>
				  	</form>
		  		</div>
		  		<?php if(!empty($result) && !empty($columns) && $this->pagination->create_links() != ""){?>
		  		<div class="card-footer">
  					<?=$this->pagination->create_links();?>
		  		</div>
		  		<?php }?>
		  	</div>
		</div>
	</div>
</div>