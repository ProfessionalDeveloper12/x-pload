<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class payment_history_model extends MY_Model {
	public function __construct(){
		parent::__construct();
	}

	function getList($table, $columns, $limit=-1, $page=-1){
		$c = (int)get_secure('c'); //Column key
		$t = get_secure('t'); //Sort type
		$k = get_secure('k'); //Search keywork

		if($limit == -1){
			$this->db->select('count(h.ids) as sum');
		}else{
			$this->db->select("p.name as package, u.email as account, h.type, h.transaction_id, h.plan, h.amount, h.created, h.ids");
		}
		
		$this->db->from($table." as h");
		$this->db->join(USERS." as u", "u.id = h.uid");
		$this->db->join(PACKAGES." as p", "p.id = h.package");

		if($limit != -1) {
			$this->db->limit($limit, $page);
		}

		if($k){
			$i = 0;
			foreach ($columns as $column_name => $column_title) {
				switch ($column_name) {
					case 'package':
						$column_name = "p.name";
						break;

					case 'account':
						$column_name = "u.email";
						break;
					
					default:
						$column_name = "h.".$column_name;
						break;
				}
				if($i == 0){
					$this->db->like($column_name, $k);
				}else{
					$this->db->or_like($column_name, $k);
				}
				$i++;
			}
		}

		if($c){
			$i = 0;
			$s = ($t && ($t == "asc" || $t == "desc"))?$t:"desc";
			foreach ($columns as $column_name => $column_title) {
				if($i == $c){
					switch ($column_name) {
						case 'package':
							$column_name = "p.name";
							break;

						case 'account':
							$column_name = "u.email";
							break;
						
						default:
							$column_name = "h.".$column_name;
							break;
					}
					$this->db->order_by($column_name , $s);
				}
				$i++;
			}
		}else{
			$this->db->order_by('h.created', 'desc');
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
}
