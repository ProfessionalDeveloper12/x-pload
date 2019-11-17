<?php if(!empty($result)){
foreach ($result as $key => $value) {
?>
    
    <a href="https://www.instagram.com/explore/tags/<?=$value->name?>/" target="_blank" class="activity-option-tag">
        <div class="pure-checkbox grey" style="padding-right: 26px; position: relative; top: -3px;">
            <input type="checkbox" name="add_tag[]" id="cb_tag_select_<?=$value->id?>" class="filled-in chk-col-red" value="<?=$value->name?>">
            <label class="p0 m0" for="cb_tag_select_<?=$value->id?>">&nbsp;</label>
        </div>
        <span><?=$value->name?> (<?=$value->media_count?>)</span>
    </a>

<?php }}else{?>
    <div class="dataTables_empty"></div>
<?php }?>