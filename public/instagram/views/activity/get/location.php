<?php if(!empty($result)){
foreach ($result as $key => $value) {
	$value = json_decode($value);
?>
    
    <a href="https://www.instagram.com/explore/locations/<?=$value->external_id?>" target="_blank" class="activity-option-location">
        <div class="pure-checkbox grey" style="padding: 0 25px 0 0; position: relative; top: -3px;">
            <input type="checkbox" name="add_location[]" id="cb_location_select_<?=$value->external_id?>" class="filled-in chk-col-red" value="<?=$value->external_id."|".$value->name?>">
            <label class="p0 m0" for="cb_location_select_<?=$value->external_id?>">&nbsp;</label>
        </div>
        <span><?=$value->name?></span>
    </a>

<?php }}else{?>
    <div class="dataTables_empty"></div>
<?php }?>