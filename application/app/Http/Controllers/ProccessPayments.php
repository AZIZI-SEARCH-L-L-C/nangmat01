<?php

namespace AziziSearchEngineStarter\Http\Controllers;

use Illuminate\Http\Request;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Address;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Order;
use Stripe\Customer;
use Stripe\SKU;
use Stripe\Product as stripeProduct;
use Stripe\PaymentIntent;

use AziziSearchEngineStarter\Billing;
use AziziSearchEngineStarter\AdsPackages;
use AziziSearchEngineStarter\Payments;

use Auth, Input, Validator, Redirect;

class ProccessPayments extends Controller
{
    private $_api_context;
	
    private $currency = 'USD';
	
	// general variables
    public function __construct() 
    {
		// setup PayPal api context
        $paypal_conf = config('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
		
		$stripe_secret_key = config('stripe.private');
		Stripe::setApiKey($stripe_secret_key);
    }
	
	public function billing()
    {
		$billing = Auth::user()->billing;
		
		if($billing){
			$name         = $billing->name;
			$addrLine1    = $billing->addrLine1;
			$addrLine2    = $billing->addrLine2;
			$country      = $billing->country;
			$zipCode      = $billing->zipCode;
			$city         = $billing->city;
			$state        = $billing->state;
			$email        = $billing->email;
			$phone        = $billing->phone;
		}else{
			$name         = Input::old('name');
			$addrLine1    = Input::old('addrLine1');
			$addrLine2    = Input::old('addrLine2');
			$country      = Input::old('country');
			$zipCode      = Input::old('zipCode');
			$city         = Input::old('city');
			$state        = Input::old('state');
			$email        = Input::old('email');
			$phone        = Input::old('phone');
		}
		
		$data = [
			'name'         => $name,
			'addrLine1'    => $addrLine1,
			'country'      => $country,
			'zipCode'      => $zipCode,
			'addrLine2'    => $addrLine2,
			'city'         => $city,
			'state'        => $state,
			'email'        => $email,
			'phone'        => $phone,
			'user'         => Auth::user(),
	    ];
		
		$data = array_merge($data, $this->commonData());
        return view('auth.profile.editBilling', $data);
    }
	
	public function postBilling()
    {
		$input = Input::only('name', 'addrLine1', 'zipCode', 'addrLine2', 'country', 'city', 'state', 'email');
		
		$validator = Validator::make($input, [
            'name' => 'required|max:128',
            'addrLine1' => 'required|max:64',
            'country' => 'required|max:64',
            'city' => 'required|max:64',
            'email' => 'required|max:64',
            'addrLine2' => 'required_if:country,RUS,JPN,CHN|max:64',
            'state' => 'required_if:country,ARG,AUS,BGR,CAN,CHN,CYP,EGY,FRA,IND,IDN,ITA,JPN,MYS,MEX,NLD,PAN,PHL,POL,ROU,RUS,SRB,SGP,ZAF,ESP,SWE,THA,TUR,TUR,USA|max:64',
            'zipCode' => 'required_if:country,ARG,AUS,BGR,CAN,CHN,CYP,EGY,FRA,IND,IDN,ITA,JPN,MYS,MEX,NLD,PAN,PHL,POL,ROU,RUS,SRB,SGP,ZAF,ESP,SWE,THA,TUR,TUR,USA|max:64',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.edit.billing')->withErrors($validator)->withInput();
        }
		
		$billing = Auth::user()->billing;
		
		if(!$billing){
			$billing = new Billing;
		}
		
		$billing->user_id       = Auth::user()->id;
		$billing->name          = Input::get('name');
		$billing->addrLine1     = Input::get('addrLine1');
		$billing->addrLine2     = Input::get('addrLine2');
		$billing->zipCode       = Input::get('zipCode');
		$billing->country       = Input::get('country');
		$billing->city          = Input::get('city');
		$billing->state         = Input::get('state');
		$billing->email         = Input::get('email');
		$billing->phone         = Input::get('phone');
			
		$billing->save();
		
		$this->sessionMessage('Billing info updated.', 'success');
		return $this->previous('profile.edit.billing');
    }
	
	public function checkout($id){
		
		$package = AdsPackages::where('id', $id)->first();
		$data = [
			'package' => $package,
	    ];
		
		$data = array_merge($data, $this->commonData());
        return view('pages.checkout', $data);
	}
	
	public function postNewCard(){
		$user = Auth::user();
		$billing = $user->billing;
		if(!$billing) {
			$this->sessionMessage('please fill your billing information', 'error');
			return $this->previous('profile.edit.billing');
		}
		// dd(Input::all());
		
		try{
			$customer = Customer::retrieve($user->bill_id);
		}catch(\Exception $e){
			try{
				$customer = Customer::create(array(
					"email"  => $billing->email,
					"source" => Input::get('token'),
				));
			}catch(\Exception $e){
				$this->sessionMessage($e->getMessage(), 'error');
				return $this->previous('ads.payments');
			}
			
			$user->bill_id = $customer->id;
			$user->save();
		}
		
		try{
			$card = $customer->sources->create(["source" => Input::get('token')]);
		}catch(\Exception $e){
			$this->sessionMessage($e->getMessage(), 'error');
			return $this->previous('ads.payments');
		}
		
		$this->sessionMessage($card->funding .' card added to your account', 'success');
		return $this->previous('ads.payments');
	}
	
	public function postPaymentsCard(){
        $settings = $this->getSettings();
		$user = Auth::user();
		$billing = $user->billing;
		if(!$billing) {
			$this->sessionMessage('please fill your billing information', 'error');
			return $this->previous('profile.edit.billing');
		}
		
		$input = Input::only('amount', 'card', 'customAmount');
		$validator = Validator::make($input, [
			'amount' => 'required',
			'card' => 'required',
			'customAmount' => 'required_if:amount,custom|numeric|min:'.$settings['min_payment'].'|max:'.$settings['max_payment'],
		]);
		
		if ($validator->fails()) {
			return redirect()->route('ads.payments')->withErrors($validator)->withInput();
		}
		
		// set amount from packages amount or custom amount
		$amount = $input['amount'];
		if($input['amount'] == 'custom'){
			$amount = $input['customAmount'];
		}
		
		try{
			$customer = Customer::retrieve($user->bill_id);
			$customer->default_source = $input['card'];
			$customer->save();

            $payment_method = \Stripe\PaymentMethod::retrieve(Input::get('card'));
		}catch(\Exception $e){
			$this->sessionMessage('no credit card saved on your account!', 'error');
			return $this->previous('ads.payments');
		}

		try{
            $payment = PaymentIntent::create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'customer' => $customer->id,
                'payment_method' => $payment_method->id,
            ]);
            $payment->confirm([
                'return_url' => route('ads.payment.card.check'),
                'setup_future_usage' => 'off_session',
            ]);
//			$charge = Charge::create(array(
//				"amount" => $amount * 100,
//				"currency" => "usd",
//				"customer" => $customer->id,
//				"description" => "add funds to your ". $this->settings['siteName'] ." account",
//			));
		}catch(\Exception $e){
			$this->sessionMessage($e->getMessage(), 'error');
			return $this->previous('ads.payments');
		}

        if($payment->next_action) {
            return redirect($payment->next_action->redirect_to_url->url);
        }else{
            return $this->completePayment($payment);
        }
		
//		if(!$charge->paid){
//			$this->sessionMessage('not paid, error', 'error');
//			return $this->previous('ads.payments');
//		}
		
		// $transaction = $charge->__toArray(true);
		// dd(json_encode($charge));

	}

    public function checkCardPayment(){
        $payment = PaymentIntent::retrieve(Input::get('payment_intent'));
        $user = Auth::user();
        if($payment->next_action) {
            return redirect($payment->next_action->redirect_to_url->url);
        }else{
            if($payment->status == 'succeeded'){
                return $this->completePayment($payment);
            }
        }
        $this->sessionMessage('The payment was not collected from your card, please try again.', 'error');
        return $this->previous('ads.payments');
    }

    public function completePayment($charge){
        $user = Auth::user();
        $payment = new Payments;
        $payment->method = 'card';
        $payment->payment_id    = $charge->id;
        $payment->transactions  = json_encode($charge);
        $payment->total = $charge->amount / 100;

        if($charge->review){
            // add review rules
            $payment->review = 1;
            $user->payments()->save($payment);
            $this->adminNotifaction('there is one payment need review', 'warning');
            $this->sessionMessage('our fraud system need to check your payment. payment charged but need verifaction', 'error');
            return $this->previous('ads.payments');
        }

        $payment->review = 0;
        $user->payments()->save($payment);

        $user->credit = $user->credit + ($charge->amount / 100);
        $user->save();
        $this->sessionMessage('great! funds added to your account.', 'success');
        return $this->previous('ads.payments');
    }
	
	public function postPaymentsPaypal(){
		
		$companyName = 'Azizi Search Ltd';
		
		if(Input::has('submitPaypal')){
			$input = Input::only('amount', 'customAmount');
			$validator = Validator::make($input, [
				'amount' => 'required',
				'customAmount' => 'required_if:amount,custom|numeric|min:5|max:10000',
			]);
			
			if ($validator->fails()) {
				return redirect()->route('ads.payments')->withErrors($validator)->withInput();
			}
			
			// set amount from packages amount or custom amount
			$amount = $input['amount'];
			if($input['amount'] == 'custom'){
				$amount = $input['customAmount'];
			}
			
			$payer = new Payer();
			$payer->setPaymentMethod('paypal');
			
			$item = new Item();
			$item->setName('payment to '.$companyName)
				 ->setCurrency($this->currency)
				 ->setQuantity(1)
				 ->setPrice($amount);
			
			$item_list = new ItemList();
			$item_list->setItems(array($item));
			
			$amountObj = new Amount();
			$amountObj->setCurrency($this->currency)
				->setTotal($amount);
			
			$transaction = new Transaction();
			$transaction->setAmount($amountObj)
				->setItemList($item_list)
				->setDescription('Your transaction description');
			
			$redirect_urls = new RedirectUrls();
			$redirect_urls->setReturnUrl(route('ads.payments.process', ['a' => 'return'])) /** Specify return URL **/
				->setCancelUrl(route('ads.payments.process', ['a' => 'canceled']));
				
			$payment = new Payment();
			$payment->setIntent('Sale')
				->setPayer($payer)
				->setRedirectUrls($redirect_urls)
				->setTransactions(array($transaction));
				/** dd($payment->create($this->_api_context));exit; **/
				
			try {
				$payment->create($this->_api_context);
			} catch (\PayPal\Exception\PPConnectionException $ex) {
				if (\Config::get('app.debug')) {
					$this->sessionMessage('Connection to paypal timeout', 'error');
					return Redirect::route('ads.payments');
					/** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
					/** $err_data = json_decode($ex->getData(), true); **/
					/** exit; **/
				} else {
					$this->sessionMessage('Some error occur, sorry for inconvenient', 'error');
					return Redirect::route('ads.payments');
					/** die('Some error occur, sorry for inconvenient'); **/
				}
			}
			
			foreach($payment->getLinks() as $link) {
				if($link->getRel() == 'approval_url') {
					$redirect_url = $link->getHref();
					break;
				}
			}
			
			/** add payment ID to session **/
			session()->put('paypal_payment_id', $payment->getId());
			if(isset($redirect_url)) {
				/** redirect to paypal **/
				return Redirect::away($redirect_url);
			}
			
			$this->sessionMessage('Unknown error occurred!', 'error');
			return Redirect::route('ads.payments');
		}
		
		$this->sessionMessage('Unknown error occurred!', 'error');
		return Redirect::route('ads.payments');
	}
	
	public function proccessWithPaypal(){
		/** Get the payment ID before session clear **/
        $payment_id = session()->get('paypal_payment_id');
        /** clear the session payment ID **/
        session()->forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
			$this->sessionMessage('Payment failed!', 'error');
			return Redirect::route('ads.payments');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary **/
        /** to execute a PayPal account payment. **/
        /** The payer_id is added to the request query parameters **/
        /** when the user is redirected from paypal back to your site **/
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        /** dd($result);exit; /** DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') { 
            
			$transaction = $result->toArray();
			$transaction_json = json_encode($transaction);
			$user = Auth::user();
			$total = $transaction['transactions'][0]['amount']['total'];
			
			$payment = new Payments;
			
			// $payment->user_id = Auth::user()->id;
			$payment->method = 'paypal';
			$payment->payment_id    = $transaction['id'];
			$payment->transactions  = $transaction_json;
			$payment->total = $total;
			
			$user->payments()->save($payment);
			$user->credit += $total;
			$user->save();
			
            /** it's all right **/
            /** Here Write your database logic like that insert record or value in database if you want **/
			$this->sessionMessage('Payment success!', 'success');
            return Redirect::route('ads.payments');
        }
		
		$this->sessionMessage('Payment failed!', 'error');
		return Redirect::route('ads.payments');
	}
	
	public function getReceipt($id){
		$user = Auth::user();
		$payment = $user->payments()->where('payment_id', $id)->first();
		if(! $payment) abort(404);
		$data = [
			'user' => $user,
			'payment' => $payment,
	    ];
		
		$data = array_merge($data, $this->commonData());
        return view('emails.payments.receipt', $data);
	}
}
