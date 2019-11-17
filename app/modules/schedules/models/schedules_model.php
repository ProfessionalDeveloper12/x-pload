<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class schedules_model extends MY_Model {
	public function __construct(){
		parent::__construct();
	}

	/****************************************/
	/*           SCHEDULES POST             */
	/****************************************/
	function get_calendar_schedules($tb_posts, $type = "queue"){
		$id = (int)get("mid");
		$user_timezone = get_field(USERS, $id, "timezone");

		$this->db->select("DATE(CONVERT_TZ(time_post,'".tz_convert(TIMEZONE)."','".tz_convert($user_timezone)."')) as time_post, COUNT(time_post) as total");
		$this->db->where("uid", $id);

		switch ($type) {
			case 'published':
				$this->db->where("status", 2);
				break;

			case 'unpublished':
				$this->db->where("status", 3);
				break;
			
			default:
				$this->db->where("status", 1);
				break;
		}

		$this->db->group_by("DATE(CONVERT_TZ(time_post,'".tz_convert(TIMEZONE)."','".tz_convert($user_timezone)."'))"); 
		$this->db->order_by('total', 'desc'); 
		$query = $this->db->get($tb_posts);

		if($query->result()){
			return $query->result();
		}else{
			return false;
		}
	}

	function count_post_on_each_account($username, $tb_posts, $tb_accounts){
		$timezone_first = get_timezone_system(session("schedule_date")." 00:00:00");
		$timezone_last = get_timezone_system(session("schedule_date")." 23:59:59");

		$accounts = $this->model->fetch("*, ".$username." as username", $tb_accounts, "uid = ".session("uid"), "id", "asc");
		foreach ($accounts as $key => $row) {
			$this->db->select("count(*) as count");
			$this->db->where("time_post >=", $timezone_first);
			$this->db->where("time_post <=", $timezone_last);
			$this->db->where("account", $row->id);

			switch ((int)get("t")) {
				case 3:
					$this->db->where("status", 3);
					break;

				case 2:
					$this->db->where("status", 2);
					break;
				
				default:
					$this->db->where("status", 1);
					break;
			}

			$query = $this->db->get($tb_posts);
			if($query->row()){
				$result = $query->row();
				$accounts[$key]->total = $result->count;
			}else{
				$accounts[$key]->total = 0;
			}
		}

		return $accounts;
	}

	function count_schedules($tb_posts){
		$timezone_first = get_timezone_system(session("schedule_date")." 00:00:00");
		$timezone_last = get_timezone_system(session("schedule_date")." 23:59:59");

		$this->db->select('status, COUNT(status) as total');
		$this->db->where("uid", session("uid"));
		$this->db->where("time_post >=", $timezone_first);
		$this->db->where("time_post <=", $timezone_last);

		$this->db->group_by("status"); 
		$query = $this->db->get($tb_posts);

		$count = array();

		if($query->result()){

			$result = $query->result();
			foreach ($result as $key => $value) {
				$count[$value->status] = $value->total;
			}
			return $count;
		}else{
			return false;
		}
	}

	function get_schedules($page = 0, $username = "username", $tb_posts = "", $tb_account = ""){
		$timezone_first = get_timezone_system(session("schedule_date")." 00:00:00");
		$timezone_last = get_timezone_system(session("schedule_date")." 23:59:59");
		
		$type = (int)post("id");
		$ids = segment("4");

		$this->db->select("post.*, account.".$username." as username");
		$this->db->from($tb_posts." as post");
		$this->db->join($tb_account." as account", "account.id = post.account");

		switch ($type) {
			case 3:
				set_session("schedule_type", 3);
				$this->db->where("post.status", 3);
				break;

			case 2:
				set_session("schedule_type", 2);
				$this->db->where("post.status", 2);
				break;
			
			default:
				set_session("schedule_type", 1);
				$this->db->where("post.status", 1);
				break;
		}

		if($ids){
			$this->db->where("account.ids", $ids);
		}
		$this->db->where("time_post >=", $timezone_first);
		$this->db->where("time_post <=", $timezone_last);
		$this->db->where("post.uid", session("uid"));
		$this->db->order_by("time_post", "desc");
		$this->db->limit(1000, (int)$page*24);
		$query = $this->db->get();

		if($query->result()){
			return $query->result();
		}else{
			return false;
		}
	}
	//****************************************/
	//         END SCHEDULES POST            */
	//****************************************/
}
