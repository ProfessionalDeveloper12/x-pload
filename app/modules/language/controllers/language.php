<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class language extends MX_Controller {
	public $table;
	public $columns;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		//Config Module
		$this->table       = LANGUAGE_LIST;
		$this->language    = LANGUAGE;
		$this->module_name = lang('language');
		$this->module_icon = "fa fa-language";
		$this->language_category = $this->model->fetch("*", $this->table);
	}

	public function index($code = ""){
		$language_cate = $this->model->get("*", $this->table, "code = '{$code}'");
		$language_items = $this->model->fetch("slug, text", $this->language, "code = '{$code}'");

		if(empty($language_cate)){
			$view = $this->load->view("ajax/empty", array(), true);
			return $this->template->build('index', array("view" => $view, "language_category" => $this->language_category));
		}

		lang_builder(APPPATH.'../');

		$language = array();
		if(!empty($language_items)){
			foreach ($language_items as $key => $value) {
				$language[$value->slug] = $value->text;
			}
		}


		/*EXPORT LANGUAGE*/
		$category = array(
			"name"        => $language_cate->name,
			"icon"        => $language_cate->icon,
			"code"        => $language_cate->code
		);

		$language_pack = array(
			"language_info" => $language_cate,
			"language_data" => $language
		);

		$language_pack = json_encode($language_pack);

		$handle = fopen(APPPATH."../assets/tmp/lang_".$code.".txt", "w");
	    fwrite($handle, $language_pack);
	    fclose($handle);
		/*END EXPORT LANGUAGE*/


		$data = array(
			"module"   => get_class($this),
			"language" => $language,
			"language_category"   => $language_cate,
			"language_default" => $this->model->fetch("*", $this->language, "code = 'en'")
		);

		if (!$this->input->is_ajax_request()) {
			$view = $this->load->view("ajax/language", $data, true);
			$this->template->build('index', array("view" => $view, "language_category" => $this->language_category));
		}else{
			$this->load->view("ajax/language", $data);
		}
	}

	public function update_language_item(){
		$code = post("code");
		$key = post("key");
		$value = post("value");

		$item = $this->db->query("SELECT * FROM ".LANGUAGE." WHERE BINARY slug='{$key}' AND code = '{$code}'")->row();
		if(!empty($item)){
			$this->db->query("UPDATE {$this->language} SET text = '{$value}' WHERE BINARY slug = '{$key}' AND code = '{$code}' ");
		}else{
			$this->db->insert($this->language, array(
				"ids"  => ids(),
				"code" => $code, 
				"text" => $value, 
				"slug" => $key
			));
		}

		/*EXPORT LANGUAGE*/
		$language_cate = $this->model->get("*", $this->table, "code = '{$code}'");
		$language_items = $this->model->fetch("slug, text", $this->language, "code = '{$code}'");
		if(!empty($language_cate)){
			$language = array();
			if(!empty($language_items)){
				foreach ($language_items as $key => $value) {
					$language[$value->slug] = $value->text;
				}
			}

			$category = array(
				"name"        => $language_cate->name,
				"icon"        => $language_cate->icon,
				"code"        => $language_cate->code
			);

			$language_pack = array(
				"language_info" => $language_cate,
				"language_data" => $language
			);

			$language_pack = json_encode($language_pack);

			$handle = fopen(APPPATH."../assets/tmp/lang_".$code.".txt", "w");
		    fwrite($handle, $language_pack);
		    fclose($handle);
		}
		/*END EXPORT LANGUAGE*/

		ms(array(
			"status"  => "success",
			"message" => lang("successfully")
		));
	}

	public function new_lang(){
		redirect(cn("language/index/".session("new_lang")));
	}

	public function ajax_update(){
		$ids  = post("ids");
		$name = post("name");
		$code = post("code");
		$icon = post("icon");
		$lang = @$_REQUEST["lang"];
		$is_default = post("is_default");

		if($name == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("name_is_required")
			));
		}

		if($code == "" && $ids == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("code_is_required")
			));
		}

		if($icon == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("please_enter_icon")
			));
		}

		//
		$data = array(
			"name"        => $name,
			"icon"        => $icon,
			"status"      => 1,
			"changed"     => NOW
		);

		$language_list =$this->model->fetch("*", $this->table, "is_default = 1");
		if(empty($language_list)){
			$data["is_default"] = 1;
		}else{
			if($is_default){
				$data["is_default"] = 1;
				$this->db->update($this->table, array("is_default" => 0));
			}
		}

		$item = $this->model->get("*", $this->table, "ids = '{$ids}'");
		if(empty($item)){

			$item_check = $this->model->get("id", $this->table, "code = '{$code}'");
			if(!empty($item_check)){
				ms(array(
					"status"  => "error",
					"message" => lang("this_language_already_exists")
				));
			}

			$data["ids"]        = ids();
			$data["code"]       = $code;
			$data["created"]    = NOW;

			$this->db->insert($this->table, $data);
			set_session("new_lang", $code);
		}else{
			
			$item_check = $this->model->get("id", $this->table, "code = '{$code}' AND id != '{$item->id}'");
			if(!empty($item_check)){
				ms(array(
					"status"  => "error",
					"message" => lang("this_language_already_exists")
				));
			}

			$this->db->update($this->table, $data, array("ids" => $item->ids));

		}

		ms(array(
			"status"  => "success",
			"message" => lang("Update successfully")
		));
	}

	public function add(){
		$data = array();

		$view = $this->load->view("ajax/add", $data, true);
		$this->template->build('index', array("view" => $view, "language_category" => $this->language_category));
	}

	public function export($code){
		$language_cate = $this->model->get("*", $this->table, "code = '{$code}'");
		$language_items = $this->model->fetch("slug, text", $this->language, "code = '{$code}'");

		$category = array(
			"name"        => $language_cate->name,
			"icon"        => $language_cate->icon,
			"code"        => $language_cate->code
		);

		$language = array();
		if(!empty($language_items)){
			foreach ($language_items as $key => $value) {
				$language[$value->slug] = $value->text;
			}
		}

		$language_pack = array(
			"language_info" => $language_cate,
			"language_data" => $language
		);

		$language_pack = json_encode($language_pack);

		$handle = fopen("lang_".$code.".txt", "w");
	    fwrite($handle, $language_pack);
	    fclose($handle);

	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.basename("lang_".$code.'.txt'));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize("lang_".$code.'.txt'));
	    readfile("lang_".$code.'.txt');

	    unlink("lang_".$code.".txt");
	    exit;
	}

	public function import($code){

	}

	public function ajax_import(){
		$config['upload_path']          = './assets/tmp';
        $config['allowed_types']        = 'txt';
        $config['encrypt_name']         = FALSE;

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

		        	$language_data = file_get_contents($info->full_path);
		        	$language_data = json_decode($language_data, 1);
		        	if(isset($language_data["language_info"])){

			        	$language_category = $language_data["language_info"];

			        	$this->db->delete($this->table, "code = '".$language_category["code"]."'");
			        	$this->db->delete($this->language, "code = '".$language_category["code"]."'");

			        	$is_default = 0;
			        	$language_list =$this->model->fetch("*", $this->table, "is_default = 1");
						if(empty($language_list)){
							$is_default = 1;
						}

			        	$data_cate = array(
			        		"ids"         => ids(),
			        		"name"        => $language_category["name"],
							"icon"        => $language_category["icon"],
							"code"        => $language_category["code"],
							"is_default"  => $is_default,
							"status"      => 1,
							"changed"     => NOW,
							"created"     => NOW
			        	);

			        	$this->db->insert($this->table, $data_cate);

			        	if(isset($language_data["language_data"]) && !empty($language_data["language_data"])){
			        		foreach ($language_data["language_data"] as $key => $value) {
			        			$this->db->insert($this->language, array(
									"ids"  => ids(),
									"code" => $language_category["code"], 
									"text" => $value, 
									"slug" => $key
								));
			        		}
			        	}

			        	/*EXPORT LANGUAGE*/
						$language_cate = $this->model->get("*", $this->table, "code = '".$language_category["code"]."'");
						$language_items = $this->model->fetch("slug, text", $this->language, "code = '".$language_category["code"]."'");
						if(!empty($language_cate)){
							$language = array();
							if(!empty($language_items)){
								foreach ($language_items as $key => $value) {
									$language[$value->slug] = $value->text;
								}
							}

							$category = array(
								"name"        => $language_cate->name,
								"icon"        => $language_cate->icon,
								"code"        => $language_cate->code
							);

							$language_pack = array(
								"language_info" => $language_cate,
								"language_data" => $language
							);

							$language_pack = json_encode($language_pack);

							$handle = fopen(APPPATH."../assets/tmp/lang_".$code.".txt", "w");
						    fwrite($handle, $language_pack);
						    fclose($handle);
						}
						/*END EXPORT LANGUAGE*/
		        	}

		        	@unlink($info->full_path);

	                ms(array(
	                	"status"  => "success",
	                	"message" => lang("Import successfully")
	                ));
		        }
		    }
        }else{
        	load_404();
        }
	}

	public function ajax_update_status(){
		$this->model->update_status($this->table, post("id"), false);
	}
	
	public function ajax_delete_item(){
		$ids = post("id");
		if(!empty($ids)){
			if(is_string($ids)){
				$lang = $this->model->get("*", $this->table, "ids = '".$ids."'");
				if(!empty($lang)){
					$this->db->delete(LANGUAGE, array("code" => $lang->code));
				}
			}else if(is_array($ids)){
				foreach ($ids as $id) {
					$lang = $this->model->get("*", $this->table, "ids = '".$id."'");
					if(!empty($lang)){
						$this->db->delete(LANGUAGE, array("code" => $lang->code));
					}
				}
			}
		}

		$this->model->delete($this->table, post("id"), false);
	}
}