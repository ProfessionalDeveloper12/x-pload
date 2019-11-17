<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MY_Model extends CI_Model
{
	function __construct(){
		parent::__construct();
		// Load the Database Module REQUIRED for this to work.
		$this->load->database();//Without it -> Message: Undefined property: XXXController::$db
	}
	
	function fetch($select = "*", $table = "", $where = "", $order = "", $by = "DESC", $start = -1, $limit = 0, $return_array = false)
	{
		$this->db->select($select);
		if($where != "")
		{
			$this->db->where($where);
		}
		if($order != "" && (strtolower($by) == "desc" || strtolower($by) == "asc"))
		{
			if($order == 'rand'){
				$this->db->order_by('rand()');
			}else{
				$this->db->order_by($order, $by);
			}
		}
		
		if((int)$start >= 0 && (int)$limit > 0)
		{
			$this->db->limit($limit, $start);
		}
		#Query
		$query = $this->db->get($table);
		if($return_array){
			$result = $query->result_array();
		} else {
			$result = $query->result();
		}
		$query->free_result();
		return $result;
	}	
	
	function get($select = "*", $table = "", $where = "", $order = "", $by = "DESC", $return_array = false)
	{
		$this->db->select($select);
		if($where != "")
		{
			$this->db->where($where);
		}
		if($order != "" && (strtolower($by) == "desc" || strtolower($by) == "asc"))
		{
			if($order == 'rand'){
				$this->db->order_by('rand()');
			}else{
				$this->db->order_by($order, $by);
			}
		}		
		#Query
		$query = $this->db->get($table);
		if($return_array){
			$result = $query->row_array();
		} else {
			$result = $query->row();
		}
		$query->free_result();

		return $result;
	}

	function schedule_report($table, $status=2){
		$value_string = "";
		$date_string = "";

		$date_list = array();
		$date = strtotime(date('Y-m-d', strtotime(NOW)));
		for ($i=29; $i >= 0; $i--) { 
			$left_date = $date - 86400 * $i;
			$date_list[date('Y-m-d', $left_date)] = 0;
		}

		//Get data
		$query = $this->db->query("SELECT COUNT(status) as count, DATE(time_post) as time_post FROM ".$table." WHERE status = '{$status}' AND uid = '".session("uid")."' AND time_post > NOW() - INTERVAL 30 DAY GROUP BY DATE(".$table.".time_post);");
		if($query->result()){
			

			foreach ($query->result() as $key => $value) {
				if(isset($date_list[$value->time_post])){
					$date_list[$value->time_post] = $value->count;
				}
			}

			
		}

		foreach ($date_list as $date => $value) {
			$value_string .= "{$value},";
			$date_string .= "'{$date}',";
		}

		$value_string = "[".substr($value_string, 0, -1)."]";
		$date_string  = "[".substr($date_string, 0, -1)."]";

		return (object)array(
			"value" => $value_string,
			"date" => $date_string
		);
		
	}

	function update_status($table, $ids, $check_user){
		if(!empty(post())){
			if($check_user){
				$where = array("uid" => session("uid"));
			}else{
				$where = array();
			}

			$item = $this->model->get("id, status", $table, "ids = '{$ids}'");
			if(!empty($item)){
				$where["id"] = $item->id;
				$status = $item->status == 0?1:0;
				$tag = $item->status == 0?"tag-success":"tag-danger";
				$text = $item->status == 0?lang("enable"):lang("disable");
				$this->db->update($table, array('status' => $status), $where);
				ms(array(
					"status"  => "success",
					"tag"     => $tag,
					"text"    => $text,
					"message" => lang("update_status_successfully")
				));
			}else{
				ms(array(
					"status"  => "error",
					"message" => lang("cannot_update_status_please_try_again")
				));
			}
		}else{
			load_404();
		}
		
	}

	function delete($table, $ids, $check_user){
		if(!empty(post())){
			if($check_user){
				$where = array("uid" => session("uid"));
			}else{
				$where = array();
			}

			if(!$ids){
				ms(array(
					"status"  => "error",
					"message" => lang("select_an_item_to_delete")
				));
			}

			if(is_array($ids)){
				foreach ($ids as $key => $id) {
					$where["ids"] = $id;
					$this->db->delete($table, $where);
				}
				
				ms(array(
					"status"  => "success",
					"message" => lang("delete_successfully")
				));
			}else{
				$item = $this->model->get("id", $table, "ids = '{$ids}'");
				if(!empty($item)){
					$where["id"] = $item->id;
					$this->db->delete($table, $where);
					ms(array(
						"status"  => "success",
						"message" => lang("delete_successfully")
					));
				}else{
					ms(array(
						"status"  => "error",
						"message" => lang("delete_failed_please_try_again")
					));
				}
			}
		}else{
			load_404();
		}
	}
	
	function history_ip($userid){
		$user = $this->model->get("id, history_ip", USERS, "id = '{$userid}'");	
		if(!empty($user)){
			$history_ip_old = (array)json_decode($user->history_ip);
			$history_ip = ($history_ip_old == "")?array():$history_ip_old;
			/*$finder = get_curl("http://ip-api.com/json");
			$finder = json_decode($finder);*/
			$history_ip[] = get_client_ip();

			if(count($history_ip) >= 10){
				array_shift($history_ip);
			}

			$this->db->update(USERS, array('history_ip' => json_encode($history_ip)), array("id" => $userid));
		}	
	}

	function get_proxies($table, $id = 0, $field = "id", $limit = true, $data){

		$uid = session("uid");
		if(!empty($data) && isset($data->uid)){
			$uid = $data->uid;
		}

		if(get_option('system_proxy', 1) == 1){
			$this->db->select("proxies.*, COUNT(accounts.default_proxy) as total");
			$this->db->from(PROXIES." as proxies");
			$this->db->join($table." as accounts", "proxies.id = accounts.default_proxy", "left");
			$this->db->where("proxies.status = 1");
			if($id != 0){
				$this->db->where("proxies.id = {$id}");
			}

			$this->db->group_by("proxies.id");
			$this->db->order_by("total", "ASC");
			if(!file_exists(APPPATH."../plugins/proxy_manager/")){
				$this->db->limit(1, 0);
			}
			$query = $this->db->get();

			if($query->result()){
				$result = $query->result();
				if(file_exists(APPPATH."../plugins/proxy_manager/")){

					$user = $this->model->get("*", USERS, "id = '".$uid."'");
					foreach ($result as $key => $row) {
						if($row->total >= (int)$row->limit){
							unset($result[$key]);
						}

						$packages = json_decode($row->package);
						if(!empty($packages)){
							if(!empty($packages) && !empty($user) &&  !in_array($user->package, $packages) && (int)$user->admin == 0){
								unset($result[$key]);
							}
						}
					}

					$result = array_values($result);
				}

				if(!empty($result)){
					if($limit && !empty($result)){
						return $result[0]->$field;
					}else{
						return $result;
					}
				}
			}
		}

		return false;
	}

	function get_storage($check_type = "", $size = 0){
		$user = $this->model->get("*", USERS, "id = '".session("uid")."'");
		$data = array(
			"max_storage_size" => 100,
			"max_file_size" => 5,
			"total_storage_size" => 0
		);

		$this->db->select("uid, SUM(file_size) AS size");
		$this->db->from(FILE_MANAGER);
		$this->db->where("uid", session("uid"));
		$this->db->group_by("uid");
		$query = $this->db->get();
		if($query->row()){
			$result = $query->row();
			if(!empty($result)){
				$total_size = (float)$result->size/1024;
				$data['total_storage_size'] = $total_size;
			}
		}else{
			
		}

		if(!empty($user)){
			$permission = (array)json_decode($user->permission);
			if(!empty($permission)){
				if(isset($permission['max_storage_size'])){
					$data['max_storage_size'] = $permission['max_storage_size'];
				}

				if(isset($permission['max_file_size'])){
					$data['max_file_size'] = $permission['max_file_size'];
				}
			}
		}

		$data = (object)$data;

		switch ($check_type) {
			case 'storage':
				$total_size = $data->total_storage_size + $size/1024;
				if($total_size > $data->max_storage_size){
					ms(array(
						"status" => "error",
						"message" => lang("you_have_exceeded_the_storage_limit")
					));
				}
				break;

			case 'file':
				$size = $size/1024;
				if($size > $data->max_file_size){
					ms(array(
						"status" => "error",
						"message" => lang("you_have_exceeded_the_file_limit")
					));
				}

				$total_size = $data->total_storage_size + $size;
				if($total_size > $data->max_storage_size){
					ms(array(
						"status" => "error",
						"message" => lang("you_have_exceeded_the_storage_limit")
					));
				}
				break;
			
			default:
				return $data;
				break;
		}
	}		

	function send_email($subject, $content, $userid){
		$user = $this->db->select("*")->from(USERS)->where("id", $userid)->get()->row();
		$package = $this->db->select("*")->from(PACKAGES)->where("type", 1)->get()->row();
		if(!empty($user)){
			//Send email
			$subject = nl2br($subject);
			$content = nl2br($content);

			$now = (int)strtotime(date("Y-m-d", strtotime(NOW)));
			$expiration_date = (int)strtotime($user->expiration_date);
			$days_left = ($expiration_date - $now)/(60*60*24);

			//Replace Subject
			$subject = str_replace("{full_name}", $user->fullname, $subject);
			$subject = str_replace("{days_left}", $days_left, $subject);
			$subject = str_replace("{expiration_date}", convert_date($user->expiration_date), $subject);
			$subject = str_replace("{trial_days}", $package->trial_day, $subject);
			$subject = str_replace("{email}", $user->email, $subject);
			$subject = str_replace("{activation_link}", cn("auth/activation/".$user->activation_key), $subject);
			$subject = str_replace("{recovery_password_link}", cn("auth/activation/".$user->reset_key), $subject);
			$subject = str_replace("{website_link}", cn(""), $subject);
			$subject = str_replace("{website_name}", get_option("website_title", "X-Pload - Social Marketing Tool"), $subject);

			//
			$content = str_replace("{full_name}", $user->fullname, $content);
			$content = str_replace("{days_left}", $days_left, $content);
			$content = str_replace("{expiration_date}", convert_date($user->expiration_date), $content);
			$content = str_replace("{trial_days}", $package->trial_day, $content);
			$content = str_replace("{email}", $user->email, $content);
			$content = str_replace("{activation_link}", cn("auth/activation/".$user->activation_key), $content);
			$content = str_replace("{recovery_password_link}", cn("auth/reset_password/".$user->reset_key), $content);
			$content = str_replace("{website_link}", cn(""), $content);
			$content = str_replace("{website_name}", get_option("website_title", "X-Pload - Social Marketing Tool"), $content);


			$template = Modules::run("email/template");
			$template = str_replace("{content}", $content, $template);

			$mail = new PHPMailer(true);
			$mail->CharSet = "utf-8";
			try {

			    if(get_option("email_protocol_type", "mail") == "smtp" && get_option("email_smtp_server", "") != "" && get_option("email_smtp_port", "") != ""){
					$mail->isSMTP();
					$mail->SMTPAuth = true;
					$mail->Host = get_option("email_smtp_server", "");
					$mail->Username = get_option("email_smtp_username", "");
					$mail->Password = get_option("email_smtp_password", "");
					$mail->SMTPSecure = get_option("email_smtp_encryption", "");
					$mail->Port = get_option("email_smtp_port", "");

				}else{
					$mail->isMail();
				}

				$email_from = get_option('email_from', '')?get_option('email_from', ''):"do-not-reply@gmail.com";
				$email_name = get_option('email_name', '')?get_option('email_name', ''):get_option('website_title', 'Social Planer - Social Marketing Tool');

			    //Recipients
			    $mail->setFrom($email_from, $email_name);
			    $mail->addAddress($user->email, $user->fullname);

			    //Content
			    $mail->isHTML(true);
			    $mail->Subject = $subject;
			    $mail->Body    = $template;
			    $mail->AltBody = $subject;

			    $mail->send();
			    return false;
			} catch (Exception $e) {
				return 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
			}

		}
	}
}
