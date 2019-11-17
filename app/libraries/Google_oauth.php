<?php
require "Google/autoload.php";

class google_oauth{
    private $ClientID;
    private $ClientSecret;
    private $client;
    private $redirect_url;
    private $access_token;

    public function __construct($client_id = null, $client_secret = null, $redirect_url = "auth/google"){
        $this->client = new Google_Client();
        $this->client->setAccessType("offline");
        $this->client->setApprovalPrompt("force");
        $this->client->setRedirectUri(cn($redirect_url));
        $this->client->setClientId($client_id);
        $this->client->setClientSecret($client_secret);
        $this->client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile'));
        $this->redirect_url = $redirect_url;
    }

    function create_login_url(){
        return $this->client->createAuthUrl();
    }

    function get_access_token(){
        try {
            if(get("code")){
                $this->client->authenticate(get("code"));
                $oauth2 = new Google_Service_Oauth2($this->client);
                $token = $this->client->getAccessToken();
                $this->access_token = $token;
                return $token;
            }else{
                redirect(cn($this->redirect_url));
            }
            
        } catch (Exception $e) {
            redirect(cn($this->redirect_url));
        }
    }

    function get_user_info(){
        try {
            $oauth2 = new Google_Service_Oauth2($this->client);
            $this->client->setAccessToken($this->access_token);
            $userinfo = $oauth2->userinfo->get();
            return $userinfo;
        } catch (Exception $e) {
            return false;
        }
    }
}