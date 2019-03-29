<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Models\company;
use App\Models\plantable;
use App\Models\SamyBotPlans;
use Illuminate\Http\Request;
use App\Models\affiliate;
use App\Models\temp_user;
use App\Models\linkedin_plans;
use Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;
use URL;
use Session;
use Redirect;
use Illuminate\Support\Facades\Input;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Api\Subscriptions;
use Cartalyst\Stripe\Exception\NotFoundException;
use Stripe\Error\Card;
use Illuminate\Support\Facades\Auth;
class StripeController extends Controller
{
    public function __construct()
    {


    }
    /**     * Show the application paywith stripe.
     *
     * @return \Illuminate\Http\Response
     */


    public function activateCard($id)
    {
        $domain = request()->getHost();
        if (Auth::user()->status == '4' && $domain != ''.env('APP_DOMAIN').'' )
        {
            return redirect('home');
        }
        $card = DB::table('stripe_cards')->whereId($id)->first();
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        DB::table('stripe_cards')->where('company_id',$card->company_id)->where('status',1)->update(['status'=>0]);
        DB::table('stripe_cards')->whereId($id)->update(['status'=>1]);
        $customer = $stripe->customers()->update( $card->customerId, [
            'default_source' => $card->cardNo
        ]);
        Session::put('success',trans('company.card_update'));
        return redirect()->back();
    }

    public function payWithStripe()
    {
        if (!Auth::check())
        {
            return redirect('login');
        }
        $id = Auth::user()->company_id;
        $company = company::whereId($id)->first();
        if ($company->affiliate_disabled == 1)
        {
            return view('frontEnd.disabled');
        }
        elseif (Auth::user()->samy_affiliate == 0)
        {
            return redirect('plans');
        }
        $planTable = DB::table('companyAffiliatePlans')->where('company_id',$company->id)->orderby('id','desc')->first();
        $plan = plantable::whereId($planTable->planid)->first();
        if(empty($company) || empty($company)){
            return view('frontEnd.home');
        }
        $amount = $plan->amount;
        if ($plan->term == 'month')
        {
            $expiry = date('d/m/Y', strtotime("+30 days"));
        }
        elseif ($plan->term == 'year')
        {
            $expiry = date('d/m/Y', strtotime("+365 days"));
        }
        $type=1;
        if (DB::table('stripe_cards')->where('company_id',$id)->where('status',1)->exists())
        {
            $stripeCard = DB::table('stripe_cards')->where('company_id',$id)->where('status',1)->first();
            $stripe = Stripe::make(env('STRIPE_SECRET'));
            try
            {
                $stripe_card = $stripe->cards()->find($stripeCard->customerId, $stripeCard->cardNo);
                $show_card_number = 'XXXX-XXXX-XXXX-'.substr($stripe_card['last4'],-4);
                return view('stripe.paywithstripe',compact('id','act_amt','total_ShipAmt','expiry','amount','show_card_number','ship_amt','activation_charge','shipping_charge','type','plan','total','stripe_card'));
            }
            catch (NotFoundException $e)
            {
                $card = "";
                $card_number = "";
                $card_cvv = "";
                $card_month = "";
                $card_year = "";
                $stripe_card = "";
                $show_card_number="";
                return view('stripe.paywithstripe',compact('id','user','stripe_card','type','plan','amount','expiry','card','card_number','card_cvv','card_month','card_year','show_card_number'));
            }
            catch (Exception $e)
            {
                $card = "";
                $card_number = "";
                $card_cvv = "";
                $card_month = "";
                $card_year = "";
                $stripe_card = "";
                $show_card_number="";
                return view('stripe.paywithstripe',compact('id','user','stripe_card','type','plan','amount','expiry','card','card_number','card_cvv','card_month','card_year','show_card_number'));
            }
        }
        else{
            $card = "";
            $card_number = "";
            $card_cvv = "";
            $card_month = "";
            $card_year = "";
            $stripe_card = "";
            $show_card_number="";
            return view('stripe.paywithstripe',compact('id','user','stripe_card','type','plan','amount','expiry','card','card_number','card_cvv','card_month','card_year','show_card_number'));
        }
    }

    public function payment()
    {
        if(Cookie::get('special_temp_user') != '' || !empty(Cookie::get('special_temp_user')))
        {
            $temp_user_id = Cookie::get('special_temp_user');
            $plansFirst = DB::table('temp_bot_plans')->where('temp_user_id',$temp_user_id)->first();
            $plans = DB::table('temp_bot_plans')->where('temp_user_id',$temp_user_id)->get();
            $total_ShipAmt = $plansFirst->shipping_charge;
            $activation = DB::table('activateCharge')->first();
            $act_amt = $activation->amount;
            $shipping = DB::table('shipping')->first();
            if ($plansFirst->shipping_country == 'United States')
            {
                $shipping_charge = ($shipping->usa);
                $ship_amt = $shipping->usa;
            }
            else
            {
                $shipping_charge = ($shipping->other);
                $ship_amt = $shipping->other;
            }
            $activation_charge = $plansFirst->activation_charge;
            $total = $plansFirst->plan_total;
            $card = "";
            $card_number = "";
            $card_cvv = "";
            $card_month = "";
            $card_year = "";
            $stripe_card = "";
            $show_card_number="";
            $type=2;
            return view('stripe.paywithstripe',compact('id','stripe_card','act_amt','ship_amt','total_ShipAmt','activation_charge','shipping_charge','type','plans','total','card','card_number','card_cvv','card_month','card_year','show_card_number'));
        }
        else{
            $id = Auth::user()->company_id;
            $company = company::whereId($id)->first();
            $plansFirst = DB::table('bot_plans')->where('transaction_id',$company->samy_bot_transaction_id)->first();
            $plans = DB::table('bot_plans')->where('transaction_id',$company->samy_bot_transaction_id)->get();
            if (Auth::user()->samy_bot == 0)
            {
                return view('frontEnd.disabled');
            }
            $total_ShipAmt = $plansFirst->shipping_charge;
            $activation = DB::table('activateCharge')->first();
            $act_amt = $activation->amount;
            $shipping = DB::table('shipping')->first();
            if ($plansFirst->shipping_country == 'United States')
            {
                $shipping_charge = ($shipping->usa);
                $ship_amt = $shipping->usa;
            }
            else
            {
                $shipping_charge = ($shipping->other);
                $ship_amt = $shipping->other;
            }
            $activation_charge = $plansFirst->activation_charge;
            $total = $plansFirst->plan_total;
            if (DB::table('stripe_cards')->where('company_id',$id)->where('status',1)->exists())
            {
                $stripeCard = DB::table('stripe_cards')->where('company_id',$id)->where('status',1)->first();
                $stripe = Stripe::make(env('STRIPE_SECRET'));
                try{
                    $stripe_card = $stripe->cards()->find($stripeCard->customerId, $stripeCard->cardNo);
                    $type=2;
                    $show_card_number = 'XXXX-XXXX-XXXX-'.substr($stripe_card['last4'],-4);
                    return view('stripe.paywithstripe',compact('id','act_amt','total_ShipAmt','show_card_number','ship_amt','activation_charge','shipping_charge','type','plans','total','stripe_card'));
                }
                catch (\Exception $ex) {
                    $card = "";
                    $card_number = "";
                    $card_cvv = "";
                    $card_month = "";
                    $card_year = "";
                    $stripe_card = "";
                    $show_card_number="";
                    $type=2;
                    return view('stripe.paywithstripe',compact('id','stripe_card','act_amt','ship_amt','total_ShipAmt','activation_charge','shipping_charge','type','plans','total','card','card_number','card_cvv','card_month','card_year','show_card_number'));
                }
            }
            else
            {
                $card = "";
                $card_number = "";
                $card_cvv = "";
                $card_month = "";
                $card_year = "";
                $stripe_card = "";
                $show_card_number="";
                $type=2;
                return view('stripe.paywithstripe',compact('id','stripe_card','act_amt','ship_amt','total_ShipAmt','activation_charge','shipping_charge','type','plans','total','card','card_number','card_cvv','card_month','card_year','show_card_number'));
            }
        }
    }

    public function LinkedInpayment(){
        if (Auth::user()->link_disabled == 1)
        {
            return view('frontEnd.disabled');
        }
        $id= Auth::user()->company_id;
        $user = company::whereId($id)->first();
        $plan = linkedin_plans::whereId($user->linkedIn_plan)->first();
        $amount = $plan->amount;

        if (DB::table('stripe_cards')->where('company_id',$id)->where('status',1)->exists())
        {
            $stripeCard = DB::table('stripe_cards')->where('company_id',$id)->where('status',1)->first();
            $stripe = Stripe::make(env('STRIPE_SECRET'));
            $stripe_card = $stripe->cards()->find($stripeCard->customerId, $stripeCard->cardNo);
            $type=2;
            $show_card_number = 'XXXX-XXXX-XXXX-'.substr($stripe_card['last4'],-4);
            return view('stripe.paywithstripe',compact('id','act_amt','total_ShipAmt','show_card_number','ship_amt','activation_charge','shipping_charge','type','plans','total','stripe_card'));
        }
        else{
            $card = "";
            $card_number = "";
            $card_cvv = "";
            $card_month = "";
            $card_year = "";
            $show_card_number="";
        }

        if ($plan->term == 'month')
        {
            $expiry = date('d/m/Y', strtotime("+30 days"));
        }
        elseif ($plan->term == 'year')
        {
            $expiry = date('d/m/Y', strtotime("+365 days"));
        }
        $type = 4;
        return view('stripe.paywithstripe',compact('id','user','type','plan','amount','expiry','card','card_number','card_cvv','card_month','card_year','show_card_number'));
    }

    public function postPaymentWithStripe(Request $request)
    {
        if(Cookie::get('special_temp_user') != '' || !empty(Cookie::get('special_temp_user'))){
            $temp_user_id = Cookie::get('special_temp_user');
            $planFirst = DB::table('temp_bot_plans')->where('temp_user_id',$temp_user_id)->first();
            $plans = DB::table('temp_bot_plans')->where('temp_user_id',$temp_user_id)->get();
            $BotPurchaseAmt = 0;
            $planids='';
            foreach($plans as $plan)
            {
                $planids .= $plan->plan.',';
                $BotPurchaseAmt += $plan->price*$plan->quantity;
            }
            $plan_amount = $planFirst->plan_total;
            $planids = str_replace_last(',','',$planids);
        }
        else{
            $id = Auth::user()->company_id;
            $company = company::whereId($id)->first();
            if ($request->type == '2')
            {
                $plans = DB::table('bot_plans')->where('transaction_id',$company->samy_bot_transaction_id)->get();
                $planFirst = DB::table('bot_plans')->where('transaction_id',$company->samy_bot_transaction_id)->first();
                $BotPurchaseAmt = 0;
                $planids='';
                foreach($plans as $plan)
                {
                    $planids .= $plan->plan.',';
                    $BotPurchaseAmt += $plan->price*$plan->quantity;
                }
                $plan_amount = $planFirst->plan_total;
                $planids = str_replace_last(',','',$planids);
            }
            elseif ($request->type == '4'){
                $plan = linkedin_plans::whereId($company->linkedIn_plan)->first();
                $plan_amount = (float)$plan->amount;
            }
            else {
                $planFirst = DB::table('companyAffiliatePlans')->where('company_id',$id)->orderby('id','desc')->first();
                $plan = plantable::whereId($planFirst->planid)->first();
                $plan_amount = (float)$plan->amount;
            }
        }
        //taking amount from database. not the form. because, client side verifcation can be easily broken
        if(!isset($request->fingerprint)){
            $validator = Validator::make($request->all(), [
                'card_no' => 'required',
                'ccExpiryMonth' => 'required',
                'ccExpiryYear' => 'required',
                'cvvNumber' => 'required',
                'amount' => 'required',
            ],
                [
                    'card_no.required' => trans('card.card_number_required'),
                    'ccExpiryMonth.required' => trans('card.expire_month_required'),
                    'ccExpiryYear.required' => trans('card.expire_year_required'),
                    'cvvNumber.required' => trans('card.cvv_required'),
                    'amount.required' => trans('card.psw_required'),
                ]
            );
            if ($validator->fails()) {
                \Session::put('error', trans('stripe.required'));
                if ($request->type == '2')
                {
                    return redirect('payment');
                }
                elseif ($request->type == '4')
                {
                    return redirect('samylinkedIn/payment');
                }
                else
                {
                    return redirect('stripe');
                }
            }
        }

        $input  = $request->all();
        $input  = array_except($input, array('_token'));
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try {
            if(!isset($request->fingerprint)){
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $request->get('card_no'),
                        'exp_month' => $request->get('ccExpiryMonth'),
                        'exp_year' => $request->get('ccExpiryYear'),
                        'cvc' => $request->get('cvvNumber'),
                    ],
                ]);
                $stripe_input['brand'] = $token['card']['brand'];
                $stripe_fingerprint = $token['card']['fingerprint'];
                if (!isset($token['id'])) {
                    \Session::put('error', trans('stripe.token_error'));
                    if ($request->type == '2')
                    {
                        return redirect('payment');
                    }
                    elseif ($request->type == '4')
                    {
                        return redirect('samylinkedIn/payment');
                    }
                    else
                    {
                        return redirect('stripe');
                    }
                }
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount' => $plan_amount,
                    'description' => 'Add in wallet',
                ]);
            }
            else{
                $stripe_fingerprint = $request->fingerprint;
                $charge = $stripe->charges()->create(array(
                    "amount" => $plan_amount,
                    "currency" => 'USD',
                    "customer" => $company->stripe_id,
                    "card" => $request->cardNo
                ));
            }
            $chargeId = $charge['id'];
            if ($charge['status'] == 'succeeded') {
                if(Cookie::get('special_temp_user') != '' || !empty(Cookie::get('special_temp_user'))){
                    $temp_user_id = Cookie::get('special_temp_user');
                    $temp_user = temp_user::whereId($temp_user_id)->first();
                    $hash = bcrypt(time() . rand(0,99999999));
                    $hash = str_replace('/', '', $hash);
                    $array['email'] = $temp_user->email;
                    $array['name'] = $temp_user->fname.' '.$temp_user->lname;
                    $array['hash'] = $hash;
                    Mail::send('email.welcome', ['array' => $array], function ($message) use ($array) {
                        $message->to($array['email'], $array['name'])->from(env('MAIL_USERNAME'), 'Samy Affiliate')->subject(trans('mail.welcome'));
                    });
                    $newcompany = [
                        'fname' =>$temp_user->fname,
                        'lname' =>$temp_user->lname,
                        'email' =>$temp_user->email,
                        'phno' =>$temp_user->phno,
                        'address' =>$temp_user->address,
                        'address2' =>$temp_user->address2,
                        'city' =>$temp_user->city,
                        'state' =>$temp_user->state,
                        'zip' =>$temp_user->zip,
                        'country' =>$temp_user->country,
                    ];
                    $new_company = company::create($newcompany);//inserting data to company table
                    $affiliate_input = ([
                        'company_id' => $new_company->id,
                        'name' => $temp_user->fname.' '.$request->lname,
                        'fname' => $temp_user->fname,
                        'lname' => $temp_user->lname,
                        'email' => $temp_user->email,
                        'phone' => $temp_user->phno,
                        'address' => $temp_user->address,
                        'address2' => $temp_user->address2,
                        'city' => $temp_user->city,
                        'state' => $temp_user->state,
                        'zip' => $temp_user->zip,
                        'country' => $temp_user->country,
                        'invitee' => $temp_user->invitee,
                    ]);
                    $new_affiliate = affiliate::create($affiliate_input);
                    $usr = User::create([
                        'fname' => $temp_user->fname,
                        'lname' => $temp_user->lname,
                        'name' => $temp_user->fname.' '.$request->lname,
                        'email' => $temp_user->email,
                        'phone' => $temp_user->phno,
                        'password' => bcrypt($temp_user->password),
                        'company_id' => $new_company->id,
                        'affiliate_id' => $new_affiliate->id,
                        'status' => 4,
                        'samy_bot' => 1,
                        'activation_hash' => $hash,
                    ]);
//                        $usr = User::create($new_usr);
                    $transaction_id = time().rand(1,999999).'_'.$new_company->id;
                    foreach ($plans as $temp_plan){
                        $new_bot_plan = [
                            'company_id' => $new_company->id,
                            'plan' => $temp_plan->plan,
                            'quantity' => $temp_plan->quantity,
                            'stripe_paln_id' => $temp_plan->stripe_plan_id,
                            'price' => $temp_plan->price,
                            'unit' => $temp_plan->unit,
                            'plan_total' => $temp_plan->plan_total,
                            'transaction_id' => $transaction_id,
                            'shipping_charge' => $temp_plan->shipping_charge,
                            'activation_charge' => $temp_plan->activation_charge,
                            'date' => date('d-m-Y'),
                            'shipping_address1' =>$temp_plan->shipping_address1,
                            'shipping_address2' =>$temp_plan->shipping_address2,
                            'shipping_city' =>$temp_plan->shipping_city,
                            'shipping_state' =>$temp_plan->shipping_state,
                            'shipping_zip' =>$temp_plan->shipping_zip,
                            'shipping_country' =>$temp_plan->shipping_country
                        ];
                        DB::table('bot_plans')->insert($new_bot_plan);
                    }
                    company::whereId($new_company->id)->update(['samy_bot_transaction_id'=>$transaction_id]);
                    if(Auth::attempt(['email'=>$usr->email,'password'=>$temp_user->password]))
                    {
                        DB::table('temp_bot_plans')->where('temp_user_id',$temp_user_id)->delete();
                        temp_user::whereId($temp_user_id)->forcedelete();
                        $company = company::whereId(Auth::user()->company_id)->first();
                        $id = $company->id;
                    }else{
                        return redirect('login');
                    }

                }
                if(empty($company->stripe_id)){
                    $customer = $stripe->customers()->create([
                        'email' => $company->email,
                        'description' => 'Stripe Customer with user id -'.$company->user_id,
                    ]);
                    $customerId = $customer['id'];
                    company::whereId($company->id)->update(['stripe_id' => $customerId]);
                }
                else{
                    try{
                        $customer = $stripe->customers()->find($company->stripe_id);
                        $customerId = $customer['id'];
                    }catch (\Exception $e){
                        $customer = $stripe->customers()->create([
                            'email' => $company->email,
                            'description' => 'Stripe Customer with user id -'.Auth::user()->id,
                        ]);
                        $customerId = $customer['id'];
                        company::whereId($company->id)->update(['stripe_id' => $customerId]);
                    }
                }
                if(DB::table('stripe_cards')->where('company_id',$id)->exists() == 0){
                    $stripe_input['status'] = 1;
                }
                if (DB::table('stripe_cards')->where('company_id',$id)->where('fingerprint',$stripe_fingerprint)->exists() == 0) //To avoid the duplicate entry
                {
                    $token = $stripe->tokens()->create([
                        'card' => [
                            'number' => $request->get('card_no'),
                            'exp_month' => $request->get('ccExpiryMonth'),
                            'exp_year' => $request->get('ccExpiryYear'),
                            'cvc' => $request->get('cvvNumber'),
                        ],
                    ]);
                    try{
                        $cards = $stripe->cards()->create($customerId, $token['id']);
                    }catch (\Exception $e){
                    }
                    $stripe_input['company_id'] = $id;
                    $stripe_input['customerId'] = $customerId;
                    $stripe_input['cardNo']  = $cards['id'];
                    $stripe_input['fingerprint'] = $stripe_fingerprint;
                    $stripe_input['digits'] = 'XXXXXXXXXXXX'.substr($request->card_no,-4);
                    DB::table('stripe_cards')->insert($stripe_input); //Entering the card details
                }
                //code to storing the card ends here
                $card_details =  DB::table('stripe_cards')->where('company_id',$id)->where('status',1)->first();
                //adding payment detailes code starts here
                $input_pay['payment_id'] = $chargeId;
                $input_pay['user_id'] = $id;
                $input_pay['card_number'] = $card_details->id;
                $input_pay['payment_type'] = "Subscribe";
                $input_pay['amount'] = $plan_amount;
                $input_pay['date'] = new \DateTime();
                $input_pay['name'] = $company->fname.' '.$company->lname;
                $input_pay['email'] = $company->email;
                $input_pay['phone'] = $company->phno;
                $input_pay['address'] = $company->address;
                $input_pay['orderid'] = time().$id;
                $input_pay['type'] = $request->type;
                if ($request->type == '2')
                {
                    $input_pay['planid'] = $planids;
                }
                elseif ($request->type == '4'){
                    $input_pay['planid']=$company->linkedIn_plan;
                }
                else
                {
                    $input_pay['planid'] = $planFirst->planid;
                }
                DB::table('stripepayment')->insert($input_pay);
                if (!isset($company->apikey) && $company->apikey == '' || empty($company->apikey))
                {
                    $apikey = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5) . time() . substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"),0,5);
                    company::whereId($company->id)->update(['apikey' => $apikey]);
                }
                if ($request->type == '2')
                {
                    $Stripeplans = DB::table('bot_plans')->where('transaction_id',$company->samy_bot_transaction_id)->get();
                    foreach($Stripeplans as $stplan)
                    {
                        $stripe_paln_id = $stplan->stripe_paln_id;
                        $current = SamyBotPlans::whereId($stplan->plan)->first();
                        if($current->term == 'year'){
                            $trial_end=	strtotime("+1 year", time());
                        }
                        else{
                            $trial_end=	strtotime("+1 month", time());
                        }
                        $subscription = $stripe->subscriptions()->create($customerId, [
                            'plan' => $stripe_paln_id,
                            'trial_end' => $trial_end
                        ]);
                        DB::table('bot_plans')->whereId($stplan->id)->update(['subscription_id' => $subscription['id']]);
                    }
                    $update_user['bot_payment'] = 1;
                    DB::table('bot_plans')->where('transaction_id',$company->samy_bot_transaction_id)->update(['payment_status' => 1]);
                }
                elseif ($request->type == '4'){
                    $update_user['linkedIn_payment'] = 1;
                }
                else
                {
                    if($plan->term == 'year'){
                        $trial_end=	strtotime("+1 year", time());
                    }
                    else{
                        $trial_end=	strtotime("+1 month", time());
                    }
                    $subscription = $stripe->subscriptions()->create($customerId, [
                        'plan' => $plan->stripe_plan_id,
                        'trial_end' => $trial_end
                    ]);
                    $updatePlan['plan_start'] = date('d/m/Y',time());
                    $updatePlan['plan_end'] = date('d/m/Y',$trial_end);
                    $updatePlan['payment'] = 1;
                    $updatePlan['stripe_subscription_id'] = $subscription['id'];
                    $updatePlan['payment'] = 1;
                    DB::table('companyAffiliatePlans')->whereId($planFirst->id)->update($updatePlan);

                }
                //updating company stripe card number
                $update_company['card_stripe'] = 'XXXXXXXXXXXX'.substr($request->card_no,-4);
                /// Cookie  goes here
                if ($request->type == '2'){
                    if(isset($_COOKIE["samybot_affiliate_id"]) && $_COOKIE["samybot_affiliate_id"] !== null) {
                        $cookie = $_COOKIE["samybot_affiliate_id"];
                        $cookie_affiliates = affiliate::whereId($cookie)->first();
                        $cookie_company = company::whereId($cookie_affiliates->company_id)->first();
                        $array = array(
                            'api' => $cookie_company->apikey,
                            'affiliate_id' => $cookie,
                            'total' => $BotPurchaseAmt,
                            'currency' => $charge['currency'],
                            'name' => Auth::user()->name
                        );
                        setcookie("samybot_affiliate_id", "", time()-3600);
                        $data = json_encode($array);
                        $url = url('/samy_affiliate/purchase_success');  // send data to mlm using curl
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                        //send api key in header to mlm
                            'Apikey: ' . $cookie_company->apikey,
                            'Content-Type: application/json',
                        ));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $res = curl_exec($ch);
                        curl_close($ch);
                    }
                    if(Cookie::has('special_type') && ($cookie_special = Cookie::get('special_type') != '' || !empty($cookie_special = Cookie::get('special_type') != ''))) {
                        $cookie = Cookie::get('special_type');
                        $combined_user = User::whereId($cookie)->first();
                        if ($combined_user->special_user != 1)
                        {
                            $cookie_affiliates = affiliate::whereId($combined_user->affiliate_id)->first();
                            $cookie_company = company::whereId($cookie_affiliates->company_id)->first();
                            $array = array(
                                'api' => $cookie_company->apikey,
                                'affiliate_id' => $cookie_affiliates->id,
                                'total' => $BotPurchaseAmt,
                                'currency' => $charge['currency'],
                                'name' => Auth::user()->name
                            );
                            $data = json_encode($array);
                            $url = url('/samy_affiliate/purchase_success');  // send data to mlm using curl
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                        //send api key in header to mlm
                                'Apikey: ' . $cookie_company->apikey,
                                'Content-Type: application/json',
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $res = curl_exec($ch);
                            curl_close($ch);
                        }

                    }
                }
                /// Cookie  goes here Added Award to affiliate
                \Session::put('success', trans('stripe.payment_succesfull'));
                if (Auth::user()->activated != 1)
                {
                    return redirect('confirmEmail');
                }
                if ($request->type == 2)
                {
                    return redirect('samybot/generateAndSendInvoice/'.$company->samy_bot_transaction_id);
                }
                elseif ($request->type == 4)
                {
                    return redirect('samylinkedIn/campaigns');
                }
                else
                {
                    return redirect('home');
                }
            }
//            Successfully charged ends
            else {
                \Session::put('error', trans('stripe.payment_failed'));
                if ($request->type == '2')
                {
                    return redirect('payment');
                }
                elseif ($request->type == '4')
                {
                    return redirect('samylinkedIn/payment');
                }
                else
                {
                    return redirect('stripe');
                }
            }
        }
        catch (Exception $e) {
            \Session::put('error', $e->getMessage());
            if ($request->type == '2')
            {
                return redirect('payment');
            }
            elseif ($request->type == '4')
            {
                return redirect('samylinkedIn/payment');
            }
            else
            {
                return redirect('stripe');
            }
        }
        catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            $code = $e->getErrorCode();
            if ($code == 'invalid_expiry_month')
            {
                \Session::put('error', trans('card.valid_month'));
            }
            elseif ($code == 'invalid_number')
            {
                \Session::put('error', trans('card.valid'));
            }
            elseif ($code == 'invalid_expiry_year')
            {
                \Session::put('error', trans('card.valid_year'));
            }
            elseif ($code == 'invalid_cvc')
            {
                \Session::put('error', trans('card.valid_cvv'));
            }
            \Session::put('error', $e->getMessage());
            if ($request->type == '2')
            {
                return redirect('payment');
            }
            elseif ($request->type == '4')
            {
                return redirect('samylinkedIn/payment');
            }
            else
            {
                return redirect('stripe');
            }
        }
        catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
            \Session::put('error', $e->getMessage());
            if ($request->type == '2')
            {
                return redirect('payment');
            }
            elseif ($request->type == '4')
            {
                return redirect('samylinkedIn/payment');
            }
            else
            {
                return redirect('stripe');
            }
        }
    }

    public function Reactivate($subscriptionId){
        $domain = request()->getHost();
        if (Auth::user()->status == '4' && $domain != ''.env('APP_DOMAIN').'' )
        {
            return redirect('home');
        }
        $id= Auth::user()->company_id;
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        $company = company::whereId($id)->first();
        $customerId = $company->stripe_id;
        $subscription = $stripe->subscriptions()->cancel($customerId, $subscriptionId, true);
        return redirect()->back();
    }

    public function TestStripe(){
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        $token = $stripe->tokens()->create([
            'card' => [
                'number' => '4111111111111111',
                'exp_month' => '02',
                'exp_year' => '2020',
                'cvc' => '044',
            ],
        ]);
        $customer = $stripe->customers()->create([
            'email' => 'test1@doe.com',
            'source' => $token['id'],
            'description' => 'Stripe Customer with user id ',
        ]);
        $subscription = $stripe->subscriptions()->create($customer['id'], [
            'plan' => 'SJM1U',
            'trial_end' => time(),
        ]);

        $subscription = $stripe->subscriptions()->find($customer['id'], $subscription['id']);
        return $subscription;
    }
}