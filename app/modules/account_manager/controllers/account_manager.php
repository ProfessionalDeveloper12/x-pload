<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class account_manager extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$data = array();
		$this->template->title('Dashboard');
		$this->template->build('account/index', $data);
	}
}