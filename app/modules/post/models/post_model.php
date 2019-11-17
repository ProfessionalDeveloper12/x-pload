<?php
defined('BASEPATH') OR exit('No direct script access allowed');
function date_compare($a, $b){
    $t1 = strtotime($a->created);
    $t2 = strtotime($b->created);
    return $t2 - $t1;
} 

class post_model extends MY_Model {
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


			$can_post = true;
			if(strpos($directory, ".") === false){
				$model_name = $directory."_model";
				$this->load->model($directory.'/'.$model_name, $model_name);
				
				$methods = get_class_methods($this->$model_name);
				if(!in_array("post_handler", $methods)){
					$can_post = false;
				}
			}

			if ( $this->db->table_exists($tb_accounts) && $this->db->table_exists($tb_posts) && $can_post){

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

		usort($data, 'date_compare');

		return $data;
	}

	public function post_validator(){
		$accounts = post("accounts");

		if(empty($accounts)){
			ms(array(
				"status" => "error",
				"message" => lang("please_select_an_account")
			));
		}

		$directory = APPPATH.'../public/';
		$scanned_directory = array_diff(scandir($directory), array('..', '.'));
		$errors = array();
		$social_post = array();
		foreach ($scanned_directory as $key => $directory) {
			if(strpos($directory, ".") === false){
				$model_name = $directory."_model";
				$this->load->model($directory.'/'.$model_name, $model_name);
				
				$methods = get_class_methods($this->$model_name);
				if(in_array("post_validator", $methods)){
					$result = $this->$model_name->post_validator();
					if($result != 0){
						$errors[$directory] = $result;
						$social_post[] = $directory; 
					}
				}
			}
		}

		$have_errors = false;
		$can_post = false;
		$html_errors = "";
		$count_errors = 0;
		$social_can_posts = array();
		if(!empty($errors)){
			foreach ($errors as $social => $sub_errors) {
				if(empty($sub_errors)){
					$can_post = true;
					$social_can_posts[] = $social;
				}else{
					$have_errors = true;

					foreach ($sub_errors as $key => $error) {
						$html_errors .= "<li>{$error}</li>";
					}
					$count_errors++;
				}
			}
		}

		$html_errors = "<p>{$count_errors} ".lang("profiles_will_be_excluded_from_your_publication_in_next_step_due_to_errors")." </p><ul>".$html_errors."</ul>";

		$message = "";
		$status = "";
		if(!$have_errors){
			$status = "success";
		}else{
			if($can_post){
				$status = "warning";
			}else{
				$status = "error";
				$message = lang("missing_content_on_the_following_social_networks").implode(", ", $social_post);
			}
		}

		return array(
			"status"   => $status,
			"errors"   => $html_errors,
			"message"  => $message,
			"can_post" => json_encode($social_can_posts) 
		);
	}

	public function post_handler($social_can_posts){

		$directory = APPPATH.'../public/';
		$scanned_directory = array_diff(scandir($directory), array('..', '.'));

		$result = array();
		foreach ($scanned_directory as $key => $directory) {
			if(strpos($directory, ".") === false){
				$model_name = $directory."_model";
				$this->load->model($directory.'/'.$model_name, $model_name);
				
				$methods = get_class_methods($this->$model_name);
				if(in_array("post_handler", $methods) && in_array($directory, $social_can_posts)){
					$result[$model_name] = $this->$model_name->post_handler();
				}
			}
		}

		$count_error = 0;
		$count_success = 0;
		if(!empty($result)){
			foreach ($result as $data) {
				foreach ($data as $item) {
					if(isset($item['status']) && $item['status'] == "success"){
						$count_success++;
					}else{
						$count_error++;
					}
				}
			}
		}

		if(!post("is_schedule")){
			if($count_error == 0){
				ms(array(
					"status"  => "success",
					"message" => sprintf(lang("Content is being published on %d profiles"), $count_success)
				));
			}else{
				ms(array(
					"status"  => "success",
					"message" => sprintf(lang("Content is being published on %d profiles and %d profiles unpublished"), $count_success, $count_error)
				));
			}
		}else{
			ms(array(
				"status"  => "success",
				"message" => lang("Content successfully scheduled")
			));
		}
	} 

	public function post_previewer($link_info){

		//pr(permission_list(),1);
		$accounts = post("accounts");

		$directory = APPPATH.'../public/';
		$scanned_directory = array_diff(scandir($directory), array('..', '.'));
		$result = array();
		foreach ($scanned_directory as $key => $directory) {

			if( permission( $directory.'/post' ) ){
				$model_name = $directory."_model";
				if(strpos($directory, ".") === false && file_exists(APPPATH."../public/".$directory."/models/".$model_name.".php")){
					$this->load->model($directory.'/'.$model_name, $model_name);
					
					$methods = get_class_methods($this->$model_name);
					if(in_array("post_previewer", $methods)){
						$result[] = $this->$model_name->post_previewer($link_info);
					}
				}
			}

		}

		return $result;
	}
	
}
