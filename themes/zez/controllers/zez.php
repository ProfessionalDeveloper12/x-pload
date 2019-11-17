<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class zez extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		$this->template->set_layout('blank_page');
	}

	public function index(){
		$data = array();
		
		$this->template->build('index', $data);
	}

	public function header($show_html = true){
		$header_data = array(
			"show" => $show_html,
			"languages" => $this->model->fetch("*", LANGUAGE_LIST, "status = 1")
		);
		
		$this->load->view('header', $header_data);
	}

	public function footer($show_html = true){
		$footer_data = array("show" => $show_html);
		$this->load->view('footer', $footer_data);
	}

	public function page(){
		$result = $this->model->get("*", CUSTOM_PAGE, "slug = '".segment(2)."'");
		if(empty($result)) redirect(PATH);

		$data = array(
			"result" => $result
		);
		$this->template->build('page', $data);
	}
}