<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class post extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$accounts = $this->model->get_accounts();

		$data = array(
			"accounts" => $accounts
		);

		$this->template->build('index', $data);
	}

	public function ajax_post($skip_validate = false){
		$validator = $this->model->post_validator();

		$social_can_post = json_decode($validator["can_post"]);
		if( ($skip_validate && !empty($social_can_post)) || $validator["status"] == "success" ){
			$result = $this->model->post_handler($social_can_post);
		}

		ms($validator);;
	}

	public function get_link_info(){
		$link = post("link");
		$link_info = get_info_link($link);
		ms($link_info);
	}

	public function previewer(){
		//Get link info
		$link = post("link");
		$link_info = (object)get_info_link($link);

		$result = $this->model->post_previewer($link_info);
		$data = array(
			"link_info" => $link_info,
			"result" => $result
		);

		echo $this->load->view("preview", $data, true);
	}
}