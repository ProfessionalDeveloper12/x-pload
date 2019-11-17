<?php
//instagram activity get value
if(!function_exists("igav")){
	function igav($type, $data, $key){
		$data_tmp = $data;
		$data = json_decode($data);
		$data = get_value($data, $type);
		switch ($type) {
			case 'todo':
				if(get_value($data, $key)){
					return true;
				}else if(empty($data_tmp)){
					return get_option('igac_enable_'.$key, ($key=="like" || $key == "comment")?1:0);
				}
				return false;

				break;

			case 'target':
				switch ($key) {
					case 'tag':
						if(get_value($data, $key)){
							return true;
						}else if(empty($data_tmp)){
							return get_option('igac_target_tag', 1);
						}
						break;

					case 'location':
						if(get_value($data, $key)){
							return true;
						}else if(empty($data_tmp)){
							return get_option('igac_target_location', 0);
						}
						break;

					case 'follower':
						if(get_value($data, $key)){
							return get_value($data, $key);;
						}else if(empty($data_tmp)){
							return get_option('igac_target_follower', '');
						}
						break;

					case 'following':
						if(get_value($data, $key)){
							return get_value($data, $key);;
						}else if(empty($data_tmp)){
							return get_option('igac_target_following', '');
						}
						break;

					case 'liker':
						if(get_value($data, $key)){
							return get_value($data, $key);;
						}else if(empty($data_tmp)){
							return get_option('igac_target_liker', '');
						}
						break;
					
					case 'commenter':
						if(get_value($data, $key)){
							return get_value($data, $key);;
						}else if(empty($data_tmp)){
							return get_option('igac_target_commenter', '');
						}
						break;
				}
				break;

			case 'speed':

				switch ($key) {
					case 'level':
						if(get_value($data, $key)){
							return get_value($data, $key);
						}else if(empty($data_tmp)){
							return get_option('igac_speed_level', "normal");
						}
						break;
					
					default:
						if(get_value($data, $key)){
							return get_value($data, $key);
						}else if(empty($data_tmp)){
							$level = get_option('igac_speed_level', "normal");
							$level = $level!=""?$level:"normal";
							return get_option('igac_speed_'.$level.'_'.$key, "normal");
						}
						break;
				}
				if(get_value($data, $key)){
					return get_value($data, $key);
				}
				return 0;
				break;

			case 'filter':
				switch ($key) {
					case 'media_age':
						return get_value($data, $key);
						break;

					case 'media_type':
						return get_value($data, $key);
						break;

					case 'user_relation':
						return get_value($data, $key);
						break;

					case 'user_profile':
						return get_value($data, $key);
						break;

					case 'gender':
						return get_value($data, $key);
						break;
					
					default:
						if(get_value($data, $key)){
							return (int)get_value($data, $key);
						}else{
							return 0;
						}
						break;
				}
				
				break;	

			case 'stop':
				switch ($key) {
					case 'timer':
						return get_value($data, $key);
						break;

					default:
						if(get_value($data, $key)){
							return get_value($data, $key);
						}
						break;
				}
				

				return 0;
				break;	

			default:
				return get_value($data, $key);
				break;
		}
	}
}

//Instagram Activity Get Count
if(!function_exists("igac")){
	function igac($type, $data){
		if(is_string($data)){
			$data = json_decode($data);
		}

		$data = (object)$data;

		if(isset($data->$type)){
			return $data->$type;
		}else{
			return 0;
		}
	}
}

//Instagram Activity Get Status
if(!function_exists("igas")){
	function igas($data, $type=""){
		if($data->account_status == 1){
			switch ($data->status) {
				case "1":
					if($type == "text"){
						echo lang('Started');
					}else{
						echo '<span class="label label-default label-success pull-right">'.lang('Started').'</span>';
					}
					break;

				case "0":
					if($type == "text"){
						echo lang('Stopped');
					}else{
						echo '<span class="label label-default label-danger pull-right">'.lang('Stopped').'</span>';
					}
					break;
				
				default:
					if($type == "text"){
						echo lang('No_time');
					}else{
						echo '<span class="label label-default label-default pull-right">'.lang('No_time').'</span>';
					}
					break;
			}
		}else{
			if($type == "text"){
				echo '<span class="danger">'.lang('re_login_text').'</span>';
			}else{
				echo '<span class="label label-default label-danger pull-right">'.lang('re_login_text').'</span>';
			}
		}
	}
}

//Instagram Activity Action Type
if(!function_exists("igaa")){
	function igaa($action){
		switch ($action) {
			case "like":
				$result = array(
					"text" => lang('Liked_media'),
					"icon" => "ft-thumbs-up"
				);
				break;

			case "comment":
				$result = array(
					"text" => lang('Commented_media'),
					"icon" => "ft-message-square"
				);
				break;

			case "follow":
				$result = array(
					"text" => lang('Followed_user'),
					"icon" => "ft-user-plus"
				);
				break;

			case "unfollow":
				$result = array(
					"text" => lang('Unfollowed_user'),
					"icon" => "ft-user-x"
				);
				break;

			case "direct_message":
				$result = array(
					"text" => lang('Message_sent_to_user'),
					"icon" => "ft-message-circle"
				);
				break;

			case "repost_media":
				$result = array(
					"text" => lang('repost_media'),
					"icon" => "ft-message-circle"
				);
				break;
			
			default:
				$result = array(
					"text" => "",
					"icon" => ""
				);
				break;
		}

		return (object)$result;
	}
}

if(!function_exists("get_random_numbers")){
	function get_random_numbers($maxSum, $minutes = 60, $maxRandom = 1){
		$numbers = array();
	    for ($i=1; $i <= $minutes; $i++) { 
	        $rand = rand(0, $maxRandom);
	        $sum = array_sum($numbers);
	        if($sum + $rand >= $maxSum){
	            if($sum < $maxSum){
	            	$numbers[] = $maxSum - $sum;
	            }else{
	            	$numbers[] = 0;
	            }
	        }else{
	            $numbers[] = $rand;
	        }
	    }
	    shuffle($numbers);
	    return $numbers;
	}
}

if(!function_exists("get_time_next_schedule")){
	function get_time_next_schedule($numbers, $maxSum, $minutes = 60, $maxRandom = 1){
		$minute = 0;
		$task = 0;
		$new_numbers = array();
		if(is_string($numbers)){
			$numbers = (array)json_decode($numbers);
		}

		$numbers = (array)$numbers;

		if(!empty($numbers) && $numbers[0] != 0){
			$task = $numbers[0];
			unset($numbers[0]);
			$numbers = array_values($numbers);
		}

		foreach ($numbers as $key => $value) {
			if($value == 0){
				$minute++;
				unset($numbers[$key]);
			}else{
				break;
			}
		}

		if(empty($numbers)){
			$numbers = get_random_numbers($maxSum, $minutes, $maxRandom);
		}else{
			$numbers = array_values($numbers);
		}

		return (object)array(
			"task" => $task,
			"minute" => $minute,
			"numbers" => $numbers
		);

	}
}

if(!function_exists("get_action_left")){
	function get_action_left($numbers, $action_complete, $task){
		if(count($action_complete) < $task){
			$action_left = $task - count($action_complete);
			if(!empty($numbers)){
				$zero_indexs = array();
				foreach ($numbers as $key => $value) {
					if($value == 0){
						$zero_indexs[] = $key;
					}
				}

				if(!empty($zero_indexs)){
					$zero_index = get_random_value($zero_indexs);
					$numbers[$zero_index] = $action_left;
				}
			}
			return $numbers;
		}else{
			return $numbers;
		}
	}
}

if(!function_exists("ig_get_setting")){
	function ig_get_setting($key, $value = "", $id){
		$CI = &get_instance();

		if(empty($CI->help_model)){
			$CI->load->model('model', 'help_model');
		}

		$setting = $CI->help_model->get("settings", INSTAGRAM_ACTIVITIES, "id = '".$id."'");
		if(!empty($setting)){
			$setting = $setting->settings;
			$option = json_decode($setting);

			if(is_array($option) || is_object($option)){
				$option = (array)$option;

				if( isset($option[$key]) ){
					return row($option, $key);
				}else{
					$option[$key] = $value;
					$CI->db->update(INSTAGRAM_ACTIVITIES, array("settings" => json_encode($option)), array("id" => $id) );
					return $value;
				}
			}else{
				$option = json_encode(array($key => $value));
				$CI->db->update(INSTAGRAM_ACTIVITIES, array("settings" => $option), array("id" => $id));
				return $value;
			}
		}

		return false;
	}
}

if(!function_exists("ig_update_setting")){
	function ig_update_setting($key, $value, $id){
		$CI = &get_instance();
		
		if(empty($CI->help_model)){
			$CI->load->model('model', 'help_model');
		}

		$setting = $CI->help_model->get("settings", INSTAGRAM_ACTIVITIES, "id = '".$id."' ")->settings;
		$option = json_decode($setting);
		if(is_array($option) || is_object($option)){
			$option = (array)$option;
			if( isset($option[$key]) ){
				$option[$key] = $value;
				$CI->db->update(INSTAGRAM_ACTIVITIES, array("settings" => json_encode($option)), array("id" => $id) );
				return true;
			}
		}
		return false;
	}
}

if(!function_exists("Instagram_Get_Message")){
	function Instagram_Get_Message($message){
		$message = explode(": ", $message);
		if(count($message) == 2){
			return $message[1];
		}else if(count($message) > 2){
			return $message[2];
		}else{
			return $message[0];
		}
	}
}

if(!function_exists("Instagram_Post_Type")){
	function Instagram_Post_Type($type){
		if($type == "photo" || $type == "story" || $type = "carousel"){
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists("Instagram_Caption")){
	function Instagram_Caption($caption){
		$caption = preg_replace("/\r\n\r\n/", "?.??.?", $caption);
		$caption = preg_replace("/\r\n/", "?.?", $caption);
		$caption = str_replace("?.? ?.?", "?.?", $caption);
		$caption = str_replace(" ?.?", "?.?", $caption);
		$caption = str_replace("?.? ", "?.?", $caption);
		$caption = str_replace("?.??.?", "\n\n", $caption);
		$caption = str_replace("?.?", "\n", $caption);
		return $caption;
	}
}

if(!function_exists("Instagram_Unlink_Temp")){
	function Instagram_Unlink_Temp($link){
		if (stripos($link, "/tmp/") !== false) {
			unlink($link);
		}
	}
}

if(!function_exists("isInstagramPostVideo")){
	function isInstagramPostVideo(){
		$FFmpeg = get_option('instaram_ffmpeg_path', "");
		$FFFprobe = get_option('instaram_ffprobe_path', "");
	    \InstagramAPI\Utils::$ffmpegBin = $FFmpeg==""?NULL:$FFmpeg;
	    \InstagramAPI\Utils::$ffprobeBin = $FFFprobe==""?NULL:$FFFprobe;
	    
	    if (\InstagramAPI\Utils::checkFFPROBE()) {
	        try {
	            InstagramAPI\Media\Video\FFmpeg::factory();
	            return true;
	        } catch (\Exception $e) {
	            return false;
	        }
	    }
	    return false;
	}
}

if(!function_exists("ig_avatar")){
	function ig_avatar($username){
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/".$username."/?__a=1");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		$data = json_decode($data);
		curl_close($ch);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $data->graphql->user->profile_pic_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);

		header('Content-Type: image/png');
		echo $data;
	}
}

