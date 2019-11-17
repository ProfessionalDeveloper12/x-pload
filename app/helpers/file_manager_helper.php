<?php
if (!function_exists('get_path_upload')) {
	function get_path_upload($file_name = ""){
		return APPPATH."../assets/uploads/user".session("uid")."/".$file_name;
	};
}

if (!function_exists('get_path_file')) {
	function get_path_file($url = ""){
		$url = str_replace("\\", "/", $url);
		$url_explode = explode("assets/", $url);
		if(count($url_explode) == 2){
			return "assets/".$url_explode[1];
		}else{
			return $url;
		}
	};
}

if (!function_exists('get_link_file')) {
	function get_link_file($file_name){
		return BASE."assets/uploads/user".session("uid")."/".$file_name;
	};
}

if (!function_exists('get_link_tmp')) {
	function get_link_tmp($file_name){
		return BASE.$file_name;
	};
}

if (!function_exists('get_file_type')) {
	function get_file_type($file_name){
		$file_name_array = explode(".", $file_name);
		return strtolower(end($file_name_array));
	};
}

if (!function_exists('get_image_size')) {
	function get_image_size($file_name){
		return @getimagesize($file_name);
	};
}

if (!function_exists('get_file_info')) {
	function get_file_info($file_name){
		$file_name = get_path_file($file_name);
		return @pathinfo($file_name);
	};
}

if (!function_exists('check_image')) {
	function check_image($file_name){
		$file_parts = pathinfo($file_name);

		if(!isset($file_parts['extension'])){
			return 0;
		}

		$extension = strtolower($file_parts['extension']);

		if($extension == "jpeg" || $extension == "jpg" || $extension == "png"  || $extension == "gif"){
			return 1;
		}else{
			return 0;
		}
	};
}

if (!function_exists('is_image')){
	function is_image($url){
		$data = @getimagesize(get_path_file($url));
		if(is_array($data)){
			return true;
		}else{
			return false;
		}
	}
}

if (!function_exists('check_media')) {
	function check_media($file_name){
		$file_parts = pathinfo($file_name);
		if(isset($file_parts['extension'])){
			$extension = strtolower($file_parts['extension']);
			if(permission("photo_type") && permission("video_type")){
				if($extension == "jpeg" || $extension == "jpg" || $extension == "png"  || $extension == "gif" || $extension == "mp4"){
					return 1;
				}else{
					return 0;
				}
			}else if(permission("photo_type")){
				if($extension == "jpeg" || $extension == "jpg" || $extension == "png"  || $extension == "gif"){
					return 1;
				}else{
					return 0;
				}
			}else if(permission("video_type")){
				if($extension == "mp4"){
					return 1;
				}else{
					return 0;
				}
			}
		}else{
			parse_str($file_name, $parse_url);
			if(isset($parse_url['mime']) && $parse_url['mime'] == 'video/mp4'){
				return 1;
			}
		}

		return 0;
	};
}

if (!function_exists('get_mime_type')) {
	function get_mime_type($file_name)
	{
	    $mime_types = array(
			"gif"  =>"image/gif",
	        "png"  =>"image/png",
	        "jpeg" =>"image/jpg",
	        "jpg"  =>"image/jpg",
	        "mp4"  =>"video/mp4",
	    );
	    $file_name_array = explode(".", $file_name);
	    $extension = strtolower(end($file_name_array));
	    return $mime_types[$extension];
	}
}

if (!function_exists('get_tmp_path')){
	function get_tmp_path($file = ""){
		return "assets/tmp/".$file;
	}
}

if (!function_exists('get_file_via_curl')){
	function get_file_via_curl($url, $file_name){
		$ch = curl_init($url);
		$fp = fopen(APPPATH.'../assets/uploads/user'.session("uid").'/'.$file_name, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}
}

if (!function_exists('curl_get_file_size')){
	function curl_get_file_size($url){
	  // Assume failure.
	  $result = -1;

	  $curl = curl_init( $url );

	  // Issue a HEAD request and follow any redirects.
	  curl_setopt( $curl, CURLOPT_NOBODY, true );
	  curl_setopt( $curl, CURLOPT_HEADER, true );
	  curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
	  curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
	  curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt( $curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');

	  $data = curl_exec( $curl );
	  curl_close( $curl );

	  if( $data ) {
	    $content_length = "unknown";
	    $status = "unknown";

	    if( preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches ) ) {
	      $status = (int)$matches[1];
	    }

	    if( preg_match( "/Content-Length: (\d+)/", $data, $matches ) ) {
	      $content_length = (int)$matches[1];
	    }

	    // http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
	    if( $status == 200 || ($status > 300 && $status <= 308) ) {
	      $result = $content_length/(1024);
	    }
	  }

	  return $result;
	}
}
?>