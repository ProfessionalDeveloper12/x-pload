<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class activity_model extends MY_Model {
	public function __construct(){
		parent::__construct();
	}

	public function get_activites(){
		$this->db->select("activities.*, accounts.username, accounts.ids as ids, accounts.avatar, accounts.status as account_status");
		$this->db->from(INSTAGRAM_ACTIVITIES." as activities");
		$this->db->join(INSTAGRAM_ACCOUNTS." as accounts", "activities.account = accounts.id", "RIGHT");

		$this->db->where("((accounts.uid = ".session("uid")." AND activities.pid = 0) OR (accounts.uid = '".session("uid")."' AND activities.pid IS NULL))");
		switch (get("time")) {
			case 'started':
				$this->db->where("activities.status", "1");
				break;

			case 'stoped':
				$this->db->where("activities.status", 0);
				break;
			
			case 'none':
				$this->db->where("activities.status", NULL);
				break;
		}

		if(get("q")){
			$this->db->like("accounts.username", get_secure("q"));
		}		

		switch (get("type")) {
			case 'username':
				$this->db->order_by("accounts.username", "asc");
				break;

			case 'time':
				$this->db->order_by("accounts.created", "asc");
				break;
		}
		
		$query = $this->db->get();

		if($query->result()){
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_activites_tmp(){
		$this->db->select("activities.*, accounts.username");
		$this->db->from(INSTAGRAM_ACTIVITIES." as activities");
		$this->db->join(INSTAGRAM_ACCOUNTS." as accounts", "activities.account = accounts.id", "left outer");
		$this->db->where("activities.uid = ".session("uid")." AND activities.pid = 0 AND accounts.username IS NULL");
		$query = $this->db->get();

		if($query->result()){
			$result = $query->result();
			if(!empty($result)){
				$ids = array();
				foreach ($result as $value) {
					$ids[] = $value->id;
				}

				$this->db->where_in("id" , $ids);
				$this->db->or_where_in("pid" , $ids);
				$this->db->delete(INSTAGRAM_ACTIVITIES);

				$this->db->where_in("pid" , $ids);
				$this->db->delete(INSTAGRAM_ACTIVITIES_LOG);
			}
		}
	}

	public function get_activity($ids){
		$this->db->select("activity.*, account.username, account.ids as ids, account.avatar, activity.pid as pid, account.status as account_status");
		$this->db->from(INSTAGRAM_ACTIVITIES." as activity");
		$this->db->join(INSTAGRAM_ACCOUNTS." as account", "activity.account = account.id", "RIGHT");
		$this->db->where("((account.uid = ".session("uid")." AND activity.pid = 0 AND activity.ids = '".$ids."') OR (account.uid = '".session("uid")."' AND activity.pid IS NULL AND account.ids = '".$ids."'))");
		$query = $this->db->get();
		if($query->row()){
			return $query->row();
		}else{
			return false;
		}
	}

	public function get_log($account, $type, $page = 0){
		$this->db->select("*");
		$this->db->from(INSTAGRAM_ACTIVITIES_LOG);

		switch ($type) {
			case "likes":
				$this->db->where("action", "like");
				break;
			
			case "comments":
				$this->db->where("action", "comment");
				break;

			case "followers":
				$this->db->where("action", "follow");
				break;

			case "unfollows":
				$this->db->where("action", "unfollow");
				break;

			case "direct_messages":
				$this->db->where("action", "direct_message");
				break;
			case "repost_medias":
				$this->db->where("action", "repost_media");
				break;
		}

		$this->db->where("pid", $account);
		$this->db->where("uid", session("uid"));
		$this->db->order_by("created", "desc");
		$this->db->limit(30, (int)$page*30);
		$query = $this->db->get();

		if($query->result()){
			return $query->result();
		}else{
			return false;
		}
	}

	public function count_all_log(){
		$activities = $this->model->fetch("*", INSTAGRAM_ACTIVITIES, "pid = 0 AND uid = '".session("uid")."'");
		$counter = array(
			"like" => 0, 
			"comment" => 0, 
			"follow" => 0, 
			"unfollow" => 0, 
			"direct_message" => 0,
			"repost_media" => 0 
		);

		foreach ($activities as $row) {
			$settings = $row->settings;
			$counter["like"] += igac("like", $row->settings);
			$counter["comment"] += igac("comment", $row->settings);
			$counter["follow"] += igac("follow", $row->settings);
			$counter["unfollow"] += igac("unfollow", $row->settings);
			$counter["direct_message"] += igac("direct_message", $row->settings);
			$counter["repost_media"] += igac("repost_media", $row->settings);
		}

		return (object)$counter;
	}

	public function stats_log($action){
		$table = INSTAGRAM_ACTIVITIES_LOG;
		$status = 2;

		$value_string = "";
		$date_string = "";

		$date_list = array();
		$date = strtotime(date('Y-m-d', strtotime(NOW)));
		for ($i=7; $i >= 0; $i--) { 
			$left_date = $date - 86400 * $i;
			$date_list[date('Y-m-d', $left_date)] = 0;
		}

		//Get data
		$query = $this->db->query("SELECT COUNT(created) as count, DATE(created) as created FROM ".$table." WHERE action = '{$action}' AND uid = '".session("uid")."' AND created > NOW() - INTERVAL 7 DAY GROUP BY DATE(created), action;");
		if($query->result()){
			

			foreach ($query->result() as $key => $value) {
				if(isset($date_list[$value->created])){
					$date_list[$value->created] = $value->count;
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
}