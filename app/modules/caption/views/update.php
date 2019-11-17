<div class="wrap-content container">
	<form action="<?=cn($module."/ajax_update")?>" data-redirect="<?=cn($module)?>" class="actionForm" method="POST">
	<input type="hidden" name="ids" value="<?=!empty($result)?$result->ids:""?>">

	<div class="row">
		<div class="col-md-6">
			<div class="users">
			  	<div class="card">
			  		<div class="card-header">
			  			<div class="card-title">
	                        <i class="<?=$module_icon?>" aria-hidden="true"></i> <?=$module_name?>
	                    </div>
	                    <div class="clearfix"></div>
			  		</div>
			  		<div class="card-body pl15 pr15">
                        <div class="form-group">
                            <textarea class="form-control post-message" name="caption" rows="3" placeholder="<?=lang('add_a_caption')?>" style="height: 114px;"><?=(!empty($result))?specialchar_decode($result->content):"";?></textarea>
                        </div>
			  		</div>
			  		<div class="card-footer">
	  					<a href="<?=cn($module)?>" class="btn btn-default"><?=lang('cancel')?></a>
                        <button type="submit" class="btn btn-primary pull-right"><?=lang('update')?></button>
	                    <div class="clearfix"></div>
			  		</div>
			  	</div>
			</div>
		</div>
	</div>
	</form>
</div>