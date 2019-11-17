<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class stripe extends MX_Controller {

	public $tb_packages;
	public $tb_payment_history;
	public $tb_users;

	public function __construct(){
		parent::__construct();
		$this->tb_packages = PACKAGES;
		$this->tb_payment_history = PAYMENT_HISTORY;
		$this->tb_users = USERS;
		$this->load->model(get_class($this).'_model', 'model');
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
			$this->load->view('stripe/stripe', $data);
		}
	}

	public function block_active(){
		$this->load->view("stripe/index");
	}

	public function block_settings(){
		$this->load->view("stripe/settings");
	}

	public function process(){
		if(ajax_page()){
			$token  = post('stripeToken');
			$ids  = post('ids');
			$plan  = post('plan');
			$payment_method = post('payment_method');
			$package = $this->model->get("*", $this->tb_packages, "ids = '".$ids."'  AND status = 1");
			$user = $this->model->get("*", $this->tb_users, "id = '".session("uid")."'");

			if(!empty($package) && !empty($user)){
				$this->load->library('stripeapi');

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
				}else{
					$plan = 1;
				}

				try {
					\Stripe\Stripe::setApiKey(get_option('stripe_secret_key'));

					$customer = \Stripe\Customer::create(array(
						'email' => $user->email,
						'description' => 'Payment date: '.NOW,
				  		'source'   => $token
					));

					$ids = ids();

					if($payment_method == 1){

						$result = \Stripe\Plan::create(array(
						    "amount" => $amount*100,
						    "interval" => ($plan == 2)?"year":"month",
						    "name" => $package->name,
						    "currency" => get_option('payment_currency','USD'),
						    "id" => $ids
						));

						// Subscribe the customer to the plan
						$result = \Stripe\Subscription::create(array(
						    "customer" => $customer->id,
						    "plan" => $ids
						));

						if($result->status == 'active'){

							//Delete Old Webhook
				        	$subscriptions = $this->model->fetch("billing_agreement_id", "general_payment_subscriptions", "type = 'stripe' AND uid = '".session("uid")."' ");
				        	if(!empty($subscriptions)){
				        		foreach ($subscriptions as $key => $subscription) {
									$sub = \Stripe\Subscription::retrieve( $subscription->billing_agreement_id );
									$sub->cancel();
				        			$this->db->delete("general_payment_subscriptions", array( "billing_agreement_id" => $subscription->billing_agreement_id));
				        		}
				        	}
				        	//End Delete Webhook

							$subscription = array(
								'ids' => ids(),
								'uid' => session("uid"),
								'package' => $package->id,
								'type' => 'stripe',
								'billing_agreement_id' => $result->id,
								'plan' => $plan,
								'status' => 1,
								'created' => NOW
							);

							$this->db->insert('general_payment_subscriptions', $subscription);
						}
					}else{
						$result = \Stripe\Charge::create(array(
							'customer' => $customer->id,
						  	'amount'   => $amount*100,
						  	'currency' => get_option('payment_currency','USD')
						));

						if($result->paid == 1){
							$data = array(
								'ids' => ids(),
								'uid' => session("uid"),
								'package' => $package->id,
								'type' => 'stripe_charge',
								'transaction_id' => $result->id,
								'amount' => $result->amount/100,
								'plan' => $plan,
								'status' => 1,
								'created' => NOW
							);
						}
						$this->db->insert($this->tb_payment_history, $data);
						$this->update_package($package, $plan);
					}

					redirect(cn('thank_you'));
				} catch (Exception $e) {
					redirect(cn('pricing'));
				}
			}else{
				redirect(cn('pricing'));
			}
		}
	}

	public function webhook(){
		$this->load->library('stripeapi');
		\Stripe\Stripe::setApiKey(get_option('stripe_secret_key'));

		$payload = @file_get_contents('php://input');
		$event = null;

		$data = json_decode($payload);

		if(is_object($data)){
			try {
			    $event = \Stripe\Event::retrieve($data->id);
			} catch(\UnexpectedValueException $e) {
			    // Invalid payload
			    http_response_code(400);
			    exit();
			}

			// Handle the event
			switch ($event->type) {
			    case 'payment_intent.succeeded':
			        $result = $event->data->object; // contains a \Stripe\PaymentIntent

					$customer = $result->customer;
					$subscription = $this->model->get("*", "general_payment_subscriptions", "", "id", "DESC");

					$id = $subscription->package;
					$plan = $subscription->plan;
					$paymentId = $result->id;

					$package = $this->model->get("*", $this->tb_packages, "id= '".$id."'  AND status = 1");
					if(!empty($package)){
						$data = array(
							'ids' => ids(),
							'uid' => $subscription->uid,
							'package' => $package->id,
							'type' => 'stripe_charge',
							'transaction_id' => $paymentId,
							'amount' => $result->amount/100,
							'plan' => $plan,
							'status' => 1,
							'created' => NOW
						);
						$this->db->insert($this->tb_payment_history, $data);
						$this->update_package($package, $plan, $subscription->uid);

						echo "true";
					}else{
						echo "false";
					}
			        break;
			    case 'payment_method.attached':
			        break;
			    default:
			        http_response_code(400);
			        exit();
			}

			http_response_code(200);
		}
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