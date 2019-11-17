<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class custom_page extends MX_Controller {
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		$this->module_name = lang("packages");
		$this->module_icon = "fa ft-package";
	}

	public function index($page = "empty", $ids = ""){
		
		$custom_pages = $this->model->fetch("*", "general_custom_page", "", "created", "DESC");

		$custom_page = array();
		if($ids != ""){
			$custom_page = $this->model->get("*", "general_custom_page", "ids = '{$ids}'");
		}

		$data = array(
			"module"      => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon,
			"result" => $custom_page,
			"packages" => $this->model->fetch("*", PACKAGES, "type = 2", "id", "DESC")
		);

		if($page == "edit"){ $page = "add"; }

		if (!$this->input->is_ajax_request()) {
			$view = $this->load->view($page, $data, true);
			$this->template->build('index', array("view" => $view, "custom_pages" => $custom_pages));
		}else{
			$this->load->view($page, $data);
		}
	}

	public function update(){
		$data = array(
			"packages"    => $this->model->fetch("name, id, ids", PACKAGES),
			"result"      => $this->model->get("*", "general_custom_page", "ids = '".segment(3)."'"),       
			"module"      => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon
		);
		$this->template->build('update', $data);
	}

	public function ajax_update(){
		$ids      = post("ids");
		$slug     = post("slug");
		$name     = post("name");
		$content  = $this->input->post("content");
		$position = post("position");

		$item = $this->model->get("*", "general_custom_page", "ids = '{$ids}'");
		if(empty($item)){

			if($name == ""){
				ms(array(
					"status"  => "error",
					"message" => lang("title_is_required")
				));
			}

			$data = array(
				"ids"         => ids(),
				"name"        => $name,
				"slug"        => $slug,
				"position"    => $position,
				"content"     => $content,
				"status"      => 1,
				"changed"     => NOW,
				"created"     => NOW,

			);

			$this->db->insert("general_custom_page", $data);
		}else{
			
			$data = array(
				"position"    => $position,
				"content"     => $content,
				"changed"     => NOW
			);

			if($item->status == 1){
				if($name == ""){
					ms(array(
						"status"  => "error",
						"message" => lang("title_is_required")
					));
				}

				$data["name"] = $name;
				$data["slug"] = $slug;
			}

			$this->db->update("general_custom_page", $data, array("ids" => $item->ids));
		}

		ms(array(
			"status"  => "success",
			"message" => lang("successfully")
		));
	}

	public function ajax_update_status(){
		$this->model->update_status("general_custom_page", post("id"), false);
	}
	
	public function ajax_delete_item(){
		$this->model->delete("general_custom_page", post("id"), false);
	}
}