<div class="pn-box-content">
    <div class="row">
        <input type="hidden" name="ids" value="<?=!empty($result)?$result->ids:""?>">

        <div class="row">
            <div class="col-md-12 ">
                <div class="users">
                    <div class="card">
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
                            <div class="form-group">
                                <label for="status"> <?=lang('status')?></label>
                                <select class="form-control" name="status" id="status">
                                    <option value="1" <?=!empty($result) && $result->status == 1?"selected":""?>><?=lang("enable")?></option>
                                    <option value="0" <?=!empty($result) && $result->status == 0?"selected":""?>><?=lang("disable")?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary"> <?=lang('save')?></button>
    <a href="<?=cn("proxies")?>" class="btn btn-default"> <?=lang('cancel')?></a>
</div>

<style type="text/css">
.trumbowyg-box{
    margin-top: 0px;
}
</style>

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