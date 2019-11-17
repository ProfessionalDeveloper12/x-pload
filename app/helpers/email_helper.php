<?php
if(!function_exists('send_email')){
	function send_email($subject, $content, $userid){
		$CI = &get_instance();
		$user = $CI->db->select("*")->from(USERS)->where("id", $userid)->get()->row();
		$package = $CI->db->select("*")->from(PACKAGES)->where("type", 1)->get()->row();
		if(!empty($user)){
			//Send email
			$subject = nl2br($subject);
			$content = nl2br($content);

			//Replace Subject
			$subject = str_replace("{full_name}", $user->fullname, $subject);
			$subject = str_replace("{days_left}", $fullname, $subject);
			$subject = str_replace("{expiration_date}", convert_date($user->expiration_date), $subject);
			$subject = str_replace("{trial_days}", $package->trial_day, $subject);
			$subject = str_replace("{email}", $user->email, $subject);
			$subject = str_replace("{activation_link}", cn("oauth/activation/".$user->reset_key), $subject);

			//
			$content = str_replace("{full_name}", $user->fullname, $content);
			$content = str_replace("{days_left}", $fullname, $content);
			$content = str_replace("{expiration_date}", convert_date($user->expiration_date), $content);
			$content = str_replace("{trial_days}", $package->trial_day, $content);
			$content = str_replace("{email}", $user->email, $content);
			$content = str_replace("{activation_link}", cn("oauth/activation/".$user->reset_key), $content);

			$template = Modules::run("email/template");
			$template = str_replace("{content}", $content, $template);

			$CI->load->library('email');
			$CI->email->from(get_option('email_from', '')?get_option('email_from', ''):"do-not-reply@gmail.com");
			$CI->email->to($user->email);
			$CI->email->set_mailtype('html');
			$CI->email->subject($subject);
			$CI->email->message($template);

			$CI->email->send();
		}

	}
}