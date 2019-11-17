<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class tools extends MX_Controller {

	public $max_size = 1*1024;
	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$data = array(
		);

		$this->template->build('index', $data);
	}

	public function ajax_upload_watermark(){
		get_upload_folder();
		$size = post("size");
		$opacity = post("opacity");
		$position = post("position");

    	get_setting("watermark_size", 30, session("uid"));
    	get_setting("watermark_opacity", 70, session("uid"));
    	get_setting("watermark_position", "lb", session("uid"));

    	update_setting("watermark_size", $size, session("uid"));
    	update_setting("watermark_opacity", $opacity, session("uid"));
    	update_setting("watermark_position", $position, session("uid"));

		$types = $types = 'gif|jpg|jpeg|png';

		$config['upload_path']          = './assets/uploads/user'.session("uid");
        $config['allowed_types']        = $types;
        $config['max_size']             = $this->max_size;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $config['encrypt_name']         = FALSE;
        $config['overwrite']         	= TRUE;
        $config['file_name']            = 'watermark';


        $this->load->library('upload', $config);
        
        if(!empty($_FILES)){
	        $files = $_FILES;
		    for($i=0; $i< count($_FILES['files']['name']); $i++){  
		        $_FILES['files']['name']= $files['files']['name'][$i];
		        $_FILES['files']['type']= $files['files']['type'][$i];
		        $_FILES['files']['tmp_name']= $files['files']['tmp_name'][$i];
		        $_FILES['files']['error']= $files['files']['error'][$i];
		        $_FILES['files']['size']= $files['files']['size'][$i];
		        
		        $this->model->get_storage("file", $_FILES['files']['size']/1024);
		        $this->upload->initialize($config);

		        if (!$this->upload->do_upload("files"))
		        {
	                ms(array(
	                	"status"  => "error",
	                	"message" => $this->upload->display_errors()
	                ));
		        }
		        else
		        {
		        	$info = (object)$this->upload->data();

		        	get_setting("watermark_image", "", session("uid"));
		        	update_setting("watermark_image", $config['upload_path']."/".$info->file_name, session("uid"));
		        }
		    }
        }

    	ms(array(
        	"status"  => "success",
        	"message" => lang("your_watermark_has_been_successfully_saved")
        ));
	}

	public function ajax_delete_watermark(){
		update_setting("watermark_size", 30, session("uid"));
    	update_setting("watermark_opacity", 70, session("uid"));
    	update_setting("watermark_position", "lb", session("uid"));
		update_setting("watermark_image", "", session("uid"));

		ms(array(
        	"status"  => "success",
        	"message" => lang("delete_successfully")
        ));
	}
}