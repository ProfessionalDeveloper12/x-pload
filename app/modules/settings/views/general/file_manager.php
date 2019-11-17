<div class="row">
    <div class="col-md-12">
    	<h3 class="head-title"><i class="ft-folder"></i> <?=lang('file_manager')?></h3>

        <div class="lead">  <?=lang('google_drive')?></div>
        <div class="form-group">
            <span class="text">  <?=lang('google_api_key')?></span> 
            <input type="text" class="form-control" name="google_drive_api_key" value="<?=get_option('google_drive_api_key', '')?>">
        </div>
        <div class="form-group">
            <span class="text">  <?=lang('google_client_id')?></span> 
            <input type="text" class="form-control" name="google_drive_client_id" value="<?=get_option('google_drive_client_id', '')?>">
        </div>
       
        <div class="lead">  <?=lang('dropbox')?></div>
        <div class="form-group">
            <span class="text">  <?=lang('dropbox_api_key')?></span> 
            <input type="text" class="form-control" name="dropbox_api_key" value="<?=get_option('dropbox_api_key', '')?>">
        </div>

        <div class="lead">  <?=lang('Designbold Image Editor')?></div>
        <div class="form-group">
            <span class="text">  <?=lang('Designbold App ID')?></span> 
            <input type="text" class="form-control" name="designbold_app_id" value="<?=get_option('designbold_app_id', '')?>">
        </div>

    </div>
</div>