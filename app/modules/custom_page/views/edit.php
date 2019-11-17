<?php
$name = "";
$code = "";
$price = "";
$type = 0;
$ids = "";
$data = array();
$expiration_date = "";

if(!empty($coupon)){
    $name = $coupon->name;
    $code = $coupon->code;
    $price = $coupon->price;
    $type = (int)$coupon->type;
    $ids = $coupon->ids;
    $data = json_decode($coupon->packages);
    $expiration_date = convert_date($coupon->expiration_date);
}
?>
<div class="pn-box-content">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?=lang("name")?></label>
                <input type="text" class="form-control" name="name" value="<?=$name?>">
                <input type="hidden" name="ids" value="<?=$ids?>">
            </div>
            <div class="form-group">
                <label><?=lang("Code")?></label>
                <input type="text" class="form-control" name="code" value="<?=$code?>">
            </div>
            <div class="form-group">
                <label for="type"><?=lang("type")?></label><br/>
                <div class="pure-checkbox grey mr15 mb15">
                    <input type="radio" id="md_checkbox_type_enable" name="type" class="filled-in chk-col-red" <?=$type==1?"checked":""?> value="1">
                    <label class="p0 m0" for="md_checkbox_type_enable">&nbsp;</label>
                    <span class="checkbox-text-right"> <?=lang('Price')?></span>
                </div>

                <div class="pure-checkbox grey mr15 mb15">
                    <input type="radio" id="md_checkbox_type_disable" name="type" class="filled-in chk-col-red" <?=$type==0?"checked":""?> value="0">
                    <label class="p0 m0" for="md_checkbox_type_disable">&nbsp;</label>
                    <span class="checkbox-text-right"> <?=lang('Percent')?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="price"><?=lang("Price")?></label>
                <input type="text" class="form-control" name="price" id="price" value="<?=$price?>">
            </div>
            <div class="form-group">
                <label for="price"><?=lang("packages")?></label><br/>
                <?php
                if(!empty($packages)){
                foreach($packages as $row){?>
                    <div class="pure-checkbox grey mr15 mb15">
                         <input type="checkbox" id="md_checkbox_<?=$row->id?>" name="packages[]" class="filled-in chk-col-red" value="<?=$row->id?>" <?=(!empty($data) && in_array($row->id, $data))?"checked":""?>>
                         <label class="p0 m0" for="md_checkbox_<?=$row->id?>">&nbsp;</label>
                        <span class="checkbox-text-right <?=$row->id?>"> <?=$row->name?></span>
                    </div>
                <?php }}?>
            </div>
            <div class="form-group">
                <label for="expiration_date"><?=lang("expiration_date")?></label>
                <input type="text" class="form-control date" name="expiration_date" id="expiration_date" value="<?=$expiration_date?>">
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary"> <?=lang('save')?></button>
    <a href="<?=cn("custom_page")?>" class="btn btn-default"> <?=lang('cancel')?></a>
</div>