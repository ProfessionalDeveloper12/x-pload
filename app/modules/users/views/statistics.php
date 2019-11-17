<div class="head-title"><i class="ft-bar-chart-2"></i> <?=lang("User report")?></div>

<div class="pn-widget">

	<div class="row row-no-padding row-col-separator-xl">
		<div class="col-md-4">
			<div class="widget">
				<div class="media">
	                <div class="media-body text-left w-100">
	                    <h3 class="primary m0"><?=$user_status->enable + $user_status->disable?></h3>
	                    <span><?=lang("Total users")?></span>
	                </div>
	                <div class="media-right media-middle">
	                    <i class="ft-user primary font-large-2 float-right"></i>
	                </div>
	            </div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="widget">
				<div class="media">
	                <div class="media-body text-left w-100">
	                    <h3 class="success m0"><?=$user_status->enable?></h3>
	                    <span><?=lang("Activated users")?></span>
	                </div>
	                <div class="media-right media-middle">
	                    <i class="ft-user-check success font-large-2 float-right"></i>
	                </div>
	            </div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="widget">
				<div class="media">
	                <div class="media-body text-left w-100">
	                    <h3 class="danger m0"><?=$user_status->disable?></h3>
	                    <span><?=lang("Banned users")?></span>
	                </div>
	                <div class="media-right media-middle">
	                    <i class="ft-user-x danger font-large-2 float-right"></i>
	                </div>
	            </div>
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-header">
            	<div class="card-title"><?=lang("Register history")?></div>
            </h5>
            <div class="card-body">
            	<div class="box-stats-users">
            		<div class="row">
	            		<div class="col-md-6">
	            			<div class="item">
	            				<div class="desc"><?=lang("Today")?></div>
	            				<div class="number"><?=$count_register_today?></div>
	            			</div>
	            		</div>
	            		<div class="col-md-6">
	            			<div class="item">
	            				<div class="desc"><?=lang("This Week")?></div>
	            				<div class="number"><?=$count_register_week?></div>
	            			</div>
	            		</div>
	            		<div class="col-md-6">
	            			<div class="item">
	            				<div class="desc"><?=lang("This Month")?></div>
	            				<div class="number"><?=$count_register_month?></div>
	            			</div>
	            		</div>
	            		<div class="col-md-6">
	            			<div class="item">
	            				<div class="desc"><?=lang("This Year")?></div>
	            				<div class="number"><?=$count_register_year?></div>
	            			</div>
	            		</div>
	            	</div>
            	</div>

            	<div class="pn-box-chart">
            		<canvas id="users-stats-line-stacked-area" height="300"></canvas>
            	</div>
            </div>
        </div>

    </div>
    <div class="col-md-6">
    	<div class="card">
            <h5 class="card-header">
            	<div class="card-title"><?=lang("Login type")?></div>
            </h5>
            <div class="card-body">
            	<div class="pn-box-chart" style="height: 507px; max-width: 550px; margin: auto;">
			    	<canvas id="user-login-type-chart-area" height="283"></canvas>
		            <script type="text/javascript">
		                $(function(){
		                    Layout.pieChart(
		                        "user-login-type-chart-area",
		                        ["<?=lang('direct')?>", "<?=lang('facebook')?>", "<?=lang('google')?>", "<?=lang('twitter')?>"], 
		                        [
		                            <?=$login_type->direct?>,
		                            <?=$login_type->facebook?>,
		                            <?=$login_type->google?>,
		                            <?=$login_type->twitter?>
		                        ],
		                        ["rgba(34,185,255,1)", "rgba(253,57,122,1)", "rgba(255,184,34,1)", "rgba(10,187,135,1)"]
		                    );
		                });
		            </script>
            	</div>
            </div>
        </div>
    </div>

    <?php if(!empty($recent_users)){?>
    <div class="col-md-12">
    	<div class="card">
            <h5 class="card-header">
            	<div class="card-title"><?=lang("New users")?></div>
            </h5>
            <div class="card-body">
            	<div class="box-list-new-users">
            		<?php foreach ($recent_users as $key => $row) { ?>
            		<div class="item">
						<div class="pic bg-danger white">
							<i class="ft-user"></i>
						</div>
						<div class="detail">
							<a href="#" class="username">
								<?=$row->fullname?>
							</a>
							<div class="text">
								<?=$row->email?>
							</div>							 		 
						</div>	
						<a href="<?=cn("users/view_user/".$row->ids)?>" data-redirect="<?=cn("dashboard")?>" class="btn btn-sm btn-label-brand btn-bold actionItem"><?=lang("View")?></a>						 
					</div>
					<?php }?>
            	</div>
            </div>
        </div>
    </div>
	<?php }?>
</div>

<script type="text/javascript">
	$(function(){
		Layout.lineChart(
            "users-stats-line-stacked-area",
            <?=$user_stats->date?>, 
            [
                <?=$user_stats->value?>
            ],
            [
                "<?=lang('New user')?>"
            ],
            "",
            ["rgba(34,185,255,0.7)"]
        );
	});	
</script>


<style type="text/css">
*, *::before, *::after {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.pn-widget{
    -webkit-box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
    box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
    background-color: #ffffff;
    margin-bottom: 20px;
    border-radius: 4px;
}

.pn-widget .widget{
    padding: 25px;
}

.pn-widget .widget .widget-detail{
	display: block;
	float: left;
}

.pn-widget .widget .title{
    font-size: 16px;
    font-weight: 500;
    color: #6c7293;
    -webkit-transition: color 0.3s ease;
    transition: color 0.3s ease;
}

.pn-widget .widget .desc{
    color: #a7abc3;
    font-weight: 400;
    font-size: 12px;
}

.pn-widget .widget .number{
	font-size: 25px;
    font-weight: 500;
    float: right;
}

.row.row-col-separator-xl > div {
    border-bottom: 0;
    border-right: 1px solid #ebedf2;
}

.row.row-col-separator-xl > div:last-child {
    border-right: 0;
}

.pn-box-chart{
	padding: 30px;
    background-color: #ffffff;
    margin-bottom: 15px;
    height: 300px;
}

.pn-mode-users .card{
    -webkit-box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
    box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
    background-color: #ffffff;
    margin-bottom: 20px;
    border-radius: 4px;
}

.pn-mode-users .card .card-header{
	position: relative;
	padding: 0 25px;
	border-bottom: 1px solid #ebedf2;
	min-height: 60px;
	border-top-left-radius: 4px;
	border-top-right-radius: 4px;
	margin: 0;
	line-height: 60px;
    background: #fff;
}

.pn-mode-users .card .card-header .card-title{
	align-items: center;
	text-transform: inherit;
}

.box-stats-users{
	padding: 30px;
}

.box-stats-users .item{
	margin-bottom: 20px;
}

.box-stats-users .item .desc{
	font-size: 14px;
	color: #a7abc3;
	padding-bottom: 0.5rem;
	font-weight: 500;
	display: block;
}

.box-stats-users .item .number{
    font-size: 20px;
    font-weight: 600;
    color: #6c7293;
    display: block;
}

.box-list-new-users{
	padding: 20px;
}

.box-list-new-users .item{
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	align-items: center;
	padding-top: 1rem;
	padding-bottom: 1rem;
	border-bottom: 1px dashed #ebedf2;
}

.box-list-new-users .item .pic{
	font-size: 20px;
	width: 40px;
	height: 40px;
	border: 1px solid #f5f5f5;
	text-align: center;
	align-items: center;
	line-height: 40px;
	margin-right: 10px;
	border-radius: 4px;
}

.box-list-new-users .item .detail{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    padding-right: 1.25rem;
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
}

.box-list-new-users .item .detail .text{
	font-size: 12px;
    color: #a7abc3;
}
</style>