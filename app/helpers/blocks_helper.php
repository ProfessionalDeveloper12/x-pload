<?php
if(!function_exists('sidebar')){
	function sidebar(){
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		foreach($folders as $folder){
			if(is_dir($folder)){
				$config = $folder."/config.json";
				if(file_exists($folder."/config.json")){
					$data_json = file_get_contents($config);
					$data = json_decode($data_json);
					$submenu = array();

					if(isset($data->menu) && !empty($data->menu)){
						$folder_list = explode("/", $folder);
						$folder_name = end($folder_list);
						//Permission
						if(permission(preg_replace("/\s+/","_",strtolower(trim(ucfirst($data->menu->title))))."_enable")){
							$item  = "";
							$item .= "<li class='nav-item ".((segment(1) == strtolower($folder_name))?"active":"")."'>";
							if(isset($data->menu->icon)){
							$menu_title = preg_replace("/\s+/","_",strtolower(trim(ucfirst($data->menu->title))));
					        $item .= "<a href='javascript:void(0);' class='menuPopover'><i class='".$data->menu->icon."' " . (get_option('sidebar_icons_color', 0)==1 && isset($data->menu->color)?"style='color: ".$data->menu->color."'":"") . " aria-hidden='true'></i> <span class='name'>".lang($menu_title)."</span></a>";
					        }	

					        $item .= "<ul class='menu-content'>";

					        if(isset($data->submenu) && !empty($data->submenu)){
						        
					        	foreach ($data->submenu as $link => $title) {
					        		$link_array = explode("/", $link);
					        		$submenu[$link] = $title;

					        		//Permission
					        		if(permission($link)){
					                	$title_tmp = preg_replace("/\s+/","_",strtolower(trim($title)));
					                	$text = lang($title_tmp) == ""?trim($title):lang($title_tmp);
					                	$item .= "<li class=".((segment(1) == strtolower($folder_name) && segment(2) == end($link_array))?"active":"")."><a href='".PATH.$link."'><i class='fa fa-angle-right' aria-hidden='true'></i> <span>".$text."</span></a></li>";
					            	}
					            	//End permission

					            }
					    	}

					    	if(file_exists($folder."/menu")){
				    			$submenu_files = glob($folder."/menu/" . "*.php");
					    		foreach ($submenu_files as $submenu_file) {
					    			$submenu_tmp = include $submenu_file;
					    			$title = $submenu_tmp['title'];
					    			$link = $submenu_tmp['link'];
					    			$link_array = explode("/", $link);
					    			if(!isset($submenu[$link])){
					    				if((isset($submenu_tmp['hide']) && !$submenu_tmp['hide']) || !isset($submenu_tmp['hide'])){
						    				//Permission
							        		if(permission($link)){
							                	$title_tmp = preg_replace("/\s+/","_",strtolower(trim($title)));
							                	$text = lang($title_tmp) == ""?trim($title):lang($title_tmp);
							                	$item .= "<li class=".((segment(1) == strtolower($folder_name) && segment(2) == end($link_array))?"active":"")."><a href='".PATH.$link."'><i class='fa fa-angle-right' aria-hidden='true'></i> <span>".$text."</span></a></li>";
							            	}
							            	//End permission
							            }
					    			}
					    		}
					    	}

					    	$item .= "</ul>";

					        $item .= "</li>";
					        echo $item;

						}



						//End permission
					}
				}
			}
		}
	}
}

if(!function_exists('plugins')){
	function plugins(){
		$directory = APPPATH."../plugins/";
		$folders = glob($directory . "*");
		$have_plugins = false;
		foreach($folders as $folder){
			if(is_dir($folder)){
				$config = $folder."/config.json";
				if(file_exists($folder."/config.json")){
					$data_json = file_get_contents($config);
					$data = json_decode($data_json);
					
					if(isset($data->submenu) && !empty($data->submenu)){
						
						$folder_list = explode("/", $folder);
						$folder_name = end($folder_list);
						$submenu_count = count((array)$data->submenu);

						if($submenu_count == 1){
							$item  = "";
							foreach ($data->submenu as $key => $menu) {
								if(isset($menu->for_admin) && $menu->for_admin == 1){
									$CI = &get_instance();
									if(empty($CI->help_model)){
										$CI->load->model('model', 'help_model');
									}
									$user = $CI->help_model->get("admin", USERS, "id = '".session("uid")."'");
									if(!empty($user) && $user->admin == 1){
										$have_plugins = true;
										$item .= "<li class='nav-item ".((segment(1) == strtolower($folder_name))?"active":"")."'>";
										if(isset($data->icon)){
											$menu_title = preg_replace("/\s+/","_",strtolower(trim($data->title)));
									        $item .= "<a href='".(PATH.$key)."'><i class='".$data->icon."' " . (get_option('sidebar_icons_color', 0)==1 && isset($data->color)?"style='color: ".$data->color."'":"") . " aria-hidden='true' data-toggle='tooltip' data-placement='right' title='' data-original-title='".lang($menu_title)."'></i> <span class='name'>".lang($menu_title)."</span></a>";
								        }
								        $item .= "</li>";

									}
								}else{
									$have_plugins = true;
									$item  = "";
									$item .= "<li class='nav-item ".((segment(1) == strtolower($folder_name))?"active":"")."'>";
									if(isset($data->icon)){
										$menu_title = preg_replace("/\s+/","_",strtolower(trim($menu->name)));
								        $item .= "<a href='".(PATH.$key)."'><i class='".$data->icon."' " . (get_option('sidebar_icons_color', 0)==1 && isset($data->color)?"style='color: ".$data->color."'":"") . " aria-hidden='true' data-toggle='tooltip' data-placement='right' title='' data-original-title='".lang($menu_title)."'></i> <span class='name'>".lang($menu_title)."</span></a>";
							        }
							        $item .= "</li>";

								}
							}
						}else{

							//Permission
							//if(permission($data->title."_enable")){
								$have_plugins = true;
								$item  = "";
								$item .= "<li class='nav-item ".((segment(1) == strtolower($folder_name))?"active":"")."'>";
								if(isset($data->icon)){
									$menu_title = preg_replace("/\s+/","_",strtolower(trim($data->title)));
							        $item .= "<a href='javascript:void(0);' class='menuPopover'><i class='".$data->icon."' " . (get_option('sidebar_icons_color', 0)==1 && isset($data->color)?"style='color: ".$data->color."'":"") . " aria-hidden='true'></i> <span class='name'>".lang($menu_title)."</span></a>";
						        }

						        if(isset($data->submenu) && !empty($data->submenu)){
							        $item .= "<ul class='menu-content'>";
							        	foreach ($data->submenu as $link => $data_submenu) {
							        		$link_array = explode("/", $link);

							        		//Permission
							        		if(permission($link)){
							                	$title_tmp = preg_replace("/\s+/","_",strtolower(trim($data_submenu->name)));
							                	$text = lang($title_tmp) == ""?trim($title):lang($title_tmp);
							                	$item .= "<li class=".((segment(1) == strtolower($folder_name) && segment(2) == end($link_array))?"active":"")."><a href='".PATH.$link."'><i class='fa fa-angle-right' aria-hidden='true'></i> <span>".$text."</span></a></li>";
							            	}
							            	//End permission

							            }
							        $item .= "</ul>";
						    	}
						        $item .= "</li>";
						        
							//}
							//End permission

						}

						echo $item;
					}
				}
			}
		}

		if($have_plugins){
			echo "<li class='nav-line'></li>";
		}
	}
}

if(!function_exists('check_permission_plugins')){
	function check_permission_plugins($plugin_name = "", $permission = ""){
		if($permission == ""){
			$permission = $plugin_name;
		}

		$directory = APPPATH."../plugins/".$plugin_name."/config.json";
		$have_plugins = false;

		if(!file_exists($directory)){
			return false;
		}

		$directory = json_decode(file_get_contents($directory));
		if(!is_object($directory) || !isset($directory->submenu)){
			return false;
		}

		$submenus = $directory->submenu;
		foreach ($submenus as $key => $menu) {
			if($key == $permission && $menu->need_auth == 1 && !session("uid")){
				return false;
			}

			if($key == $permission && $menu->need_auth == 0){
				return true;
			}

			if($key == $permission && $menu->for_admin == 1){
				$CI = &get_instance();
				if(empty($CI->help_model)){
					$CI->load->model('model', 'help_model');
				}
				$user = $CI->help_model->get("admin", USERS, "id = '".session("uid")."'");
				if(!empty($user) && $user->admin == 1){
					return true;
				}
			}

			if($key == $permission && $menu->for_admin == 0){
				return true;
			}

		}

		return false;
	}
}

if(!function_exists('load_social_list')){
	function load_social_list(){
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		$social_list = array();
		foreach($folders as $folder){
			if(is_dir($folder)){
				$config = $folder."/config.json";
				if(file_exists($folder."/config.json")){
					$data_json = file_get_contents($config);
					$data = json_decode($data_json);
					if(isset($data->menu) && !empty($data->menu)){
						$social_list[] = $data->menu->title;
					}
				}
			}
		}

		return $social_list;
	}
}

if(!function_exists('load_social_info')){
	function load_social_info($permission = false){
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		$social_list = array();
		foreach($folders as $folder){
			if(is_dir($folder)){
				$config = $folder."/config.json";
				if(file_exists($folder."/config.json")){
					$data_json = file_get_contents($config);
					$data = json_decode($data_json);
					if(isset($data->menu) && !empty($data->menu)){
						if($permission){
							//Permission
							if(permission(str_replace(" ", "_", $data->menu->title)."_enable")){
								$social_list[] = (object)array(
									"title" => $data->menu->title,
									"icon"  => $data->menu->icon,
									"color" => isset($data->menu->color)?$data->menu->color:"#000"
								);
							}

						}else{
							$social_list[] = (object)array(
								"title" => $data->menu->title,
								"icon"  => $data->menu->icon,
								"color" => isset($data->menu->color)?$data->menu->color:"#000"
							);
						}
						
					}	
				}
			}
		}

		return $social_list;
	}
}

if(!function_exists('load_cron')){
	function load_cron(){
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		$cron_list = array();
		foreach($folders as $folder){
			if(is_dir($folder)){
				$config = $folder."/config.json";
				if(file_exists($folder."/config.json")){
					$data_json = file_get_contents($config);
					$data = json_decode($data_json);
					$submenus = array();

					if(isset($data->menu) && !empty($data->menu)){
						$folder_list = explode("/", $folder);
						$folder_name = end($folder_list);
				        if(isset($data->submenu) && !empty($data->submenu)){
				        	$submenu = $data->submenu;
				        	if(!empty($submenu)){
				        		foreach ($submenu as $key => $sub) {
				        			$submenus[$key] = $sub;
									$title = preg_replace("/\s+/","_",strtolower(trim(ucfirst($data->menu->title))));
									$sub = preg_replace("/\s+/","_",strtolower(trim($sub)));
				        			$time_cron = ""; 
				        			$name_cron = lang($title)." | ".lang($sub);
				        			$link_cron = "wget --spider -O - ".PATH.$key."/cron >/dev/null 2>&1";
				        			$file = APPPATH."../public/".str_replace("/", "/controllers/", $key).".php";
				        			if(file_exists($file)){
				        				$time_cron_simple = get_line_with_string($file, "Time cron");
				        				$list_cron_advance = get_line_with_string($file, "List Cron");
				        				if($time_cron_simple){
				        					$time_cron = explode(": ", $time_cron_simple);
				        					$time_cron = end($time_cron);
				        				}

				        				if($list_cron_advance){
				        					$list_cron = explode(": ", $list_cron_advance);
				        					if(isset($list_cron[1])){
				        						$list_cron = explode(",", $list_cron[1]);
				        						foreach ($list_cron as $cron) {
				        							if($time_cron != "" && $name_cron != "" && $link_cron != ""){
				        								$link_cron = "wget --spider -O - ".PATH.$key."/cron/".$cron." >/dev/null 2>&1";
							        					$cron_list[] = array(
							        						"name" => $name_cron,
							        						"link" => $link_cron,
							        						"time" => $time_cron
							        					);
							        				}
				        						}
				        					}
				        					
				        				}else{

					        				if($time_cron != "" && $name_cron != "" && $link_cron != ""){
					        					$cron_list[] = array(
					        						"name" => $name_cron,
					        						"link" => $link_cron,
					        						"time" => $time_cron
					        					);
					        				}

				        				}
				        			}
				        		}
				        	}
				        }

				        if(file_exists($folder."/menu")){
			    			$submenu_files = glob($folder."/menu/" . "*.php");
				    		foreach ($submenu_files as $submenu_file) {
				    			$submenu_tmp = include $submenu_file;
				    			$sub = $submenu_tmp['title'];
				    			$link = $submenu_tmp['link'];
				    			$link_array = explode("/", $link);
				    			if(!isset($submenus[$link])){
				    				if((isset($submenu_tmp['hide']) && !$submenu_tmp['hide']) || !isset($submenu_tmp['hide'])){
					    				
				    					$title = preg_replace("/\s+/","_",strtolower(trim(ucfirst($data->menu->title))));
										$sub = preg_replace("/\s+/","_",strtolower(trim($sub)));
					        			$time_cron = ""; 
					        			$name_cron = lang($title)." | ".lang($sub);
					        			$link_cron = "wget --spider -O - ".PATH.$link."/cron >/dev/null 2>&1";
					        			$file = APPPATH."../public/".str_replace("/", "/controllers/", $link).".php";
					        			if(file_exists($file)){
					        				$time_cron_simple = get_line_with_string($file, "Time cron");
					        				$list_cron_advance = get_line_with_string($file, "List Cron");
					        				if($time_cron_simple){
					        					$time_cron = explode(": ", $time_cron_simple);
					        					$time_cron = end($time_cron);
					        				}

					        				if($list_cron_advance){
					        					$list_cron = explode(": ", $list_cron_advance);
					        					if(isset($list_cron[1])){
					        						$list_cron = explode(",", $list_cron[1]);
					        						foreach ($list_cron as $cron) {
					        							if($time_cron != "" && $name_cron != "" && $link_cron != ""){
					        								$link_cron = "wget --spider -O - ".PATH.$link."/cron/".$cron." >/dev/null 2>&1";
								        					$cron_list[] = array(
								        						"name" => $name_cron,
								        						"link" => $link_cron,
								        						"time" => $time_cron
								        					);
								        				}
					        						}
					        					}
					        					
					        				}else{
						        				if($time_cron != "" && $name_cron != "" && $link_cron != ""){
						        					$cron_list[] = array(
						        						"name" => $name_cron,
						        						"link" => $link_cron,
						        						"time" => $time_cron
						        					);
						        				}
						        			}
					        			}

						            }
				    			}
				    		}
				    	}

					}
				}
			}
		}

		return $cron_list;
	}
}

if(!function_exists('load_account')){
	function load_account(){
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		foreach($folders as $folder){
			if(is_dir($folder)){
				$config = $folder."/config.json";
				if(file_exists($folder."/config.json")){
					$data_json = file_get_contents($config);
					$data = json_decode($data_json);
					if(isset($data->account) && !empty($data->account)){
						if(isset($data->account->add_account)){
							
							//Permission
							if(permission(preg_replace("/\s+/","_",strtolower(trim(ucfirst($data->menu->title))))."_enable")){
								echo modules::run($data->account->add_account);
							}
							//End permission
						}
					}
				}
			}
		}
	}
}

if(!function_exists('load_js')){
	function load_js(){
		$submenu = array();
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		foreach($folders as $folder){
			if(is_dir($folder)){
				$submenu = array();
				$config = $folder."/config.json";
				if(file_exists($folder."/config.json")){
					$data_json = file_get_contents($config);
					$data = json_decode($data_json);
					if(isset($data->js) && !empty($data->js)){
						//permission
						if(permission(preg_replace("/\s+/","_",strtolower(trim(ucfirst($data->menu->title))))."_enable")){
							foreach ($data->js as $key => $link) {
								$submenu[] = $link;
								echo '<script type="text/javascript" src="'.BASE.'public/'.$link.'"></script>';
							}
						}
						//End permission
					}

					if(file_exists($folder."/menu")){
		    			$submenu_files = glob($folder."/menu/" . "*.php");
			    		foreach ($submenu_files as $submenu_file) {
			    			$submenu_tmp = include $submenu_file;
			    				
			    			if(isset($submenu_tmp['js']) && is_array($submenu_tmp['js']) && !empty($submenu_tmp['js'])){

			    				$files = $submenu_tmp['js'];
			    				
			    				foreach ($files as $file) {
					    			if(!in_array($file, $submenu)){
					    				$submenu[] = $file;
					    				//Permission
										if(permission(preg_replace("/\s+/","_",strtolower(trim(ucfirst($data->menu->title))))."_enable") && file_exists('public/'.$file)){
											echo '<script type="text/javascript" src="'.BASE.'public/'.$file.'"></script>';
										}
										//End permission
						                
					    			}

			    				}
			    			}
			    		}
			    	}
				}
			}
		}

		$directory = APPPATH."../plugins/";
		$folders = glob($directory . "*");
		foreach($folders as $folder){
			$folder_list = explode("/", $folder);
			$folder_name = end($folder_list);

			if(is_dir($folder)){
				$config = $folder."/config.json";
				if(file_exists($folder."/config.json")){
					$data_json = file_get_contents($config);
					$data = json_decode($data_json);
					if(isset($data->js)){
						$submenu[] = $data->js;
						$file = $data->js;
						if(is_array($data->js)){
							$file = reset($data->js);
						}
						echo '<script type="text/javascript" src="'.BASE.'plugins/'.$folder_name."/".$file.'"></script>';
						
					}

					if(file_exists($folder."/menu")){
		    			$submenu_files = glob($folder."/menu/" . "*.php");
			    		foreach ($submenu_files as $submenu_file) {
			    			$submenu_tmp = include $submenu_file;
			    				
			    			if(isset($submenu_tmp['js']) && is_array($submenu_tmp['js']) && !empty($submenu_tmp['js'])){

			    				$files = $submenu_tmp['js'];
			    				
			    				foreach ($files as $file) {

					    			if(!in_array($file, $submenu)){
					    				$submenu[] = $file;
					    				//Permission
										if(permission(preg_replace("/\s+/","_",strtolower(trim(ucfirst($data->menu->title))))."_enable") && file_exists('public/'.$file)){
											echo '<script type="text/javascript" src="'.BASE.'public/'.$file.'"></script>';
										}
										//End permission
						                
					    			}

			    				}
			    			}
			    		}
			    	}

				}
			}
		}
	}
}

if(!function_exists('load_css')){
	function load_css(){
		$submenu = array();
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		foreach($folders as $folder){
			if(is_dir($folder)){
				$config = $folder."/config.json";
				if(file_exists($folder."/config.json")){
					$data_json = file_get_contents($config);
					$data = json_decode($data_json);
					if(isset($data->css) && !empty($data->css)){

						//Permission
						if(permission(preg_replace("/\s+/","_",strtolower(trim(ucfirst($data->menu->title))))."_enable")){
							foreach ($data->css as $key => $link) {
								$submenu[] = $link;
								echo '<link rel="stylesheet" type="text/css" href="'.BASE.'public/'.$link.'">';
							}
						}
						//End permission
					}

					if(file_exists($folder."/menu")){
		    			$submenu_files = glob($folder."/menu/" . "*.php");
			    		foreach ($submenu_files as $submenu_file) {
			    			$submenu_tmp = include $submenu_file;
			    				
			    			if(isset($submenu_tmp['css']) && is_array($submenu_tmp['css']) && !empty($submenu_tmp['css'])){

			    				$files = $submenu_tmp['css'];
			    				
			    				foreach ($files as $file) {

					    			if(!in_array($file, $submenu)){
					    				$submenu[] = $file;
					    				//Permission
										if(permission(preg_replace("/\s+/","_",strtolower(trim(ucfirst($data->menu->title))))."_enable") && file_exists('public/'.$file)){
											echo '<link rel="stylesheet" type="text/css" href="'.BASE.'public/'.$file.'">';
										}
										//End permission
						                
					    			}

			    				}
			    			}
			    		}
			    	}

				}

			}
		}


		$directory = APPPATH."../plugins/";
		$folders = glob($directory . "*");
		foreach($folders as $folder){
			$folder_list = explode("/", $folder);
			$folder_name = end($folder_list);

			if(is_dir($folder)){
				$config = $folder."/config.json";
				if(file_exists($folder."/config.json")){
					$data_json = file_get_contents($config);
					$data = json_decode($data_json);
					if(isset($data->css)){
						$submenu[] = $data->css;
						$file = $data->css;
						if(is_array($data->css)){
							$file = reset($data->css);
						}
						echo '<link rel="stylesheet" type="text/css" href="'.BASE.'plugins/'.$folder_name."/".$file.'">';
						
					}

					if(file_exists($folder."/menu")){
		    			$submenu_files = glob($folder."/menu/" . "*.php");
			    		foreach ($submenu_files as $submenu_file) {
			    			$submenu_tmp = include $submenu_file;
			    				
			    			if(isset($submenu_tmp['css']) && is_array($submenu_tmp['css']) && !empty($submenu_tmp['css'])){

			    				$files = $submenu_tmp['css'];
			    				
			    				foreach ($files as $file) {

					    			if(!in_array($file, $submenu)){
					    				$submenu[] = $file;
					    				//Permission
										if(permission(preg_replace("/\s+/","_",strtolower(trim(ucfirst($data->menu->title))))."_enable") && file_exists('public/'.$file)){
											echo '<link rel="stylesheet" type="text/css" href="'.BASE.'public/'.$file.'">';
										}
										//End permission
						                
					    			}

			    				}
			    			}
			    		}
			    	}

				}

			}
		}
	}
}

if(!function_exists('get_theme')){
	function get_theme(){
		$theme_config = APPPATH."../themes/config.json";
		$theme = "basic";
		if(file_exists($theme_config)){	
			$config = file_get_contents($theme_config);
			$config = json_decode($config);
			if(is_object($config) && isset($config->theme)){
				$theme = $config->theme;
			}
		}


		return $theme;
	}
}

if(!function_exists('theme_js')){
	function theme_js(){
		$theme_config = APPPATH."../themes/config.json";
		$theme = "basic";
		if(file_exists($theme_config)){	
			$config = file_get_contents($theme_config);
			$config = json_decode($config);
			if(is_object($config) && isset($config->theme)){
				$config_layout = APPPATH."../themes/".$config->theme."/config.json";
				if(file_exists($config_layout)){
					$data_json = file_get_contents($config_layout);
					$data = json_decode($data_json);
					if(isset($data->js) && !empty($data->js)){
						foreach ($data->js as $key => $link) {
							if(file_exists(APPPATH."../themes/".$config->theme."/".$link)){
								echo '<script type="text/javascript" src="'.BASE."themes/".$config->theme."/".$link.'"></script>';
							}
						}
					}
				}
			}
		}
	}
}

if(!function_exists('theme_css')){
	function theme_css(){
		$theme_config = APPPATH."../themes/config.json";
		$theme = "basic";
		if(file_exists($theme_config)){	
			$config = file_get_contents($theme_config);
			$config = json_decode($config);
			if(is_object($config) && isset($config->theme)){
				$config_layout = APPPATH."../themes/".$config->theme."/config.json";
				if(file_exists($config_layout)){
					$data_json = file_get_contents($config_layout);
					$data = json_decode($data_json);
					if(isset($data->css) && !empty($data->css)){
						foreach ($data->css as $key => $link) {
							if(file_exists(APPPATH."../themes/".$config->theme."/".$link)){
								echo '<script type="text/javascript" src="'.BASE."themes/".$config->theme."/".$link.'"></script>';
							}
						}
					}
				}
			}
		}
	}
}

if(!function_exists('permission_list')){
	function permission_list(){
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		$items = array();
		foreach($folders as $folder){
			if(is_dir($folder)){
				$directory_folder = explode("/", $folder);
				$folder_name = end($directory_folder);
				$config = $folder."/config.json";
				if(file_exists($folder."/config.json")){
					$data_json = file_get_contents($config);
					$data = json_decode($data_json);
					if(isset($data->menu) && !empty($data->menu)){
						$item = array();
						$submenu = array();
				        if(isset($data->submenu) && !empty($data->submenu)){
				        	foreach ($data->submenu as $link => $title) {
				        		$submenu[$link] = $title;
				                $item[] = array(
				                	'link' => $link,
				                	'name' => $title,
				                	'color' => isset($data->menu->color)?$data->menu->color:"#000",
				                	'icon' => $data->menu->icon
				                );
				            }
			    		}

			    		if(file_exists($folder."/menu")){
			    			$submenu_files = glob($folder."/menu/" . "*.php");
				    		foreach ($submenu_files as $submenu_file) {
				    			$submenu_tmp = include $submenu_file;
				    			$title = $submenu_tmp['title'];
				    			$link = $submenu_tmp['link'];
				    			$link_array = explode("/", $link);
				    			if(!isset($submenu[$link])){

				    				$item[] = array(
					                	'link' => $link,
					                	'name' => $title,
					                	'color' => isset($data->menu->color)?$data->menu->color:"#000",
					                	'icon' => $data->menu->icon
					                );
				    			}
				    		}
				    	}

				        $items[$folder_name] = $item;
					}
				}
			}
		}

		return $items;
	}
}

if(!function_exists('block_general_settings')){
	function block_general_settings(){
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		$module_actived = array();
		$data = "";
		$count = 0;
		foreach($folders as $key => $folder)
		{
			if(is_dir($folder))
			{
				$directory_folder = explode("/", $folder);
				$folder_name = end($directory_folder);
				$config = $folder."/config.json";

				
				if(file_exists($folder."/config.json"))
				{
					$controller_files = glob($folder."/controllers/". "*.php");

					if(is_array($controller_files))
					{	
						$data .= '<div id="'.$folder_name.'" class="tab-pane fade in ' .(($count == 0)?"active":""). '">';
						$count++;

						foreach ($controller_files as $controller_file) 
						{
							$content_file = file_get_contents($controller_file);

							if (preg_match("/block_general_settings/i", $content_file))
							{
								$directory_file = explode("/", $controller_file);
								if(!empty($directory_file))
								{

									$module_actived[] = $folder_name;
									$file = end($directory_file);
									$file_name = str_replace(".php", "", $file);
									$data .= modules::run("{$folder_name}/{$file_name}/block_general_settings", $folder);
								}
							}
						}

						$data .= '</div>';
					}
				}
			}
		}

		return (object)array(
			"data" => $data,
			"setting_lists" => json_encode(array_unique($module_actived))
		);
	}
}

if(!function_exists('block_report')){
	function block_report($folder_view = ''){
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		$module_actived = array();
		$data = "";
		$count = 0;
		foreach($folders as $key => $folder)
		{
			if(is_dir($folder))
			{
				$directory_folder = explode("/", $folder);
				$folder_name = end($directory_folder);
				$config = $folder."/config.json";
				if(permission($folder_name."_enable")){

					$content_file = file_get_contents($config);
					$config_data = json_decode($content_file);

					$module_actived[] = array(
						"title" => $config_data->menu->title,
						"color" => $config_data->menu->color,
						"icon" => $config_data->menu->icon,
						"permission" => $folder_name
					);

					if(file_exists($folder."/config.json") && $folder_view == $folder_name)
					{
						$controller_files = glob($folder."/controllers/". "*.php");

						if(is_array($controller_files))
						{	
							$data .= '<div id="'.$folder_name.'" class="tab-pane fade in ' .(($count == 0)?"active":""). '">';
							$count++;

							foreach ($controller_files as $controller_file) 
							{
								$content_file = file_get_contents($controller_file);

								if (preg_match("/block_report/i", $content_file))
								{
									$directory_file = explode("/", $controller_file);
									if(!empty($directory_file))
									{
										$file = end($directory_file);
										$file_name = str_replace(".php", "", $file);

										//Permission
										if(permission("{$folder_name}/{$file_name}")){
											$data .= modules::run("{$folder_name}/{$file_name}/block_report", $folder);
										}
										
									}
								}
							}

							$data .= '</div>';
						}
						
					}
				}
			}
		}

		$report_lists = array_map("unserialize", array_unique(array_map("serialize", $module_actived)));
		return (object)array(
			"data" => $data,
			"report_lists" => json_encode($report_lists)
		);
	}
}

if(!function_exists('block_schedules')){
	function block_schedules($type, $social_filter){
		$social_filter = explode(".", strtolower($social_filter));
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		$module_actived = array();
		$data = "";
		$count = 0;
		echo '<?xml version="1.0"?>';
		$data .= '<monthly>';
		$paht = array();
		foreach($folders as $key => $folder)
		{
			if(is_dir($folder))
			{
				$directory_folder = explode("/", $folder);
				$folder_name = end($directory_folder);
				$config = $folder."/config.json";

				if(in_array($folder_name, $social_filter))
				{
					if(file_exists($folder."/config.json"))
					{
						$controller_files = glob($folder."/controllers/". "*.php");

						if(is_array($controller_files))
						{	
							$count++;

							foreach ($controller_files as $controller_file) 
							{	
								$content_file = file_get_contents($controller_file);

								if (preg_match("/block_schedules_xml/i", $content_file))
								{

									$directory_file = explode("/", $controller_file);
									if(!empty($directory_file))
									{
										$module_actived[] = $folder_name;
										$file = end($directory_file);
										$file_name = str_replace(".php", "", $file);
										$data .= file_get_contents(PATH."{$folder_name}/{$file_name}/block_schedules_xml/".$type."?mid=".session("uid"));

									}

								}

							}

						}

					}
				}

			}
		}
		$data .= '</monthly>';

		echo $data;
	}
}

if(!function_exists('delete_schedules')){
	function delete_schedules($type, $social){
		$directory = APPPATH."../public/";
		$folders = glob($directory . "*");
		$paht = array();
		foreach($folders as $key => $folder)
		{
			if(is_dir($folder))
			{
				$directory_folder = explode("/", $folder);
				$folder_name = end($directory_folder);
				$config = $folder."/config.json";

				if(file_exists($folder."/config.json"))
				{
					$controller_files = glob($folder."/controllers/". "*.php");

					if(is_array($controller_files))
					{	
						foreach ($controller_files as $controller_file) 
						{	
							$content_file = file_get_contents($controller_file);

							if (preg_match("/ajax_delete_schedules/i", $content_file))
							{

								$directory_file = explode("/", $controller_file);
								if(!empty($directory_file))
								{
									$file = end($directory_file);
									$file_name = str_replace(".php", "", $file);
									if($social == $folder_name){
										Modules::run($folder_name."/".$file_name."/ajax_delete_schedules", true, $type);
									}
								}

							}

						}

					}

				}

			}
		}
	}	
}

if(!function_exists("custom_row")){
	function custom_row($data, $column_name, $module, $ids = ""){
		$result = $data;
		switch ($column_name) {
			case 'changed':
				$result = convert_datetime($data);
				break;
			case 'created':
				$result = convert_datetime($data);
				break;
			case 'expiration_date':
				$result = convert_date($data);
				break;
			case 'package':
				$result = $data != ""?$data:"<span class='text-danger'>".lang("no_package")."</span>";
				break;
			case 'icon':
				$result = $data == ""?$data:"<span class='{$data}' style='font-size: 20px;'></span>";
				break;
			case 'price_monthly':
				$result = $data == ""?"Free":$data." ".get_option('payment_currency');
				break;
			case 'price_annually':
				$result = $data == ""?"Free":$data." ".get_option('payment_currency');
				break;
			case 'plan':
				$result = $data == 2?"Annually":"Monthly";
				break;
			case 'amount':
				$result = $data == ""?"0".get_option('payment_currency'):$data." ".get_option('payment_currency');
				break;
			case 'history_ip':
				$history = json_decode($data);
				$result = $history == ""?"":end($history);
				break;
			case 'location':
				$result = list_countries($data);
				break;
				
			case 'type':
				switch ($module) {
					case 'payment_history':
							
						if(strpos($data, "stripe") !== false){
							$result = "<i class='fa fa-cc-stripe' style='font-size: 25px;'></i>";
						}else if(strpos($data, "paypal") !== false){
							$result = "<i class='fa fa-cc-paypal' style='font-size: 25px;'></i>";
						}
					break;
				}
				break;
			case 'slug':
				switch ($module) {
					case 'custom_page':
						$result = '<a href="'.cn('p/'.$data).'" data-id="'.$ids.'">'.$data.'</a>';
					break;
				}
				break;
			case 'status':
				switch ($module) {
					case 'users':
						switch ($data) {
							case 0:
								$result = '<a href="'.cn($module.'/ajax_update_status').'" class="tag tag-danger actionItem" data-transfer="true" data-id="'.$ids.'">'.lang("disable").'</a>';
								break;
							
							case 1:
								$result = '<a href="'.cn($module.'/ajax_update_status').'" class="tag tag-success actionItem" data-transfer="true" data-id="'.$ids.'">'.lang("enable").'</a>';
								break;
						}

						break;
					
					default:
						switch ($data) {
							case 0:
								$result = '<a href="'.cn($module.'/ajax_update_status').'" class="tag tag-danger actionItem" data-transfer="true" data-id="'.$ids.'">'.lang("disable").'</a>';
								break;
							
							case 1:
								$result = '<a href="'.cn($module.'/ajax_update_status').'" class="tag tag-success actionItem" data-transfer="true" data-id="'.$ids.'">'.lang("enable").'</a>';
								break;
						}

						break;
				}
				break;
			
			default:
				$result = $data;
				break;
		}

		return $result;
	}
}

if(!function_exists("permission")){
	function permission($name = "", $uid = 0){
		$CI = &get_instance();

		if($uid == 0){
			$uid = session("uid");
		}

		if($name == ""){
			$name = segment(1)."/".segment(2);
		}

		$permission = $CI->model->get("permission, expiration_date, admin", USERS, "id = '".$uid."'");

		if(!empty($permission)){
			if($permission->admin == 1){
				return true;
			}

			$today = strtotime(NOW);
			$expiration_date = strtotime($permission->expiration_date." 23:59:59");
			if($expiration_date < $today){
				return false;
			}			
			
			$permission = (array)json_decode($permission->permission);
			if(in_array(strtolower($name), $permission)){
				return true;
			}
		}
		return false;
	} 
}

if(!function_exists("check_expiration_date")){
	function check_expiration_date($uid = 0){
		$CI = &get_instance();

		if($uid == 0){
			$uid = session("uid");
		}

		$permission = $CI->model->get("permission, expiration_date, admin", USERS, "id = '".$uid."'");

		if(!empty($permission)){
			if($permission->admin == 1){
				return true;
			}

			$today = strtotime(NOW);
			$expiration_date = strtotime($permission->expiration_date." 23:59:59");
			if($expiration_date > $today){
				return true;
			}			
		}
		return false;
	}
}

if(!function_exists("get_left_days")){
	function get_left_days($uid = 0){
		$CI = &get_instance();

		if($uid == 0){
			$uid = session("uid");
		}

		$user = $CI->model->get("permission, expiration_date, admin", USERS, "id = '".$uid."'");

		$now = (int)strtotime(date("Y-m-d", strtotime(NOW)));
		$expiration_date = (int)strtotime($user->expiration_date);
		$days_left = ($expiration_date - $now)/(60*60*24);

		return $days_left;
	}
}

if(!function_exists("check_number_account")){
	function check_number_account($table){
		$CI = &get_instance();
		$user = $CI->model->get("package, permission, expiration_date, admin", USERS, "id = '".session("uid")."'");
		if(!empty($user)){
			if($user->admin == 1){
				return true;
			}

			$number_accounts = $CI->model->get("*", PACKAGES, "id = '{$user->package}'");
			$current_accounts = $CI->model->fetch("*", $table, "uid = '".session("uid")."'");
			if(!empty($number_accounts) && $number_accounts->number_accounts <= count($current_accounts)){
				return false;
			}else{
				return true;
			}

		}

		return false;
	}
}
?>