<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class activity extends MX_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->tb_accounts = INSTAGRAM_ACCOUNTS;
		$this->tb_activities = INSTAGRAM_ACTIVITIES;
		$this->tb_activities_log = INSTAGRAM_ACTIVITIES_LOG;
		$this->module = get_class($this);
		$this->module_name = lang("instagram_accounts");
		$this->module_icon = "fa fa-instagram";
		$this->load->model($this->module.'_model', 'model');
	}

	public function index(){
		$this->model->get_activites_tmp();

		$data = array(
			"activities" =>  $this->model->get_activites()
		);
		$this->template->build('activity/index', $data);
	}

	public function block_report(){
		$this->load->model('activity_model', 'report_model');
		$data = array(
			"counter" => $this->report_model->count_all_log(),
			"stats_like" => $this->report_model->stats_log("like"),
			"stats_comment" => $this->report_model->stats_log("comment"),
			"stats_follow" => $this->report_model->stats_log("follow"),
			"stats_unfollow" => $this->report_model->stats_log("unfollow"),
			"stats_direct_message" => $this->report_model->stats_log("direct_message"),
			"stats_repost_media" => $this->report_model->stats_log("repost_media")
		);
		$this->load->view('activity/block_report', $data);
	}

	public function block_general_settings(){
		$data = array();
		$this->load->view('activity/general_settings', $data);
	}

	public function settings($id = ""){
		$activity = $this->model->get_activity($id);
		if(empty($activity)) redirect(cn("instagram/activity"));

		$data = array(
			"result" => $activity,
			"recent_log" => $this->model->fetch("*", INSTAGRAM_ACTIVITIES_LOG, "pid = '{$activity->id}'", "created", "desc", 0, 10)
		);
		$this->template->build('activity/update', $data);
	}

	public function log($id = ""){
		$activity = $this->model->get_activity($id);
		if(empty($activity)) redirect(cn("instagram/activity"));

		if(get_option('igac_save_log', 7) != 0){
	        //DELETE LOG AFTER 30 DAYS
	        $after_day =  date("Y-m-d H:i:s", strtotime(NOW) - get_option('igac_save_log', 7)*86400);
			$this->db->query("DELETE FROM ".INSTAGRAM_ACTIVITIES_LOG." WHERE created < '{$after_day}'");
			//END DELETE LOG AFTER 30 DAYS
		}

		$data = array(
			"result" => $activity
		);
		$this->template->build('activity/log', $data);
	}

	public function load_log($id = ""){
		$activity = $this->model->get_activity($id);
		if(empty($activity)) redirect(cn("instagram/activity"));
		$page = (int)post("page");
		$type = segment(5);

		$data = array(
			'page' => $page,
			'result' => $this->model->get_log($activity->id, $type, $page)
		);

		$this->load->view('activity/load_log', $data);
	}

	public function profile($id = ""){
		$activity = $this->model->get_activity($id);
		if(empty($activity)) redirect(cn("instagram/activity"));

		$account = $this->model->get("*", $this->tb_accounts, "ids = '{$id}'");
		if(empty($account)) return false;

		$data = array(
			"result" => $activity
		);
		
		$this->template->build('activity/profile', $data);
	}

	public function load_profile_info($id = ""){
		$activity = $this->model->get_activity($id);
		if(empty($activity)) redirect(cn("instagram/activity"));

		$account = $this->model->get("*", $this->tb_accounts, "ids = '{$id}'");
		if(empty($account)) return false;

		try {
			$proxy_data = get_proxy($this->tb_accounts, $account->proxy, $account);
			$ig = new InstagramAPI($account->username, $account->password, $proxy_data->use);
			$user = $result = $ig->get_userinfo();
			
			$data = array(
				"user" => array(),
				"result" => $activity
			);

			if($user){
				$data["user"] = $user;
			}

			$this->load->view('activity/load_profile_info', $data);
		} catch (Exception $e) {
			echo "<div class='alert alert-danger'>".$e->getMessage()."</div>";
		}
	}

	public function load_profile($id = ""){
		if(post("id") == "" && post("page") != 0){
			return false;
		}

		$account = $this->model->get("*", $this->tb_accounts, "ids = '{$id}'");
		if(empty($account)) return false;

		try {
			$proxy_data = get_proxy($this->tb_accounts, $account->proxy, $account);
			$ig = new InstagramAPI($account->username, $account->password, $proxy_data->use);
			$feed = $result = $ig->get_feed(null, post("id"), true);

			$data = array(
				'feed' => $feed,
			);

			$this->load->view('activity/load_profile', $data);
		} catch (Exception $e) {
			echo "<div class='dataTables_empty'></div>";
		}
	}

	public function stats($id = ""){
		$activity = $this->model->get_activity($id);
		if(empty($activity)) redirect(cn("instagram/activity"));

		$data = array(
			"follower" => -1,
			"result" => $activity
		);

		$account = $this->model->get("*", $this->tb_accounts, "ids = '{$id}'");
		if(empty($account)) return false;

		try {
			$proxy_data = get_proxy($this->tb_accounts, $account->proxy, $account);
			$ig = new InstagramAPI($account->username, $account->password, $proxy_data->use);
			$user = $result = $ig->get_userinfo();
			if($user){
				$data["follower"] = $user->follower_count;
			}
		} catch (Exception $e) {}

		$this->template->build('activity/stats', $data);
	}

	public function delete_media($id = "", $mediaId=""){
		$account = $this->model->get("*", $this->tb_accounts, "ids = '{$id}'");
		if(!empty($account)){
			try {
				$proxy_data = get_proxy($this->tb_accounts, $account->proxy, $account);
				$ig = new InstagramAPI($account->username, $account->password, $proxy_data->use);
				$response = $result = $ig->delete_media($mediaId);

				if(isset($response->status) && $response->status == "ok"){
					ms(array(
						"status" => "success",
						"message" => lang('delete_successfully'),
						"callback" => "<script>$('#id".$mediaId."').remove();</script>"
					));
				}
			} catch (Exception $e) {
				
			}
		}

		ms(array(
			"status" => "error",
			"message" => lang('delete_failed_please_try_again')
		));
	}
	
	public function save_settings($id = ""){
		if($id == "") ms(array("status" => "error"));
		$account = $this->model->get("*", $this->tb_accounts, "ids = '{$id}'");
		if(empty($account)) ms(array("status" => "error"));

		$activity_settings = array();
		$todo_params = $this->input->post("todo");
		$target_params = $this->input->post("target");
		$speed_params = $this->input->post("speed");
		$filter_params = $this->input->post("filter");
		$comment_params = $this->input->post("comment");
		$direct_message_params = $this->input->post("direct_message");
		$follow_params = $this->input->post("follow");
		$unfollow_params = $this->input->post("unfollow");
		$repost_media_params = $this->input->post("repost_media");
		$tag_params = $this->input->post("tag");
		$location_params = $this->input->post("location");
		$username_params = $this->input->post("username");
		$tag_blacklist_params = $this->input->post("tag_blacklist");
		$username_blacklist_params = $this->input->post("username_blacklist");
		$keyword_blacklist_params = $this->input->post("keyword_blacklist");
		$stop_params = $this->input->post("stop");
		$schedule_days = $this->input->post("schedule_data");

		//Schedule days
		$activity_settings['schedule_days'] = $schedule_days;

		//To do
		$todo = array(
			"like" => get_value($todo_params, "like"),
			"comment" => get_value($todo_params, "comment"),
			"follow" => get_value($todo_params, "follow"),
			"unfollow" => get_value($todo_params, "unfollow"),
			"direct_message" => get_value($todo_params, "direct_message"),
			"repost_media" => get_value($todo_params, "repost_media")
		);
		$activity_settings['todo'] = remove_empty_value($todo);

		//Target
		$target = array(
			"tag" => get_value($target_params, "tag"),
			"location" => get_value($target_params, "location"),
			"follower" => get_value($target_params, "follower"),
			"following" => get_value($target_params, "following"),
			"liker" => get_value($target_params, "liker"),
			"commenter" => get_value($target_params, "commenter"),
		);
		$activity_settings['target'] = remove_empty_value($target);

		//Speed
		$speed = array(
			"level" => get_value($speed_params, "level"),
			"like" => get_value($speed_params, "like"),
			"comment" => get_value($speed_params, "comment"),
			"follow" => get_value($speed_params, "follow"),
			"unfollow" => get_value($speed_params, "unfollow"),
			"direct_message" => get_value($speed_params, "direct_message"),
			"repost_media" => get_value($speed_params, "repost_media")
		);
		$activity_settings['speed'] = remove_empty_value($speed);

		//Filter
		$filter = array(
			"media_age" => get_value($filter_params, "media_age"),
			"media_type" => get_value($filter_params, "media_type"),
			"min_like" => get_value($filter_params, "min_like"),
			"max_like" => get_value($filter_params, "max_like"),
			"min_comment" => get_value($filter_params, "min_comment"),
			"max_comment" => get_value($filter_params, "max_comment"),
			"user_relation" => get_value($filter_params, "user_relation"),
			"user_profile" => get_value($filter_params, "user_profile"),
			"min_follower" => get_value($filter_params, "min_follower"),
			"max_follower" => get_value($filter_params, "max_follower"),
			"min_following" => get_value($filter_params, "min_following"),
			"max_following" => get_value($filter_params, "max_following"),
			"gender" => get_value($filter_params, "gender"),
		);
		$activity_settings['filter'] = remove_empty_value($filter);

		//Comment
		$activity_settings['comment'] = remove_empty_value($comment_params);

		//Direct Message
		$activity_settings['direct_message'] = remove_empty_value($direct_message_params);

		//Follow
		$follow = array(
			"cycle" => get_value($follow_params, "cycle"),
			"dont_spam" => get_value($follow_params, "dont_spam"),
			"dont_private" => get_value($follow_params, "dont_private"),
		);
		$activity_settings['follow'] = remove_empty_value($follow);

		//Unfollow
		$unfollow = array(
			"cycle" => get_value($unfollow_params, "cycle"),
			"source" => get_value($unfollow_params, "source"),
			"after" => get_value($unfollow_params, "after"),
			"dont_follower" => get_value($unfollow_params, "dont_follower"),
		);
		$activity_settings['unfollow'] = remove_empty_value($unfollow);

		//Comment
		$activity_settings['repost_media'] = remove_empty_value($repost_media_params);

		//Tag
		$activity_settings['tag'] = remove_empty_value($tag_params);

		//Tag
		$activity_settings['location'] = remove_empty_value($location_params);

		//Username
		$activity_settings['username'] = remove_empty_value($username_params);

		//Blacklist
		$activity_settings['tag_blacklist'] = remove_empty_value($tag_blacklist_params);
		$activity_settings['username_blacklist'] = remove_empty_value($username_blacklist_params);
		$activity_settings['keyword_blacklist'] = remove_empty_value($keyword_blacklist_params);

		//Auto Stop
		$stop = array(
			"like" => get_value($stop_params, "like"),
			"comment" => get_value($stop_params, "comment"),
			"follow" => get_value($stop_params, "follow"),
			"unfollow" => get_value($stop_params, "unfollow"),
			"direct_message" => get_value($stop_params, "direct_message"),
			"repost_media" => get_value($stop_params, "repost_media"),
			"timer" => get_value($stop_params, "timer"),
			"no_activity" => get_value($stop_params, "no_activity"),
		);
		$activity_settings['stop'] = remove_empty_value($stop);

		$activity_settings_encode = json_encode($activity_settings); //json_encode(utf8ize($activity_settings));

		$activity = $this->model->get("*", $this->tb_activities, "ids = '{$id}' AND pid = 0");

		if(!empty($activity)){
			$data = array(
				"action" => "main",
				"data" => $activity_settings_encode,
				"status" => 0
			);
			$this->db->update($this->tb_activities, $data, array("id" => $activity->id));
			$this->db->delete($this->tb_activities, array("pid" => $activity->id));

			if($activity->status == 1){
				ms(array(
					"status" => "error",
					"message" => lang('All_activities_stopped_when_you_changed_Click_the_Start_button_to_continue'),
					"btnStart" => "<a href='".cn("instagram/activity/start/".$id)."' class='btn btn-primary btnActivityStart'>Start</a>",
					"iconState" => "<i class='fa ft-stop-circle danger'></i>",
					"labeState" => "<span class='label label-default label-danger pull-right'>Stoped</span>"
				));
			}


		}else{
			$data = array(
				"ids" => $id,
				"uid" => session("uid"),
				"pid" => 0,
				"account" => $account->id,
				"action" => "main",
				"data" => $activity_settings_encode,
				"status" => 2,
				"changed" => NOW,
				"created" => NOW
			);

			$this->db->insert($this->tb_activities, $data);
			$id = $this->db->insert_id();
		}
	}

	public function start($id = ""){
		$main = $this->model->get("*", $this->tb_activities, "ids = '{$id}'");
		if(!empty($main)){
			$settings = json_decode($main->data);
			$saved = json_decode($main->settings);
			$todo = get_value($settings, "todo");
			$target = get_value($settings, "target");
			$tag = get_value($settings, "tag");
			$location = get_value($settings, "location");
			$username = get_value($settings, "username");
			$speed = get_value($settings, "speed");
			$todo_params = array();
			$this->db->delete($this->tb_activities, array('pid' => $main->id));
			//Roles
			if(empty($todo)){
				ms(array(
					"status" => "error",
					"message"=> lang('select_at_least_one_task_to_get_started')
				));
			}

			if(empty($target)){
				ms(array(
					"status" => "error",
					"message"=> lang('Please_select_at_least_one_type_of_target_to_get_started')
				));
			}

			if(isset($target->tag) && count($tag) < 2){
				ms(array(
					"status" => "error",
					"message"=> lang('Please_select_at_least_2_tags_to_get_started')
				));
			}

			if(isset($target->location) && count($location) < 2){
				ms(array(
					"status" => "error",
					"message"=> lang('Please_select_at_least_2_locations_to_get_started')
				));
			}

			if(
				(isset($target->follower) && $target->follower != "me" && count($username) < 2) 
				|| (isset($target->following) && $target->following != "me" && count($username) < 2) 
				|| (isset($target->liker) && $target->liker != "me" && count($username) < 2) 
				|| (isset($target->commenter) && $target->commenter != "me" && count($username) < 2) 
			){
				ms(array(
					"status" => "error",
					"message"=> lang('Please_select_at_least_2_usernames_to_get_started')
				));
			}

			$like_value = get_value($speed, "like");
			if($like_value > 60 || $like_value < 1){
				ms(array(
					"status" => "error",
					"message" => lang('Just_allowed_values_1-60_likes_per_hour')
				));
			}

			$comment_value = get_value($speed, "comment");
			if($comment_value > 20 || $comment_value < 1){
				ms(array(
					"status" => "error",
					"message" => lang('Just_allowed_values_1-20_comments_per_hour')
				));
			}

			$follow_value = get_value($speed, "follow");
			if($follow_value > 40 || $follow_value < 1){
				ms(array(
					"status" => "error",
					"message" => lang('Just_allowed_values_1-40_follows_per_hour')
				));
			}

			$unfolow_value = get_value($speed, "unfollow");
			if($unfolow_value > 40 || $unfolow_value < 1){
				ms(array(
					"status" => "error",
					"message" => lang('Just_allowed_values_1-40_unfollows_per_hour')
				));
			}

			$direct_message_value = get_value($speed, "direct_message");
			if($direct_message_value > 20 || $direct_message_value < 1){
				ms(array(
					"status" => "error",
					"message" => lang('Just_allowed_values_1-20_direct_messages_per_hour')
				));
			}

			if(isset($todo->repost_media)){
				switch ($settings->repost_media->by) {
					case 'tag':
						if(count($tag) < 2){
							ms(array(
								"status" => "error",
								"message"=> lang('Please_select_at_least_2_tags_to_get_started')
							));
						}
						break;

					case 'location':
						if(count($location) < 2){
							ms(array(
								"status" => "error",
								"message"=> lang('Please_select_at_least_2_locations_to_get_started')
							));
						}
						break;

					case 'username':
						if(count($username) < 2){
							ms(array(
								"status" => "error",
								"message"=> lang('Please_select_at_least_2_usernames_to_get_started')
							));
						}
						break;
					
					default:
						if(count($tag) < 2){
							ms(array(
								"status" => "error",
								"message"=> lang('Please_select_at_least_2_tags_to_get_started')
							));
						}

						if(count($location) < 2){
							ms(array(
								"status" => "error",
								"message"=> lang('Please_select_at_least_2_locations_to_get_started')
							));
						}

						if(count($username) < 2){
							ms(array(
								"status" => "error",
								"message"=> lang('Please_select_at_least_2_usernames_to_get_started')
							));
						}
						break;
				}
			}

			if(!empty($todo)){
				$this->db->delete($this->tb_activities, array('pid' => $main->id));
				foreach ($todo as $action => $status) {
					$todo_params[] = $action;
					$item = $this->model->get("id", $this->tb_activities, "action = '{$action}' AND pid = {$main->id}");

					switch ($action) {
						case 'repost_media':
							$settings = json_encode(get_random_numbers($speed->$action, 3600, 1));
							break;

						case 'comment':
							$settings = json_encode(get_random_numbers($speed->$action, 60, 1));
							break;
						
						default:
							$settings = json_encode(get_random_numbers($speed->$action));
							break;
					}

					$data = array(
						"ids" => ids(),
						"uid" => session("uid"),
						"pid" => $main->id,
						"account" => $main->account,
						"action" => $action, 
						"time" => NOW, 
						"data" => $main->data,
						"settings" => $settings, 
						"status" => 1,
						"changed" => NOW,
						"created" => NOW
					);

					ig_update_setting($action."_tmp", 0, $main->id);
					$this->db->insert($this->tb_activities, $data);
				}

				$this->db->update($this->tb_activities, array("created" => NOW, "status" => 1), array("id" => $main->id));

				//Save follow, following, media count
				if(!isset($saved->save_count)){
					$account = $this->model->get("*", $this->tb_accounts, "id = '{$main->account}'");
					if(!empty($account)){
						try {
							$proxy_data = get_proxy($this->tb_accounts, $account->proxy, $account);
							$ig = new InstagramAPI($account->username, $account->password, $proxy_data->use);
							$user = $result = $ig->get_userinfo();
							if($user){
								ig_get_setting("save_count", 1, $main->id);
								ig_get_setting("follower_count", 0, $main->id);
								ig_get_setting("following_count", 0, $main->id);
								ig_get_setting("media_count", 0, $main->id);
								ig_update_setting("follower_count", $user->follower_count, $main->id);
								ig_update_setting("following_count", $user->following_count, $main->id);
								ig_update_setting("media_count", $user->media_count, $main->id);
							}
						} catch (Exception $e) {}
					}
				}
			}

			ms(array(
				"status" => "success",
				"message" => lang('start_successfully'),
				"btnStop" => "<a href='".cn("instagram/activity/stop/".$id)."' class='btn btn-grey btnActivityStop'>Stop</a>",
				"iconState" => "<i class='fa ft-clock primary pe-spin'></i>",
				"labeState" => "<span class='label label-default label-success pull-right'>Started</span>"
			));
			
		}else{
			ms(array(
				"status" => "error",
				"message" => lang('there_was_a_temporary_problem_with_your_request_please_try_again')
			));
		}
	}

	public function stop($id = ""){
		$main = $this->model->get("*", $this->tb_activities, "ids = '{$id}'");
		if(!empty($main)){
			$this->db->delete($this->tb_activities, array('pid' => $main->id));
			$this->db->update($this->tb_activities, array("status" => 0), array("id" => $main->id));
		}

		ms(array(
			"status" => "success",
			"message" => lang('stop_successfully'),
			"btnStart" => "<a href='".cn("instagram/activity/start/".$id)."' class='btn btn-primary btnActivityStart'>Start</a>",
			"iconState" => "<i class='fa ft-stop-circle danger'></i>",
			"labeState" => "<span class='label label-default label-danger pull-right'>Stoped</span>"
		));
	}

	public function popup($type){
		switch ($type) {
			case 'tag':
				$this->load->view("activity/add_tag");
				break;

			case 'comment':
				$this->load->view("activity/add_comment");
				break;

			case 'direct_message':
				$this->load->view("activity/add_direct_message");
				break;

			case 'username':
				$this->load->view("activity/add_username");
				break;
			
			case 'location':
				$this->load->view("activity/add_location");
				break;

			case 'backlist_tag':
				$this->load->view("activity/add_backlist_tag");
				break;

			case 'backlist_username':
				$this->load->view("activity/add_backlist_username");
				break;

			case 'backlist_keyword':
				$this->load->view("activity/add_backlist_keyword");
				break;

			default:
				return false;
				break;
		}
	}

	public function search($type = "", $ids = ""){
		$k = post("k");
		if($ids == "") return false;

		$instagram_account = $this->model->get("*", $this->tb_accounts, "uid = '".session("uid")."' AND status = 1 AND ids = '{$ids}'");
		if(!empty($instagram_account)){
			$proxy_data = get_proxy($this->tb_accounts, $instagram_account->proxy, $instagram_account);
			try {
				$ig   = new InstagramAPI($instagram_account->username, $instagram_account->password, $instagram_account->proxy);
				switch ($type) {
					case 'tag':
						$response = $ig->search_tag($k);
						$this->load->view("activity/get/tag", array("result" => $response));
						break;

					case 'location':
						$response = $ig->search_locations($k);
						$this->load->view("activity/get/location", array("result" => $response));
						break;

					case 'username':
						$response = $ig->search_username($k);
						$this->load->view("activity/get/username", array("result" => $response));
						break;
					
					default:
						# code...
						break;
				}
			} catch (Exception $e) {
				return false;
			}

		}else{
			return false;
		}
	}

	public function save_log($schedule, $data){
		$save_log = array();
		$mainId = $schedule->pid;
		$type = $schedule->action;
		$settings = json_decode($schedule->data);

		if(isset($data->status) && $data->status == "fail"){
			if(isset($data->feedback_title)){
				ig_update_setting($type."_block", $data->feedback_title.": ".$data->feedback_message, $mainId);
				//ig_get_setting("has_block", 0, $mainId);
				//ig_update_setting("has_block", 1, $mainId);
			}

			if(isset($data->message)){
				if(strpos($data->message, "following the max limit of accounts") !== false){
					
					//SAVE
					$status = 1;
					if(isset($settings->todo) && isset($settings->todo->follow)){
						unset($settings->todo->follow);
						$save["data"] = json_encode($settings);
						if(empty((array)$settings->todo)){
							$status = 0;
						}
					}

					$save = array("data" => json_encode($settings), "status" => $status);
					//END SAVE

					$this->db->update(INSTAGRAM_ACTIVITIES, $save, "id = {$mainId} OR pid = {$mainId}");
					$this->db->delete(INSTAGRAM_ACTIVITIES, array("pid" => $mainId, "action" => $type));
					ig_update_setting($type."_block", $data->message, $mainId);
					return false;
				}

			}
			return false;
		}


		if(!empty($data) && is_array($data)){

			//ig_get_setting("has_block", 0, $mainId);
			//ig_update_setting("has_block", 0, $mainId);

			ig_update_setting($type."_block", "", $mainId);
			ig_update_setting($type, ig_get_setting($type, 0, $mainId) + count($data), $mainId);
			ig_update_setting($type."_tmp", ig_get_setting($type."_tmp", 0, $mainId) + count($data), $mainId);
			
			foreach ($data as $key => $value) {
				if(is_object($value)){
					$image = "";
					$user_id = NULL;
					$media_id = NULL;
					if($type == "like" || $type == "comment" || $type == "repost_media"){
						if(isset($value->carousel_media)){
							$image = end($value->carousel_media[0]->image_versions2->candidates)->url;
						}else{
							$image = end($value->image_versions2->candidates)->url;
						}

						$user_id = $value->user->pk;
						$media_id = $value->id;
						$item = array(
							"id" => $value->code,
							"username" => $value->user->username,
							"userid" => $value->user->pk,
							"image" => $image,
							"type" => $value->media_type
						);
					}else{
						$user_id = $value->pk;

						$mid = $value->pk;
						$image = "https://avatar.stackposts.com/?u=".$value->username;
						$item = array(
							"id" => $value->pk,
							"username" => $value->username,
							"userid" => $value->pk,
							"image" => $image,
							"type" => "user"
						);
					}

					$save_log[] = array(
						"ids" => ids(),
						"uid" => $schedule->uid,
						"pid" => $mainId,
						"action" => $type,
						"user_id" => $user_id,
						"media_id" => $media_id,
						"data" => json_encode($item),
						"created" => NOW
					);
				}
			}

			if(!empty($save_log)){
				$this->db->insert_batch($this->tb_activities_log, $save_log); 
			}
		}
	}

	public function stop_activity($id, $type, $schedule){
		$stop_count = ig_get_setting($type."_tmp", 0, $id);
		$data = json_decode($schedule->data);
		$uid = $schedule->uid;

		//SAVE
		$status = 1;
		if(is_string($data)){
			$data = json_decode($data);
		}
		
		if(isset($data->todo) && isset($data->todo->$type)){
			unset($data->todo->$type);

			$save["data"] = json_encode($data);
			if(empty((array)$data->todo)){
				$status = 0;
			}
		}

		$save = array("data" => json_encode($data), "status" => $status);
		//END SAVE

		//Schedule
		if($schedule->action != "repost_media"){
			$now = get_timezone_user(NOW, false, $uid);
			$schedule_days = json_decode($data->schedule_days);
			$day = date("w", strtotime($now));
			$hour = date("G", strtotime($now));
			$hours_today = $schedule_days[$day];
			if(!empty($schedule_days)){
				if(!in_array($hour, $hours_today)){
					$next_hour = -1;

					$hour_tmp = $hour;
					$next = 0;
					$reload = 0;
					for ($i=$hour; $i < 100; $i++) { 
						if(!in_array($hour_tmp, $hours_today)){
							$next++;
						}else{
							break;
						}

						 
						if($i >= 23 && $reload == 0){
							$hour_tmp = 0;
							$reload = 1;
						}else{
							$hour_tmp++;
						}
					}

					$this->db->update(INSTAGRAM_ACTIVITIES, array(
						"time" => date("Y-m-d H", strtotime(NOW) + $next*3600).":00:00",
						"changed" => date("Y-m-d H", strtotime(NOW) + $next*3600).":00:00"
					), "pid = {$id}");
					return true;
				}
			}
		}

		//Timer stop
		if(isset($data->stop) && isset($data->stop->timer) && strlen($data->stop->timer) == 5){
			$str_time = $data->stop->timer;
			$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "$1:$2", $str_time);
			sscanf($str_time, "%d:%d", $hours, $minutes);
			$time_seconds = $hours * 3600 + $minutes * 60;
			if(strtotime($schedule->created) + $time_seconds < strtotime(NOW)){
				$this->db->update(INSTAGRAM_ACTIVITIES, $save, "id = {$id} OR pid = {$id}");
				$this->db->delete(INSTAGRAM_ACTIVITIES, array("pid" => $id, "action" => $type));
				return true;
			}
		}

		//No activity stop
		if($schedule->action != "repost_media" && isset($data->stop) && isset($data->stop->no_activity) && $data->stop->no_activity != "no"){
			switch ($data->stop->no_activity) {
				case '1h':
					$strtotime = 3600;
					break;

				case '3h':
					$strtotime = 10800;
					break;

				case '12h':
					$strtotime = 43200;
					break;

				case '1d':
					$strtotime = 86400;
					break;

				case '3d':
					$strtotime = 259200;
					break;

				case '1w':
					$strtotime = 604800;
					break;
			}

			//Action stop
			if(isset($strtotime) && strtotime($schedule->changed) + $strtotime < strtotime(NOW)){
				$this->db->update(INSTAGRAM_ACTIVITIES, $save, "id = {$id} OR pid = {$id}");
				$this->db->delete(INSTAGRAM_ACTIVITIES, array("pid" => $id, "action" => $type));
				return true;
			}
		}

		if(isset($data->stop) && isset($data->stop->$type) && $data->stop->$type != 0 && $stop_count >= $data->stop->$type){
			$this->db->update(INSTAGRAM_ACTIVITIES, $save, "id = {$id} OR pid = {$id}");
			$this->db->delete(INSTAGRAM_ACTIVITIES, array("pid" => $id, "action" => $type));
			return true;
		}else{
			return false;
		}
	}

	/***********************************************************************/
	/* CRON                                                                */
	/* Time cron: once_per_minute                                          */
	/* List Cron: like,comment,follow,unfollow,direct_message,repost_media */
	/***********************************************************************/
	public function cron($type = ""){
		$schedule_list = $this->db->select('activities.*, account.username, account.password, account.proxy, account.default_proxy')
		->from($this->tb_activities." as activities")
		->join($this->tb_accounts." as account", "activities.account = account.id")
		->where("activities.action = '{$type}' AND activities.status = 1 AND activities.time <= '".NOW."' AND account.status = 1")->order_by("time", "asc")->limit(7,0)->get()->result();

		if(!empty($schedule_list)){
			foreach ($schedule_list as $key => $schedule) {
				if(!permission("instagram/activity", $schedule->uid)){
					$this->db->delete($this->tb_activities, array("id" => $schedule->id));
					$this->db->update($this->tb_activities, array("status" => 0, array("id" => $pid)));
				}

				$mainId = $schedule->pid;
				$settings = json_decode($schedule->data);
				$speed = get_value($settings, "speed");

				//Check Action Block
				/*$main = $this->model->get("settings", $this->tb_activities, "id = '{$mainId}'");
				if(!empty($main)){
					$main_data = json_decode($main->settings);
					if(isset($main_data->has_block) && $main_data->has_block == 1){
						$this->db->update("instagram_sessions", array("cookies" => NULL), array("username" => $schedule->username));
					}
				}*/

				switch ($type) {
					case 'repost_media':
						$next = get_time_next_schedule($schedule->settings, $speed->$type, 1440, 1);
						break;

					case 'comment':
						$next = get_time_next_schedule($schedule->settings, $speed->$type, 60, 1);
						break;
					
					default:
						$next = get_time_next_schedule($schedule->settings, $speed->$type);
						break;
				}

				$stop = $this->stop_activity($mainId, $type, $schedule);
				if($stop){ continue; }

				if($next->task != 0){
					$schedule->number = $next->task;
					$proxy_data = get_proxy($this->tb_accounts, $schedule->proxy, $schedule);
					try {
						$ig = new InstagramAPI($schedule->username, $schedule->password, $proxy_data->use);
						$result = $ig->activity->process($schedule);
						if(is_array($result) || is_object($result)){
							$this->save_log($schedule, $result);
							$next->numbers = get_action_left($next->numbers, $result, $next->task);
						}

					} catch (Exception $e) {
						ig_update_setting($type."_block", $e->getMessage(), $mainId);
						$next->numbers = get_action_left($next->numbers, array(), $next->task);
					}
				}

				$this->db->update(INSTAGRAM_ACTIVITIES, array(
						"time" => date("Y-m-d H:i:s", strtotime(NOW) + $next->minute*60), 
						"settings" => json_encode($next->numbers),
						"changed" => date("Y-m-d H:i:s", strtotime(NOW) + $next->minute*60)
					), 
					array("id" => $schedule->id)
				);

			}
		}else{
			echo "No activity";
		}

		echo "<script>
		  setInterval(function() {
		    window.location.reload(true);
		  }, 60000);
		</script>";
	}
	//****************************************/
	//               END CRON                */
	//****************************************/
}