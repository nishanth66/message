<?php

namespace App\Http\Controllers;
use App\Models\distributor;
use App\Models\usermessage;
use App\Models\users;
use App\User;
use Illuminate\Support\Facades\DB;
use Schema;
use App\Models\packages;
use App\Models\paypalCredentials;
use App\Models\logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class Home1Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()) {
//            return"yes";
            if (Auth::user()->status == 'admin' || Auth::user()->type == 'active')
            {
                return view('frontEnd.index');
            }
            elseif (Auth::user()->type == 'disabled' || Auth::user()->type == 'pending')
            {
                return redirect('paywithpaypal');
            }
        }
        else {
//            return "no";
            return view('frontEnd.index');
        }
//        return view('frontEnd.index');
    }
//    public function calculateamt($id){
//        $package=packages::whereId($id)->first();
//        return $package;
//    }
    public function store(Request $request)
    {
        $input = $request->except('password');
        $real_pass = $request->password;
        $input['real_pass'] = $real_pass;
        $password = bcrypt($request->password);
        $input['password'] = $password;
        $input['private_key'] = $request->personalKey;
        if(distributor::where('email',$request->email)->exists())
        {
            return Redirect()->back()->withError("This email is aready exist");
        }




        $input1 = $request->except('code','password','distributor_name');
        $real_pass = $request->password;
        $input1['real_pass'] = $real_pass;
        $password = bcrypt($request->password);
        $input1['password'] = $password;
        $lastUpdated = time();
        $input1['personalKey'] = $request->personalKey;
        $input1['name'] = $request->distributor_name;
        $input1['lastUpdated'] = $lastUpdated;
        $input1['status'] = 'distributor';
//        return $input1;
        if(users::where('email',$request->email)->exists())
        {
            return Redirect()->back()->withError("This email is aready exist");
        }
        $private = $input1['personalKey'];
        $config = array(
            "digest_alg" => $private,
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $res = openssl_pkey_new($config);

        openssl_pkey_export($res, $private_key);

        $public_key = openssl_pkey_get_details($res);
        $public_key_c = $public_key["key"];
        $d=distributor::create($input);
        $input1['distributor_id'] = $d->id;
        $input1['user_type'] = "new";
        $input1['type'] = "active";
        $input1['private_key'] = $private_key;
        $input1['public_key'] = $public_key_c;
        users::create($input1);

        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            return redirect()->intended('home');
        }
        else
        {
            return redirect('/login');
        }
    }
    public function register()
    {
        return view('distributors.register');
    }
    public function checkCode($code)
    {
        if (distributor::where('code',$code)->exists())
        {
            return "exist";
        }
        else
        {
            return "success";
        }
    }
    public function checkCode1($code,$id)
    {
        if (distributor::where('id','!=',$id)->where('code',$code)->exists())
        {
            return "exist";
        }
        else
        {
            return "success";
        }
    }
    public function checkCode2($code)
    {
        if (distributor::where('code',$code)->exists())
        {
            return "exist";
        }
        else
        {
            return "success";
        }
    }

    public function deleteProfile($id)
    {
        $user = users::whereId($id)->first();
        if ($user->status == 'distributor')
        {
            distributor::whereId($user->distributor_id)->forcedelete();
            if (DB::table('distributor_users')->where('distributor_id',$user->distributor_id)->exists())
            {
                DB::table('distributor_users')->where('distributor_id',$user->distributor_id)->delete();
            }
        }
        usermessage::where('userid',$id)->forcedelete();
        if (DB::table('distributor_users')->where('userid',$user->id)->exists())
        {
            DB::table('distributor_users')->where('userid',$user->id)->delete();
        }
        users::whereId($id)->forcedelete();
        Session::flush();
    }
    public function disableTime()
    {
        if (Auth::user()->status == 'admin')
        {
            $time = \Illuminate\Support\Facades\DB::table('servicedisable')->first();
            return view('ServiceDisable.show')->with('time',$time);
        }
        else
        {
            return redirect('home');
        }
    }
    public function editDisableTime(Request $request)
    {
        if (Auth::user()->status == 'admin')
        {
            $input = $request->except('_token');
            \Illuminate\Support\Facades\DB::table('servicedisable')->whereId(1)->update($input);
            $time = \Illuminate\Support\Facades\DB::table('servicedisable')->first();
            return view('ServiceDisable.show')->with('time',$time);
        }
        else
        {
            return redirect('home');
        }
    }
    public function editDisableDay()
    {
        if (Auth::user()->status == 'admin')
        {
            $time = \Illuminate\Support\Facades\DB::table('servicedisable')->first();
            return view('ServiceDisable.edit')->with('time',$time);
        }
        else
        {
            return redirect('home');
        }
    }
    public function disabledUser()
    {
        if (Auth::user()->status == 'admin')
        {
            $users  = users::where('type','disabled')->where('type','user')->get();
            return view('users.disabled')->with('users',$users);
        }
        else
        {
            return redirect('home');
        }
    }
    public function disabledUserShow($id)
    {
        if (Auth::user()->status == 'admin')
        {
            $users  = users::whereId($id)->first();
            return view('users.details')->with('users',$users);
        }
        else
        {
            return redirect('home');
        }
    }
    public function viewPackage()
    {
        $packages = packages::get();
        return view('frontEnd.packages')->with('packages',$packages);
    }

    public function test()
    {
//        DB::table('social_link')->insert(
//            ['links' => 'https://www.facebook.com/login/', 'title' => 'facebook']
//        );
//        Schema::create('social_link', function($table)
//        {
//            $table->increments('id');
//        });
//        Schema::table('social_link', function($table)
//        {
//            $table->string('links');
//        });
        return "true";
    }
    public function sql()
    {
        $tables = DB::table('users')->get();
        return $tables;
    }
    public function showRegisterForm($id)
    {
        return view('auth.register',compact('id'));
    }
    public function registerFromLink($id,$distributor)
    {
        $id = decrypt($id);
        $did = decrypt($distributor);
        $distributor = distributor::whereId($did)->first();
        $code = $distributor->code;
        return view('auth.register',compact('id','code'));
    }
}
