<div class="wrap-content container">
	<form action="<?=cn($module."/ajax_update")?>" data-redirect="<?=cn($module)?>" class="actionForm" method="POST">
	<input type="hidden" name="ids" value="<?=!empty($result)?$result->ids:""?>">

	<div class="row">
		<div class="col-md-6">
			<div class="users">
			  	<div class="card">
			  		<div class="card-header">
			  			<div class="card-title">
	                        <i class="<?=$module_icon?>" aria-hidden="true"></i> <?=$module_name?>
	                    </div>
	                    <div class="clearfix"></div>
			  		</div>
			  		<div class="card-body pl15 pr15">
                        <div class="form-group">
                            <label for="address"><?=lang("address")?></label>
                            <input type="text" class="form-control" name="address" id="address" value="<?=!empty($result)?$result->address:""?>">
                        </div>
                        <div class="form-group">
                            <label for="location"> <?=lang('location')?></label>
                            <select name="location" class="form-control" id="location">
                                <option value="unknown"><?=lang("unknown")?></option>
                                <?php foreach (list_countries() as $key => $value){?>
                                    <option value="<?=$key?>" <?=(!empty($result) && $key == $result->location)?"selected":""?>><?=$value?></option>                             
                                <?php }?>                                
                            </select>
                            
                        </div>
			  		</div>
			  		<div class="card-footer">
	  					<a href="<?=cn($module)?>" class="btn btn-default"><?=lang('cancel')?></a>
                        <button type="submit" class="btn btn-primary pull-right"><?=lang('update')?></button>
	                    <div class="clearfix"></div>
			  		</div>
			  	</div>
			</div>
		</div>
	</div>
	</form>
</div>

<script type="text/javascript">
    $(function(){
        $("#address").change(function(){
            _ip      = "";
            _address = $(this).val();
            if(_address != ""){
                _address_parse = _address.split("@");
                if(_address_parse.length > 1){
                    if(_address_parse[1] != undefined){
                        ipport = _address_parse[1].split(":");
                        if(ipport.length == 2){
                            _ip = ipport[0]
                        }
                    }
                }else{
                    if(_address_parse[0] != undefined){
                        ipport = _address_parse[0].split(":");
                        if(ipport.length == 2){
                            _ip = ipport[0]
                        }
                    }
                }

                if(_ip == ""){
                    return false;
                }
                
                $.ajax({
                    url: "http://ip-api.com/json/"+_ip,
                    jsonpCallback: "callback",
                    dataType: "jsonp",
                    success: function( location ) {
                        console.log(location);
                        if(location.status == "success"){
                            $("#location").val(location.countryCode);
                        }else{
                            $("#location").val("unknown");
                        }
                    }
                });
            }
        });
    });
</script>