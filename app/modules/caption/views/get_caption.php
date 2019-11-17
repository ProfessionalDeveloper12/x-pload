<?php if(!empty($captions)){
foreach ($captions as $key => $caption) {
?>
<a href="javascript:void(0);" class="item" data-content="<?=specialchar_decode($caption->content)?>">
    <div class="caption-content"><div class="number text-primary">#<?=$key+($page*$limit)+1?></div> <?=specialchar_decode(nl2br($caption->content))?></div>
</a>
<?php }}?>
<?php if(!empty($next_captions)){?>
<div class="wrap-load-more">
    <button type="button" class="btn btn-primary caption-load-more" data-page="<?=$page+1?>"><?=lang("load_more")?></button>
</div>
<?php }?>

<?php if($page == 0 && empty($captions)){?>
<div class="dataTables_empty"></div>
<?php }?>