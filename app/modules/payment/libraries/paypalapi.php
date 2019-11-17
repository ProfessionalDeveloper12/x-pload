<?php
require "paypal/autoload.php";

class paypalapi{
    private $ClientID;
    private $ClientSecret;
    private $apiContext;

    public function __construct($ClientID = null, $ClientSecret = null){
        if($ClientID != "" && $ClientSecret != ""){
            $this->apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential($ClientID, $ClientSecret)
            );

            if(get_option("payment_environment", 0)){
                $this->apiContext->setConfig(
                    array(
                        'mode' => 'live',
                    )
                );
            }
        }
    }

    public function createPayment($data = array()){
        if(!empty($data)){
            $data = (object)$data;
            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');
            $amount = new \PayPal\Api\Amount();
            $amount->setTotal($data->amount);
            $amount->setCurrency($data->currency);
            $transaction = new \PayPal\Api\Transaction();
            $transaction->setAmount($amount);
            $redirectUrls = new \PayPal\Api\RedirectUrls();
            $redirectUrls->setReturnUrl($data->redirect_url)
                ->setCancelUrl($data->cancel_url);
            $payment = new \PayPal\Api\Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

            try {
                $payment->create($this->apiContext);

                set_session("paypal_payment_id", $payment->getId());
                redirect($payment->getApprovalLink());
            }
            catch (\PayPal\Exception\PayPalConnectionException $ex) {
                redirect(cn('pricing'));
            }
        }
    }

    public function getPaymentDetails($PaymentId = ""){
        try {
            $payment = \PayPal\Api\Payment::get($PaymentId, $this->apiContext);
        } catch (Exception $ex) {
            redirect(cn('pricing'));
        }

        return $payment;
    }

    public function proccessPayment($PaymentId, $PayerId = ""){
        // Get payment object by passing paymentId
        $payment = $this->getPaymentDetails($PaymentId);

        // Execute payment with payer id
        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($PayerId);

        try {
            // Execute payment
            $result = $payment->execute($execution, $this->apiContext);

            // Extract order
            $order = $payment->transactions[0]->related_resources[0]->order;
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            $error_data = json_decode($ex->getData());
            redirect(cn('payment_unsuccessfully')."?message=".urlencode($error_data->message));
        } catch (Exception $ex) {
            redirect(cn('payment_unsuccessfully')."?message=".urlencode($ex->getMessage()));
            die($ex);
        }

        return $order;
    }

    public function createRecurringPayment( $data = array() ){

        if(!empty($data)){



            $data = (object)$data;
            
            $days = '30';
            if($data->plan == 2){
                $days = '365';
            }


            $plan = new \PayPal\Api\Plan();
            $plan->setName($data->plan_name)
                ->setDescription($data->plan_description)
                ->setType('FIXED');

            // Set billing plan definitions
            $paymentDefinition = new \PayPal\Api\PaymentDefinition();
            $paymentDefinition->setName('Regular Payments')
                ->setType('REGULAR')
                ->setFrequency('DAY')
                ->setFrequencyInterval('1')
                ->setCycles($days)
                ->setAmount(new \PayPal\Api\Currency(array(
                    'value' => $data->amount,
                    'currency' => $data->currency
                )
            ));

            // Set charge models
            /*$chargeModel = new \PayPal\Api\ChargeModel();
            $chargeModel->setType('SHIPPING')->setAmount(new \PayPal\Api\Currency(array(
                'value' => 199,
                'currency' => $data->currency
            )));

            $paymentDefinition->setChargeModels(array(
                $chargeModel
            ));*/

            // Set merchant preferences
            $merchantPreferences = new \PayPal\Api\MerchantPreferences();
            $merchantPreferences->setReturnUrl( current_url()."?status=success" )
                ->setCancelUrl( cn('payment_unsuccessfully' ) )
                ->setAutoBillAmount('yes')
                ->setInitialFailAmountAction('CONTINUE')
                ->setMaxFailAttempts('0')
                ->setSetupFee(new \PayPal\Api\Currency(array(
                    'value' => $data->amount,
                    'currency' => $data->currency
                )
            ));

            $plan->setPaymentDefinitions(array(
                $paymentDefinition
            ));

            $plan->setMerchantPreferences($merchantPreferences);

            try {

                //PROCESS
                $createdPlan = $plan->create($this->apiContext);
                
                try {
                    $patch = new \PayPal\Api\Patch();
                    $patch->setOp('replace')
                        ->setPath('/')
                        ->setValue( json_decode('{"state":"ACTIVE"}') );

                    $patchRequest = new \PayPal\Api\PatchRequest();
                    $patchRequest->addPatch($patch);
                    $createdPlan->update($patchRequest, $this->apiContext);
                    $patchedPlan = \PayPal\Api\Plan::get($createdPlan->getId(), $this->apiContext);
                    
                    
                    // Create new agreement
                    $startDate = date('c', time() + 3600);
                    $agreement = new \PayPal\Api\Agreement();
                    $agreement->setName(lang('Subscription Agreement'))
                        ->setDescription( lang('Please check our terms of services before submit payment') )
                        ->setStartDate($startDate);

                    // Set plan id
                    $plan = new \PayPal\Api\Plan();
                    $plan->setId($patchedPlan->getId());
                    $agreement->setPlan($plan);

                    // Add payer type
                    $payer = new \PayPal\Api\Payer();
                    $payer->setPaymentMethod('paypal');
                    $agreement->setPayer($payer);

                    // Adding shipping details
                    /*$shippingAddress = new \PayPal\Api\ShippingAddress();
                    $shippingAddress->setLine1('111 First Street')
                        ->setCity('Saratoga')
                        ->setState('CA')
                        ->setPostalCode('95070')
                        ->setCountryCode('US');

                    $agreement->setShippingAddress($shippingAddress);*/

                    try {
                        // Create agreement
                        $agreement = $agreement->create($this->apiContext);
                        
                        // Extract approval URL to redirect user
                        $approvalUrl = $agreement->getApprovalLink();
                        
                        header("Location: " . $approvalUrl);
                        exit();
                    } catch (PayPal\Exception\PayPalConnectionException $ex) {
                        echo $ex->getCode();
                        echo $ex->getData();
                        die($ex);
                    } catch (Exception $ex) {
                        die($ex);
                    }
                    //END PROCESS

                } catch (PayPal\Exception\PayPalConnectionException $ex) {
                    echo $ex->getCode();
                    echo $ex->getData();
                    die($ex);
                } catch (Exception $ex) {
                    die($ex);
                }
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            } catch (Exception $ex) {
                die($ex);
            }

        }
    }

    public function getRecurringPayment( $token ){

        $agreement = new \PayPal\Api\Agreement();
        
        try {
            // Execute agreement
            $result = $agreement->execute($token, $this->apiContext);

            /*
            * Create Webhooks
            */            
            $webhook = new \PayPal\Api\Webhook();

            // Set webhook notification URL
            $webhook->setUrl( cn('payment/paypal/webhook') );

            // Set webhooks to subscribe to
            $webhookEventTypes = array();
            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
              '{
                "name":"PAYMENT.SALE.COMPLETED"
              }'
            );

            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
              '{
                "name":"PAYMENT.SALE.DENIED"
              }'
            );

            $webhook->setEventTypes($webhookEventTypes);

            try {
              $output = $webhook->create($this->apiContext);
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                
            } catch (Exception $ex) {
                
            }

            /*
            * End create Webhooks
            */  

            return $result;

        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }

    }

    public function deleteWebHook($agreementId){
        $agreement = new \PayPal\Api\Agreement();
        $agreement->setId($agreementId);
        $agreementStateDescriptor = new \PayPal\Api\AgreementStateDescriptor();
        $agreementStateDescriptor->setNote("Cancel the agreement");

        try {
            $agreement->cancel($agreementStateDescriptor, $this->apiContext);
            $cancelAgreementDetails = \PayPal\Api\Agreement::get($agreement->getId(), $this->apiContext); 
            return true;               
        } catch (Exception $ex) {
            return false;
        }
    }
}