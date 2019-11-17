<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*CONFIG POST VIDEO*/
define('FFMPEG_BIN', NULL);
define('FFPROBE_BIN', NULL);
/*END CONFIG POST VIDEO*/


define('INSTAGRAM_ACCOUNTS', "instagram_accounts");
define('INSTAGRAM_POSTS', "instagram_posts");
require_all(APPPATH."../public/instagram/config/constants/");
