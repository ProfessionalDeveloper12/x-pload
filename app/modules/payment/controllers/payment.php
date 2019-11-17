<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class payment extends MX_Controller {

	public $tb_packages;

	public function __construct(){
		parent::__construct();
		$this->tb_packages = PACKAGES;
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$package = $this->model->get("*", $this->tb_packages, "ids = '".segment(2)."'  AND status = 1 AND type = 2", "sort", "asc");
		if(empty($package)){
			redirect(cn('pricing'));
		}


		$type = 2;
		if((int)get("type") == 1){
			$type = 1;
		}

		$data = array(
			'package' => $package,
			'type'    => $type
		);
		$this->template->set_layout('pricing_page');
		$this->template->build('index', $data);
	}

	public function pricing(){
		$data = array(
			"package" => $this->model->fetch("*", $this->tb_packages, "status = 1 AND type = 2", "sort", "asc")
		);

		$this->template->set_layout('blank_page');
		$this->template->build('../../../themes/'.get_theme().'/views/pricing', $data);
	}

	public function block_pricing(){
		$data = array(
			"package" => $this->model->fetch("*", $this->tb_packages, "status = 1 AND type = 2", "sort", "asc")
		);

		$this->load->view('../../../themes/'.get_theme().'/views/block_pricing', $data);
	}

	public function block_sidebar(){
		$this->load->view("block_siderbar");
	}

	public function block_menu(){
		$this->load->view("menu");
	}

	public function block_general_settings(){
		$this->load->view("general_settings");
	}

	public function block_payments($block = "block_active"){
		$directory = APPPATH."modules/payment/controllers/";
		$files = glob($directory . "*");

		$stripe_file = "";
		$paypal_file = "";
		foreach ($files as $file) {
			if(stripos($file, "paypal") !== false){
				$paypal_file = $file;
			}

			if(stripos($file, "stripe") !== false){
				$stripe_file = $file;
			}
		}

		if (($key = array_search($stripe_file, $files)) !== false) {
		    unset($files[$key]);
		}

		if (($key = array_search($paypal_file, $files)) !== false) {
		    unset($files[$key]);
		}
		array_unshift($files, $paypal_file);
		array_unshift($files, $stripe_file);

		$data = "";

		foreach ($files as $controller_file) 
		{
			$content_file = file_get_contents($controller_file);

			if (preg_match("/{$block}/i", $content_file))
			{
				$directory_file = explode("/", $controller_file);
				if(!empty($directory_file))
				{
					$file = end($directory_file);
					$file_name = str_replace(".php", "", $file);
					$data .= modules::run("payment/{$file_name}/{$block}");
				}
			}
		}

		echo $data;
	}

	public function thank_you(){
		if(get_option("email_payment_enable", "")){
			$this->model->send_email(get_option("email_payment_subject", ""), get_option("email_payment_content", ""), session("uid"));
		}

		$data = array();
		$this->template->set_layout('thank_you_page');
		$this->template->build('thank_you', $data);
	}

	public function payment_unsuccessfully(){
		$data = array();
		$this->template->set_layout('thank_you_page');
		$this->template->build('payment_unsuccessfully', $data);
	}

	
}