<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Models\distributor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    protected function authenticated()
    {
        $update['lastUpdated'] = time();
        $update['lastreminder'] = null;
        $update['schedule_reminder'] = null;
//        $update['counter'] = 0;
        $update['lastLogin'] = new \DateTime();
        $user1 = auth()->user();
        User::whereId($user1->id)->update($update);
        if (Auth::attempt(['email' => $user1->email, 'password' => $user1->password, 'name' => $user1->name, 'deleted_at' => null])) {
            // Authentication passed...
            return redirect()->intended('/home');
        } else {
            return back()->withInput();
        }



    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

            $private = $data['personalKey'];
            $config = array(
                "digest_alg" => $private,
                "private_key_bits" => 4096,
                "private_key_type" => OPENSSL_KEYTYPE_RSA,
            );
            $res = openssl_pkey_new($config);

            openssl_pkey_export($res, $private_key);

            $public_key = openssl_pkey_get_details($res);
            $public_key_c = $public_key["key"];
            $lastUpdated = time();
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'real_pass' => $data['password'],
                'package' => $data['package'],
                'days_remember_to_login' => $data['days_remember_to_login'],
                'personalKey' => $private,
                'lastUpdated' => $lastUpdated,
                'distributor_code' => $data['distributor_code'],
                'status' => "user",
                'lastreminder' => "",
                'user_type' => 'new',
                'private_key' => $private_key,
                'public_key' => $public_key_c,
            ]);
    }
}
