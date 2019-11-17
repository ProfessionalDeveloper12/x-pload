<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class packages extends MX_Controller {
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		$this->module_name = lang("packages");
		$this->module_icon = "fa ft-package";
	}

	public function index($page = "empty", $ids = ""){
		
		$packages = $this->model->fetch("*", "general_packages", "", "created", "DESC");

		$package = array();
		if($ids != ""){
			$package = $this->model->get("*", "general_packages", "ids = '{$ids}'");
		}

		$data = array(
			"result" => $package,
			"module"      => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon,
			"packages" => $this->model->fetch("*", PACKAGES, "type = 2", "id", "DESC")
		);

		if($page == "edit"){ $page = "add"; }

		if (!$this->input->is_ajax_request()) {
			$view = $this->load->view($page, $data, true);
			$this->template->build('index', array("view" => $view, "packages" => $packages));
		}else{
			$this->load->view($page, $data);
		}
	}

	public function update(){
		$data = array(
			"packages"    => $this->model->fetch("name, id, ids", PACKAGES),
			"result"      => $this->model->get("*", "general_packages", "ids = '".segment(3)."'"),       
			"module"      => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon
		);
		$this->template->build('update', $data);
	}

	public function ajax_update(){
		$ids         = post("ids");
		$name        = post("name");
		$description = post("description");
		$trial_day       = post("trial_day");
		$subscribers     = post("subscribers");
		$price_monthly   = (float)post("price_monthly");
		$price_annually  = (float)post("price_annually");
		$number_accounts = (int)post("number_accounts");
		$sort            = (int)post("sort");
		$max_storage_size= (float)post("max_storage_size");
		$max_file_size   = (float)post("max_file_size");
		$watermark       = post("watermark");
		$image_editor    = post("image_editor");
		$permission_list = $this->input->post('permission[]');
		$file_pickers = $this->input->post('file_pickers[]');
		$file_types = $this->input->post('file_types[]');
		$status          = (int)post("status");

		if($name == "" && !post("trial_day")){
			ms(array(
				"status"  => "error",
				"message" => lang('name_is_required')
			));
		}

		$permission = array();
		if(!empty($permission_list)){
			foreach ($permission_list as $value) {
				$permission[] = $value;
			}
		}

		if(!empty($file_pickers)){
			foreach ($file_pickers as $value) {
				$permission[] = $value;
			}
		}

		if(!empty($file_types)){
			foreach ($file_types as $value) {
				$permission[] = $value;
			}
		}

		$permission['max_storage_size'] = $max_storage_size;
		$permission['max_file_size'] = $max_file_size;
		$permission['watermark'] = $watermark;
		$permission['image_editor'] = $image_editor;

		$data = array(
			
			'description'     => $description,
			'price_monthly'   => $price_monthly,
			'price_annually'  => $price_annually,
			'number_accounts' => $number_accounts,
			"permission" => json_encode($permission, 0),
			'sort' => $sort,
			'status' => $status,
			'changed' => NOW
		);

		$package = $this->model->get("id, ids, type", "general_packages", "ids = '{$ids}'");
		if(empty($package)){
			$data['ids'] = ids();
			$data['created'] = NOW;
			$data['sort'] = $sort;
			$data['name'] = $name;
			$data['type'] = 2;
			$this->db->insert("general_packages", $data);
		}else{
			$data['name'] = $name;
			if($package->type == 2){
				$data['sort'] = $sort;
			}else{
				$data['trial_day'] = $trial_day;
			}

			if($subscribers){
				$this->db->update(USERS, array('permission' => json_encode($permission)), "package = {$package->id}");
			}

			$this->db->update("general_packages", $data, array("ids" => $package->ids));
		}
		
		ms(array(
			"status"  => "success",
			"message" => lang("successfully")
		));
	}

	public function ajax_update_status(){
		$this->model->update_status("general_packages", post("id"), false);
	}
	
	public function ajax_delete_item(){
		$this->model->delete("general_packages", post("id"), false);
	}
}