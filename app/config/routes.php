<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
$route["default_controller"] = $theme;
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$theme_config = APPPATH."../themes/config.json";
$theme = "basic";
if(file_exists($theme_config)){	
	$config = file_get_contents($theme_config);
	$config = json_decode($config);

	if(is_object($config) && isset($config->theme)){
		if(file_exists(APPPATH."../themes/".$config->theme)){
			$theme = $config->theme;
		}
	}
}

if (!defined('CUSTOM_PAGE')) {
    define("CUSTOM_PAGE", "general_custom_page");
}

$route["default_controller"] = $theme;
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['set_language'] = 'blocks/set_language';
$route['pricing'] = 'payment/pricing';
$route['thank_you'] = 'payment/thank_you';
$route['payment_unsuccessfully'] = 'payment/payment_unsuccessfully';
$route['payment/([a-z0-9]{32})'] = 'payment/index';
$route['file_manager/block_file_manager_multi'] = 'file_manager/block_file_manager/multi';
$route['p/(:any)'] = $theme.'/page';

