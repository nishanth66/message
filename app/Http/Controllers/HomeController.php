<?php

namespace App\Http\Controllers;
use App\Models\distributor;
use App\Models\users;
use DB;
use App\Models\packages;
use App\Models\paypalCredentials;
use App\Models\logo;
use App\Models\messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (Auth::user()) {
            if (Auth::user()->status == 'admin' || Auth::user()->type == 'active')
            {
                return view('home');
            }
            elseif (Auth::user()->type == 'disabled' || Auth::user()->type == 'pending')
            {
                return redirect('paywithpaypal');
            }
        }
        else {
            return view('home');
        }

    }
    public function package()
    {
        $data = packages::get();
//        return $data;
        return view('packages/display',compact('data'));
    }
    public function changeLogo(Request $request)
    {
        if ($request->hasFile('LogoImage')) {
            $image = $request->LogoImage;
                $photoName = rand(1, 9999999) .time(). '.' . $image->getClientOriginalExtension();
                $image->move(public_path('avatars'), $photoName);
                $input['image'] = $photoName;
                $input['status']='1';
                 DB::update("update logo set image='$photoName' where id=1");
            }
        return redirect(url('home'));
    }
    public function paypal()
    {
        $credit = paypalCredentials::get();
        return view('paypal_credentials.display',compact('credit'));
    }
    public function EditHeaders()
    {
        $header = DB::select('select * from header');
        return view('header_title',compact('header'));
    }
    public function SocialLink()
    {
        $socialLinks = DB::select('select * from social_link');
        return view('socialLinks',compact('socialLinks'));
    }
    public function updateHeader(Request $request)
    {
        $title=$request->title;
        $id=$request->id;
        DB::update("update header set title='$title' where id='$id' ");
        $header = DB::select('select * from header');
        return view('header_title',compact('header'));
    }
    public function updateLink(Request $request)
    {
        $link=$request->links;
        $id=$request->id;
        DB::update("update social_link set links='$link' where id='$id' ");
        $socialLinks = DB::select('select * from social_link');
        return view('socialLinks',compact('socialLinks'));
    }
    public function Messages()
    {
        $message = messages::get();
        return view('messages',compact('message'));
    }
    public function sendMessage(Request $request)
    {
        $message = $request->all();
        messages::create($message);
        return redirect('home');
    }
    public function regUsers()
    {
        if (Auth::user()->status == 'distributor')
        {
            $id = Auth::user()->distributor_id;
            $dist = distributor::whereId($id)->first();
            $code = $dist->code;
            $registered_user = users::where('distributor_code',$code)->get();
            return view('registeredUsers.index')->with('registered_user',$registered_user);
        }
        else
        {
            return redirect('/home');
        }
    }
    public function viewUser($id)
    {
        if (Auth::user()->status == 'distributor')
        {
            $registered_user = users::whereId($id)->first();
            return view('registeredUsers.show')->with('registered_user',$registered_user);
        }
        else
        {
            return redirect('/home');
        }
    }
    public function changeType($val)
    {
        $input['package_type'] = $val;
        users::whereId(Auth::user()->id)->update($input);
        $package = packages::whereId(Auth::user()->package)->first();
        $result = [];
        if (Auth::user()->user_type == 'new')
        {
            $total = (float)$package->initial_setup + (float)$package->yearly_subscribe;
            $result[0] = 1;
            $result[1] = $package->initial_setup;
            $result[2] = $package->yearly_subscribe;
            $result[3] = $total;
            return $result;
        }
        else
        {
            $result[0] = 2;
            $result[2] = $package->yearly_subscribe;
            $result[3] = $package->yearly_subscribe;
            return $result;
        }
    }
    public function changePackage($id)
    {
        $users = users::whereId($id)->first();
        return view('users.change')->with('users',$users);
    }
    public function changeData($id,$pid)
    {

        $users = users::whereId($id)->first();
        $package = packages::whereId($users->package)->first();
        $packages = packages::whereId($pid)->first();
        $result = [];
        $result[0] = $packages->id;
        $result[1] = $packages->package_name;
        $result[2] = $packages->initial_setup;
        $result[3] = $packages->yearly_subscribe;
        $result[4] = 0;
        if ((float)$package->yearly_subscribe > (float)$packages->yearly_subscribe)
        {

            $result[5] = "Change the Subscription";
        }
        else
        {

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
            $diff = ($day*(float)$packages->yearly_subscribe)/365;
            $diff = number_format((float)$diff, 2, '.', '');

//            $diff = ((float)$packages->yearly_subscribe) - (float)$package->yearly_subscribe;
            $result[4] = $diff;
            $result[5] = "Proceed to Pay";
        }
        return $result;
    }
    public function CancelChange($id)
    {
        return redirect('dashboard');
    }
    public function packageChange()
    {
        $msg = DB::table('changePackage')->whereId(1)->first();
        return view('packages.change')->with('msg',$msg);
    }
    public function changePAckge(Request $request)
    {
        $update['message'] = $request->changeMessage;
        $t = DB::table('changePackage')->whereId(1)->update($update);
        $msg = DB::table('changePackage')->whereId(1)->get();
        return redirect('change/pakage/message');
    }
    public function changePAckgeMsg()
    {
        $msg = DB::table('changePackage')->whereId(1)->first();
        return view('packages.showChange')->with('msg',$msg);
    }

}
