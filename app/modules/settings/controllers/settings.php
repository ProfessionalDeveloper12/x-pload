<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class settings extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){}

	public function general($page = "general"){

		if(!file_exists(APPPATH."modules/settings/views/general/".$page.".php")){
			$page = "general";
		}

		$data = array();

		if (!$this->input->is_ajax_request()) {
			$view = $this->load->view("general/".$page, $data, true);
			modules::run("setting/index", $data);
			$this->template->build('index', array("view" => $view));
		}else{
			$this->load->view("general/".$page, $data);
		}

	}

	public function ajax_settings(){
		$data = $this->input->post();
		$theme = $this->input->post("theme");
		if(is_array($data)){
			foreach ($data as $key => $value) {
				if($key == "embed_javascript"){
					$value = htmlspecialchars(@$_POST[$key], ENT_QUOTES);
				}

				if($key == "disable_landing_page"){
					$route = file(APPPATH."config/routes.php"); // reads an array of lines
					if( post('disable_landing_page') ){
						$route = array_map(function($route) {
						  return stristr($route,'default_controller') ? '$route["default_controller"] = "auth/login";'."\n" : $route;
						}, $route);
					}else{
						$route = array_map(function($route) {
						  return stristr($route,'default_controller') ? '$route["default_controller"] = $theme;'."\n" : $route;
						}, $route);
					}
					file_put_contents(APPPATH."config/routes.php", implode('', $route));

					$value = htmlspecialchars(@$_POST[$key], ENT_QUOTES);
				}

				update_option($key, trim($value));
			}
		}

		if($theme != ""){
			$theme_file = fopen(APPPATH."../themes/config.json", "w");
			$txt = '{ "theme" : "'.$theme.'" }';
			fwrite($theme_file, $txt);
			fclose($theme_file);
		}

		ms(array(
        	"status"  => "success",
        	"message" => lang('update_successfully'),
        ));
	}
}