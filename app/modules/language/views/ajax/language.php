<?php if(!empty($language_category)){?>
<div class="card" style="padding-top: 50px;">
    <div class="card-block p0">
        <div class="tab-content p15">
            <div class="row">
                <form style="margin: 15px; background: #dbf3ff; border-radius: 6px; padding: 15px 0;" class="actionForm" action="<?=cn("language/ajax_update")?>">
                    <input type="hidden" class="form-control" name="ids" id="ids" value="<?=!empty($language_category)?$language_category->ids:""?>">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name"><?=lang("name")?></label>
                            <input type="text" class="form-control" name="name" id="name" value="<?=!empty($language_category)?$language_category->name:""?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="code"><?=lang("Code")?></label>
                            <input type="text" class="form-control" name="code" id="code" value="<?=!empty($language_category)?$language_category->code:""?>" <?=!empty($language_category)?"disabled":""?>>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group select-language">
                            <label for="price_default_month">Icon</label>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name"><?=lang("default")?></label>
                            <select class="form-control" name="is_default">
                                <option value="0" <?=(!empty($language_category) && $language_category->is_default == 0)?"selected":""?> ><?=lang("No")?></option>
                                <option value="1" <?=(!empty($language_category) && $language_category->is_default == 1)?"selected":""?>><?=lang("Yes")?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary"><?=lang("update")?></button>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <table class="table table-bordered mb0" style="border-top: 1px solid #e5e5e5" width="100%">
                <thead>
                    <tr>
                        <td style="background: #dbf3ff; padding: 15px;">
                            <div class="input-group">
                                <input type="text" class="form-control lg-search" placeholder="<?=lang("search")?>" aria-describedby="basic-addon2">
                                <span class="input-group-addon" id="basic-addon2"><i class="ft-search"></i></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <a href="javascript:void(0);">
                                <span class="text"><?=lang('text')?></span>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($language_default)){
                foreach ($language_default as $key => $value) {
                ?>
                    <tr>
                        <td style="width: 50%;">
                            <?php if(strlen($value->text) < 100){?>
                            <input type="text" class="form-control lang-item" name="<?=$value->slug?>" value="<?=(isset($language[$value->slug]))?$language[$value->slug]:$value->text?>">
                            <?php }else{ ?>
                            <textarea name="<?=$value->slug?>" rows="3" class="form-control lang-item"><?=(isset($language[$value->slug]))?trim(preg_replace('/\s+/', ' ', $language[$value->slug])):trim(preg_replace('/\s+/', ' ', $value->text))?></textarea>
                            <?php }?>   
                        </td>
                    </tr>
                <?php }}?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php }else{?>
<div class="ml15 mr15 bg-white dataTables_empty" style="margin-top: 150px;"></div>
<?php }?>

<script type="text/javascript">
    $(function(){
        $(".language-app .lg-search").keyup(function(){
            _key = $(this).val().toLowerCase();
            $(".language-app table tbody .lang-item").each(function(){
                _that = $(this);
                _name = _that.val().toLowerCase();
                
                if(_name.search(_key) != -1){
                    _that.parents("tr").show();
                }else{
                    _that.parents("tr").hide();
                }
            });
        });

        /*Select search*/
        if($('select.selectpicker').length > 0 || $('.date').length > 0){
            $('select.selectpicker').selectpicker();
        }
    });
</script>