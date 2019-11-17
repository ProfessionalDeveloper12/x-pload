<?php
require "Facebook/autoload.php";

class facebook_oauth{
    private $access_token;
    private $app_id;
    private $app_secret;
    private $app_version;
    private $fb;

    public function __construct($app_id = null, $app_secret = null, $app_version = "v2.11"){
        if($app_id != "" && $app_secret != ""){
            $this->app_id = $app_id;
            $this->app_secret = $app_secret;
            $this->app_version = $app_version;
        }else{
            $this->app_id = "NONE";
            $this->app_secret = "NONE";
            $this->app_version = "v2.11";
        }

        $fb = new \Facebook\Facebook([
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret,
            'default_graph_version' => $this->app_version,
        ]);

        $this->fb = $fb;
    }

    function create_login_url(){
        $helper = $this->fb->getRedirectLoginHelper();
        $permissions = array('email'); // optional
        $loginUrl = $helper->getLoginUrl(PATH.'auth/facebook', $permissions);
        return $loginUrl;
    }

    function get_access_token(){
        try {
            $helper = $this->fb->getRedirectLoginHelper();
            $access_token = $helper->getAccessToken(PATH.'auth/facebook');
            $access_token = $access_token->getValue();
            return $this->set_access_token($access_token);
        } catch (Exception $e) {
            redirect(PATH."auth/login");
        }
    }

    function set_access_token($access_token){
        $this->fb->setDefaultAccessToken($access_token);
        $this->access_token = $access_token;
    }

    function get_user_info(){
        return $this->get('/me?fields=name,id,email');
    }

    function get_app_info(){
        return $this->get('/app');
    }

    function get_access_token_page($pid){
        $response = $this->get('/'.$pid.'/?fields=access_token');
        if(is_object($response)){
            return $response->access_token;
        }else{
            return false;
        }
    }

    function get($params, $app_version = null){
        try {
            $response = $this->fb->get($params, null, null, $app_version);
            return json_decode($response->getBody()); 
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          return 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }


    function post($params, $data){
        try {
            $response = $this->fb->post($params, $data);
            return json_decode($response->getBody()); 
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          return 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }
}