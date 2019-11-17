<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class instagram extends MX_Controller {
	public $table;
	public $module;
	public $module_name;
	public $module_icon;
	public $username;
	public $password;
	public $security_code;
	public $apiPath;
	public $choice = 1;

	public function __construct(){ 
		parent::__construct();
		
		$this->table = INSTAGRAM_ACCOUNTS;
		$this->module = get_class($this);
		$this->module_name = lang("instagram_accounts");
		$this->module_icon = "fa fa-instagram";
		$this->load->model($this->module.'_model', 'model');
	}

	public function block_general_settings(){
		$data = array();
		$this->load->view('account/general_settings', $data);
	}

	public function block_list_account(){
		$data = array(
			'module'       => $this->module,
			'module_name'  => $this->module_name,
			'module_icon'  => $this->module_icon,
			'list_account' => $this->model->fetch("id, username, avatar, ids, status", $this->table, "uid = '".session("uid")."'")
		);
		$this->load->view("account/index", $data);
	}
	
	public function popup_add_account(){
		$ids = segment(3);
		$result = $this->model->get("*", $this->table, "ids = '".$ids."' AND uid = '".session("uid")."'");

		$data = array(
			'module'       => $this->module,
			'module_name'  => $this->module_name,
			'module_icon'  => $this->module_icon,
			'result'       => $result
		);
		$this->load->view('account/popup_add_account', $data);
	}

	public function ajax_add_account(){
		$username = post("username");
		$password = post("password");
		$proxy    = post("proxy");
		$code     = post("code");
		$security_code     = post("security_code");
		$verification_code = post("code");
		$password_encode = encrypt_encode($password);

		$this->username = $username;
		$this->password = $password;
		$this->security_code = $security_code;

		if(empty($username) || empty($password)){
			ms(array(
				"status"  => "error",
				"message" => lang("please_enter_username_and_password")
			));
		}

		if(!permission("instagram_enable")){
			ms(array(
				"status" => "error",
				"message" => lang("disable_feature")
			));
		}

		$instagram_account = $this->model->get("id, default_proxy", $this->table, "username = '".$username."' AND uid = '".session("uid")."'");
		$proxy_data = get_proxy($this->table, $proxy, $instagram_account);


		try {
			$ig = new InstagramAPI($username, $password_encode, $proxy_data->use, true, $security_code, $verification_code);
			$login_repsonse = $ig->login();

			if($login_repsonse["status"] == "success"){

				$user = $ig->get_current_user();

				if(!empty($user)){
					$user = $user->user;
					
					$data = array(
						"uid"      => session("uid"),
						"pid"      => $user->pk,
						"avatar"   => "https://avatar.stackposts.com/?u=".$user->username,
						"username" => $user->username,
						"password" => $password_encode,
						"proxy"    => (get_option('user_proxy', 1) == 1)?$proxy:"",
						"default_proxy" => $proxy_data->system,
						"status"   => 1,
						"changed"  => NOW,
					);

					if(empty($instagram_account)){

						if(!check_number_account($this->table)){
							ms(array(
								"status" => "error",
								"message" => lang("limit_social_accounts")
							));
						}

						$data['ids'] = ids();
						$data['created'] = NOW;
						$this->db->insert($this->table, $data);
					}else{
						$this->db->update($this->table, $data, "id = '".$instagram_account->id."'");			
					}

					ms(array(
						"status"  => "success",
						"message" => lang("successfully")
					));
				}else{
					ms(array(
						"status"  => "error",
						"message" => lang("login_failed_please_try_again")
					));
				}

			}else{
				ms($login_repsonse);
			}
			
			
		} catch (Exception $e) {

			ms(array(
				"status"  => "error",
				"message" => $e->getMessage()
			));

		}
		
	}

	public function clear_cookies(){
		$id = post("id");
		$account = $this->model->get("*", $this->table, "ids = '".post("id")."' AND uid = '".session("uid")."'");

		if(!empty($account)){
			$this->db->update("instagram_sessions", array("cookies" => NULL), array("username" => $account->username));
		}

		ms(array(
			"status"  => "success",
			"message" => lang("successfully")
		));
	}

	public function ajax_delete_item(){
		$item = $this->model->get("username", $this->table, "ids = '".post("id")."'");
		if(!empty($item)){
			$this->db->delete('instagram_sessions', "username = '{$item->username}'");
		}
		$this->model->delete($this->table, post("id"), false);

	}
}