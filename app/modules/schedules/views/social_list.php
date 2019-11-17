<?php $social_list = permission_list();
if(!empty($social_list)){
foreach ($social_list as $data) {
	if(!empty($data)){
	foreach ($data as $row) {
		$row = (object)$row;
		if(permission($row->link)){
?>

<?php 
$controller_file = APPPATH."../public/".str_replace("/", "/controllers/", $row->link).".php";
if(file_exists($controller_file)){
$content_file = file_get_contents($controller_file);
if(preg_match("/block_schedules_xml/i", $content_file)){?>
<a href="<?=cn($row->link."/schedules/".$day."?t=2")?>" style="background-color: <?=$row->color?>"><i class="<?=$row->icon?>"></i> <?=lang(strtolower(str_replace(" ", "_", $row->name)))?></a>
<?php }}?>

<?php }}}}}?>
