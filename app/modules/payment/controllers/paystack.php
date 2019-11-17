<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class paystack extends MX_Controller {

	public $tb_packages;
	public $tb_payment_history;
	public $tb_users;

	public function __construct(){
		parent::__construct();
		$this->tb_packages = PACKAGES;
		$this->tb_payment_history = PAYMENT_HISTORY;
		$this->tb_users = USERS;
		$this->load->model(get_class($this).'_model', 'model');
	    require APPPATH.'modules/payment/libraries/paystack/src/autoload.php';
	}

	public function index(){
		if(ajax_page()){
			$package = $this->model->get("*", $this->tb_packages, "ids = '".get_secure("pid")."'  AND status = 1");
			$user = $this->model->get("*", USERS, "id = '".session("uid")."'");
			if(empty($package)){
				$ms = lang('can_not_processing_this_gateway_please_try_again_later');
				echo $ms;
				exit(0);
			}

			set_session("paystack_ids", $package->ids);
			$data = array(
				'user' => $user,
				'package' => $package
			);
			$this->load->view('paystack/paystack', $data);
		}
	}

	public function block_active(){
		$this->load->view("paystack/index");
	}

	public function block_settings(){
		$this->load->view("paystack/settings");
	}

	public function process($reference = "",  $plan){

        if(get_option('paystack_secret_key', '') == "" || get_option('paystack_secret_key', '') == ""){
        	exit(0);
        }	

	    if($reference == ""){
	    	exit(0);
	    }

	    // initiate the Library's Paystack Object
	    $paystack = new Yabacon\Paystack(get_option('paystack_secret_key', ''));
	    try {
	      	//Verify using the library
	      	$tranx = $paystack->transaction->verify([
	      		'reference' => $reference, // unique to transactions
	      	]);

	    } catch(\Yabacon\Paystack\Exception\ApiException $e){
	    	
	    	ms(array(
	    		"status" => "error",
	    		"message" => $e->getMessage()
	    	));

	    }

	    if ('success' === $tranx->data->status) {
			
	    	$ids  = session("paystack_ids");
	    	$uid  = session("uid");
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

				if($amount == $tranx->data->amount){

					$data = array(
						'ids' => ids(),
						'uid' => $uid,
						'package' => $package->id,
						'type' => 'paystack_charge',
						'transaction_id' => $reference,
						'amount' => $tranx->data->amount,
						'plan' => $plan,
						'status' => 1,
						'created' => NOW
					);
					$this->db->insert($this->tb_payment_history, $data);
					$this->update_package($package, $plan, $uid);
					unset_session("paystack_ids");

					ms(array(
			    		"status" => "sucess"
			    	));
				}else{

					ms(array(
			    		"status" => "error",
			    		"message" => lang("An error has occurred. Please try again later")
			    	));

				}

				
			}
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
}