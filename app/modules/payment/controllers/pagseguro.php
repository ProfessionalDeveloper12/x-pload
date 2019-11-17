<?php
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
defined('BASEPATH') OR exit('No direct script access allowed');
 
class pagseguro extends MX_Controller {

	public $tb_packages;
	public $tb_payment_history;
	public $tb_users;

	public function __construct(){
		parent::__construct();
		$this->tb_packages = PACKAGES;
		$this->tb_payment_history = PAYMENT_HISTORY;
		$this->tb_users = USERS;
		$this->load->model(get_class($this).'_model', 'model');
		$this->load->library('Pagsegurolibrary/Pagsegurolibrary');
	}

	public function index(){
		if(ajax_page()){
			$package = $this->model->get("*", $this->tb_packages, "ids = '".get_secure("pid")."'  AND status = 1");
			if(empty($package)){
				$ms = lang('can_not_processing_this_gateway_please_try_again_later');
				echo $ms;
				exit(0);
			}
			$data = array(
				'package' => $package
			);
			$this->load->view('pagseguro/pagseguro', $data);
		}
	}

	public function block_active(){
		$this->load->view("pagseguro/index");
	}

	public function block_settings(){
		$this->load->view("pagseguro/settings");
	}

	public function complete(){
		if(isset($_POST['notificationCode']) && isset($_POST['notificationType'])){
			$code = (isset($_POST['notificationCode']) && trim($_POST['notificationCode']) !== "" ?
	            trim($_POST['notificationCode']) : null);
	        $type = (isset($_POST['notificationType']) && trim($_POST['notificationType']) !== "" ?
	            trim($_POST['notificationType']) : null);

	        if ($code && $type) {

	            $notificationType = new PagSeguroNotificationType($type);
	            $strType = $notificationType->getTypeFromValue();

	            switch ($strType) {

	                case 'TRANSACTION':
	                    $credentials = PagSeguroConfig::getAccountCredentials();

				        try {
				            $transaction = PagSeguroNotificationService::checkTransaction($credentials, $code);
				            $ids = $transaction->getItems()[0]->getId();
				            $reference = $transaction->getReference();
				            $uid = (int)str_replace("REF", "", $reference);
							$package = $this->model->get("*", $this->tb_packages, "ids = '".$ids."'  AND status = 1");
							
							$amount_monthly = $package->price_monthly;
							$amount_annually = $package->price_annually*12;
							$plan = 1;
							if($amount_annually == $transaction->getGrossAmount()){
								$plan = 2;
							}

							$paymentId = get('paymentId');
							$PayerID = get('PayerID');
							$transaction_id = $transaction->getCode();

							$checkPaid = $this->model->get("*", $this->tb_payment_history, "transaction_id = '".$transaction_id."'");

							if(!empty($package) && empty($checkPaid) && $transaction->getStatus()->getValue() == 3){
								$data = array(
									'ids' => ids(),
									'uid' => $uid,
									'package' => $package->id,
									'type' => 'pagseguro_charge',
									'transaction_id' => $transaction_id,
									'amount' => $transaction->getGrossAmount(),
									'plan' => $plan,
									'status' => 1,
									'created' => NOW
								);
								$this->db->insert($this->tb_payment_history, $data);
								$this->update_package($package, $plan, $uid);

								echo "Sucesss";
							}else{
								die("Invalid notification parameters. Please try to again.");
							}
				        } catch (PagSeguroServiceException $e) {
				            die($e->getMessage());
				        }
	                    break;

	                default:
	                    die("Invalid notification parameters. Please try to again.");

	            }
	        } else {
	            die("Invalid notification parameters. Please try to again.");
	        }
		}else{
			//redirect(cn("dashboard"));
		}
	}

    public function update_package($package_new, $plan, $uid){
		$user = $this->model->get("*", $this->tb_users, "id = '".$uid."'");
		if(!empty($user)){
			$package_old = $this->model->get("*", $this->tb_packages, "id = '".$user->package."'");
			$package_id = $package_new->id;

			$new_days  = 30;
			if($plan == 2){
				$new_days  = 365;
			}

			if(!empty($package_old)){
				if(strtotime(NOW) < strtotime($user->expiration_date)){
					$date_now = date("Y-m-d", strtotime(NOW));
					$date_expiration = date("Y-m-d", strtotime($user->expiration_date));
					$diff = abs(strtotime($date_expiration) - strtotime($date_now));
					$left_days = floor($diff/86400);
					if($plan == 2){
						$new_days  = 365;
						$day_added = round(($package_old->price_annually/$package_new->price_annually)*$left_days);
					}else{
						$new_days  = 30;
						$day_added = round(($package_old->price_monthly/$package_new->price_monthly)*$left_days);
					}

					$total_day = $new_days + $day_added;
					$expiration_date = date('Y-m-d', strtotime(NOW." +".$total_day." days"));
				}else{
					$expiration_date = date('Y-m-d', strtotime(NOW." +".$new_days." days"));
				}
			}else{
				$expiration_date = date('Y-m-d', strtotime(NOW." +".$new_days." days"));
			}

			$data = array(
				"package"      => $package_id,
				"expiration_date" => $expiration_date
			);

			$this->db->update($this->tb_users, $data, "id = '".$uid."'");
		}
	}

	public function process(){
		$ids  = segment(4);
		$plan  = segment(5);
		$package = $this->model->get("*", $this->tb_packages, "ids = '".$ids."'  AND status = 1");
		$user = $this->model->get("*", $this->tb_users, "id = '".session("uid")."' AND status = 1");

		if(!empty($package) && !empty($user)){

			$price_monthly = $package->price_monthly;
	        $price_annually = $package->price_annually;
			if(session("coupon")){
	            $coupon = (object)session("coupon");
	            $coupon_code = $coupon->code;
	            if(in_array((int)$package->id, $coupon->package)){
	                if($coupon->type == 1){
	                    $price_monthly = number_format($price_monthly - $coupon->price, 2);
	                    $price_annually = number_format($price_annually - $coupon->price, 2);
	                }else{
	                    $price_monthly = number_format($price_monthly*(100 - $coupon->price)/100, 1);
	                    $price_annually = number_format($price_annually*(100 - $coupon->price)/100, 2);
	                }
	            }

	        }

			$amount = $price_monthly;
			if($plan == 2){
				$amount = $price_annually*12;
			}

			// Instantiate a new payment request
	        $paymentRequest = new PagSeguroPaymentRequest();

	        // Set the currency
	        $paymentRequest->setCurrency("BRL");

	        // Add an item for this payment request
	        $paymentRequest->addItem($package->ids, $package->name, 1, number_format($amount,2));

	        // Set a reference code for this payment request. It is useful to identify this payment
	        // in future notifications.
	        $paymentRequest->setReference("REF".session("uid"));

	        // Set your customer information.
	        $paymentRequest->setSender(
	            $user->fullname." customer",
	            $user->email
	        );

	        // Set the url used by PagSeguro to redirect user after checkout process ends
	        $paymentRequest->setRedirectUrl(cn("payment/pagseguro/complete"));

	        // Another way to set checkout parameters
	        $paymentRequest->addParameter('notificationURL', cn("payment/pagseguro/complete"));
	        $paymentRequest->addIndexedParameter('itemId', $package->ids, 3);
	        $paymentRequest->addIndexedParameter('itemDescription', $package->name, 3);
	        $paymentRequest->addIndexedParameter('itemQuantity', '1', 3);
	        $paymentRequest->addIndexedParameter('itemAmount', number_format($amount,2), 3);

	        try {

	            /*
	             * #### Credentials #####
	             * Replace the parameters below with your credentials
	             * You can also get your credentials from a config file. See an example:
	             * $credentials = new PagSeguroAccountCredentials("vendedor@lojamodelo.com.br",
	             * "E231B2C9BCC8474DA2E260B6C8CF60D3");
	             */

	            // seller authentication
	            $credentials = PagSeguroConfig::getAccountCredentials();

	            // application authentication
	            //$credentials = PagSeguroConfig::getApplicationCredentials();

	            //$credentials->setAuthorizationCode("E231B2C9BCC8474DA2E260B6C8CF60D3");

	            // Register this payment request in PagSeguro to obtain the payment URL to redirect your customer.
	            $url = $paymentRequest->register($credentials);
	            redirect($url);
	        } catch (PagSeguroServiceException $e) {
	            die($e->getMessage());
	        }

		}
	}
}

/***
 * Provides for user a option to configure their credentials without changes in PagSeguroConfigWrapper.php file.
 */ 
class PagSeguroConfigWrapper
{
    public static function getConfig()
    {
        $PagSeguroConfig = array();

        $PagSeguroConfig['environment'] = get_option('payment_environment', 0)==0?"sandbox":"production"; // production, sandbox

        $PagSeguroConfig['credentials'] = array();
    	$PagSeguroConfig['credentials']['email'] = get_option('pagseguro_email', '');
        if(get_option('payment_environment', 0)==0){
        	$PagSeguroConfig['credentials']['token']['sandbox'] = get_option('pagseguro_token', '');
        }else{
        	$PagSeguroConfig['credentials']['token']['production'] = get_option('pagseguro_token', '');
        }

        $PagSeguroConfig['application'] = array();
        $PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

        $PagSeguroConfig['log'] = array();
        $PagSeguroConfig['log']['active'] = FALSE;
        // Informe o path completo (relativo ao path da lib) para o arquivo, ex.: ../PagSeguroLibrary/logs.txt
        $PagSeguroConfig['log']['fileLocation'] = "";

        return $PagSeguroConfig;
    }
}