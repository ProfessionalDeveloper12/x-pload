<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class blocks extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function set_language(){
		set_language(post("id"));

		ms(array("status" => "success"));
	}

	public function header(){
		$user = array();
		if(get_option('show_subscription', 0)==1){
			$user = $this->model->get("*", USERS, "id = '".session("uid")."'");
		}

		$data = array(
			"languages" => $this->model->fetch("*", LANGUAGE_LIST, "status = 1"),
			"user" => $user	
		);
		$this->load->view('header', $data);
	}
	
	public function sidebar(){
		$data = array();
		$this->load->view('sidebar', $data);
	}
}