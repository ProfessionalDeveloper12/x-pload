<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profile_model extends MY_Model {
	public function __construct(){
		parent::__construct();
	}

	public function get_profile(){
		$this->db->select("user.*, package.name as package_name");
		$this->db->from(USERS." as user");
		$this->db->join(PACKAGES. " as package", "package.id = user.package");
		$this->db->where("user.id", session("uid"));
		$query = $this->db->get();
		if($query->row()){
			return $query->row();
		}else{
			return false;
		}
	}
}
