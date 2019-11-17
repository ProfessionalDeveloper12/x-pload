<?php if(!empty($result)){
foreach ($result as $key => $row) {
	$data = json_decode($row->data);
?>
<div class="col-md-4 col-sm-6 mb15">
	<div class="item">
		<div class="item-info">
			<div class="time"><?=time_elapsed_string($row->created)?></div>
			<div class="action">
				<div class="type"><?=igaa($row->action)->text?></div>
				<div class="id"><?=is_numeric($data->id)?$data->username:$data->id?></div>
			</div>
		</div>
		<a href="https://www.instagram.com/<?=is_numeric($data->id)?$data->username:"p/".$data->id?>" target="_blank">
			<div class="box-img">
				<img src="<?=is_numeric($data->id)?$data->image:"https://www.instagram.com/p/".$data->id."/media/?size=m"?>">
				<div class="icon"><i class="<?=igaa($row->action)->icon?>"></i></div>
			</div>
		</a>
	</div>
</div>
<?php }}else{
	if($page == 0){
?>
<div class="dataTables_empty"></div>
<?php }}?>