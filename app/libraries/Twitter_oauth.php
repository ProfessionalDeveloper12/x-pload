<?php
require "twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter_oauth{
    private $consumer_key;
    private $consumer_secret;
    private $oauth_token;
    private $oauth_token_secret;
    private $twitter;

    public function __construct($consumer_key = null, $consumer_secret = null, $oauth = false, $redirect_url = "auth/twitter"){
        $this->consumer_key = $consumer_key;
        $this->consumer_secret = $consumer_secret;

        if($oauth == true){
            $this->twitter = new TwitterOAuth($this->consumer_key, $this->consumer_secret);
            $oauth_token = (object)$this->twitter->oauth('oauth/request_token', ['oauth_callback' => cn($redirect_url)]);
            $this->oauth_token = $oauth_token->oauth_token;
            $this->oauth_token_secret = $oauth_token->oauth_token_secret;
        }

        if(session("twitter_oauth_token") && session("twitter_oauth_token_secret")){
            $this->oauth_token = session("twitter_oauth_token");
            $this->oauth_token_secret = session("twitter_oauth_token_secret");
        }

        if($this->oauth_token == null && $this->oauth_token_secret == null){
            $this->twitter = new TwitterOAuth($this->consumer_key, $this->consumer_secret);
        }else{
            $this->twitter = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $this->oauth_token, $this->oauth_token_secret);
        }
    }

	function login_url(){
		$url = $this->twitter->url("oauth/authorize", ["oauth_token" => $this->oauth_token]);
        set_session("twitter_oauth_token", $this->oauth_token);
        set_session("twitter_oauth_token_secret", $this->oauth_token_secret);
		return $url;
	}
    
    function get_access_token(){
        try {
            unset_session("twitter_oauth_token");
            unset_session("twitter_oauth_token_secret");
            $access_token = $this->twitter->oauth("oauth/access_token", ["oauth_verifier" => get("oauth_verifier")]);
            return $access_token;
        } catch (Exception $e) {
            redirect(cn("oauth/twitter_oauth"));
        }
	}

    function set_access_token($token){
        $token = json_decode($token);
        $this->twitter->setOauthToken($token->oauth_token, $token->oauth_token_secret);
    }

    function get_user_info(){
        return $this->twitter->get("account/verify_credentials", ["include_email" => 'true']);
    }
}