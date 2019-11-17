<?php if(!empty($result)){?>
<div class="ap-preview-header">
    <ul class="tab-social">
        <?php foreach ($result as $key => $row) {?>
            <li class="item <?=$key == 0?"active":""?>"><a href="#preview-<?=$row['name']?>" data-toggle="tab"><i class="<?=$row['icon']?>" style="color: <?=$row['color']?>"></i></a></li>
        <?php }?>
    </ul>
</div>
<div class="col-md-8 col-md-offset-2 col-sm-12 tab-content">
    <?php foreach ($result as $key => $row) {?>
        <div class="tab-pane fade <?=$key == 0?"active in":""?>" id="preview-<?=$row['name']?>">
            <?=$row['content']?>
        </div> 
    <?php }?>
</div>

<?php }?>