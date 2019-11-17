<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class file_manager extends MX_Controller {
	public $max_size = 5*1024;
	public $info_upload;
	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		$info_upload = $this->model->get_storage();
		$this->info_upload = $info_upload;
		$this->max_size = $info_upload->max_file_size*1024;
	}

	public function index(){
		$data = array(
			"info"       => $this->info_upload,
			"total_item" => $this->model->getFiles(-1, -1),
		);
		$this->template->build('index', $data);

		if(!permission("photo_type") && !permission("video_type")){
			redirect(cn("dashboard"));	
		}
	}

	public function block_file_manager($type = "single", $media = array()){
		$this->load->view("block_file_manager", array("type" => $type, "media" => $media));
	}

	public function ajax_load_files(){
		$limit = 40;
		$page = (int)post("page");
		$total_item = $this->model->getFiles(-1, -1);

		$data = array(
			"page"       => $page + 1,
			"limit"      => $limit,
			"total_item" => $total_item,
			"files"      => $this->model->getFiles($limit, $page)
		);

		echo json_encode(array(
			"total_item" => $total_item,
			"data"       => $this->load->view('ajax_load_files', $data, 1)
		));
	}

	public function popup_add_files($type = ""){
		$data = array(
			"id" => get("id"),
			"type" => $type
		);
		$this->load->view('popup_add_files', $data);
	}

	public function upload_files(){
		get_upload_folder();

		$types = "";
		if(permission("photo_type") && permission("video_type")){
			$types = 'gif|jpg|jpeg|png|mp4';
		}else if(permission("photo_type")){
			$types = 'gif|jpg|jpeg|png';
		}else if(permission("video_type")){
			$types = 'mp4';
		}

		$config['upload_path']          = './assets/uploads/user'.session("uid");
        $config['allowed_types']        = $types;
        $config['max_size']             = $this->max_size;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $config['encrypt_name']         = TRUE;


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
		        	$data = array(
		        		"ids" => ids(),
		        		"uid" => session("uid"),
		        		"file_name" => $info->file_name,
		        		"image_type" => $files['files']['type'][$i],
		        		"file_ext" => str_replace(".", "", strtolower($info->file_ext)),
		        		"file_size" => $info->file_size,
		        		"is_image" => $info->is_image,
		        		"image_width" => (int)$info->image_width,
		        		"image_height" => (int)$info->image_height,
		        		"created" => NOW,
		        	);

		        	$this->db->insert(FILE_MANAGER, $data);

	                ms(array(
	                	"status"  => "success",
	                	"link"    => get_link_file($info->file_name)
	                ));
		        }
		    }
        }else{
        	load_404();
        }
	}

	public function save_image(){
		get_upload_folder();

		if(get("image") || post("image")){
			$return_type = "page";

			if(get("image")){
				$return_type = "page";
				$media_link  = str_replace( " ", "%20", urldecode(get("image")) );
				$media_parse = explode("?", $media_link);
				$fileParts   = pathinfo($media_parse[0]);
				$file_name   = $fileParts['basename'];
				$file_type   = get_file_type($file_name);
				$newfilename = md5(encrypt_encode($file_name)).".".$file_type;
			}

			if(post("image")){
				$return_type = "json";
				$media_link  = str_replace( " ", "%20", urldecode(post("image")) );
				$media_parse = explode("?", $media_link);
				$fileParts   = pathinfo($media_parse[0]);
				$file_name   = "";

				if(isset($fileParts['extension'])){
					$file_name   = ids().".".$fileParts['extension'];
				}else{
					parse_str($media_link, $parse_url);
					if(isset($parse_url['mime']) && $parse_url['mime'] == 'video/mp4'){
						$file_name   = ids().".mp4";
						$media_parse[0] = $file_name;
					}
				}

				$file_type   = get_file_type($file_name);
				$newfilename = md5(encrypt_encode($file_name)).".".$file_type;
			}

			if(!check_media($media_parse[0])){
				ms(array(
                	"status"  => "error",
                	"message" => "The filetype you are attempting to upload is not allowed.",
                ));
			}

			$file_size = curl_get_file_size($media_link);
			if($file_size > $this->max_size){
				ms(array(
                	"status"  => "error",
                	"message" => lang("you_have_exceeded_the_file_limit"),
                ));
			}

			get_file_via_curl($media_link, $newfilename);

			$file_size = @filesize(get_path_upload($newfilename));
			if(is_int($file_size) && $file_size/1024 > $this->max_size){
				ms(array(
                	"status"  => "error",
                	"message" => lang("you_have_exceeded_the_file_limit"),
                ));
                unlink(get_path_upload($newfilename));

			}

			$this->model->get_storage("file", $file_size/1024);

			$image_width = 0;
			$image_height = 0;
			$fileinfo = @getimagesize(get_path_upload($newfilename));
			if(!empty($fileinfo)){
				$image_width = $fileinfo[0];
				$image_height = $fileinfo[1];
			}
			
			$data = array(
				"ids"       => ids(),
        		"file_name" => $newfilename,
        		"image_type"=> get_mime_type(get_file_type($newfilename)),
        		"file_ext"  => get_file_type($newfilename),
				"is_image"  => check_image($newfilename),
				"file_size" => round($file_size/1024,2),
				"image_width" => $image_width,
        		"image_height" => $image_height,
         		"created"   => NOW
        	);

			$media = $this->model->get("ids", FILE_MANAGER, "file_name = '".$newfilename."' AND uid = '".session("uid")."'");
			if(empty($media)){
				$data['uid']      = session("uid");
				$this->db->insert(FILE_MANAGER, $data);
			}else{
				$this->db->update(FILE_MANAGER, $data, "ids = '".$media->ids."'");
			}
        	

        	if($return_type == "page"){
        		$this->template->build('index');
        	}else{
        		ms(array(
                	"status"  => "success",
                	"message" => "Upload successfully",
                	"link"    => get_link_file($newfilename)
                ));
        	}
		}else{
			load_404();
		}
	}

	public function save_image_google_drive(){
		get_upload_folder();

		if(post("file_name") && post("file_id") && post("oauthToken") && permission("google_drive")){
			$fileId     = post("file_id");
			$file_name  = post("file_name");
			$file_size  = (int)post("file_size")/1024;
			$file_type  = get_file_type($file_name);
			$oAuthToken = post("oauthToken");
			$newfilename = md5(encrypt_encode($file_name)).".".$file_type;

			if(!check_media($file_name)){
				ms(array(
                	"status"  => "error",
                	"message" => "The filetype you are attempting to upload is not allowed.",
                ));
			}

			if(!$file_size || $file_size <= 0){
				ms(array(
                	"status"  => "error",
                	"message" => "Cannt load file size. Please try to again.",
                ));
			}

			$this->model->get_storage("file", $file_size);

			$getUrl = 'https://www.googleapis.com/drive/v3/files/' . $fileId . '?alt=media';
			$authHeader = 'Authorization: Bearer ' . $oAuthToken ;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $getUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_HEADER, 0);  
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
			    $authHeader ,
			]);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

			$data = curl_exec($ch);
			$error = curl_error($ch);
			curl_close($ch);

			file_put_contents(get_path_upload($newfilename), $data);

			/*$mime = mime_content_type(get_path_upload($newfilename));
			if(!strstr($mime, "video/") && !strstr($mime, "image/")){
				ms(array(
                	"status"  => "error",
                	"message" => "The filetype you are attempting to upload is not allowed.",
                ));
				unlink(get_path_upload($newfilename));
			}*/

			$file_size = @filesize(get_path_upload($newfilename));
			if(is_int($file_size) && $file_size/1024 > $this->max_size){
				ms(array(
                	"status"  => "error",
                	"message" => lang("you_have_exceeded_the_file_limit"),
                ));
                unlink(get_path_upload($newfilename));
			}

			$image_width = 0;
			$image_height = 0;
			$fileinfo = @getimagesize(get_path_upload($newfilename));
			if(!empty($fileinfo)){
				$image_width = $fileinfo[0];
				$image_height = $fileinfo[1];
			}

			$data = array(
				"ids"       => ids(),
        		"file_name" => $newfilename,
        		"image_type"=> get_mime_type(get_file_type($newfilename)),
        		"file_ext"  => get_file_type($newfilename),
				"is_image"  => check_image($newfilename),
				"file_size" => round($file_size/1024, 2),
				"image_width" => $image_width,
        		"image_height" => $image_height,
         		"created"   => NOW
        	);
			
			$image = $this->model->get("ids", FILE_MANAGER, "file_name = '".$newfilename."' AND uid = '".session("uid")."'");
			
			if(empty($image)){
				$data['uid']      = session("uid");
				$this->db->insert(FILE_MANAGER, $data);
			}else{
				$this->db->update(FILE_MANAGER, $data, "ids = '".$image->ids."'");
			}

			ms(array(
	        	"status"  => "success",
	        	"link"    => get_link_file($newfilename)
	        ));
		}else{
			load_404();
		}
	}

	public function view_video(){
		$this->load->view("view_video", array("video" => get("video")));
	}

	public function get_youtube_video_info(){
		$url = post("url");

		$result = download_youtube_video($url);

		if(empty($result)){
			ms(array(
				"status" => "error",
				"message" => lang("Invalid URL")
			));
		}

		$result['status'] = "success";
		$result['message'] = "";

		ms($result);
	}

	public function delete_file(){
		$id = post("id");
		$image = $this->model->get("ids,file_name", FILE_MANAGER, "ids = '".$id."' AND uid = '".session("uid")."'");
		if(!empty($image)){
			unlink(APPPATH."../assets/uploads/user".session("uid")."/".$image->file_name);
			$this->db->delete(FILE_MANAGER, "ids = '".$id."'");
			ms(array(
				"status"  => "success",
				"message" => lang("delete_file_successfully")
			));
		}else{
			ms(array(
				"status"  => "error",
				"message" => lang("delete_file_failure")
			));
		}
	}

	public function delete_files(){
		$list_id = $this->input->post("id");

		foreach ($list_id as $id) {
			$image = $this->model->get("ids,file_name", FILE_MANAGER, "ids = '".$id."' AND uid = '".session("uid")."'");

			if(!empty($image)){
				unlink(APPPATH."../assets/uploads/user".session("uid")."/".$image->file_name);
				$this->db->delete(FILE_MANAGER, "ids = '".$id."'");
			}
		}

		ms(array(
			"status"  => "success",
			"message" => lang("delete_file_successfully")
		));
	}

	public function editor($ids = ""){
		$image = $this->model->get("*", FILE_MANAGER, "ids = '{$ids}' AND uid = '".session("uid")."'");
		$data = array(
			"image" => $image
		);

		$this->load->view("editor", $data);
	}

	public function designbold_editor($ids = ""){
		$image = $this->model->get("*", FILE_MANAGER, "ids = '{$ids}' AND uid = '".session("uid")."'");
		$data = array(
			"image" => $image
		);

		$this->load->view("designbold_editor", $data);
	}

	public function save_editor(){
		$imageData = post("imgBase64");
		// Remove the headers (data:,) part.
		// A real application should use them according to needs such as to check image type
		$filteredData=substr($imageData, strpos($imageData, ",")+1);

		// Need to decode before saving since the data we received is already base64 encoded
		$unencodedData=base64_decode($filteredData);

		//echo "unencodedData".$unencodedData;

		// Save file. This example uses a hard coded filename for testing,
		// but a real application can specify filename in POST variable
		$file = 'assets/tmp/'.ids().'.png';
		$fp = fopen(APPPATH."../".$file , 'wb' );
		fwrite($fp, $unencodedData);
		fclose($fp);

		//SAVE
		$return_type = "json";
		$media_link  = urldecode(BASE.$file);
		$media_parse = explode("?", $media_link);
		$fileParts   = pathinfo($media_parse[0]);
		$file_name   = "";

		if(isset($fileParts['extension'])){
			$file_name   = ids().".".$fileParts['extension'];
		}else{
			parse_str($media_link, $parse_url);
			if(isset($parse_url['mime']) && $parse_url['mime'] == 'video/mp4'){
				$file_name   = ids().".mp4";
				$media_parse[0] = $file_name;
			}
		}

		$file_type   = get_file_type($file_name);
		$newfilename = md5(encrypt_encode($file_name)).".".$file_type;

		if(!check_media($media_parse[0])){
			ms(array(
            	"status"  => "error",
            	"message" => "The filetype you are attempting to upload is not allowed.",
            ));
		}

		$file_size = curl_get_file_size($media_link);
		if($file_size > $this->max_size){
			ms(array(
            	"status"  => "error",
            	"message" => lang("you_have_exceeded_the_file_limit"),
            ));
		}

		get_file_via_curl($media_link, $newfilename);
		$file_size = @filesize(get_path_upload($newfilename));
		if(is_int($file_size) && $file_size/1024 > $this->max_size){
			ms(array(
            	"status"  => "error",
            	"message" => lang("you_have_exceeded_the_file_limit"),
            ));
            unlink(get_path_upload($newfilename));

		}

		$this->model->get_storage("file", $file_size/1024);

		$image_width = 0;
		$image_height = 0;
		$fileinfo = @getimagesize(get_path_upload($newfilename));
		if(!empty($fileinfo)){
			$image_width = $fileinfo[0];
			$image_height = $fileinfo[1];
		}
		
		$data = array(
			"ids"       => ids(),
    		"file_name" => $newfilename,
    		"image_type"=> get_mime_type(get_file_type($newfilename)),
    		"file_ext"  => get_file_type($newfilename),
			"is_image"  => check_image($newfilename),
			"file_size" => round($file_size/1024,2),
			"image_width" => $image_width,
    		"image_height" => $image_height,
     		"created"   => NOW
    	);

		$media = $this->model->get("ids", FILE_MANAGER, "file_name = '".$newfilename."' AND uid = '".session("uid")."'");
		if(empty($media)){
			$data['uid']      = session("uid");
			$this->db->insert(FILE_MANAGER, $data);
		}else{
			$this->db->update(FILE_MANAGER, $data, "ids = '".$media->ids."'");
		}

		@unlink(APPPATH."../".$file);
    	
		ms(array(
        	"status"  => "success",
        	"message" => "Upload successfully",
        	"link"    => get_link_file($newfilename)
        ));
	}
}