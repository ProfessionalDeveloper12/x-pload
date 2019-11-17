<div class="wrap-content">
	<form action="<?=cn($module."/ajax_update")?>" data-redirect="<?=cn($module)?>" class="actionForm" method="POST">
	<input type="hidden" name="ids" value="<?=!empty($result)?$result->ids:""?>">

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="users">
			  	<div class="card">
			  		<div class="card-header">
			  			<div class="card-title">
	                        <i class="<?=$module_icon?>" aria-hidden="true"></i> <?=$module_name?>
	                    </div>
	                    <div class="clearfix"></div>
			  		</div>
			  		<?php if((!empty($result) && $result->status == 1) || empty($result)){?>
			  		<div class="card-body pl15 pr15">
		  				<div class="form-group">
                            <label for="name"><?=lang("title")?></label>
                            <input type="text" name="name" class="form-control" id="name" value="<?=!empty($result)?$result->name:""?>">
                        </div>
			  		</div>
			  		<div class="card-body pl15 pr15">
		  				<div class="form-group">
                            <label for="slug"><?=lang("slug")?></label>
                            <input type="text" name="slug" class="form-control" id="slug" value="<?=!empty($result)?$result->slug:""?>">
                            <div class="small pagelink" style="color: #adadad; padding-top: 3px;"></div>
                        </div>
			  		</div>

                    <!--<div class="card-body pl15 pr15">
                        <div class="form-group">
                            <label for="name"><?=lang("position")?></label>
                            <select name="position" class="form-control">
                                <option value="0">None</option>
                                <option value="1">Header</option>
                                <option value="2">Bottom</option>
                            </select>
                        </div>
                    </div> -->
                    <?php }else{?>
                    <div class="card-body pl15 pr15">
		  				<div class="form-group">
                            <label for="name"><?=lang("title")?></label>
                            <input type="text" class="form-control" value="<?=!empty($result)?$result->name:""?>" disabled="">
                        </div>
			  		</div>
                    <?php }?>
                    <div class="card-body pl15 pr15">
                        <div class="form-group">
                            <label for="name"><?=lang("content")?></label>
                            <textarea name="content" class="form-control texterea-editor"><?=!empty($result)?$result->content:""?></textarea>
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
        $("#name").change(function(){
        	_val  = $(this).val();
        	_slug = utf8ConvertJavascript(_val);
        	$("#slug").val(_slug);
        	$(".pagelink").text("<?=PATH?>p/"+_slug);
        });

        setTimeout(function(){
        	$(".trumbowyg-editor").niceScroll();
        }, 1000);
    });
	
	function utf8ConvertJavascript(str) 
	{
	    var str;
	    str = str.toLowerCase();
	    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
	    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
	    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
	    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
	    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
	    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
	    str = str.replace(/đ/g, "d");
	    str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");  
	    /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
	    str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1-  
	    str = str.replace(/^\-+|\-+$/g, "");
	 
	    return str;
	}
</script>