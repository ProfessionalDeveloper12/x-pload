<div class="list_choice_options scrollbar-dynamic">
    <?php if(!empty($result)){
    foreach ($result as $row) {
    ?>
    <a class="item" href="javascript:void(0);">
        <div class="checkbox pure-checkbox grey mr15">
            <input type="radio" id="md_checkbox_location_ids" name="location" class="filled-in chk-col-red enable_instagram_schedule" value='<?=serialize($row)?>'>
            <label class="p0 m0" for="md_checkbox_location_ids">&nbsp;</label>
        </div>
        <div class="infos">
            <div class="name"><?=$row->getName()?></div>
            <div class="desc"><?=$row->getAddress()?></div>
        </div>
    </a>
    <?php }}else{?>
    <a class="item empty" href="javascript:void(0);"><?=lang("No result")?></a>
    <?php }?>
</div>

<script type="text/javascript">
    $(function(){
        $('.list_choice_options').scrollbar({
            "autoUpdate" : true
        });
    });
</script>