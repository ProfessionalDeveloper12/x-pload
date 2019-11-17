<?php
if(!class_exists("instagramapi")){

    require "instagram-php/autoload.php";
    if(file_exists(APPPATH."../public/instagram/libraries/instagram_activity.php")){
        require "instagram_activity.php";
    }

    if(file_exists(APPPATH."../public/instagram/libraries/instagram_comments.php")){
        require "instagram_comments.php";
    }

    if(file_exists(APPPATH."../public/instagram/libraries/instagram_likes.php")){
        require "instagram_likes.php";
    }

    if(file_exists(APPPATH."../public/instagram/libraries/instagram_follows.php")){
        require "instagram_follows.php";
    }

    if(file_exists(APPPATH."../public/instagram/libraries/instagram_unfollows.php")){
        require "instagram_unfollows.php";
    }

    if(file_exists(APPPATH."../public/instagram/libraries/instagram_direct_messages.php")){
        require "instagram_direct_messages.php";
    }

    if(file_exists(APPPATH."../public/instagram/libraries/instagram_reposts.php")){
        require "instagram_reposts.php";
    }

    if(file_exists(APPPATH."../public/instagram/libraries/instagram_livestream.php")){
        require "instagram_livestream.php";
    }

    if(file_exists(APPPATH."../public/instagram/libraries/instagram_analytics.php")){
        require "instagram_analytics.php";
    }

    class instagramapi{
        public $username;
        public $password;
        public $proxy;
        public $ig;
        public $security_code;
        public $verification_code;
        public $twoFactorIdentifier = NULL;
        public $choice;

        function __construct($username = null, $password = null, $proxy = null, $login = false, $security_code = null, $verification_code = null){
            if(file_exists(APPPATH."../public/instagram/libraries/instagram_activity.php")){
                $this->activity = new instagram_activity($this);
            }

            if(file_exists(APPPATH."../public/instagram/libraries/instagram_comments.php")){
                $this->auto_comment = new instagram_comments($this);
            } 

            if(file_exists(APPPATH."../public/instagram/libraries/instagram_likes.php")){
                $this->auto_like = new instagram_likes($this);
            }   

            if(file_exists(APPPATH."../public/instagram/libraries/instagram_follows.php")){
                $this->auto_follow = new instagram_follows($this);
            }  

            if(file_exists(APPPATH."../public/instagram/libraries/instagram_unfollows.php")){
                $this->auto_unfollow = new instagram_unfollows($this);
            }

            if(file_exists(APPPATH."../public/instagram/libraries/instagram_direct_messages.php")){
                $this->auto_direct_message = new instagram_direct_messages($this);
            }

            if(file_exists(APPPATH."../public/instagram/libraries/instagram_reposts.php")){
                $this->auto_repost = new instagram_reposts($this);
            }

            if(file_exists(APPPATH."../public/instagram/libraries/instagram_livestream.php")){
                $this->livestream = new instagram_livestream($this);
            }

            if(file_exists(APPPATH."../public/instagram/libraries/instagram_analytics.php")){
                $this->analytics = new instagram_analytics($this);
            }

            $this->choice = get_option('instagram_verification_code_via', 0);

            if($username != null && $password != null){
                $password = encrypt_decode($password);
                $this->username = $username;
                $this->password = $password;
                $this->proxy = $proxy;
                $this->security_code = $security_code;
                $this->verification_code = $verification_code;
                
                $ig = new \InstagramAPI\Instagram(false, false, [
                    'storage'    => 'mysql',
                    'dbhost'     => DB_HOST,
                    'dbname'     => DB_NAME,
                    'dbusername' => DB_USER,
                    'dbpassword' => DB_PASS,
                    'dbtablename'=> "instagram_sessions"
                ]);

                $ig->setVerifySSL(false);

                if(!empty($proxy)){
                    $ig->setProxy($proxy);
                }

                if(!$login){
                    try {
                        
                        $loginResponse = $ig->login($username, $password);

                    } catch (\Exception $e) {

                        $this->checkpoint($e);
                        throw new \InvalidArgumentException(Instagram_Get_Message($e->getMessage()));


                    }
                }

                $this->ig = $ig;
            }
        }

        function login(){
            if(session($this->username."_twofa")){
                return $this->confirmTwoFactorLogin();
            }

            try {
                $loginResponse = $this->ig->login($this->username, $this->password);
                return $this->checkTwoFactorLogin($loginResponse);

            } catch (InstagramAPI\Exception\ChallengeRequiredException $e) {

                $apiPath = $e->getResponse()->getChallenge()->getApiPath();
                return $this->confirmSecurityCode($apiPath);
                //$this->sendSecurityCode($Instagram, $apiPath);

            } catch (InstagramAPI\Exception\CheckpointRequiredException $e) {

                return array(
                    "status" => "error",
                    "message" => lang("please_login_on_instagram_to_pass_checkpoint")
                );

            } catch (InstagramAPI\Exception\AccountDisabledException $e) {

                return array(
                    "status" => "error",
                    "message" => lang("your_account_has_been_disabled_for_violating_instagram_terms")
                );

            } catch (InstagramAPI\Exception\SentryBlockException $e) {
                return array(
                    "status" => "error",
                    "message" => lang("your_account_has_been_banned_from_instagram_api_for_spam_behaviour_or_otherwise_abusing")
                );

            } catch (InstagramAPI\Exception\IncorrectPasswordException $e) {

                return array(
                    "status" => "error",
                    "message" => lang("the_password_you_entered_is_incorrect_please_try_again")
                );

            } catch (InstagramAPI\Exception\InstagramException $e) {
                if ($e->hasResponse()) {

                    if($e->getResponse()->getMessage() == "consent_required"){
                        return array(
                            "status" => "error",
                            "message" => lang("Go to instagram.com login with this account and then try to add this account again")
                        );
                    }
                    
                    return array(
                        "status" => "error",
                        "message" => $e->getResponse()->getMessage()
                    );

                } else {
                    
                    $message = explode(":", $e->getMessage(), 2);
                    return array(
                        "status" => "error",
                        "message" => end($message)
                    );
                }

            } catch (\Exception $e) {

                return array(
                    "status" => "error",
                    "message" => lang("oops_something_went_wrong_please_try_again_later")
                );

            }
        }

        function confirmTwoFactorLogin(){
            $twoFactorIdentifier = session($this->username."_twofa");
            unset_session($this->username."_twofa");
            try {
                
                $this->ig->finishTwoFactorLogin($this->username, $this->password,  $twoFactorIdentifier, $this->verification_code);

                return array(
                    "status" => "success",
                    "message" => lang("login_successful")
                );

            } catch (InstagramAPI\Exception\ChallengeRequiredException $e) {

                $apiPath = $e->getResponse()->getChallenge()->getApiPath();
                return $this->confirmSecurityCode($apiPath);
                //$this->sendSecurityCode($Instagram, $apiPath);

            } catch (InstagramAPI\Exception\CheckpointRequiredException $e) {

                return array(
                    "status" => "error",
                    "message" => lang("please_login_on_instagram_to_pass_checkpoint")
                );

            } catch (InstagramAPI\Exception\AccountDisabledException $e) {

                return array(
                    "status" => "error",
                    "message" => lang("your_account_has_been_disabled_for_violating_instagram_terms")
                );

            } catch (InstagramAPI\Exception\SentryBlockException $e) {

                return array(
                    "status" => "error",
                    "message" => lang("your_account_has_been_banned_from_instagram_api_for_spam_behaviour_or_otherwise_abusing")
                );

            } catch (InstagramAPI\Exception\IncorrectPasswordException $e) {

                return array(
                    "status" => "error",
                    "message" => lang("the_password_you_entered_is_incorrect_please_try_again")
                );

            } catch (InstagramAPI\Exception\InstagramException $e) {

                if ($e->hasResponse()) {

                    if($e->getResponse()->getMessage() == "consent_required"){
                        return array(
                            "status" => "error",
                            "message" => lang("Go to instagram.com login with this account and then try to add this account again")
                        );
                    }
                    
                    return array(
                        "status" => "error",
                        "message" => $e->getResponse()->getMessage()
                    );

                } else {

                    $message = explode(":", $e->getMessage(), 2);
                    return array(
                        "status" => "error",
                        "message" => end($message)
                    );
                }

            } catch (\Exception $e) {

                return array(
                    "status" => "error",
                    "message" => lang("oops_something_went_wrong_please_try_again_later")
                );

            }
        }

        function checkTwoFactorLogin($loginResponse){
            if (!is_null($loginResponse) && $loginResponse->isTwoFactorRequired()) {

                $phone_number = $loginResponse->getTwoFactorInfo()->getObfuscatedPhoneNumber();
                $twoFactorIdentifier = $loginResponse->getTwoFactorInfo()->getTwoFactorIdentifier();
                set_session($this->username."_twofa", $twoFactorIdentifier);
                
                return array(
                    "status"   => "error",
                    "callback" => '<script type="text/javascript">Instagram.TwoFactorLogin();</script>',
                    "message"  => lang("enter_the_6_digit_code_we_sent_to_the_number_ending_in")." ".$phone_number
                );  

            }

            return array(
                "status" => "success",
                "message" => lang("login_successful")
            );
        }

        function sendSecurityCode($apiPath){
            try {
                $sendSecurityCode = $this->ig->checkpoint->sendSecurityCode($apiPath, $this->choice);

                if(empty($sendSecurityCode) || is_null($sendSecurityCode)){
                    return array(
                        "status" => "error",
                        "message" => lang("could_not_send_verification_code_please_try_again_later")
                    );
                }

                if(isset($sendSecurityCode->message) && strpos($sendSecurityCode->message, "is not one of the available choices") !== false){
                    $new_choice = $this->choice==1?0:1;
                    $sendSecurityCode = $this->ig->checkpoint->sendSecurityCode($apiPath, $new_choice);
                }

                if($sendSecurityCode->status != "ok"){
                    if($sendSecurityCode->message == "This field is required."){
                        return $this->resendSecurityCode($apiPath);
                    }

                    return array(
                        "status" => "error",
                        "message" => lang("could_not_send_verification_code_please_try_again_later")
                    );
                }

                if($sendSecurityCode->step_name == "verify_email"){
                    return array(
                        "status" => "error",
                        "message" => lang("enter_the_6_digit_code_we_sent_to_the_email_address")." ".$sendSecurityCode->step_data->contact_point,
                        "callback" => '<script type="text/javascript">Instagram.ChallengeRequired();</script>'
                    );
                }else{
                    return array(
                        "status" => "error",
                        "message" => lang("enter_the_6_digit_code_we_sent_to_the_number_ending_in")." ".$sendSecurityCode->step_data->contact_point,
                        "callback" => '<script type="text/javascript">Instagram.ChallengeRequired();</script>'
                    );
                }

            } catch (InvalidArgumentException $e) {

                return array(
                    "status" => "error",
                    "message" => $e->getMessage()
                );

            }
        }

        function confirmSecurityCode($apiPath){
            try {

                $confirmSecurityCode = $this->ig->checkpoint->confirmSecurityCode($this->username, $this->password, $apiPath, $this->security_code);
                return $this->checkTwoFactorLogin($confirmSecurityCode);

            } catch (InvalidArgumentException $e) {

                return array(
                    "status" => "error",
                    "message" => $e->getMessage()
                );

            } catch (Exception $e) {
                    
                if(empty($e)){
                    return array(
                        "status" => "error",
                        "message" => lang("could_not_verification_code_please_try_again_later")
                    );
                }

                $response = $e->getResponse();
                if($response->getStatus() != "ok"){
                    try {
                        if($response->getMessage() == "This field is required."){
                            return $this->sendSecurityCode($apiPath);
                        }

                        return $this->resendSecurityCode($apiPath);
                    } catch (Exception $e) {
                        
                        return array(
                            "status" => "error",
                            "message" => $e->getMessage()
                        );

                    }
                }
            }
        }

        function resendSecurityCode($apiPath){
            try {
                $resendSecurityCode = $this->ig->checkpoint->resendSecurityCode($this->username, $apiPath, $this->choice);
                
                if(empty($resendSecurityCode) || is_null($resendSecurityCode)){
                    return array(
                        "status" => "error",
                        "message" => lang("could_not_send_verification_code_please_try_again_later")
                    );
                }

                if(isset($resendSecurityCode->message) && strpos($resendSecurityCode->message, "is not one of the available choices") !== false){
                    $new_choice = $this->choice==1?0:1;
                    $resendSecurityCode = $this->ig->checkpoint->resendSecurityCode($this->username, $apiPath, $new_choice);
                }

                if($resendSecurityCode->status != "ok"){
                    return array(
                        "status" => "error",
                        "message" => lang("could_not_send_verification_code_please_try_again_later")
                    );
                }

                if($resendSecurityCode->step_name == "verify_email"){
                    return array(
                        "status" => "error",
                        "message" => lang("enter_the_6_digit_code_we_sent_to_the_email_address")." ".$resendSecurityCode->step_data->contact_point,
                        "callback" => '<script type="text/javascript">Instagram.ChallengeRequired();</script>'
                    );
                }else{
                    return array(
                        "status" => "error",
                        "message" => lang("enter_the_6_digit_code_we_sent_to_the_number_ending_in")." ".$resendSecurityCode->step_data->contact_point,
                        "callback" => '<script type="text/javascript">Instagram.ChallengeRequired();</script>'
                    );
                }
            } catch (Exception $e) {
                return array(
                    "status" => "error",
                    "message" => $e->getMessage()
                );
            }
        }

        function checkpoint($e){
            $challenge_type = Instagram_Get_Message($e->getMessage());

            if($challenge_type == "challenge_required" 
                || $challenge_type == "login_required" 
                || $challenge_type == "checkpoint_required" 
                || strpos($challenge_type, "The password you entered is incorrect") !== false
                || strpos($challenge_type, "Challenge required") !== false){
                $CI = &get_instance();
                $CI->db->update("instagram_accounts", array("status" => 0), "username = '{$this->username}'");
                $CI->db->delete('instagram_sessions', "username = '{$this->username}'");
            }
        }

        function get_current_user(){
            try {
                $user = $this->ig->account->getCurrentUser();
                return json_decode($user);
            } catch (\Exception $e) {
                $this->checkpoint($e);
                ms(array(
                    "status"  => "error",
                    "message" => Instagram_Get_Message($e->getMessage())
                ));
            }   
        }

        function post($data){
            $spintax  = new Spintax();
            $data     = (object)$data;
            $response = array();
            $tmp_img  = array();
            try {
                $data->data = (object)json_decode($data->data);
                $media      = $data->data->media;
                $caption    = @$spintax->process(Instagram_Caption($data->data->caption));
                $comment    = @$spintax->process(Instagram_Caption($data->data->comment));
                $params     = array("caption" => $caption);

                // Location
                $location = "";
                if (isset($data->data->location) && $data->data->location != "") {
                    $location = @unserialize($data->data->location);
                    
                    if (!$location || !($location instanceof \InstagramAPI\Response\Model\Location)) {
                        $location = "";
                    }
                }

                switch ($data->type) {
                    case 'photo':
                        if($location != ""){
                            $params['location'] = $location;
                        }

                        if(check_image($media[0])){

                            //Auto Resize
                            $media[0] = $this->instagram_image_handlers($media[0], "photo", $data->uid);
                            $tmp_img[]= $media[0];
                            $response = $this->ig->timeline->uploadPhoto(get_path_file($media[0]), $params);
                            $response = json_decode($response);
                        }else{
                            if(!isInstagramPostVideo()){
                                return array(
                                    "status"  => "error",
                                    "message" => lang("The system does not support video posting")
                                );
                            }

                            $response = $this->ig->timeline->uploadVideo(get_path_file($media[0]), $params);
                            $response = json_decode($response);
                        }

                        if(!empty($caption) && empty($response->media->caption)){
                            sleep(5);
                            try {
                                $this->ig->media->edit($response->media->id, $caption);
                            } catch (Exception $e) {
                                
                            }
                        }
                        
                        //Add first comment
                        if($comment != ""){
                            $this->ig->media->comment($response->media->pk, $comment);
                        }
                        break;

                    case 'story':
                        if(isset($data->data->url) && $data->data->url != ""){
                            $params['link'] = $data->data->url;
                        }

                        if(check_image($media[0])){

                            //Auto Resize
                            $media[0] = $this->instagram_image_handlers($media[0], "story", $data->uid);
                            $tmp_img[]= $media[0];
                            if(isset($data->data->story_friends) && $data->data->story_friends){
                                $response = $this->ig->story->uploadCloseFriendsPhoto(get_path_file($media[0]), $params);
                            } else {
                                $response = $this->ig->story->uploadPhoto(get_path_file($media[0]), $params);
                            }
                            $response = json_decode($response);
                        }else{
                            if(!isInstagramPostVideo()){
                                return array(
                                    "status"  => "error",
                                    "message" => lang("The system does not support video posting")
                                );
                            }

                            if(isset($data->data->story_friends) && $data->data->story_friends){
                                $response = $this->ig->story->uploadCloseFriendsVideo(get_path_file($media[0]), $params);
                            } else {
                                $response = $this->ig->story->uploadVideo(get_path_file($media[0]), $params);
                            }
                            $response = json_decode($response);
                        }

                        if(!empty($caption) && empty($response->media->caption)){
                            sleep(5);
                            try {
                                $this->ig->media->edit($response->media->id, $caption);
                            } catch (Exception $e) {
                                
                            }
                        }

                        //Add first comment
                        if($comment != ""){
                            $this->ig->media->comment($response->media->pk, $comment);
                        }
                        break;

                    case 'carousel':
                        $medias = array();
                        $media = array_chunk($media , 10);
                        
                        if($location){
                            $params['location'] = $location;
                        }

                        foreach ($media[0] as $item) {
                            $image_info = get_image_size(get_path_file($item));
                            if(!empty($image_info)){

                                //Auto Resize
                                $item = $this->instagram_image_handlers($item, "carousel", $data->uid);
                                $tmp_img[] = $item;
                                $medias[] = array(
                                    'type' => 'photo',
                                    'file' => get_path_file($item)
                                );
                            }else{
                                $file_info = get_file_info($item);
                                if(!empty($file_info) && isset($file_info['extension']) && isset($file_info['extension']) == "mp4"){
                                    if(!isInstagramPostVideo()){
                                        return array(
                                            "status"  => "error",
                                            "message" => lang("The system does not support video posting")
                                        );
                                    }

                                    $medias[] = array(
                                        'type' => 'video',
                                        'file' => get_path_file($item)
                                    );
                                }
                            }
                        }

                        $response = $this->ig->timeline->uploadAlbum($medias, $params);
                        $response = json_decode($response);

                        if(!empty($caption) && empty($response->media->caption)){
                            sleep(5);
                            try {
                                $this->ig->media->edit($response->media->id, $caption);
                            } catch (Exception $e) {
                                
                            }
                        }

                        //Add first comment
                        if($comment != ""){
                            $this->ig->media->comment($response->media->pk, $comment);
                        }
                        break;
                }

                //Delete Image Temp
                if(!empty($tmp_img)){
                    foreach ($tmp_img as $img) {
                        @unlink(get_path_file($img));
                    }
                }

                return $response->media;

            } catch (Exception $e) {

                $this->checkpoint($e);

                //Delete Image Temp
                if(!empty($tmp_img)){
                    foreach ($tmp_img as $img) {
                        @unlink(get_path_file($img));
                    }
                }

                return array(
                    "status"  => "error",
                    "message" => Instagram_Get_Message($e->getMessage())
                );
            }
        }

        function instagram_image_handlers($file_path, $type, $uid = 0){
            $file_path = get_path_file($file_path);

            if(get_option('enable_ig_optimize_option', 0)==1){
                include_once(APPPATH.'libraries/ImgCompressor.class.php');
                // setting
                $setting = array('directory' => './assets/tmp');
                if(file_exists($file_path)){
                    $ImgCompressor = new ImgCompressor($setting);
                    $result = $ImgCompressor->run($file_path, 'jpg', 4); 
                    $file_path = $result;
                }
            }
            
            switch ($type) {
                case 'photo':
                    $img = new \InstagramAPI\Media\Photo\InstagramPhoto($file_path, [
                        "targetFeed" => \InstagramAPI\Constants::FEED_TIMELINE,
                        "operation" => \InstagramAPI\Media\InstagramMedia::CROP
                    ]);
                    break;

                case 'story':
                    $img = new \InstagramAPI\Media\Photo\InstagramPhoto($file_path, [
                        "targetFeed" => \InstagramAPI\Constants::FEED_STORY,
                        "operation" => \InstagramAPI\Media\InstagramMedia::CROP
                    ]);
                    break;

                case 'carousel':
                    $img = new \InstagramAPI\Media\Photo\InstagramPhoto($file_path, [
                        "targetFeed" => \InstagramAPI\Constants::FEED_TIMELINE_ALBUM,
                        "operation" => \InstagramAPI\Media\InstagramMedia::CROP,
                        //"minAspectRatio" => 1.0,
                        //"maxAspectRatio" => 1.0
                    ]);
                    break;
            }

            $img_tmp = APPPATH."../assets/tmp/".ids().".jpg";
            $img_data = file_get_contents($img->getFile());
            file_put_contents($img_tmp, $img_data);
            @unlink($result);
                
            $new_image_path = Watermark($img_tmp, $img_tmp, $uid);
            $img = $new_image_path;

            return $img;
        }

        function search_media($keyword, $type){
            try {
                switch ($type) {
                    case 'username':
                        $id = $this->ig->people->getUserIdForName($keyword);
                        $response = $this->ig->timeline->getUserFeed($id, $this->rankToken());
                        $response = json_decode($response);
                        return $response;
                        break;
                    
                    default:
                        $response = $this->ig->hashtag->getFeed($keyword, $this->rankToken());
                        $response = json_decode($response);
                        return $response;
                        break;
                }
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function search_tag($keyword){
            try {
                $response = $this->ig->hashtag->search($keyword, array(), $this->rankToken());
                $response = json_decode($response);
                if(isset($response->results) && !empty($response->results)){
                    return $response->results;
                }
                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function search_username($keyword){
            try {
                $response = $this->ig->people->search($keyword, array(), $this->rankToken());
                $response = json_decode($response);
                if(isset($response->users) && !empty($response->users)){
                    return $response->users;
                }
                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function search_locations($keyword){
            try {
                $response = $this->ig->location->search("37.2759932","-104.6515434", $keyword);
                if ($response->isOk()) {
                    return $response->getVenues();
                }
                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function search_location($keyword){
            try {
                $response = $this->ig->location->findPlaces($keyword, array(), $this->rankToken());
                $response = json_decode($response);
                if(isset($response->items) && !empty($response->items)){
                    return $response->items;
                }
                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function get_followers($getAll = false, $userId = null, $maxId = null, $maxCount = 1000){
            if($userId == "") $userId = $this->ig->account_id;
            try {
                if($getAll){
                    $users = array();
                    do {
                        $response = $this->ig->people->getFollowers($userId, $this->rankToken(), array(), $maxId);
                        $response = json_decode($response); 
                        $users = array_merge($users, $response->users);
                    } while (isset($response->next_max_id) && !is_null($maxId = $response->next_max_id) && $maxCount > count($users));

                    return $users;
                }else{
                    $response = $this->ig->people->getFollowers($userId, $this->rankToken(), array(), $maxId);
                    $response = json_decode($response);
                    if(isset($response->users) && !empty($response->users)){
                        return $response->users;
                    }
                }
                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function get_following($getAll = false, $userId = null, $maxId = null, $maxCount = 1000){
            if($userId == "") $userId = $this->ig->account_id;
            try {
                if($getAll){
                    $users = array();
                    do {
                        $response = $this->ig->people->getFollowing($userId, $this->rankToken(), array(), $maxId);
                        $response = json_decode($response);
                        $users = array_merge($users, $response->users);
                    } while (isset($response->next_max_id) && !is_null($maxId = $response->next_max_id) && $maxCount > count($users));
                    return $users;
                }else{
                    $response = $this->ig->people->getFollowing($userId, $this->rankToken(), array(), $maxId);
                    $response = json_decode($response);
                    if(isset($response->users) && !empty($response->users)){
                        return $response->users;
                    }
                }
                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function get_feed($userId = null, $maxId = null, $full = false, $maxCount = 80){
            if($userId == "") $userId = $this->ig->account_id;
            try {

                if($full){
                
                    $response = $this->ig->timeline->getUserFeed($userId, $maxId);
                    $response = json_decode($response);
                    return $response;
                
                }else{

                    $feed = array();
                    do {
                        $response = $this->ig->timeline->getUserFeed($userId, $maxId);
                        $response = json_decode($response);
                        $feed = array_merge($feed, $response->items);
                    } while (isset($response->next_max_id) && !is_null($maxId = $response->next_max_id) && $maxCount > count($feed));
                    return $feed;
                }

                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function get_feed_by_tag($tag, $maxId = null, $maxCount = 50){
            try {
                $items = array();
                do {
                    $response = $this->ig->hashtag->getFeed($tag, $this->rankToken(), $maxId);
                    $response = json_decode($response);
                    
                    if(isset($response->ranked_items)){
                        $items = array_merge($items, $response->ranked_items);
                    }else if(isset($response->items)){
                        $items = array_merge($items, $response->items);
                    }

                } while (isset($response->next_max_id) && !is_null($maxId = $response->next_max_id) && $maxCount > count($items));

                return $items;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function get_feed_by_location($tag, $maxId = null, $maxCount = 80){
            try {
                $items = array();
                do {
                    $response = $this->ig->location->getFeed($tag, $this->rankToken(), "ranked", null, null, $maxId);
                    $response = json_decode($response);
                     foreach ($response->sections as $row) {
                        $medias = $row->layout_content->medias;
                        foreach ($medias as $media) {
                            $items[] = $media->media;
                        }
                    }

                } while (isset($response->next_max_id) && !is_null($maxId = $response->next_max_id) && $maxCount > count($items));
                return $items;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function get_comments($mediaId, $maxId = null, $expect_me = true, $maxCount = 80){
            try {
                $comments = array();
                do {
                    $response = $this->ig->media->getComments($mediaId, array("maxId" => $maxId));
                    $response = json_decode($response);

                    if(isset($response->comments) && !empty($response->comments)){
                        $comments = array_merge($comments, $response->comments);
                    }
                } while (isset($response->next_min_id) && !is_null($maxId = $response->next_min_id) && $maxCount > count($comments));

                if(!empty($comments)){
                    if($expect_me){
                        $comments_tmp = array();

                        foreach ($comments as $value) {
                            if($value->user_id != $this->ig->account_id){
                                $comments_tmp[] = $value;
                            }
                        }

                        return $comments_tmp;
                    }else{
                        return $comments;
                    }
                }else{
                    return false;
                }
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function get_likers($mediaId, $expect_me = true){
            try {
                $response = $this->ig->media->getLikers($mediaId);
                $response = json_decode($response);
                if(isset($response->users) && !empty($response->users)){
                    $users = $response->users;
                    if($expect_me){

                        $users_tmp = array();

                        foreach ($users as $value) {
                            if($value->pk != $this->ig->account_id){
                                $users_tmp[] = $value;
                            }
                        }

                        return $users_tmp;

                    }else{
                        return $users;
                    }

                    
                }
                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function get_userinfo($userId = null){
            if($userId == "") $userId = $this->ig->account_id;
            try {
                $response = $this->ig->people->getInfoById($userId);
                $response = json_decode($response);
                if(isset($response->user) && !empty($response->user)){
                    return $response->user;
                }
                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function get_friendships($userIds){
            try {
                $response = $this->ig->people->getFriendships($userIds);
                $response = json_decode($response);
                if(isset($response->friendship_statuses) && !empty($response->friendship_statuses)){
                    return $response->friendship_statuses;
                }
                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function get_friendship($userId){
            try {
                $response = $this->ig->people->getFriendship($userId);
                $response = json_decode($response);
                if(isset($response->status) && $response->status == "ok"){
                    return $response;
                }
                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function get_recent_activity_inbox(){
            try {
                $response = $this->ig->people->getRecentActivityInbox();
                $response = json_decode($response);
                if(isset($response->status) && $response->status == "ok"){
                    $stories = array_merge($response->new_stories, $response->old_stories);
                    $stories = array_reverse($stories);
                    return $stories;
                }
                return false;
            } catch (Exception $e) {
                $this->checkpoint($e);
                return false;
            }
        }

        function comment($mediaId, $comment){
            try {
                $spintax  = new Spintax();
                $comment = (object)$comment;
                if(is_object($comment)){
                    if(isset($comment->dont_spam)){
                        unset($comment->dont_spam);
                    }

                    $comment = array_values((array)$comment);
                    $comment = get_random_value($comment);
                }

                $comment = @$spintax->process($comment);
                $response = $this->ig->media->comment($mediaId, $comment);
                $response = json_decode($response);
                return $response;
            } catch (Exception $e) {
                $response = json_decode($e->getResponse());
                $this->checkpoint($e);
                return $response;
            }
        }

        function like($mediaId){
            try {
                $response = $this->ig->media->like($mediaId, 0);
                $response = json_decode($response);
                return $response;
            } catch (Exception $e) {
                $response = json_decode($e->getResponse());
                $this->checkpoint($e);
                return $response;
            }
        }

        function follow($userId){
            try {
                $response = $this->ig->people->follow($userId);
                $response = json_decode($response);
                return $response;
            } catch (Exception $e) {
                $response = json_decode($e->getResponse());
                $this->checkpoint($e);
                return $response;
            }
        }

        function unfollow($userId){
            try {
                $response = $this->ig->people->unfollow($userId);
                $response = json_decode($response);
                return $response;
            } catch (Exception $e) {
                $response = json_decode($e->getResponse());
                $this->checkpoint($e);
                return $response;
            }
        }

        function delete_media($mediaId){
            try {
                $response = $this->ig->media->delete($mediaId);
                $response = json_decode($response);
                return $response;
            } catch (Exception $e) {
                $response = json_decode($e->getResponse());
                $this->checkpoint($e);
                return $response;
            }
        }

        function direct_message($userId, $message = null, $type = null, $file = null, $mediaId = null){
            try {
                $temp_userid = $userId;
                if(is_string($userId)){
                    $userId = array('users' => array($userId));
                }

                $message = (array)$message;
                $spintax  = new Spintax();

                if(is_array($message)){
                    if(isset($message['by'])){
                        unset($message['by']);
                    }

                    $message = array_values((array)$message);
                    $message = get_random_value($message);
                }

                $message = str_replace("{{break}}", "\n\n", $message);
                if(strpos($message, "{{username}}") !== false || strpos($message, "{{full_name}}") !== false){
                    $userinfo = $this->ig->people->getInfoById($temp_userid);
                    $userinfo = json_decode($userinfo);
                    if(!empty($userinfo) && $userinfo->status = "ok"){
                        $message = str_replace("{{username}}", "@".$userinfo->user->username, $message);
                        if($userinfo->user->full_name != ""){
                            $message = str_replace("{{full_name}}", $userinfo->user->full_name, $message);
                        }else{
                            $message = str_replace("{{full_name}}", "@".$userinfo->user->username, $message);
                        }
                    }
                }

                $message = @$spintax->process($message);

                switch ($type) {
                    case 'post':
                        $response = $this->ig->direct->sendPost($userId, $mediaId);
                        break;

                    case 'photo':
                        $response = $this->ig->direct->sendPhoto($userId, $file);
                        break;
                    
                    default:
                        $response = $this->ig->direct->sendText($userId, $message);
                        break;
                }
                
                $response = json_decode($response);
                return $response;
            } catch (Exception $e) {
                $response = $e->getMessage();
                $this->checkpoint($e);
                return $response;
            }
        }

        function get_random_feed($userId = null, $filter = ""){
            $feeds = $this->get_feed($userId);
                   
            if(!empty($feeds)){
                if($filter != ""){
                    $feeds_tmp = array();
                    foreach ($feeds as $key => $feed) {
                        if(isset($feed->$filter) && $feed->$filter != 0){
                            $feeds_tmp[] = $feed;
                        }
                    }

                    $feeds = $feeds_tmp;
                    return get_random_value($feeds);
                }

                return get_random_value($feeds);
            }

            return false;
        }

        function rankToken(){
            $rankToken = \InstagramAPI\Signatures::generateUUID();
            return  $rankToken;
        }
    }

}