<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class notification extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function get(){
		$data = array(
			"user"    => $this->model->get("admin", USERS, "id = '".session("uid")."'")
		);
		$this->load->view("get_notification", $data);
	}

	//Check For Updates

	public function check_update(){
		
	}

	public function curl($url){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_VERBOSE, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
	    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    $result = curl_exec($ch);
	    curl_close($ch);

	    return $result;
	}
}