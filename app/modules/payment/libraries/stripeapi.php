<?php
require "stripe/init.php";

class stripeapi{
    private $token;
    private $serect_key;

    public function __construct($token = null, $serect_key = null){
        return \Stripe\Stripe::setApiKey($serect_key);
    }
}