<link rel="stylesheet" type="text/css" href="<?=BASE."assets/plugins/tui.image-editor/tui-color-picker.min.css"?>">
<link rel="stylesheet" type="text/css" href="<?=BASE."assets/plugins/tui.image-editor/tui-image-editor.css"?>">
<style>
    @import url(https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i);
    html, body {
        height: 100%;
        margin: 0;
        font-family: 'Montserrat', sans-serif!important;
    }
    *{
    	font-family: 'Montserrat', sans-serif!important;
    }
    .tui-image-editor-header-buttons{
    	display: none;
    }

    .save{
    	outline: none;
    	position: fixed;
    	top: 15px;
    	left: 15px;
    	border: none;
    	border-radius: 100px;
    	background: #0089cf;
    	color: #fff;
    	padding: 10px 30px;
    	font-weight: bold;
    	cursor: pointer;
    }

    .tui-image-editor-container{
        min-width: 1000px;
    }
</style>
<script type="text/javascript">var BASE = "<?=BASE?>"; var token = '<?=$this->security->get_csrf_hash()?>';</script>
<div id="tui-image-editor-container"></div>
<button type="button" class="save"><?=lang("save")?></button>
<script type="text/javascript" src="<?=BASE."assets/plugins/jquery/jquery.min.js"?>"></script>
<script type="text/javascript" src="<?=BASE."assets/plugins/tui.image-editor/fabric.js"?>"></script>
<script type="text/javascript" src="<?=BASE."assets/plugins/tui.image-editor/tui-code-snippet.min.js"?>"></script>
<script type="text/javascript" src="<?=BASE."assets/plugins/tui.image-editor/tui-color-picker.min.js"?>"></script>
<script type="text/javascript" src="<?=BASE."assets/plugins/tui.image-editor/FileSaver.min.js"?>"></script>
<script type="text/javascript" src="<?=BASE."assets/plugins/tui.image-editor/tui-image-editor.js"?>"></script>
<script type="text/javascript" src="<?=BASE."assets/plugins/tui.image-editor/theme/black-theme.js"?>"></script>

<script>
// Image editor
var imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
 	includeUI: {
 		loadImage: {
         	path: '../../assets/uploads/user<?=session("uid")?>/<?=$image->file_name?>',
        	name: 'SampleImage'
     	},
 		theme: blackTheme,
		initMenu: 'filter',
		menuBarPosition: 'bottom'
 	},
	cssMaxWidth: 700,
 	cssMaxHeight: 500
});

window.onresize = function() {
}

$(function(){
	$(document).on("click", ".save", function(){
        parent.overplay();
		var dataURL = imageEditor.toDataURL();
		$.ajax({
		    type: 'POST',
		    url: '<?=cn("file_manager/save_editor")?>',
		    data: {
		    	token: token,
		      	imgBase64: dataURL 
		    }
		}).done(function(_result) {
			parent.reload();
            parent.hide_overplay();
		});
	});
});
</script>