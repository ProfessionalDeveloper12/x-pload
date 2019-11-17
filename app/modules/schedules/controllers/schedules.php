<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class schedules extends MX_Controller {
	public $table;
	public $columns;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$data = array();
		$this->template->build('index', $data);
	}

	public function calendar(){
		$type = post("sc_type");
		$socials = $this->input->post("social_filter");
		$data = array(
			"type" => $type,
			"socials" =>  $socials
		);
		$this->load->view('calendar', $data);
	}

	public function delete(){
		$type = post("sc_delete_type");
		$social = post("sc_delete_social");

		if(empty($social)){
			ms(array(
				"status" => "error",
				"message" => lang("Please select social network you want delete schedules")
			));
		}

		delete_schedules($type, $social);

		ms(array(
        	"status"  => "success"
        ));
	}

	public function xml($type = "queue", $socials = ""){
		header("Content-type: text/xml");
		block_schedules($type, $socials);
	}

	/****************************************/
	/*           SCHEDULES POST             */
	/****************************************/
	public function block_schedules_xml($template = "", $tb_posts = "", $type = ""){
		$this->load->model('schedules_model');

		$this->load->library('user_agent');
		if($this->agent->browser() != ""){
			redirect(cn());
		}

		switch ($type) {
			case 'published':
				$filter = "?t=2";
				break;

			case 'unpublished':
				$filter = "?t=3";
				break;
			
			default:
				$filter = "";
				break;
		}

		$result = $this->schedules_model->get_calendar_schedules($tb_posts, $type);
		
		$data = "";
		if(!empty($result)){
			foreach ($result as $key => $row) {
				$module = "post";

				if(isset($template['module'])){
					$module = $template['module'];
				}

				$data .= '<event>
				    <id>'.ids().'</id>
				    <name>	&lt;i class="'.$template['icon'].'" &gt; &lt;/i &gt; '.$row->total.' '.$template['name'].'</name>
				    <startdate>'.$row->time_post.'</startdate>
				    <enddate></enddate>
				    <color>'.$template['color'].'</color>
				    <url>'.PATH.$template['controller']."/".$module."/schedules/".date("Y/m/d", strtotime($row->time_post)).$filter.'</url>
				  </event>';
			}
		}else{
			return false;
		}

		print_r($data);
	}

	public function schedules($username = "", $tb_posts = "", $tb_accounts = ""){
		$this->load->model('schedules_model');

		$year = segment(4);
		$month = segment(5);
		$day = segment(6);
		$date = $year."/".$month."/".$day;
		if(!validateDate($date, "Y/m/d")){
			redirect(cn("schedules"));
		}else{
			set_session("schedule_date", str_replace("/", "-", $date));
		}

		$data = array(
			'accounts' => $this->schedules_model->count_post_on_each_account($username, $tb_posts, $tb_accounts),
			'date' => $date,
			'count_status' => $this->schedules_model->count_schedules($tb_posts)
		);

		if (!$this->input->is_ajax_request()) {
			$view = $this->load->view("../../../app/modules/schedules/views/general", $data, true);
			$this->template->build('../../../app/modules/schedules/views/schedules', array("view" => $view));
		}else{
			$this->load->view("../../../app/modules/schedules/views/general", $data);
		}
	}

	public function ajax_schedules($username = "", $tb_posts = "", $tb_accounts = ""){
		if (!$this->input->is_ajax_request()) {
			redirect(cn());
		}

		$this->load->model('schedules_model');
		$data = array(
			'schedules' => $this->schedules_model->get_schedules((int)post("page"), $username, $tb_posts, $tb_accounts),
			'page' => (int)post("page")
		);

		$this->load->view('ajax_schedules', $data);
	}

	public function ajax_delete_schedules($tb_posts = "", $delete_all = false, $type = ""){
		if (!$this->input->is_ajax_request()) {
			redirect(cn());
		}

		$this->load->model('schedules_model');

		if($delete_all){
			switch ($type) {
				case 'queue':
					
					$type = 1;
					break;

				case 'published':
					$type = 2;
					break;

				case 'unpublished':
					$type = 3;
					break;
				
				default:
					$type = 0;
					break;
			}

			$this->db->delete($tb_posts, array("uid" => session("uid"), "status" => $type));
		}else{

			if($tb_posts != ""){
				$ids = post("id");

				if($ids == -1){
					$this->db->delete($tb_posts, array(
						"uid" => session("uid"), 
						"time_post >=" => get_timezone_system(session("schedule_date")." 00:00:00"),
						"time_post <=" => get_timezone_system(session("schedule_date")." 23:59:59"),
						"status" => session("schedule_type")
					));
				}else{
					$this->db->delete($tb_posts, array("uid" => session("uid"), "ids" => $ids ));
				}

				ms(array(
		        	"status"  => "success",
		        	"message" => lang('delete_successfully')
		        ));
			}
		}
	}

	//****************************************/
	//         END SCHEDULES POST            */
	//****************************************/
}