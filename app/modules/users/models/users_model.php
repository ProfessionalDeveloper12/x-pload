<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class users_model extends MY_Model {
	public function __construct(){
		parent::__construct();
	}

	function getList($table, $columns, $limit=-1, $page=-1){
		$c = (int)get_secure('c'); //Column key
		$t = get_secure('t'); //Sort type
		$k = trim(get_secure('k')); //Search keywork

		if($limit == -1){
			$this->db->select('count(*) as sum');
			$this->db->from($table." as users");
		}else{
			$this->db->select(implode(", users.", array_keys($columns)).", users.ids, package.name as package");
			$this->db->from($table." as users");
			$this->db->join(PACKAGES." as package", 'package.id = users.package', 'left');
		}
		
		if($limit != -1) {
			$this->db->limit($limit, $page);
		}

		$this->db->where("users.login_type != 'team'");

		if($k){
			$i = 0;
			foreach ($columns as $column_name => $column_title) {
				if($i == 0){
					$this->db->like("users.".$column_name, $k);
				}else{
					$this->db->or_like("users.".$column_name, $k);
				}

				$this->db->not_like("users.login_type", "team");
				$i++;
			}
		}

		if($c){
			$i = 0;
			$s = ($t && ($t == "asc" || $t == "desc"))?$t:"desc";
			foreach ($columns as $column_name => $column_title) {
				if($i == $c){
					$this->db->order_by("users.".$column_name , $s);
				}
				$i++;
			}
		}else{
			$this->db->order_by('users.created', 'desc');
		}
				
		$query = $this->db->get();
		if($query->result()){
			if($limit == -1){
				return $query->row()->sum;
			}else{
				$result =  $query->result();
				return $result;
			}

		}else{
			return false;
		}
	}

	public function total_register_by_day($days = 30){
		$days =  date("Y-m-d 00:00:00", strtotime(NOW) - $days*86400);
		$query = $this->db->query("SELECT created FROM ".USERS." WHERE created > '".$days."'");
		return $query->num_rows();
	}

	public function get_login_type(){
		$query = $this->db->query("SELECT COUNT(login_type) as count, login_type FROM ".USERS." GROUP BY login_type");
		$data = array(
			"direct" => 0,
			"facebook" => 0,
			"google" => 0,
			"twitter" => 0
		);
		if($query->result()){
			foreach ($query->result() as $row) {
				$data[$row->login_type] = $row->count;
			}
		}

		return (object)$data;
	}

	public function get_users_status(){
		$query = $this->db->query("SELECT COUNT(status) as count, status FROM ".USERS." GROUP BY status");
		$data = array(
			"enable" => 0,
			"disable" => 0
		);

		if($query->result()){
			foreach ($query->result() as $row) {
				if($row->status == 0){
					$data["disable"] = $row->count;
				}else{
					$data["enable"] = $row->count;
				}
			}
		}

		return (object)$data;
	}

	public function get_stats($day = 10){
		$day -= 1;
		$table = USERS;
		$value_string = "";
		$date_string = "";

		$date_list = array();
		$date = strtotime(date('Y-m-d', strtotime(NOW)));
		for ($i=$day; $i >= 0; $i--) { 
			$left_date = $date - 86400 * $i;
			$date_list[date('Y-m-d', $left_date)] = 0;
		}

		//Get data
		$query = $this->db->query("SELECT COUNT(created) as count, DATE(created) as created FROM ".$table." WHERE created > NOW() - INTERVAL 30 DAY GROUP BY DATE(".$table.".created);");

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
