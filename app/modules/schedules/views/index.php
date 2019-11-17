<form class="schedules-form" action="<?=PATH."schedules/calendar"?>" data-content="sc-calendar" data-result="html">
<div class="schedules">
	<div class="row">
		<a href="javascript:void(0);" class="sc-toggle-open"><i class="fa fa-filter" aria-hidden="true"></i></a>
		<div class="sc-options">
			<div class="box-sc-option box-sc-option-type">
				<div class="title"><?=lang("Schedule type")?></div>
				<ul>
					<li class="active">
						<input type="radio" name="sc_type" class="hide sc-action" id="sc_type_queue" checked="" value="queue">
						<label for="sc_type_queue" class="btn btn-default btn-block sc-btn-type" data-type="queue" href="javascript:void(0);" role="button">
				            <span class="icon"></span>
				            <span class="long"><?=lang("Queue")?></span>
			          	</label>
					</li>
					<li>
						<input type="radio" name="sc_type" class="hide sc-action" id="sc_type_published" value="published">
						<label for="sc_type_published" class="btn btn-default btn-block sc-btn-type" data-type="published" href="javascript:void(0);" role="button">
				            <span class="icon"></span>
				            <span class="long"><?=lang("Published")?></span>
			          	</label>
					</li>
					<li>
						<input type="radio" name="sc_type" class="hide sc-action" id="sc_type_unpublished" value="unpublished">
						<label for="sc_type_unpublished" class="btn btn-default btn-block sc-btn-type" data-type="unpublished" href="javascript:void(0);" role="button">
				            <span class="icon"></span>
				            <span class="long"><?=lang("Unpublished")?></span>
			          	</label>
					</li>
				</ul>
			</div>

			<?php 
			$social_info = load_social_info(true);
			$socials = array();
			if(!empty($social_info)){?>
			<div class="box-sc-option">
				<div class="title"><?=lang("Social networks")?></div>
				<ul>
					<?php foreach ($social_info as $key => $row) {
						$socials[] = strtolower($row->title);
					?>
					<li>
						<div class="pure-checkbox grey">
					        <input type="checkbox" name="social_filter[]" id="md_checkbox_<?=$row->title?>" class="filled-in chk-col-red sc-action" checked="" value="<?=str_replace(" ", "_", $row->title)?>">
					        <label class="p0 m0" for="md_checkbox_<?=$row->title?>">
					        	<span class="name" style="color: <?=$row->color?>"><i class="fa <?=$row->icon?>"></i> <?=$row->title?></span>
					        </label>
					    	
					    </div>
					</li>
					<?php }?>
				</ul>
			</div>
			<div class="box-sc-option">
				<div class="title"><?=lang("Advance options")?></div>
				<ul>
					<li class="box-border">
						<div class="box-title"><?=lang("Delete schedules")?></div>
						<div class="box-content">
							<ul>
								<li>
									<div class="pure-checkbox grey">
								        <input type="radio" name="sc_delete_type" id="md_radio_delete_queue" class="filled-in chk-col-red" checked="" value="queue">
								        <label class="p0 m0" for="md_radio_delete_queue">
								        	<span class="name"><?=lang("Queue")?></span>
								        </label>
								    </div>
								</li>
								<li>
									<div class="pure-checkbox grey">
								        <input type="radio" name="sc_delete_type" id="md_radio_delete_published" class="filled-in chk-col-red" value="published">
								        <label class="p0 m0" for="md_radio_delete_published">
								        	<span class="name"><?=lang("Published")?></span>
								        </label>
								    </div>
								</li>
								<li>
									<div class="pure-checkbox grey">
								        <input type="radio" name="sc_delete_type" id="md_radio_unpublished" class="filled-in chk-col-red" value="unpublished">
								        <label class="p0 m0" for="md_radio_unpublished">
								        	<span class="name"><?=lang("Unpublished")?></span>
								        </label>
								    </div>
								</li>
							</ul>
							<div class="form-group">
								<div class="label"><?=lang("Social networks")?></div>
								<select class="form-control" name="sc_delete_social">
							    	<option value=""><?=lang("Select")?></option>
							    	<option value='<?=json_encode($socials)?>'><?=lang("delete_all")?></option>
							    	<?php foreach ($social_info as $key => $row) {?>
									<option value="<?=strtolower($row->title)?>"><?=$row->title?></option>
									<?php }?>
							    </select>
							</div>
					    	<a class="btn btn-danger btn-block actionDeleteSchedules" href="<?=PATH."schedules/delete"?>"><i class="ft-trash"></i> <?=lang("delete")?></a>
						</div>
					</li>

				</ul>
			</div>
			<?php }?>

		</div>
		<div class="sc-calendar">
		</div>
	</div>
</div>
</form>