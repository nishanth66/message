<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\packages;
use App\Models\usermessage;
use App\Models\paypalCredentials;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;
use URL;
use Session;
use Redirect;
use Illuminate\Support\Facades\Input;

/** All Paypal Details class **/
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

class PaypalController extends HomeController
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        /** setup PayPal api context **/
        $paypal_key = DB::table('paypal_details')->where('status',1)->first();
        $paypal_conf = \Config::get('paypal');
        if ($paypal_key->mode == '0')
        {
            $mode = "sandbox";
        }
        else
        {
            $mode = "live";
        }
        $client = str_replace(' ','',$paypal_key->client_id);
        $secrete = str_replace(' ','',$paypal_key->client_secrete);
        $this->_api_context = new ApiContext(new OAuthTokenCredential($client,$secrete));
        $settingPaypal = array([
            'mode' => $mode,
            'http.ConnectionTimeOut' => 1000,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'FINE'
        ]);
        $this->_api_context->setConfig($settingPaypal);
    }

    /**
     * Show the application paywith paypalpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function payWithPaypal()
    {
        $user = \App\Models\users::whereId(Auth::user()->id)->first();
        $package = \App\Models\packages::whereId($user->package)->first();
        $countries = array("AF" => "Afghanistan",
            "AX" => "Åland Islands",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, The Democratic Republic of The",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and Mcdonald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran, Islamic Republic of",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic of",
            "KR" => "Korea, Republic of",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macao",
            "MK" => "Macedonia, The Former Yugoslav Republic of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States of",
            "MD" => "Moldova, Republic of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territory, Occupied",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and The Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome and Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and The South Sandwich Islands",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan, Province of China",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic of",
            "TH" => "Thailand",
            "TL" => "Timor-leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.S.",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe");
        return view('paywithpaypal',compact('user','package','countries'));
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithpaypal(Request $request)
    {
        $paypalCurrency = DB::table('paypal_details')->where('status',1)->first();
        if (isset($request->submit)) {
            $p = packages::whereId($request->package)->first();
            $msg55 = $p->no_of_limit_messages;
            if ($request->submit == 'no payment') {
                $success['type'] = 'active';
                $success['user_type'] = 'subscribed';
                $success['last_payment'] = time();
                $success['user_type'] = 'paid';
                $success['package'] = $request->package;
                $success['old_package'] = Auth::user()->package;
                $success['available_msg'] = $msg55;
                users::whereId(Auth::user()->id)->update($success);
                return redirect('home');
            }
        }
        \Session::put('name',$request->name);
        \Session::put('email',$request->email);
        \Session::put('phone',$request->phone);
        \Session::put('country',$request->country);
        \Session::put('city',$request->city);
        \Session::put('post',$request->post);
        \Session::put('street',$request->street);
        \Session::put('type',$request->type);
        \Session::put('reason',$request->reason);
        \Session::put('package',$request->package);
        if ($request->name == '' || $request->email == '' || $request->post == '' || $request->city == '' || $request->street == '' || $request->country == '')
        {
            return Redirect()->back()->withError("Please fill all the required Fields");
        }

        if (isset($request->submit))
        {
            \Session::put('submit',$request->submit);
            if ($request->submit == 'payment')
            {
                $packages55 = packages::whereId($request->package)->first();
                $mil1 = time();
                $d1 = date("d-m-Y", $mil1);
                $mil2 = Auth::user()->package_expire;
                $d2= date("d-m-Y", $mil2);
                $date1=date_create($d1);
                $date2=date_create($d2);
                $diff=date_diff($date1,$date2);
                $day = $diff->format("%a");
                if ($day > 365)
                {
                    $day = 365;
                }
                if ($day > 0) {
                    $diff = ($day * (float)$packages55->yearly_subscribe) / 365;
                    $amt = number_format((float)$diff, 2, '.', '');
                }
                elseif ($day <= 0)
                {
                    $day = 0;
                    $amt = $packages55->yearly_subscribe;
                }
            }
        }
        else {
            \Session::put('submit','');
            $package = packages::whereId(Auth::user()->package)->first();
            if (Auth::user()->user_type == 'new') {
                $amt = $package->initial_setup + $package->yearly_subscribe;
            } else {
                $amt = $package->yearly_subscribe;
            }
        }
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName('Item 1') /** item name **/
        ->setCurrency($paypalCurrency->currency)
            ->setQuantity(1)
            ->setPrice($amt); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency($paypalCurrency->currency)
            ->setTotal($amt);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('status')) /** Specify return URL **/
        ->setCancelUrl(URL::route('status'));

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
                \Session::put('error','Connection timeout');
                if (isset($request->submit))
                {
                    return redirect()->back();
                }
                else
                {
                    return Redirect::route('paywithpaypal');
                }
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                /** $err_data = json_decode($ex->getData(), true); **/
                /** exit; **/
            } else {
                \Session::put('error','Some error occur, sorry for inconvenient');
                if (isset($request->submit))
                {
                    return redirect()->back();
                }
                else {
                    return Redirect::route('paywithpaypal');
                }
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
        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }

        \Session::put('error','Unknown error occurred');
        if (isset($request->submit))
        {
            return redirect()->back();
        }
        else
        {
            return Redirect::route('paywithpaypal');
        }
    }

    public function getPaymentStatus()
    {
        $mssg = \Session::get('submit');
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error','Payment failed');
            if ($mssg != '')
            {
                return redirect()->back();
            }
            else
            {
                return Redirect::route('paywithpaypal');
            }

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

            /** it's all right **/
            /** Here Write your database logic like that insert record or value in database if you want **/
            $pakage = \Session::get('package');
            $pack = packages::whereId($pakage)->first();
            \Session::put('success','Payment success');
            $reason = \Session::get('reason');
            if ($reason == 'new') {
                $success['type'] = 'active';
                $success['user_type'] = 'subscribed';
                $success['last_payment'] = time();
                $success['package_expire'] = strtotime('+1 years');
                $success['user_type'] = 'paid';
                $success['available_msg'] = (int)$pack->no_of_limit_messages;
                $success['lastreminder'] = '';
                $data['user'] = Auth::user()->id;
                $data['package'] = \Session::get('package');
                $data['email'] = Auth::user()->email;
                $data['name'] = Auth::user()->name;
                Mail::send('emails.renew',['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject("Welcome to Message");
                });
            }
            elseif ($reason == 'change')
            {
                $success['type'] = 'active';
                $success['user_type'] = 'subscribed';
                $success['last_payment'] = time();
                $success['user_type'] = 'paid';
                $success['package'] = \Session::get('package');
                $success['old_package'] = Auth::user()->package;
                $success['available_msg'] = (int)$pack->no_of_limit_messages;
                $success['lastreminder'] = '';
                $success['msgid'] = 1;
                $data['user'] = Auth::user()->id;
                $data['package'] = \Session::get('package');
                $data['email'] = Auth::user()->email;
                $data['name'] = Auth::user()->name;
                $msg = usermessage::where('userid',Auth::user()->id)->count();
                if ($msg > $success['available_msg'])
                {
                    $user_msgs = usermessage::where('userid',Auth::user()->id)->limit($success['available_msg'])->get();
                    foreach ($user_msgs as $user_msg)
                    {
                        usermessage::whereId($user_msg->id)->update(['disabled'=>0]);
                    }
                    usermessage::where('userid',Auth::user()->id)->where('disabled','!=',0)->forcedelete();
                }
                else
                {
                    usermessage::where('userid',Auth::user()->id)->update(['disabled'=>0]);
                }
                Mail::send('emails.change',['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject("Welcome to Message");
                });
            }
            elseif ($reason == 'reneval')
            {
                $success['type'] = 'active';
                $success['user_type'] = 'subscribed';
                $success['last_payment'] = time();
                $success['user_type'] = 'paid';
                $success['package_expire'] = strtotime('+1 years');
                $success['package'] = \Session::get('package');
                $success['old_package'] = Auth::user()->package;
                $success['available_msg'] = (int)$pack->no_of_limit_messages;
                $success['lastreminder'] = '';
                $success['msgid'] = 1;
                $data['user'] = Auth::user()->id;
                $data['package'] = \Session::get('package');
                $data['email'] = Auth::user()->email;
                $data['name'] = Auth::user()->name;
                usermessage::where('userid',Auth::user()->id)->update(['disabled'=>0]);
                Mail::send('emails.signup',['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'],$data['name'])->subject("Welcome to Message");
                });
            }
            users::whereId(Auth::user()->id)->update($success);
            $update['name'] = \Session::get('name');
            $update['email'] = \Session::get('email');
            $update['phone'] = \Session::get('phone');
            $update['country'] = \Session::get('country');
            $update['city'] = \Session::get('city');
            $update['zipcode'] = \Session::get('post');
            $update['street'] = \Session::get('street');
            $update['type'] = \Session::get('type');
            $update['payment_id'] = $payment_id;
            $update['packageExpireDate'] = strtotime('+1 years');
            $update['paymentDate'] = time();
            $update['package'] = Auth::user()->package;
            $update['user_id'] = Auth::user()->id;
            paypalCredentials::create($update);
            return Redirect('home');
        }
        \Session::put('error','Payment failed');
        if ($mssg != '')
        {
            return redirect()->back();
        }
        else
        {
            return Redirect::route('paywithpaypal');
        }
    }
}