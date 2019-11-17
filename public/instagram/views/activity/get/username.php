<?php if(!empty($result)){
foreach ($result as $key => $value) {
?>
    
    <a href="https://www.instagram.com/<?=$value->username?>" target="_blank" class="activity-option-user">
        <div class="pure-checkbox grey" style="padding: 0 25px 0 10px; position: relative; top: -3px;">
            <input type="checkbox" name="add_username[]" id="cb_username_select_<?=$value->pk?>" class="filled-in chk-col-red" value="<?=$value->pk."|".$value->username?>">
            <label class="p0 m0" for="cb_username_select_<?=$value->pk?>">&nbsp;</label>
        </div>
        <img src="https://avatar.stackposts.com/?u=<?=$value->username?>">
        <span><?=$value->username?> (<?=$value->follower_count?>)</span>
    </a>

<?php }}else{?>
    <div class="dataTables_empty"></div>
<?php }?>