<div class="card" style="padding-top: 50px;">
    <div class="card-block p0">
        <div class="tab-content p15">
            <div class="row">
                <form style="margin: 15px; border-radius: 6px; padding: 15px 0; border: 1px solid #f5f5f5; max-width: 500px;" class="actionForm" action="<?=cn("language/ajax_update")?>" data-redirect="<?=cn("language/new_lang")?>">
                    <input type="hidden" class="form-control" name="ids" id="ids" value="<?=!empty($language_category)?$language_category->ids:""?>">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name"><?=lang("name")?></label>
                            <input type="text" class="form-control" name="name" id="name" value="<?=!empty($language_category)?$language_category->name:""?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="code"><?=lang("Code")?></label>
                            <input type="text" class="form-control" name="code" id="code" value="<?=!empty($language_category)?$language_category->code:""?>" <?=!empty($language_category)?"disabled":""?>>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group select-language">
                            <label for="price_default_month"><?=lang("Icon")?></label>
                            <select class="form-control selectpicker" name="icon">
                                <?php $fileList = glob(APPPATH.'../assets/plugins/flags/flags/4x3/*');
                                foreach($fileList as $filename){
                                    $directory_list = explode("/", $filename);
                                    $filename = end($directory_list);
                                    $ext = explode(".", $filename);
                                    if(count($ext) == 2 && $ext[1] == "svg"){
                                        echo $language_category->icon. " == flag-icon flag-icon-<?=$ext[0]?>";
                                ?>
                                        <option class="flag-icon flag-icon-<?=$ext[0]?>" <?=(!empty($language_category) && $language_category->icon == "flag-icon flag-icon-".$ext[0])?"selected":""?> value="flag-icon flag-icon-<?=$ext[0]?>"><?=$ext[0]?></option>
                                <?php
                                    }
                                    
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name"><?=lang("default")?></label>
                            <select class="form-control" name="is_default">
                                <option value="0" <?=(!empty($language_category) && $language_category->is_default == 0)?"selected":""?> ><?=lang("No")?></option>
                                <option value="1" <?=(!empty($language_category) && $language_category->is_default == 1)?"selected":""?>><?=lang("Yes")?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary"><?=lang("Create")?></button>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
