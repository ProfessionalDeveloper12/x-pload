<?php
if(!function_exists('post_get')){
	function post_get($name = ""){
		$CI = &get_instance();
		if($name != ""){
			return $CI->input->post_get(trim($name));
		}else{
			return $CI->input->post_get();
		}
	}
}

if(!function_exists('post')){
	function post($name = ""){
		$CI = &get_instance();

		if($name != ""){
			$post = $CI->input->post(trim($name));
			if(is_string($post)){
				return $CI->input->post(trim($name), FALSE);
			}else{
				return $post;
			}
		}else{
			return $CI->input->post();
		}
	}
}

if(!function_exists('get')){
	function get($name = ""){
		$CI = &get_instance();
		return $CI->input->get(trim($name));
	}
}

if(!function_exists('get_social_accounts')){
	function get_social_accounts($social_name = "", $accounts_tmp = array()){
		$CI = &get_instance();

		if(empty($accounts_tmp)){
			$accounts_tmp = $CI->input->post("accounts");
		}

		$accounts = array();
		if(!empty($accounts_tmp)){
			foreach ($accounts_tmp as $value) {
				if(strpos($value, $social_name.'-') !== false) {
					$accounts[] = str_replace($social_name.'-', "", $value);
				}
			}
		}

		return $accounts;
	}
}

if(!function_exists('get_value')){
	function get_value($data, $key, $parseArray = false, $return = false){
		if(is_string($data)){
			$data = json_decode($data);
		}

		if(is_object($data)){
			if(isset($data->$key)){
				if($parseArray){
					return (array)$data->$key;
				}else{
					return $data->$key;
				}
			}
		}else if(is_array($data)){
			if(isset($data[$key])){
				return $data[$key];
			}
		}else{
			return $data;
		}
		
		return $return;
	}
}

if(!function_exists('get_secure')){
	function get_secure($name = ""){
		$CI = &get_instance();
		return filter_input_xss($CI->input->get(trim($name)));
	}
}

if(!function_exists('remove_empty_value')){
	function remove_empty_value($data){
		if(!empty($data)){
			return array_filter($data, function($value) {
			    return ($value !== null && $value !== false && $value !== ''); 
			});
		}else{
			return false;
		}
	}
}

if(!function_exists('get_random_value')){
	function get_random_value($data){
		if(is_array($data) && !empty($data)){
			$index = array_rand($data);
			return $data[$index];
		}else{
			return false;
		}
	}
}

if(!function_exists('get_random_values')){
	function get_random_values($data, $limit){
		if(is_array($data) && !empty($data)){
			shuffle($data);
			if(count($data) < $limit){
				$limit = count($data);
			}

			return array_slice($data, 0, $limit);
		}else{
			return false;
		}
	}
}

if(!function_exists("utf8ize")){
	function utf8ize($d) {
	    if (is_array($d)) {
	        foreach ($d as $k => $v) {
	            $d[$k] = utf8ize($v);
	        }
	    } else if (is_string ($d)) {
	        return utf8_encode($d);
	    }
	    return $d;
	}
}


if(!function_exists('specialchar_decode')){
	function specialchar_decode($input){
		$input = str_replace("\\'", "'", $input);
		$input = str_replace('\"', '"', $input);
        $input = htmlspecialchars_decode($input, ENT_QUOTES);
		return $input;
	}
}

if(!function_exists('get_proxy')){
	function get_proxy($table, $user_proxies, $data){
		$CI = &get_instance();

		$default_proxy = $CI->model->get_proxies($table, 0, "id", true, $data);
		$system_proxy = (empty($data))?$default_proxy:$data->default_proxy;

		if(get_option('user_proxy', 1) == 1 && $user_proxies != ""){
			return (object)array(
				"use"    => $user_proxies,
				"system" => $system_proxy
			);
		}

		if(get_option('system_proxy', 1) == 1){
			return (object)array(
				"use"    => $CI->model->get_proxies($table, $system_proxy, "address", true, $data),
				"system" => $system_proxy
			);
		}

		return (object)array(
			"use"    => "",
			"system" => ""
		);
	}
}

if(!function_exists('filter_input_xss')){
	function filter_input_xss($input){
        $input = htmlspecialchars($input, ENT_QUOTES);
		return $input;
	}
}

if(!function_exists('ms')){
	function ms($array){
		print_r(json_encode($array));
		exit(0);
	}
}

if (!function_exists('ids')) {
	function ids(){
		$CI = &get_instance();
		return md5($CI->encryption->encrypt(time()));
	};
}

if (!function_exists('session')){
	function session($input){
		$CI = &get_instance();
		return $CI->session->userdata($input);
	}
}

if (!function_exists('set_session')){
	function set_session($name,$input){
		$CI = &get_instance();
		return $CI->session->set_userdata($name,$input);
	}
}

if (!function_exists('unset_session')){
	function unset_session($name){
		$CI = &get_instance();
		return $CI->session->unset_userdata($name);
	}
}

if (!function_exists('encrypt_encode')) {
	function encrypt_encode($text){
		$CI = &get_instance();
		return $CI->encryption->encrypt($text);
	};
}

if (!function_exists('encrypt_decode')) {
	function encrypt_decode($key){
		$CI = &get_instance();
		return $CI->encryption->decrypt($key);
	};
}

if (!function_exists('segment')){
	function segment($index){ 
		$CI = &get_instance();
        return $CI->uri->segment($index);
	}
}

if (!function_exists('cn')) {
	function cn($module=""){
		return PATH.$module;
	};
}

if (!function_exists('load_404')) {
	function load_404(){
		$CI = &get_instance();
		return	$CI->load->view("layouts/error_404.php");
	};
}


if(!function_exists('login_as_user')){
	function login_as_user($uid, $remmove = false){
		if(!$remmove){
			$uid_tmp = session("uid");
			set_session("uid_tmp", $uid_tmp);
			set_session("uid", $uid);
		}else{
			$uid_tmp = session("uid_tmp");
			if($uid_tmp){
				unset_session("uid_tmp");
				set_session("uid", $uid_tmp);
			}
		}
	}
}

if (!function_exists('time_elapsed_string')) {
	function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . lang($v . ($diff->$k > 1 ? 's' : ''));
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' '.lang('ago') : lang('just_now');
	}
}

if (!function_exists('ajax_page')) {
	function ajax_page(){
		$CI = &get_instance();
		if(!post()){
			$CI = &get_instance();
			$CI->load->view("layouts/error_404.php");
			return false;
		}else{
			return true;
		}
	};
}

if (!function_exists('require_all')) {
	function require_all($dir = "", $depth=0) {
		if($dir == ""){
			$segment = segment(1);
			$dir = APPPATH."../public/".$segment."/config/constants/";
		}

	    // require all php files
	    $scan = glob("$dir/*");
	    foreach ($scan as $path) {
	        if (preg_match('/\.php$/', $path)) {
	            require_once $path;
	        }
	        elseif (is_dir($path)) {
	            require_all($path, $depth+1);
	        }
	    }
	}
}

if (!function_exists('get_all_file_from_folder')) {
	function get_all_file_from_folder($dir = "") {
		$data = array();
		if($dir == ""){
			$segment = segment(1);
			$dir = APPPATH."../public/".$segment."/config/constants/";
		}

	    // require all php files
	    $scan = glob("$dir/*");
	    foreach ($scan as $path) {
	        if (preg_match('/\.php$/', $path)) {
	        	$data[] = $path;
	        }
	    }

	    return $data;
	}
}

if (!function_exists('get_path_module')) {
	function get_path_module(){
		$CI = &get_instance();
		return APPPATH.'modules/'.$CI->router->fetch_module().'/';
	}
}

if (!function_exists('folder_size')) {
	function folder_size($dir){
	    $size = 0;
	    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
	        $size += is_file($each) ? filesize($each) : folderSize($each);
	    }
	    return $size;
	}
}

if (!function_exists('pr')) {
    function pr($data, $type = 0) {
        print '<pre>';
        print_r($data);
        print '</pre>';
        if ($type != 0) {
            exit();
        }
    }
}

if(!function_exists('pr_sql')){
	function pr_sql($type=0){
		$CI = &get_instance();
		$sql = $CI->db->last_query();
		pr($sql,$type);
	}
}

if (!function_exists('export_csv')) {
	function export_csv($table_name){
		$CI = &get_instance();
        $CI->load->dbutil();
        $CI->load->helper('file');
        $CI->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $query = $CI->db->query("SELECT * FROM ".$table_name);
        $filename = $table_name.date("-d-m-Y", strtotime(NOW)).".csv";
        $data = $CI->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download($filename, "\xEF\xBB\xBF".$data);
	}
}

if(!function_exists("convert_datetime")){
	function convert_datetime($datetime){
		return date("h:iA M d, Y", strtotime($datetime));
	}
}

if(!function_exists("convert_date")){
	function convert_date($date){
		return date("M d, Y", strtotime($date));
	}
}

if(!function_exists("convert_datetime_sql")){
	function convert_datetime_sql($datetime){
		return date("Y-m-d H:i:s", get_to_time($datetime));
	}
}

if(!function_exists("convert_date_sql")){
	function convert_date_sql($date){
		return date("Y-m-d", get_to_time($date));
	}
}

if(!function_exists("validateDate")){
	function validateDate($date, $format = 'Y-m-d'){
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
}

if(!function_exists("get_to_time")){
	function get_to_time($date){
		if(is_numeric($date)){
			return $date;
		}else{
			return strtotime(str_replace('/', '-', $date));
		}
	}
}

if(!function_exists("get_to_day")){
	function get_to_day($date, $fulltime = true){
		$strtime = strtotime(str_replace('/', '-', $date));
		if($fulltime){
			return date("Y-m-d H:i:s", $strtime);
		}else{
			return date("Y-m-d", $strtime);
		}
	}
}

if(!function_exists("row")){
	function row($data, $field){
		if(is_object($data)){
			if(isset($data->$field)){
				return $data->$field;
			}else{
				return "";
			}
		}

		if(is_array($data)){
			if(isset($data[$field])){
				return $data[$field];
			}else{
				return "";
			}
		}
	}
}

if (!function_exists('tz_list')){
	function tz_list() {
	  	$zones_array = array();
	  	$timestamp = time();
	  	foreach(timezone_identifiers_list() as $key => $zone) {
	   		date_default_timezone_set($zone);
	   		$zones_array[$key]['zone'] = $zone;
	    	$zones_array[$key]['time'] = '(UTC ' . date('P', $timestamp).") ".$zone;
	    	$zones_array[$key]['sort'] = date('P', $timestamp);
	  	}


	  	usort($zones_array, function($a, $b) {
	  		return strcmp($a["sort"], $b["sort"]);
		});
		
	  	return $zones_array;
	}
}


if (!function_exists('tz_convert')){
	function tz_convert($timezone) {
		date_default_timezone_set($timezone);
	  	$zones_array = array();
	  	$timestamp = time();
	  	foreach(timezone_identifiers_list() as $key => $zone) {
	   		if($zone == $timezone){
	   			return date('P', $timestamp);
	   		}
	  	}
		
	  	return false;
	}
}

if (!function_exists('get_line_with_string')){
	function get_line_with_string($fileName, $str) {
		if(is_file($fileName)){
	    	$lines = file($fileName);
		    foreach ($lines as $lineNumber => $line) {
		        if (strpos($line, $str) !== false) {
		            return trim(str_replace("/*", "", str_replace("*/", "", $line)));
		        }
		    }
		}else{
			$lines = $fileName;
		}
		
	    return false;
	}
}

if (!function_exists('get_timezone_user')){
	function get_timezone_user($datetime, $convert = false, $uid = 0){
		$datetime = get_to_time($datetime);
		$datetime = is_numeric($datetime)?date("Y-m-d H:i:s", $datetime):$datetime;

		$uid = session("uid")?session("uid"):$uid;
		$CI = &get_instance();

		if(empty($CI->help_model)){
			$CI->load->model('model', 'help_model');
		}

		$user = $CI->help_model->get("timezone", USERS, "id = '".$uid."'");
		if(!empty($user)){
			$date = new DateTime($datetime, new DateTimeZone(TIMEZONE));
			$date->setTimezone(new DateTimeZone($user->timezone));
			$result = $date->format('Y-m-d H:i:s');
			return $convert?convert_datetime($result):$result;
		}else{
			return $convert?convert_datetime($datetime):$result;
		}
	}
}

if (!function_exists('get_timezone_system')){
	function get_timezone_system($datetime, $convert = false, $uid = 0){
		$datetime = get_to_time($datetime);
		$datetime = is_numeric($datetime)?date("Y-m-d H:i:s", $datetime):$datetime;

		$uid = session("uid")?session("uid"):$uid;
		$CI = &get_instance();

		if(empty($CI->help_model)){
			$CI->load->model('model', 'help_model');
		}

		$user = $CI->help_model->get("timezone", USERS, "id = '".$uid."'");
		if(!empty($user)){
			$date = new DateTime($datetime, new DateTimeZone($user->timezone));
			$date->setTimezone(new DateTimeZone(TIMEZONE));
			$result = $date->format('Y-m-d H:i:s');  
			return $convert?convert_datetime($result):$result;
		}else{
			return $convert?convert_datetime($datetime):$result;
		}
	}
}

if(!function_exists('get_role')){
	function get_role(){
		if(strpos(current_url(), "/cron") === FALSE || segment(1) == "cron"){
			$CI = &get_instance();

			if(empty($CI->help_model)){
				$CI->load->model('model', 'help_model');
			}

			$user = $CI->help_model->get("admin", USERS, "id = '".session("uid")."'");
			if(!empty($user) && $user->admin == 1){
				return true;
			}else{
				return false;
			}
		}
	}
}

if(!function_exists('get_controller_role')){
	function get_controller_role(){
		if(!get_role()){
			redirect(cn());
		}
	}
}

if(!function_exists('get_schedule_report')){
	function get_schedule_report($table, $status){
		$CI = &get_instance();

		if(empty($CI->help_model)){
			$CI->load->model('model', 'help_model');
		}

		$data = $CI->help_model->schedule_report($table, $status);

		return $data;
	}
}

if(!function_exists("get_option")){
	function get_option($key, $value = ""){
		$CI = &get_instance();
		
		if(empty($CI->help_model)){
			$CI->load->model('model', 'help_model');
		}
		$option = $CI->help_model->get("value", OPTIONS, "name = '{$key}'");
		if(empty($option)){
			$CI->db->insert(OPTIONS, array("name" => $key, "value" => $value));
			return $value;
		}else{
			return $option->value;
		}
	}
}

if(!function_exists("update_option")){
	function update_option($key, $value){
		$CI = &get_instance();
		
		if(empty($CI->help_model)){
			$CI->load->model('model', 'help_model');
		}
		
		$option = $CI->help_model->get("value", OPTIONS, "name = '{$key}'");
		if(empty($option)){
			$CI->db->insert(OPTIONS, array("name" => $key, "value" => $value));
		}else{
			$CI->db->update(OPTIONS, array("value" => $value), array("name" => $key));
		}
	}
}

if(!function_exists("get_groups")){
	function get_groups(){
		$CI = &get_instance();
		
		if(empty($CI->help_model)){
			$CI->load->model('model', 'help_model');
		}
		
		$groups = $CI->help_model->fetch("*", "general_groups", "uid = '".session("uid")."'");
		return $groups;
	}
}

if(!function_exists("delete_option")){
	function delete_option($key){
		$CI = &get_instance();
		$CI->db->delete(OPTIONS, array("name" => $key));
	}
}

if(!function_exists("get_setting")){
	function get_setting($key, $value = "", $uid = 0){
		$CI = &get_instance();
		if(session("uid")){
			$uid = session("uid");
		}

		if($uid != 0){
			
			if(empty($CI->help_model)){
				$CI->load->model('model', 'help_model');
			}

			$setting = $CI->help_model->get("settings", USERS, "id = '".$uid."' ")->settings;
			$option = json_decode($setting);

			if(is_array($option) || is_object($option)){
				$option = (array)$option;

				if( isset($option[$key]) ){
					return row($option, $key);
				}else{
					$option[$key] = $value;
					$CI->db->update(USERS, array("settings" => json_encode($option)), array("id" => $uid) );
					return $value;
				}
			}else{ 
				$option = json_encode(array($key => $value));
				$CI->db->update(USERS, array("settings" => $option), array("id" => $uid));
				return $value;
			}
		}
	}
}

if(!function_exists("update_setting")){
	function update_setting($key, $value, $uid = 0){
		$CI = &get_instance();
		if(session("uid")){
			$uid = session("uid");
		}

		if($uid != 0){
			
			if(empty($CI->help_model)){
				$CI->load->model('model', 'help_model');
			}

			$setting = $CI->help_model->get("settings", USERS, "id = '".$uid."' ")->settings;
			$option = json_decode($setting);
			if(is_array($option) || is_object($option)){
				$option = (array)$option;
				if( isset($option[$key]) ){
					$option[$key] = $value;
					$CI->db->update(USERS, array("settings" => json_encode($option)), array("id" => $uid) );
					return true;
				}
			}
		}
		return false;
	}
}

if(!function_exists("get_field")){
	function get_field($table, $id, $field){
		$CI = &get_instance();

		if(empty($CI->help_model)){
			$CI->load->model('model', 'help_model');
		}
		$item =$CI->help_model->get("*", $table, "id = '{$id}'");

		if(!empty($item) && isset($item->$field)){
			return $item->$field;
		}else{
			return false;
		}
	}
}

if(!function_exists("get_payment")){
	function get_payment(){
		if (is_dir(APPPATH."modules/payment")) {
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists("get_upload_folder")){
	function get_upload_folder(){
		$path = APPPATH."../assets/uploads/user" . session("uid")."/";
		if (!file_exists($path)) {
			$uold     = umask(0);
	    	mkdir($path, 0777);
			umask($uold);

	    	file_put_contents($path."index.html", "<h1>404 Not Found</h1>");
	    }
	}
}

if ( ! function_exists('get_info_link')){
	function get_info_link($url)
	{	

		$info = array(
			'title' => "",
			'description' => "",
			'image' => "",
			'host' => ""
		);

		$parse_url = @parse_url($url);
		if(isset($parse_url["host"])){
			$info['host'] = $parse_url["host"];
		}

		// Check if the URL is youtube video
		$youtube_reg = "/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";
		if(preg_match($youtube_reg, $url, $match)){
			//https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=B4CRkpBGQzU&format=json
			$result = get_curl("https://www.youtube.com/oembed?url=".$url."&format=json");
			$result = json_decode($result);
			if(!empty($result)){

				if(isset($result->title))
					$info['title'] = $result->title;

				if(isset($result->thumbnail_url))
					$info['image'] = $result->thumbnail_url;
			}
			
			return $info;
		}
		
		$result = get_curl($url);
		$doc = new DOMDocument();
		@$doc->loadHTML(mb_convert_encoding($result, 'HTML-ENTITIES', 'UTF-8'));
		$title = $doc->getElementsByTagName('title');
		$metas = $doc->getElementsByTagName('meta');

		$info["title"] = isset($title->item(0)->nodeValue) ? $title->item(0)->nodeValue : "";

		for ($i = 0; $i < $metas->length; $i++){
		    $meta = $metas->item($i);
		    
		    if($info['description'] == ""){
			    if(strtolower($meta->getAttribute('name')) == 'description'){
			        $info['description'] = $meta->getAttribute('content');
			    }
			}
			if($info['image'] == ""){
				if($meta->getAttribute('property') == 'og:image'){
			        $info['image'] = $meta->getAttribute('content');
			    }
			}
		}

		if($info['description'] == ""){
			for ($i = 0; $i < $metas->length; $i++){
			    $meta = $metas->item($i);
				if(strtolower($meta->getAttribute('property')) == 'og:description'){
			       	$info['description'] = $meta->getAttribute('content');
			   	}
			}
		}

		if($info['description'] == ""){
			for ($i = 0; $i < $metas->length; $i++){
		    	$meta = $metas->item($i);
				$body = $doc->getElementsByTagName('body');
				$text = strip_tags($body->item(0)->nodeValue);
				$dots = "";
				if(strlen(utf8_decode($text))>250) $dots = "...";
				$text = mb_substr(stripslashes($text),0,250, 'utf-8');
				$info['description'] = $text.$dots;
			}
		}

		return $info;
	}
}

if(!function_exists("get_client_ip")){
	function get_client_ip() {
	    $ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';

	    return $ipaddress;
	}
}

if(!function_exists("info_client_ip")){
	function info_client_ip(){
		$result = get_curl("https://timezoneapi.io/api/ip");

		$result = json_decode($result);
		if(!empty($result)){
			return $result;
		}
		return false;
	}
}

if(!function_exists("get_curl")){
	function get_curl($url){
		$user_agent='Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3';

		$headers = array
		(
		    'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
		    'Accept-Language: en-US,fr;q=0.8;q=0.6,en;q=0.4,ar;q=0.2',
		    'Accept-Encoding: gzip,deflate',
		    'Accept-Charset: utf-8;q=0.7,*;q=0.7',
		    'cookie:datr=; locale=en_US; sb=; pl=n; lu=gA; c_user=; xs=; act=; presence='
		); 

        $ch = curl_init( $url );

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST , "GET");
        curl_setopt($ch, CURLOPT_POST, false);     
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_REFERER, base_url());

        $result = curl_exec( $ch );
       
        curl_close( $ch );

        return $result;
	}
}

if(!function_exists("get_js")){
	function get_js($js_files = array()){
		$core = APPPATH."../assets/js/core.js";

		if(!file_exists($core)){
			$minifier = new MatthiasMullie\Minify\JS();
			foreach ($js_files as $file) {
				$minifier->add(APPPATH."../".$file);
			}

			$minifier->minify($core);
			$minifier->add($core);
		}else{

			$mod_date=date("F d Y H:i:s.", filemtime($core));
			$date = strtotime(date("Y-m-d", strtotime(NOW)));
			$mod_date = strtotime(date("Y-m-d", strtotime($mod_date)));

			if($mod_date < $date){
				$minifier = new MatthiasMullie\Minify\JS();
				foreach ($js_files as $file) {
					$minifier->add(APPPATH."../".$file);
				}

				$minifier->minify($core);
				$minifier->add($core);
			}

		}
		echo BASE."assets/js/core.js";
	}
}

if(!function_exists("get_css")){
	function get_css($css_files = array()){
		$core = APPPATH."../assets/css/core.css";

		if(!file_exists($core)){
			$minifier = new MatthiasMullie\Minify\CSS();
			foreach ($css_files as $file) {
				$minifier->add(APPPATH."../".$file);
			}
			$minifier->minify($core);
			$minifier->add($core);
		}else{

			$mod_date=date("F d Y H:i:s.", filemtime($core));
			$date = strtotime(date("Y-m-d", strtotime(NOW)));
			$mod_date = strtotime(date("Y-m-d", strtotime($mod_date)));

			if($mod_date < $date){
				$minifier = new MatthiasMullie\Minify\CSS();
				foreach ($css_files as $file) {
					$minifier->add(APPPATH."../".$file);
				}

				$minifier->minify($core);
				$minifier->add($core);
			}

		}
		
		echo '<link rel="stylesheet" type="text/css" href="'.BASE.'assets/css/core.css">';
	}
}

if (!function_exists('getEmailTemplate')) {
	function getEmailTemplate($key=""){
		$result = (object)array();
		$result->subject = '';
		$result->content = '';
		if(!empty($key)){
			switch ($key) {
				case 'activate':
					$result->subject = "Hello {full_name}! Activation your account";
					$result->content = "Welcome to {website_name}! \r\n\r\nHello {full_name},  \r\n\r\nThank you for joining! We're glad to have you as community member, and we're stocked for you to start exploring our service.  \r\n All you need to do is activate your account: \r\n  {activation_link} \r\n\r\nThanks and Best Regards!";
					return $result;
					break;
				case 'welcome':
					$result->subject = "Hi {full_name}! Getting Started with Our Service";
					$result->content = "Hello {full_name}! \r\n\r\nCongratulations! \r\nYou have successfully signed up for our service. \r\nYou have got a trial package, starting today. \r\nWe hope you enjoy this package! We love to hear from you, \r\n\r\nThanks and Best Regards!";
					return $result;
					break;
				case 'forgot_password':
					$result->subject = "Hi {full_name}! Password Reset";
					$result->content = "Hi {full_name}! \r\n\r\nSomebody (hopefully you) requested a new password for your account. \r\n\r\nNo changes have been made to your account yet. \r\nYou can reset your password by click this link: \r\n{recovery_password_link}. \r\n\r\nIf you did not request a password reset, no further action is required. \r\n\r\nThanks and Best Regards!";
					return $result;
					break;
				case 'payment':
					$result->subject = "Hi {full_name}, Thank you for your payment";
					$result->content = "Hi {full_name}, \r\n\r\nYou just completed the payment successfully on our service. \r\nThank you for being awesome, we hope you enjoy your package. \r\n\r\nThanks and Best Regards!";
					return $result;
					break;
				case 'reminder':
					$result->subject = "Hi {full_name}, Here's a little Reminder your Membership is expiring soon...";
					$result->content = "Dear {full_name}, \r\n\r\nYour membership with your current package will expire in {days_left} days. \r\nWe hope that you will take the time to renew your membership and remain part of our community. It couldn’t be easier - just click here to renew: {website_link} \r\n\r\nThanks and Best Regards!";
					return $result;
					break;
			}
		}
		return $result;
	}
}

class Spintax
{
    public function process( $text )
    {
    	$text = specialchar_decode($text);
        return preg_replace_callback(
            '/\{(((?>[^\{\}]+)|(?R))*)\}/x',
            array( $this, 'replace' ),
            $text
        );
    }

    public function replace( $text )
    {
        $text = $this -> process( $text[1] );
        $parts = explode( '|', $text );
        return $parts[ array_rand( $parts ) ];
    }
}

if (!function_exists('watermark')) {
	function watermark($path_image, $save_image = "", $uid = 0){
		$uid = (session("uid") && $uid != 0)?session("uid"):$uid;

		$watermark_image = get_setting("watermark_image", "", $uid);
	    $watermark_size = get_setting("watermark_size", 30, $uid);
	    $watermark_opacity = get_setting("watermark_opacity", 70, $uid);
	    $watermark_position = get_setting("watermark_position", "lb", $uid);

		if(file_exists($watermark_image)){
		    $watermark = new Watermark();

		    $path_image = get_path_file($path_image);
		    $save_image = get_path_file($save_image);

		    if($save_image == ""){
				$save_image = $path_image;
			}

		    $watermark->apply($path_image, $save_image, $watermark_image, $watermark_position, $watermark_size, $watermark_opacity/100);

		    return get_link_tmp($save_image);
		}else{
			return $path_image;
		}
	}
}

if(!function_exists('team_session')){
	function team_session(){
		if(session("uid_main")){
			return session("uid_main");
		}
		return  session("uid");
	}
}