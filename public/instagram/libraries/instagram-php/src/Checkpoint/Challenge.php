<?php

namespace InstagramAPI\Checkpoint;

use InstagramAPI\Response;

class Challenge
{   
    protected $_parent;

    public function __construct($parent){
        $this->_parent = $parent;
    }

    public function sendSecurityCode(
        $apiPath, 
        $choice
    ) {
        if (!is_string($apiPath) || !$apiPath) {
            throw new \InvalidArgumentException('You must provide a valid api path to sendSecurityCode().');
        }

        $apiPath = ltrim($apiPath, "/");
        $response = $this->_parent->request($apiPath)
            ->setNeedsAuth(false)
            ->addPost('choice', $choice)
            ->getDecodedResponse(true);   

        if(is_array($response)){
            $response = json_decode( json_encode($response) );
        }

        return $response;
    }

    public function resendSecurityCode(
        $username,
        $apiPath, 
        $choice
    ) {
        if (!is_string($apiPath) || !$apiPath) {
            throw new \InvalidArgumentException('You must provide a valid api path to resendSecurityCode().');
        }

        preg_match("/^\/challenge\/([0-9]+)\/([A-Za-z0-9]+)(\/)?/", $apiPath, $matches);
        $apiResendPath = "challenge/replay/" . $matches[1] . "/" . $matches[2] . "/";
        $this->_parent->_setUserWithoutPassword($username);

        $response = $this->_parent->request($apiResendPath)
            ->setNeedsAuth(false)
            ->addPost('choice', $choice)
            ->getDecodedResponse(true);

        if(is_array($response)){
            $response = json_decode( json_encode($response) );
        }

        return $response;
    }

    public function confirmSecurityCode(
        $username, 
        $password,
        $apiPath, 
        $securityCode, 
        $appRefreshInterval = 1800
    ) {
        if (empty($username) || empty($password)) {
            throw new \InvalidArgumentException('You must provide a username and password to confirmSecurityCode().');
        }

        if (empty($apiPath)) {
            throw new \InvalidArgumentException('You must provide a api path and security code to confirmSecurityCode().');
        }

        $securityCode = preg_replace('/\s+/', '', $securityCode);

        $this->_parent->_setUser($username, $password);
        $this->_parent->_sendPreLoginFlow();

        $apiPath = ltrim($apiPath, "/");

        $response = $this->_parent->request($apiPath)
            ->setNeedsAuth(false)
            ->addPost('security_code', $securityCode)
            ->getResponse(new Response\LoginResponse());

        if(!$response->getLoggedInUser()){
            throw new \InvalidArgumentException(lang("there_is_a_problem_with_your_account_please_try_again_later"));
        }

        $this->_parent->_updateLoginState($response);
        $this->_parent->_sendLoginFlow(true, $appRefreshInterval);

        return $response;

    }

}