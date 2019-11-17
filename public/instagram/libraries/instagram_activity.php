<?php 
if (!defined('TEMP_PATH')) {
    define("TEMP_PATH", APPPATH . "../assets/tmp");
}

class instagram_activity{
    public function __construct($parent){
        $this->_parent = $parent;
        $this->act = array();
        $this->todo = false;
        $this->number = 0;
        $this->follow = array();
        $this->unfollow = array();
        $this->comment = array();
        $this->direct_message = array();
        $this->repost_media = null;
        $this->filter = array();
        $this->schedule = null;
        $this->ci = &get_instance();
    }

    public function process($schedule){
        $field = false;

        $this->act = json_decode($schedule->data, 0);
        $this->todo = $schedule->action;
        $this->filter = get_value($this->act, "filter");
        $this->follow = get_value($this->act, "follow");
        $this->unfollow = get_value($this->act, "unfollow");
        $this->comment = get_value($this->act, "comment");
        $this->direct_message = get_value($this->act, "direct_message");
        $this->repost_media = get_value($this->act, "repost_media");
        $this->schedule = $schedule;
        $this->number = $schedule->number;

        $target = $this->random_field("target", false);
        if($this->todo != "unfollow"){
            $field = $this->target($target);
        }
        
        $response = $this->action($target, $field);
        return $response;
    }

    public function action($target, $field){
        $field = is_string($field)?trim($field):$field;
        $response = array();
        switch ($this->todo) {
            case 'like':
                $response = $this->like_comment($target, $field);
                break;

            case 'comment':
                $response = $this->like_comment($target, $field);
                break;

            case 'follow':
                $response = $this->follow_direct($target, $field);
                break;

             case 'unfollow':
                $response = $this->unfollow();
                break;

            case 'direct_message':
                if(isset($this->direct_message->by) && $this->direct_message->by ==  "target"){
                    $response = $this->follow_direct($target, $field);
                }else{
                    $response = $this->welcomedm($target, $field);
                }
                break;

            case 'repost_media':
                $response = $this->repost_media($field);
                break;
        }

        return $response;
    } 

    public function like_comment($target, $field){
        $feed_action = false;
        $response = array();
        switch ($target) {
            case 'tag':
                $feeds = $this->_parent->get_feed_by_tag($field);
                $feeds = $this->filter($feeds);

                if(!empty($feeds)){

                    //Remove posts can't comment
                    $feeds = $this->remove_post_cant_comment($feeds);

                    //Don't comment same users
                    $feeds = $this->dont_comment_same_users("feed", $feeds);

                    //Don't comment same posts
                    $feeds = $this->dont_comment_same_posts($feeds);

                    //Don't like same posts
                    $feeds = $this->dont_like_same_posts($feeds);

                    $feed = get_random_values($feeds, $this->number);
                    $feed_action = $feed;
                }
                
                break;

            case 'location':
                $feeds = $this->_parent->get_feed_by_location($field);
                $feeds = $this->filter($feeds);

                if(!empty($feeds)){

                    //Remove posts can't comment
                    $feeds = $this->remove_post_cant_comment($feeds);

                    //Don't comment same users
                    $feeds = $this->dont_comment_same_users("feed", $feeds);

                    //Don't comment same posts
                    $feeds = $this->dont_comment_same_posts($feeds);

                    //Don't like same posts
                    $feeds = $this->dont_like_same_posts($feeds);

                    $feed = get_random_values($feeds, $this->number);
                    $feed_action = $feed;
                }
                break;

            case 'follower':
                $users = $this->_parent->get_followers(true, $field);
                $users = $this->filter($users);

                if(!empty($users)){

                    //Don't comment same users
                    $feeds = $this->dont_comment_same_users("user", $users);

                    $user = get_random_value($users);
                    $userId = $user->pk;
                    $feeds = $this->_parent->get_feed($userId);

                    //Remove posts can't comment
                    $feeds = $this->remove_post_cant_comment($feeds);

                    //Don't comment same posts
                    $feeds = $this->dont_comment_same_posts($feeds);

                    //Don't like same posts
                    $feeds = $this->dont_like_same_posts($feeds);
                    
                    if(!empty($feeds)){
                        $feed = get_random_values($feeds, $this->number);
                        $feed_action = $feed;
                    }
                }
                break;

            case 'following':
                $users = $this->_parent->get_following(true, $field);
                $users = $this->filter($users);

                if(!empty($users)){

                    //Don't comment same users
                    $feeds = $this->dont_comment_same_users("user", $users);

                    $user = get_random_value($users);
                    $userId = $user->pk;
                    $feeds = $this->_parent->get_feed($userId);

                    //Remove posts can't comment
                    $feeds = $this->remove_post_cant_comment($feeds);

                    //Don't comment same posts
                    $feeds = $this->dont_comment_same_posts($feeds);

                    //Don't like same posts
                    $feeds = $this->dont_like_same_posts($feeds);

                    if(!empty($feeds)){
                        $feed = get_random_values($feeds, $this->number);
                        $feed_action = $feed;
                    }
                }
                break;

            case 'liker':
                $liker = get_random_value($field);

                if(isset($liker->pk)){
                    $field = $liker->pk;

                    $feeds = $this->_parent->get_feed($field);
                    $feeds = $this->filter($feeds);

                    if(!empty($feeds)){

                        //Remove posts can't comment
                        $feeds = $this->remove_post_cant_comment($feeds);
                        
                        //Don't comment same users
                        $feeds = $this->dont_comment_same_users("feed", $feeds);

                        //Don't comment same posts
                        $feeds = $this->dont_comment_same_posts($feeds);

                        //Don't like same posts
                        $feeds = $this->dont_like_same_posts($feeds);

                        $feed = get_random_values($feeds, $this->number);
                        $feed_action = $feed;
                    }
                }

                break;

            case 'commenter':
                $comment = get_random_value($field);
                if(isset($comment->user_id)){
                    $field = $comment->user_id;

                    $feeds = $this->_parent->get_feed($field);
                    $feeds = $this->filter($feeds);

                    if(!empty($feeds)){

                        //Remove posts can't comment
                        $feeds = $this->remove_post_cant_comment($feeds);

                        //Don't comment same users
                        $feeds = $this->dont_comment_same_users("feed", $feeds);

                        //Don't comment same posts
                        $feeds = $this->dont_comment_same_posts($feeds);

                        //Don't like same posts
                        $feeds = $this->dont_like_same_posts($feeds);

                        $feed = get_random_values($feeds, $this->number);
                        $feed_action = $feed;
                    }
                }

                break;
        }

        if($feed_action){
            switch ($this->todo) {
                case 'like':
                    foreach ($feed_action as $key => $feed) {
                        $action = $this->_parent->like($feed->id);
                        if(isset($action->status) && $action->status == "ok"){
                            $response[] = $feed;
                        }else{
                            $response = $action;
                        }
                    }
                    break;

                case 'comment':
                    $comment = get_value($this->act, "comment");
                    foreach ($feed_action as $key => $feed) {
                        $action = $this->_parent->comment($feed->id, $comment);
                        if(isset($action->status) && $action->status == "ok"){
                            $response[] = $feed;
                        }else{
                            $response = $action;
                        }
                    }
                    break;
            }
        }

        return $response;
    }

    public function follow_direct($target, $field){
        $userIds = false;
        $response = array();
        switch ($target) {
            case 'tag':
                $feeds = $this->_parent->get_feed_by_tag($field);
                $feeds = $this->filter($feeds);
                if(!empty($feeds)){
                    $feeds = $this->dont_follow_private_users($feeds, ["user", "is_private"]);
                    $feeds = $this->dont_follow_same_users("feed", $feeds);
                    $feeds = $this->remove_onwer_posts("feed", $feeds);
                    $feeds = $this->dont_dm_same_users("feed", $feeds);
                    $feed = get_random_values($feeds, $this->number);
                    $userIds = array();
                    if(!empty($feed)){
                        foreach ($feed as $key => $value) {
                            $userIds[] = $value->user;
                        }
                    }
                }
                break;

            case 'location':
                $feeds = $this->_parent->get_feed_by_location($field);
                $feeds = $this->filter($feeds);
                if(!empty($feeds)){
                    $feeds = $this->dont_follow_private_users($feeds, ["user", "is_private"]);
                    $feeds = $this->dont_follow_same_users("feed", $feeds);
                    $feeds = $this->remove_onwer_posts("feed", $feeds);
                    $feeds = $this->dont_dm_same_users("feed", $feeds);
                    $feed = get_random_values($feeds, $this->number);
                    $userIds = array();
                    if(!empty($feed)){
                        foreach ($feed as $key => $value) {
                            $userIds[] = $value->user;
                        }
                    }
                }
                break;

            case 'follower':
                $users = $this->_parent->get_followers(true, $field);
                $users = $this->filter($users);
                if(!empty($users)){
                    $users = $this->dont_follow_private_users($users, "is_private");
                    $users = $this->dont_follow_same_users("user", $users);
                    $users = $this->remove_onwer_posts("user", $users);
                    $users = $this->dont_dm_same_users("user", $users);
                    $users = get_random_values($users, $this->number);
                    $userIds = $users;
                }
                break;

            case 'following':
                $users = $this->_parent->get_following(true, $field);
                $users = $this->filter($users);
                if(!empty($users)){
                    $users = $this->dont_follow_private_users($users, "is_private");
                    $users = $this->dont_follow_same_users("user", $users);
                    $users = $this->remove_onwer_posts("user", $users);
                    $users = $this->dont_dm_same_users("user", $users);
                    $users = get_random_values($users, $this->number);
                    $userIds = $users;
                }
                break;

            case 'liker':
                $field = $this->filter($field);
                $field = $this->dont_follow_private_users($field, "is_private");
                $field = $this->dont_follow_same_users("user", $field);
                $field = $this->remove_onwer_posts("user", $field);
                $field = $this->dont_dm_same_users("user", $field);
                $userIds = get_random_values($field, $this->number);
                break;

            case 'commenter':
                $field = $this->filter($field);
                $field = $this->dont_follow_private_users($field, "is_private");
                $field = $this->dont_follow_same_users("user", $field);
                $field = $this->remove_onwer_posts("user", $field);
                $field = $this->dont_dm_same_users("user", $field);
                $userIds = get_random_values($field, $this->number);
                break;
        }

        if($userIds){
            switch ($this->todo) {
                case 'follow':
                    foreach ($userIds as $key => $user) {
                        $action = $this->_parent->follow($user->pk);
                        if(isset($action->status) && $action->status == "ok"){
                            $response[] = $user;
                        }else{
                            $response = $action;
                        }
                    }
                    break;

                case 'direct_message':
                    $message = get_value($this->act, "direct_message");
                    foreach ($userIds as $key => $user) {
                        $action = $this->_parent->direct_message($user->pk, $message);
                        if(isset($action->status) && $action->status == "ok"){
                            $response[] = $user;
                        }else{
                            $response = $action;
                        }
                    }
                    break;
            }
        }

        
        return $response;
    }

    public function unfollow(){
        $userIds = false;
        $response = array();

        if(isset($this->unfollow->source)){
            $source = $this->unfollow->source;
            switch ($source) {
                case 'db':
                    $after_day = $this->unfollow->after; 
                    $after_day =  date("Y-m-d H:i:s", strtotime(NOW) - $after_day*86400);

                    $userIds = $this->ci->model->fetch("id,user_id", INSTAGRAM_ACTIVITIES_LOG, "action = 'follow' AND created < '{$after_day}' AND pid = '{$this->schedule->pid}'", "id", "desc", "0", $this->number);
                    if(!empty($userIds)){
                        foreach ($userIds as $key => $user) {
                            $check_is_follower = $this->dont_unfollow_my_followers($user->user_id);
                            if($check_is_follower){
                                continue;
                            }

                            $action = $this->_parent->unfollow($user->user_id);
                            if(isset($action->status) && $action->status == "ok"){
                                $this->ci->db->update(INSTAGRAM_ACTIVITIES_LOG, array("action" => "unfollow", "created" => NOW), array("id" => $user->id));
                                $response[] = $key;
                            }else{
                                $response = $action;
                            }
                        }
                    }else{
                        $response = -1;
                    }

                    break;
                
                default:
                    $users = $this->_parent->get_following(true);
                    $users = $this->filter($users);
                    if(!empty($users)){
                        $user = get_random_values($users, $this->number);
                        $userIds = $user;
                    }

                    if($userIds){
                        foreach ($userIds as $key => $user) {
                            $check_is_follower = $this->dont_unfollow_my_followers($user->pk);
                            if(!$check_is_follower){
                                $action = $this->_parent->unfollow($user->pk);

                                if(isset($action->status) && $action->status == "ok"){
                                    $response[] = $user;
                                    $this->ci->db->delete(INSTAGRAM_ACTIVITIES_LOG, array("user_id" => $user->pk, "action" => "follow"));
                                }else{
                                    $response = $action;
                                }
                            }
                        }
                    }
                    break;
            }

        }

        return $response;
    }

    public function welcomedm(){
        $response = array();
        $result = $this->_parent->get_recent_activity_inbox();

        if(!empty($result)){
            $count = 0;
            foreach ($result as $key => $row) {
                if($row->type == 3 && isset($row->args->profile_id)){                    

                    if($count <= $this->number){
                        $profile_id = $row->args->profile_id;
                        $log = $this->ci->model->get("*", INSTAGRAM_ACTIVITIES_LOG, "uid = '{$this->schedule->uid}' AND pid = '{$this->schedule->pid}' AND user_id = '".$profile_id."' ");
                        if(empty($log)){
                        
                            $check_sent = false;
                            if(!empty($response)){
                                foreach ($response as $value) {
                                    if ($value->pk == $profile_id) {
                                        $check_sent = true;
                                    }
                                }
                            } 

                            if(!$check_sent){
                                $message = get_value($this->act, "direct_message");

                                $action = $this->_parent->direct_message($profile_id, $message);
                                if(isset($action->status) && $action->status == "ok"){
                                    $response[] = (object)array(
                                        "pk" => $profile_id,
                                        "username" => $row->args->profile_name
                                    );
                                    $count++;
                                }else{
                                    $response = $action;
                                }
                            }

                            if(isset($row->args->second_profile_id)){

                                if($count <= $this->number){

                                    $second_profile_id = $row->args->second_profile_id;
                                    $log = $this->ci->model->get("*", INSTAGRAM_ACTIVITIES_LOG, "uid = '{$this->schedule->uid}' AND pid = '{$this->schedule->pid}' AND user_id = '".$second_profile_id."' ");

                                    if(empty($log)){
                                        $check_sent = false;
                                        if(!empty($response)){
                                            foreach ($response as $value) {
                                                if ($value->pk == $second_profile_id) {
                                                    $check_sent = true;
                                                }
                                            }
                                        } 

                                        if(!$check_sent){
                                            $message = get_value($this->act, "direct_message");

                                            $action = $this->_parent->direct_message($second_profile_id, $message);
                                            if(isset($action->status) && $action->status == "ok"){
                                                $userinfo = $this->_parent->get_userinfo($second_profile_id);

                                                    $response[] = (object)array(
                                                        "pk" => $second_profile_id,
                                                        "username" => $userinfo->username
                                                    );

                                                $count++;
                                            }else{
                                                $response = $action;
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

        return $response;
    }

    public function repost_media($field){
        if(isset($this->repost_media->by)){
            $target = $this->repost_media->by;
            $target_list = array("username", "location", "tag");

            if($target == "all"){
                $rand = rand(0,2);
                $target = $target_list[$rand];
            }

            $feed_action = false;
            $response = array();
            switch ($target) {
                case 'tag':
                    $feeds = $this->_parent->get_feed_by_tag($field);
                    if(!empty($feeds)){
                        $feed = get_random_values($feeds, 1);
                        $feed_action = $feed;
                    }
                    
                    break;

                case 'location':
                    $feeds = $this->_parent->get_feed_by_location($field);
                    if(!empty($feeds)){
                        $feed = get_random_values($feeds, 1);
                        $feed_action = $feed;
                    }
                    break;

                case 'username':
                    $username = $this->random_field("username");
                    $username = explode("|", $username);
                    if(count($username) == 2){
                        $field = $username[0];
                        $feeds = $this->_parent->get_feed($field);

                        if(!empty($feeds)){
                            $feed = get_random_values($feeds, 1);
                            $feed_action = $feed;
                        } 
                    }

                    break;
            }

        
            //START POST
            if($feed_action){
                $feed = $feed_action[0];
                $log = $this->ci->model->get("*", INSTAGRAM_ACTIVITIES_LOG, "uid = '".$this->schedule->uid."' AND pid = '".$this->schedule->pid."' AND media_id = '".$feed->id."'");
                if(empty($log)){

                    $spintax  = new Spintax();

                    // Download the media
                    $media = [];
                    if ($feed->media_type == 1) {
                        $media[] = $feed->image_versions2->candidates[0]->url;
                    } else if ($feed->media_type == 2) {
                        $media[] = $feed->video_versions[0]->url;
                    } else if ($feed->media_type == 8) {
                        foreach ($feed->carousel_media as $m) {
                            if ($m->media_type == 1) {
                                $media[] = $m->image_versions2->candidates[0]->url;

                            } else if ($m->media_type == 2) {
                                $media[] = $m->video_versions[0]->url;
                            }
                        }
                    }

                    $downloaded_media = [];
                    foreach ($media as $m) {
                        $url_parts = parse_url($m);
                        if (empty($url_parts['path'])) {
                            continue;
                        }

                        $ext = strtolower(pathinfo($url_parts['path'], PATHINFO_EXTENSION));
                        $filename = uniqid(ids()."-").".".$ext;
                        $downres = file_put_contents(TEMP_PATH . "/". $filename, file_get_contents($m));
                        if ($downres) {
                            $downloaded_media[] = $filename;
                        }
                    }

                    if (empty($downloaded_media)) {
                        throw new \InvalidArgumentException("Couldn't download the media of the selected post");
                    }

                    $original_caption = "";
                    if ($feed->caption->text) {
                        $original_caption = $feed->caption->text;
                    }

                    $caption = "";
                    if(isset($this->repost_media->caption)){
                        $caption = $this->repost_media->caption;
                    }

                    $variables = [
                        "{{caption}}" => $original_caption,
                        "{{username}}" => "@".$feed->user->username,
                        "{{full_name}}" => $feed->user->full_name != ""?
                                               $feed->user->full_name :
                                               "@".$feed->user->username
                    ];

                    $caption = str_replace(
                        array_keys($variables), 
                        array_values($variables), 
                        $caption);

                    $caption = @$spintax->process($caption);
                    $caption = mb_substr($caption, 0, 2200);
                    $caption = Instagram_Caption($caption);

                    // Try to repost
                    try {
                        $response = array();
                        if (count($downloaded_media) > 1) {
                            $album_media = [];

                            foreach ($downloaded_media as $m) {
                                $ext = strtolower(pathinfo($m, PATHINFO_EXTENSION));

                                $album_media[] = [
                                    "type" => in_array($ext, ["mp4"]) ? "video" : "photo",
                                    "file" => TEMP_PATH."/".$m
                                ];
                            }

                            $response = $this->_parent->ig->timeline->uploadAlbum($album_media, ['caption' => $caption]);
                        } else {
                            $m = $downloaded_media[0];
                            $ext = strtolower(pathinfo($m, PATHINFO_EXTENSION));
                            if (in_array($ext, ["mp4"])) {
                                $response = $this->_parent->ig->timeline->uploadVideo(TEMP_PATH."/".$m, ["caption" => $caption]);
                            } else {
                                $response = $this->_parent->ig->timeline->uploadPhoto(TEMP_PATH."/".$m, ["caption" => $caption]);
                            }
                        }

                        $res = array();
                        $res[] = $feed;
                        return $res;
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                }
            }
        }
    }

    public function target($target){
        $field = false;
        $value = $this->random_field("target");

        switch ($target) {
            case 'tag':
                $field = $this->random_field("tag");
                break;

            case 'location':
                $field = $this->random_field("location");
                $field = explode("|", $field);
                if(count($field) == 2){
                    $field = $field[0];
                }
                break;

            case 'follower':
                $field = $this->target_advance($target, $value);
                break;

            case 'following':
                $field = $this->target_advance($target, $value);
                break;

            case 'liker':
                $field = $this->target_advance($target, $value);
                break;

            case 'commenter':
                $field = $this->target_advance($target, $value);
                break;
        }

        return $field;
    }

    public function target_advance($target_key ,$target_value){
        $field = false;
        $rand = rand(1,2);
        if($target_value == "user" || ($target_value == "all" && $rand == 1)){
            switch ($target_key) {
                case 'follower':
                    $username = $this->random_field("username");
                    $username = explode("|", $username);
                    if(count($username) == 2){
                        $field = $username[0];
                    }
                    break;

                case 'following':
                    $username = $this->random_field("username");
                    $username = explode("|", $username);
                    if(count($username) == 2){
                        $field = $username[0];
                    }
                    break;

                case 'liker':
                    $username = $this->random_field("username");
                    $username = explode("|", $username);
                    if(count($username) == 2){
                        $feed = $this->_parent->get_random_feed($username[0], "like_count");
                        if(!empty($feed)){
                            $field = $this->_parent->get_likers($feed->id);  
                        }
                    }
                    break;

                case 'commenter':
                    $username = $this->random_field("username", "comment_count");
                    $username = explode("|", $username);
                    if(count($username) == 2){
                        $feed = $this->_parent->get_random_feed($username[0]);
                        if(!empty($feed)){
                            $field = $this->_parent->get_comments($feed->id);
                        }
                    }
                    break;
            }
        }else{
            switch ($target_key) {
                case 'follower':
                    $users = $this->_parent->get_followers(true, null);
                    if(!empty($users)){
                        $user = get_random_value($users);
                        $field = $user->pk;
                    }
                    break;

                case 'following':
                    $users = $this->_parent->get_following(true, null);
                    if(!empty($users)){
                        $user = get_random_value($users);
                        $field = $user->pk;
                    }
                    break;

                case 'liker':
                    $feed = $this->_parent->get_random_feed(null, "like_count");
                    if(!empty($feed)){
                        $field = $this->_parent->get_likers($feed->id);
                    }
                    break;

                case 'commenter':
                    $feed = $this->_parent->get_random_feed(null, "comment_count");
                    if(!empty($feed)){
                        $field = $this->_parent->get_comments($feed->id);
                    }
                    break;
            }
        }
        return $field;
    }

    public function filter($data){
        $data = $this->filter_basic($data);
        $data = $this->blacklist($data);
        return $data;
    }

    public function filter_basic($data){
        $time_array = array("new" => 1800, "1h" => 3600, "12h" => 43200, "1d" => 86400, "3d" => 259000, "1w" => 604800, "2w" => 1209600, "1m" => 2419200);
        $userIds = array();

        //Filter feed
        if(!empty($data) && isset($data[0]->media_type)){
            foreach ($data as $key => $row) {
                if(isset($data[$key]->media_type)){

                    //Media Age
                    if(isset($this->filter->media_age) && array_key_exists($this->filter->media_age, $time_array)){
                        $media_age = $this->filter->media_age;
                        if(strtotime(NOW) - $row->taken_at > $time_array[$media_age]){ unset($data[$key]); continue; }
                    }

                    //Media Type
                    if(isset($this->filter->media_type)){
                        switch ($this->filter->media_type) {
                            case 'image':
                                if($row->media_type != 1){ unset($data[$key]); continue; }
                                break;

                            case 'video':
                                if($row->media_type != 2){ unset($data[$key]); continue; }
                                break;
                        }
                    }

                    if(isset($this->filter->min_like) && isset($row->like_count) && (int)$this->filter->min_like != 0){
                        $min_like = $this->filter->min_like;
                        if($min_like != 0 && $min_like > $row->like_count){ unset($data[$key]); continue; }
                    }

                    if(isset($this->filter->max_like)){
                        $max_like = $this->filter->max_like;
                        if($max_like != 0 && $max_like < $row->like_count){ unset($data[$key]); continue; }
                    }

                    if(isset($this->filter->min_comment) && isset($row->comment_count)){
                        $min_comment = $this->filter->min_comment;
                        if($min_comment != 0 && $min_comment > $row->comment_count){ unset($data[$key]); continue; }
                    }

                    if(isset($this->filter->max_comment)  && isset($row->comment_count)){
                        $max_comment = $this->filter->max_comment;
                        if($max_comment != 0 && $max_comment < $row->comment_count){ unset($data[$key]); continue; }
                    }

                    $userIds[] = $row->user->pk;
                }
            }

        }

        if(!empty($data)){
            $data = array_values($data);
            $data = $this->filter_advance($data);
        }

        return $data;
    }

    public function filter_advance($data, $index = 0){
        $response = array();
        if(
            (isset($this->filter->min_follower) && (int)$this->filter->min_follower != 0) ||
            (isset($this->filter->max_follower) && (int)$this->filter->max_follower != 0) ||
            (isset($this->filter->min_following) && (int)$this->filter->min_following != 0) ||
            (isset($this->filter->max_following) && (int)$this->filter->max_following != 0) ||
            isset($this->filter->user_profile) ||
            isset($this->filter->user_relation) ||
            isset($this->filter->gender)
        ){
            shuffle($data);
            $data = array_values($data);
            do {
                $check = true;
                $row = $data[$index];

                $userId = null;
                if(isset($row->user)){
                    $userId = $row->user->pk;
                }else if(isset($row->username)){
                    $userId = $row->pk;
                }

                if(!is_null($userId)){
                    $userinfo = $this->_parent->get_userinfo($userId);
                    $friendship = $this->_parent->get_friendship($userId);

                    if(!empty($userinfo)){

                        if(isset($this->filter->min_follower) && $this->filter->min_follower != 0 && $this->filter->min_follower > $userinfo->follower_count){
                            $check = false;
                        }

                        if(isset($this->filter->max_follower) && $this->filter->max_follower != 0 && $this->filter->max_follower < $userinfo->follower_count){
                            $check = false;
                        }

                        if(isset($this->filter->min_following) && $this->filter->min_following != 0 && $this->filter->min_following > $userinfo->following_count){
                            $check = false;
                        }

                        if(isset($this->filter->max_following) && $this->filter->max_following != 0 && $this->filter->max_following < $userinfo->following_count){
                            $check = false;
                        }  

                        //User profile
                        if(isset($this->filter->user_profile) && $check){
                            $user_profile = $this->filter->user_profile;
                            switch ($user_profile) {
                                case 'low':
                                    if(!isset($userinfo->profile_pic_id) || $userinfo->media_count == 0){
                                        $check = false;
                                    }
                                    break;

                                case 'medium':
                                    if(!isset($userinfo->profile_pic_id) || $userinfo->media_count < 10 || $userinfo->full_name == ""){
                                        $check = false;
                                    }
                                    break;
                                case 'high':
                                    if(!isset($userinfo->profile_pic_id) || $userinfo->media_count < 30 || $userinfo->full_name == "" || $userinfo->biography == ""){
                                        $check = false;
                                    }
                                    break;
                            }
                        }

                    }else{
                        $check = false;
                    }

                    //User relation
                    if(isset($this->filter->user_relation) && $check){
                        $user_relation = $this->filter->user_relation;
                        switch ($user_relation) {
                            case 'followers':
                                if($friendship->followed_by == 1 || $friendship->incoming_request == 1){
                                    $check = false;
                                }
                                break;

                            case 'followings':
                                if($friendship->following == 1 || $friendship->outgoing_request == 1){
                                    $check = false;
                                }
                                break;
                            case 'both':
                                if($friendship->followed_by == 1 || $friendship->following == 1 || $friendship->incoming_request == 1 || $friendship->outgoing_request == 1){
                                    $check = false;
                                }
                                break;
                        }
                    }

                    //Gender
                    if(isset($this->filter->gender) && $check){
                        $gender = $this->filter_gender($row->user->full_name);
                        if($gender){
                            switch ($this->filter->gender) {
                                case 'm':
                                    if($gender != "male"){ $check = false; }
                                    break;
                                
                                case 'f':
                                    if($gender != "female"){ $check = false; }
                                    break;
                            }
                        }
                    }
                }

                if($check){
                    $response[] = $row;
                }

                $index++;
            } while (isset($data[$index]) && $this->number > count($response));

            return $response;
        }

        return $data;
    }

    public function blacklist($data){
        $tag_blacklist = get_value($this->act, "tag_blacklist");
        $username_blacklist = get_value($this->act, "username_blacklist");
        $keywork_blacklist = get_value($this->act, "keyword_blacklist");
        if(!empty($data)){
            foreach ($data as $key => $value) {
                
                $check_unset = false;

                if(isset($value->caption)){
                    $caption = $value->caption->text;
                    if(!empty($tag_blacklist) && !$check_unset){
                        foreach ($tag_blacklist as $tag_value) {
                            if (strpos($caption, "#".$tag_value) !== false) {
                                unset($data[$key]);
                                $check_unset = true;
                                break;
                            }
                        }
                    }

                    if(!empty($keywork_blacklist) && !$check_unset){
                        foreach ($keywork_blacklist as $keyword_value) {
                            if (strpos($caption, $keyword_value) !== false) {
                                unset($data[$key]);
                                $check_unset = true;
                                break;
                            }
                        }
                    }
                }

                if(isset($value->user)){
                    $username = $value->user->username;
                    if(!empty($username_blacklist) && !$check_unset){
                        foreach ($username_blacklist as $username_value) {
                            if ($username == $username_value) {
                                unset($data[$key]);
                                $check_unset = true;
                                break;
                            }
                        }
                    }
                }

                if(isset($value->username)){
                    $username = $value->username;
                    if(!empty($username_blacklist) && !$check_unset){
                        foreach ($username_blacklist as $username_value) {
                            if ($username == $username_value) {
                                unset($data[$key]);
                                $check_unset = true;
                                break;
                            }
                        }
                    }
                }

            }
            
            return array_values($data);
        }

        return $data;
    }
    
    public function filter_gender($name) {
        /*$apiKey = '5b3346dbff8c2743b41b2091';
        $data = json_decode(file_get_contents('https://genderapi.io/api?key=' . $apiKey . '&name=' . urlencode($name)));
        if(isset($data->gender)){
            return $data->gender;
        }*/
        return false;
    }

    //Remove onwer posts
    public function remove_onwer_posts($type, $data){
        if(!empty($data)){
            $owner = $this->_parent->get_current_user();
            switch ($type) {
                case 'feed':
                    foreach ($data as $key => $row) {
                        if($row->user->pk == $owner->user->pk){
                            unset($data[$key]); continue;
                        }
                    }
                    break;
                
                case 'user':
                    foreach ($data as $key => $row) {
                        if($row->pk == $owner->user->pk){
                            unset($data[$key]); continue;
                        }
                    }
                    break;
            }

            if(!empty($data)){
                $data = array_values($data);
                $data = $this->filter_advance($data);
            }
        }
        
        return $data;
    }

    //Remove post can't comment
    public function remove_post_cant_comment($data){
        if($this->todo == "comment"){
            if(!empty($data)){
                foreach ($data as $key => $value) {
                    if(isset($value->comments_disabled) && $value->comments_disabled == 1){
                        unset($data[$key]); continue;
                    }
                }
            }
        }

        if(!empty($data)){
            $data = array_values($data);
            $data = $this->filter_advance($data);
        }

        return $data;
    }

    //Don't comment same users
    public function dont_comment_same_users($type, $data){
        if($this->todo == "comment" && isset($this->comment->dont_spam)){
            switch ($type) {
                case 'feed':
                    $feeds_tmp = array();
                    shuffle($data);
                    foreach ($data as $key => $row) {
                        $item = $this->ci->model->get("id",INSTAGRAM_ACTIVITIES_LOG, "user_id = '".$row->user->pk."' AND action = 'comment' AND pid = '{$this->schedule->pid}'");
                        if(empty($item)) $feeds_tmp[] = $row;
                        if(count($feeds_tmp) == 3) break;
                    }
                    $data = $feeds_tmp;
                    break;
                
                case 'user':
                    $users_tmp = array();
                    shuffle($data);
                    foreach ($data as $key => $row) {
                        $item = $this->ci->model->get("id",INSTAGRAM_ACTIVITIES_LOG, "user_id = '".$row->pk."' AND action = 'comment' AND pid = '{$this->schedule->pid}'");
                        if(empty($item)) $users_tmp[] = $row;
                        if(count($users_tmp) == 3) break;
                    }
                    $data = $users_tmp;
                    break;
            }
        }

        return $data;
    }

    //Don't like same posts
    public function dont_like_same_posts($data){
        if($this->todo == "like"){
            $feeds_tmp = array();
            if(!empty($data)){
                shuffle($data);
                foreach ($data as $key => $row) {
                    $item = $this->ci->model->get("id",INSTAGRAM_ACTIVITIES_LOG, "media_id = '".$row->id."' AND action = 'like' AND pid = '{$this->schedule->pid}'");
                    if(empty($item)) $feeds_tmp[] = $row;
                    if(count($feeds_tmp) == 3) break;
                }
            }
            $data = $feeds_tmp;
        }
        return $data;
    }

    //Don't send comment same posts
    public function dont_comment_same_posts($data){
        if($this->todo == "comment"){
            $feeds_tmp = array();
            if(!empty($data)){
                shuffle($data);
                foreach ($data as $key => $row) {
                    $item = $this->ci->model->get("id",INSTAGRAM_ACTIVITIES_LOG, "media_id = '".$row->id."' AND action = 'comment' AND pid = '{$this->schedule->pid}'");
                    if(empty($item)) $feeds_tmp[] = $row;
                    if(count($feeds_tmp) == 3) break;
                }
            }
            $data = $feeds_tmp;
        }
        return $data;
    }

    //Don't follow same users
    public function dont_follow_same_users($type, $data){
        if($this->todo == "follow" && isset($this->follow->dont_spam)){
            switch ($type) {
                case 'feed':
                    $feeds_tmp = array();
                    if(!empty($data)){
                        shuffle($data);
                        foreach ($data as $key => $row) {
                            $item = $this->ci->model->get("id",INSTAGRAM_ACTIVITIES_LOG, "user_id = '".$row->user->pk."' AND ( action = 'follow' OR action = 'unfollow' ) AND pid = '{$this->schedule->pid}'");
                            if(empty($item)) $feeds_tmp[] = $row;
                            if(count($feeds_tmp) == 3) break;
                        }
                    }
                    $data = $feeds_tmp;
                    break;
                
                case 'user':
                    $users_tmp = array();
                    if(!empty($data)){
                        shuffle($data);
                        foreach ($data as $key => $row) {
                            $item = $this->ci->model->get("id",INSTAGRAM_ACTIVITIES_LOG, "user_id = '".$row->pk."' AND ( action = 'follow' OR action = 'unfollow' ) AND pid = '{$this->schedule->pid}'");
                            if(empty($item)) $users_tmp[] = $row;
                            if(count($users_tmp) == 3) break;
                        }
                    }
                    $data = $users_tmp;
                    break;
            }
        }

        return $data;
    }

    //Don't send direct message same users
    public function dont_dm_same_users($type, $data){
        if($this->todo == "direct_message"){
            switch ($type) {
                case 'feed':
                    $feeds_tmp = array();
                    if(!empty($data)){
                        shuffle($data);
                        foreach ($data as $key => $row) {
                            $item = $this->ci->model->get("id",INSTAGRAM_ACTIVITIES_LOG, "user_id = '".$row->user->pk."' AND action = 'direct_message' AND pid = '{$this->schedule->pid}'");
                            if(empty($item)) $feeds_tmp[] = $row;
                            if(count($feeds_tmp) == 3) break;
                        }
                    }
                    $data = $feeds_tmp;
                    break;
                
                case 'user':
                    $users_tmp = array();
                    if(!empty($data)){
                        shuffle($data);
                        foreach ($data as $key => $row) {
                            $item = $this->ci->model->get("id",INSTAGRAM_ACTIVITIES_LOG, "user_id = '".$row->pk."' AND action = 'direct_message' AND pid = '{$this->schedule->pid}'");
                            if(empty($item)) $users_tmp[] = $row;
                            if(count($users_tmp) == 3) break;
                        }
                    }
                    $data = $users_tmp;
                    break;
            }
        }
        return $data;
    }

    //Don't unfollow my followers
    public function dont_unfollow_my_followers($userId){
        if($this->todo == "unfollow" && isset($this->unfollow->dont_follower)){
            $item = $this->_parent->get_friendship($userId);
            if(isset($item->status) && $item->status == "ok" && $item->followed_by == 1){
                return true;
            }else{
                return false;
            }
        }

        return false;
    }

    //Don't follow private users
    public function dont_follow_private_users($data, $field){
        if($this->todo == "follow" && isset($this->follow->dont_private)){
            $data = $this->remove_row($data, $field, 1);
        }
        return $data;
    }

    public function remove_row($data, $type, $value){
        if(!empty($data)){
            foreach ($data as $key => $row) {
                if(is_array($type) && count($type) == 2){
                    $type1 = $type[0];
                    $type2 = $type[1];

                    if($row->$type1->$type2 == $value){
                        unset($data[$key]);
                        continue;
                    }
                }else{
                    if(isset($row->$type) && $row->$type == $value){
                        unset($data[$key]);
                        continue;
                    }
                }
            }
            return array_values($data);
        }

        return $data;
    }

    public function random_field($field, $return_value = true){
        $data = get_value($this->act, $field, true);
        $rand_key = array_rand($data);
        if(!empty($data)){
            if($return_value){
                return $data[$rand_key];
            }else{
                return $rand_key;
            }
        }
        return false;
    }
}