<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class paypal extends MX_Controller {

	public $tb_packages;
	public $tb_payment_history;
	public $tb_users;
	public $pp;

	public function __construct(){
		parent::__construct();
		$this->tb_packages = PACKAGES;
		$this->tb_payment_history = PAYMENT_HISTORY;
		$this->tb_users = USERS;
		$this->load->model(get_class($this).'_model', 'model');
		$this->load->library('paypalapi');
		$this->pp = new PaypalAPI(get_option('paypal_client_id'), get_option('paypal_client_secret'));
	}

	public function index(){
		if(ajax_page()){
			$package = $this->model->get("*", PACKAGES, "ids = '".get_secure("pid")."'  AND status = 1");
			if(empty($package)){
				echo  "Cannot processing this getway, Please try again later.";
				exit(0);
			}
			$data = array(
				'package' => $package
			);
			$this->load->view('paypal/paypal', $data);
		}
	}

	public function block_active(){
		$this->load->view("paypal/index");
	}

	public function block_settings(){
		$this->load->view("paypal/settings");
	}

	public function process(){
		$ids  = segment(4);
		$plan  = segment(5);
		$package = $this->model->get("*", $this->tb_packages, "ids = '".$ids."'  AND status = 1");

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

		if(!empty($package)){
			$amount = $price_monthly;
			if($plan == 2){
				$amount = $price_annually*12;
			}else{
				$plan = 1;
			}

			set_session('paypal_package', $ids);
			set_session('paypal_plan', $plan);

			$this->pp->createPayment(array(
				"amount" => $amount,
				"currency" => get_option('payment_currency','USD'),
				"redirect_url" => cn("payment/paypal/complete"),
				"cancel_url" => cn("payment_unsuccessfully")
			));

		}

	}

	public function recurring_process(){

		if( get('status') == 'success' ){

	        $result = $this->pp->getRecurringPayment( get('token') );

	        if($result){
	        	$ids = session('paypal_package');
				$plan = session('paypal_plan');
	        	$package = $this->model->get("*", $this->tb_packages, "ids = '".$ids."'  AND status = 1");

	        	//Delete Old Webhook
	        	$subscriptions = $this->model->fetch("billing_agreement_id", "general_payment_subscriptions", " uid = '".session("uid")."' ");
	        	if(!empty($subscriptions)){
	        		foreach ($subscriptions as $key => $subscription) {
		        		$status = $this->pp->deleteWebHook($subscription->billing_agreement_id);
	        			$this->db->delete("general_payment_subscriptions", array( "billing_agreement_id" => $subscription->billing_agreement_id));
	        		}
	        	}
	        	//End Delete Webhook

	        	$data = array(
					'ids' => ids(),
					'uid' => session("uid"),
					'package' => $package->id,
					'type' => 'paypal',
					'billing_agreement_id' => $result->getId(),
					'plan' => $plan,
					'status' => 1,
					'created' => NOW
				);

				$this->db->insert('general_payment_subscriptions', $data);
				redirect(cn('thank_you'));
			}else{
				redirect(cn("payment_unsuccessfully"));
			}
		}else{
			
			$ids  = segment(4);
			$plan  = segment(5);
			$package = $this->model->get("*", $this->tb_packages, "ids = '".$ids."'  AND status = 1");

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

			if(!empty($package)){
				$amount = $price_monthly;
				if($plan == 2){
					$amount = $price_annually*12;
				}else{
					$plan = 1;
				}

				set_session('paypal_package', $ids);
				set_session('paypal_plan', $plan);

				$this->pp->createRecurringPayment(array(
					"plan" => $plan,
					"amount" => $amount,
					"plan_name" => $package->name,
					"plan_description" => $package->description,
					"currency" => get_option('payment_currency','USD'),
					"redirect_url" => cn("payment/paypal/complete"),
					"cancel_url" => cn("payment_unsuccessfully")
				));
			}

		}

	}

	public function webhook(){
		
		$bodyReceived = file_get_contents('php://input');
		$result = json_decode($bodyReceived);

		if(!empty($result) && $result->event_type == 'PAYMENT.SALE.COMPLETED'){

			$billing_agreement_id = $result->resource->billing_agreement_id;
			$subscription = $this->model->get("*", "general_payment_subscriptions", " billing_agreement_id = '".$billing_agreement_id."' ");

			$id = $subscription->package;
			$plan = $subscription->plan;
			$paymentId = $result->resource->id;

			$package = $this->model->get("*", $this->tb_packages, "id= '".$id."'  AND status = 1");

			if(!empty($package)){
				$data = array(
					'ids' => ids(),
					'uid' => $subscription->uid,
					'package' => $package->id,
					'type' => 'paypal_charge',
					'transaction_id' => $paymentId,
					'amount' => $result->resource->amount->total,
					'plan' => $plan,
					'status' => 1,
					'created' => NOW
				);
				$this->db->insert($this->tb_payment_history, $data);
				$this->update_package($package, $plan, $subscription->uid);

				return true;
			}else{
				return false;
			}

		}else{
			return false;
		}

	}

	public function complete(){
		$ids = session('paypal_package');
		$plan = session('paypal_plan');
		$paymentId = get('paymentId');
		$PayerID = get('PayerID');
		$order = $this->pp->proccessPayment($paymentId, $PayerID);
		$result = $this->pp->getPaymentDetails($paymentId);

		$package = $this->model->get("*", $this->tb_packages, "ids = '".$ids."'  AND status = 1");

		if(!empty($package) && !empty($result) && session("paypal_payment_id") == $paymentId && $result->state == "approved"){
			$data = array(
				'ids' => ids(),
				'uid' => session("uid"),
				'package' => $package->id,
				'type' => 'paypal_charge',
				'transaction_id' => $result->id,
				'amount' => $result->transactions[0]->amount->total,
				'plan' => $plan,
				'status' => 1,
				'created' => NOW
			);
			$this->db->insert($this->tb_payment_history, $data);
			$this->update_package($package, $plan);

			redirect(cn('thank_you'));
		}else{
			redirect(cn("payment_unsuccessfully"));
		}
	}

	public function cancel(){
		
	}

	public function update_package($package_new, $plan, $uid = ""){
		if($uid == ""){
			$uid = session("uid");
		}

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
						$day_added = round(($package_old->price_annually/$package_new->price_annually)*$left_days);
					}else{
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
}