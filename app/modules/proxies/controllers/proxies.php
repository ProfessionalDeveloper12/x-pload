<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class proxies extends MX_Controller {
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		$this->module_name = lang("packages");
		$this->module_icon = "fa ft-package";
	}

	public function index($page = "empty", $ids = ""){
		
		$proxies = $this->model->fetch("*", "general_proxies", "", "created", "DESC");

		$proxy = array();
		if($ids != ""){
			$proxy = $this->model->get("*", "general_proxies", "ids = '{$ids}'");
		}

		$data = array(
			"module"      => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon,
			"result" => $proxy,
			"packages" => $this->model->fetch("*", PACKAGES, "type = 2", "id", "DESC")
		);

		if($page == "edit"){ $page = "add"; }

		if (!$this->input->is_ajax_request()) {
			$view = $this->load->view($page, $data, true);
			$this->template->build('index', array("view" => $view, "proxies" => $proxies));
		}else{
			$this->load->view($page, $data);
		}
	}

	public function update(){
		$data = array(
			"packages"    => $this->model->fetch("name, id, ids", PACKAGES),
			"result"      => $this->model->get("*", "general_proxies", "ids = '".segment(3)."'"),       
			"module"      => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon
		);
		$this->template->build('update', $data);
	}

	public function ajax_update(){
		$ids         = post("ids");
		$address     = post("address");
		$location    = post("location");
		$status      = (int)post("status");

		if($address == ""){
			ms(array(
				"status"  => "error",
				"message" => "Address is required"
			));
		}

		$data = array(
			'address'   => $address,
			'location'  => $location,
			'status'    => $status,
			'changed'   => NOW
		);

		$proxies = $this->model->get("id", "general_proxies", "ids = '{$ids}'");
		if(empty($proxies)){
			$data['ids'] = ids();
			$data['created'] = NOW;
			$this->db->insert("general_proxies", $data);
		}else{
			$this->db->update("general_proxies", $data, array("id" => $proxies->id));
		}
		
		ms(array(
			"status"  => "success",
			"message" => lang("successfully")
		));
	}

	public function ajax_update_status(){
		$this->model->update_status("general_proxies", post("id"), false);
	}
	
	public function ajax_delete_item(){
		$this->model->delete("general_proxies", post("id"), false);
	}
}