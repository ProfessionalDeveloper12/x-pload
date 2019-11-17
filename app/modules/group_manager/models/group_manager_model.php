<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class group_manager_model extends MY_Model {
	public function __construct(){
		parent::__construct();
	}

	public function get_accounts(){
		$directory = APPPATH.'../public/';
		$scanned_directory = array_diff(scandir($directory), array('..', '.'));
		
		$data = array();
		foreach ($scanned_directory as $key => $directory) {
			$tb_accounts = $directory."_accounts";
			$tb_posts = $directory."_posts";

			if ( $this->db->table_exists($tb_accounts) && $this->db->table_exists($tb_posts)){
				if($directory == "facebook"){
					$accounts = $this->model->fetch("*", $tb_accounts, "status = 1 AND uid = '".session("uid")."' AND official != 3");
				}else{
					$accounts = $this->model->fetch("*", $tb_accounts, "status = 1 AND uid = '".session("uid")."'");
				}

				if(!empty($accounts)){
					foreach ($accounts as $key => $account) {
						$data[] = (object)array(
							"category" => $directory,
							"username" => isset($account->username)?$account->username:$account->fullname,
							"type" => isset($account->type)?$account->type:"profile",
							"pid" => $account->ids,
							"avatar" => $account->avatar,
							"created" => $account->created,
						);
					}
				}
			}

		}

		return $data;
	}

}
