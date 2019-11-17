<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class group_manager extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index($page = "empty", $ids = ""){

		if(!file_exists(APPPATH."modules/group_manager/views/general/".$page.".php")){
			$page = "general";
		}

		$groups = $this->model->fetch("*", "general_groups", "uid = '".session("uid")."'");

		$group = array();
		if($ids != ""){
			$group = $this->model->get("*", "general_groups", "ids = '{$ids}' AND uid = '".session("uid")."'");
		}

		$data = array(
			"accounts" => $this->model->get_accounts(),
			"group" => $group
		);

		if (!$this->input->is_ajax_request()) {
			$view = $this->load->view("general/".$page, $data, true);
			$this->template->build('index', array("view" => $view, "groups" => $groups));
		}else{
			$this->load->view("general/".$page, $data);
		}

	}

	public function ajax_save(){
		$ids = post("ids");
		$name = post("name");
		$id = post("id");


		if(empty($id)){
			ms(array(
				"status" => "error",
				"message" => lang("Select at least one account")
			));
		}

		if(!$ids){
			if($name == ""){
				ms(array(
					"status" => "error",
					"message" => lang("Group name is required")
				));
			}

			$item = $this->model->get("*", "general_groups", "name = '{$name}'");
			if(!empty($item)){
				ms(array(
					"status" => "error",
					"message" => lang("Group name already exists")
				));
			}

			$data = array(
				"ids" => ids(),
				"uid" => session("uid"),
				"name" => $name,
				"data" => json_encode(array_unique($id)),
				"changed" => NOW,
				"created" => NOW
			);

			$this->db->insert("general_groups", $data);

		}else{

			if($name == ""){
				ms(array(
					"status" => "error",
					"message" => lang("Group name is required")
				));
			}

			$item = $this->model->get("*", "general_groups", "name = '{$name}' AND ids != '{$ids}'");
			if(!empty($item)){
				ms(array(
					"status" => "error",
					"message" => lang("Group name already exists")
				));
			}

			$data = array(
				"name" => $name,
				"data" => json_encode(array_unique($id)),
				"changed" => NOW,
			);

			$this->db->update("general_groups", $data, array("ids" => $ids));
		}

		ms(array(
        	"status"  => "success",
        	"message" => lang('update_successfully'),
        ));
	}

	public function ajax_delete_item(){
		$this->model->delete("general_groups", post("id"), false);
	}
}