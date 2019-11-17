<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class caption extends MX_Controller {
	public $table;
	public $columns;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		//Config Module
		$this->table       = CAPTION;
		$this->module_name = lang("caption");
		$this->module_icon = "ft-command";
		

		$this->columns = array(
			"content"              => lang("content"),
			"status"               => lang("status")
		);
	}

	public function index(){
		$page        = (int)get("p");
		$limit       = 20;
		$result      = $this->model->getList($this->table, $this->columns, $limit, $page);
		$total       = $this->model->getList($this->table, $this->columns, -1, -1);
		$total_final = $total;

		$query = array();
		$query_string = "";
		if(get("c")) $query["c"] = get("c");
		if(get("t")) $query["t"] = get("t");
		if(get("k")) $query["k"] = get("k");

		if(!empty($query)){
			$query_string = "?".http_build_query($query);
		}

		$configs = array(
			"base_url"   => cn(get_class($this).$query_string), 
			"total_rows" => $total_final, 
			"per_page"   => $limit
		);

		$this->pagination->initialize($configs);

		$data = array(
			"columns" => $this->columns,
			"result"  => $result,
			"total"   => $total_final,
			"page"    => $page,
			"limit"   => $limit,
			"module"  => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon
		);

		$this->template->build('index', $data);
	}

	public function update(){
		$data = array(
			"result"      => $this->model->get("*", $this->table, "ids = '".segment(3)."'"),       
			"module"      => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon
		);
		$this->template->build('update', $data);
	}

	public function ajax_update(){
		$ids         = post("ids");
		$caption     = post("caption");

		if($caption == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("caption_is_required")
			));
		}

		$data = array(
			'uid'       => session("uid"),
			'content'   => $caption,
			'changed'   => NOW
		);

		$item = $this->model->get("id", $this->table, "ids = '{$ids}'");
		if(empty($item)){
			$data['ids'] = ids();
			$data['status'] = 1;
			$data['created'] = NOW;
			$this->db->insert($this->table, $data);
		}else{
			$this->db->update($this->table, $data, array("id" => $item->id));
		}
		
		ms(array(
			"status"  => "success",
			"message" => lang("successfully")
		));
	}

	public function export(){
		export_csv($this->table);
	}

	public function ajax_update_status(){
		$this->model->update_status($this->table, post("id"), false);
	}
	
	public function ajax_delete_item(){
		$this->model->delete($this->table, post("id"), false);
	}

	public function popup(){
		$this->load->view('popup_caption');
	}

	public function save_caption(){
		$caption = post("caption");

		$item = $this->model->get("*", $this->table, "content = '{$caption}' AND uid = '".session("uid")."'");
		if(empty($item)){
			$data = array(
				"ids" => ids(),
				"uid" => session("uid"),
				"content" => $caption,
				"status" => 1,
				"changed" => NOW,
				"created" => NOW
			);

			$this->db->insert($this->table, $data);

			ms(array(
			"status"  => "success",
			"message" => lang("add_caption_successfully")
		));
		}else{
			ms(array(
				"status"  => "error",
				"message" => lang("this_caption_already_exists")
			));
		}
	}

	public function get_caption($page = 0){
		$limit = 10;
		$start = $page * $limit;
		$next_start = ($page+1) * $limit;
		$captions = $this->model->fetch("*", $this->table, "status = 1 AND uid = '".session("uid")."'", "id", "desc", $start, $limit);
		$next_captions = $this->model->fetch("*", $this->table, "status = 1 AND uid = '".session("uid")."'", "id", "desc", $next_start, $limit);
		$data = array(
			"limit" => $limit,
			"page" => $page,
			"captions" => $captions,
			"next_captions" => $next_captions
		);

		$this->load->view('get_caption', $data);
	}
}