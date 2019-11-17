<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller 
{
	public $autoload = array();
	
	public function __construct() 
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	

		date_default_timezone_set(TIMEZONE);
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		$CI = &get_instance();
		
		if(strpos(current_url(), "cron") === FALSE){
			
			//Save session
			if(get_cookie("mid") && !session("uid")){
				$cookie_login = encrypt_decode(get_cookie("mid"));
				if(strlen($cookie_login) == 32 && preg_match("/^[a-zA-Z0-9]+$/", $cookie_login)){
					$user = $CI->db->select("id")->from(USERS)->where("ids", $cookie_login)->where("status", 1)->get()->row();
					if(!empty($user)){
						set_session("uid", $user->id);
					}
				}else{
					delete_cookie("mid");
				}
			}

			//Clear Session
			$CI->db->query("DELETE FROM general_sessions WHERE timestamp < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY))");
		}

		if( segment(1) != "set_language" 
			&& ( segment(2) != "pagseguro" || segment(3) != "complete" ) 
			&& ( segment(2) != "paypal" || segment(3) != "webhook" ) 
			&& ( segment(2) != "stripe" || segment(3) != "webhook" ) 
			&& !file_exists("plugins/".segment(1)) 
		)
		{
			$controller_approved = array("auth");
			$page_approved = array("logout", "p");
			$method_approved = array("block_schedules_xml");

			if(!in_array($this->router->fetch_class(), $controller_approved) && !in_array(segment(3), $method_approved) && !in_array(segment(1), $page_approved) && !session("uid")){
				if(segment(1) != "" && segment(3) != "cron" && segment(1) != "cron"){
					redirect(PATH);
				}
			}

			if(session("uid") && in_array($this->router->fetch_class(), $controller_approved) && !in_array(segment(2), $page_approved) && !in_array(segment(1), $page_approved)  && segment(2) != "timezone"){
				redirect(PATH."dashboard");
			}

			//Admin Controller
			$admin_controllers = array("users", "module", "packages", "language", "settings", "payment_history");
			if(!get_role() && in_array(segment(1), $admin_controllers)){
				redirect(cn());
			}
		}

		if(session("redirect") && segment(1) == "dashboard"){
			$redirect = session("redirect");
			unset_session("redirect");
			redirect($redirect);
		}

		/* autoload module items */
		$this->load->_autoloader($this->autoload);
	}
	
	public function __get($class) 
	{
		return CI::$APP->$class;
	}
}