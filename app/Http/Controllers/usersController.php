<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateusersRequest;
use App\Http\Requests\UpdateusersRequest;
use App\Models\distributor;
use App\Models\packages;
use App\Repositories\usersRepository;
use App\Models\users;
use App\Http\Controllers\AppBaseController;
use App\User;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\usermessage;

class usersController extends AppBaseController
{
    /** @var  usersRepository */
    private $usersRepository;

    public function __construct(usersRepository $usersRepo)
    {
        $this->middleware('auth');
        $this->usersRepository = $usersRepo;
    }

    /**
     * Display a listing of the users.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->usersRepository->pushCriteria(new RequestCriteria($request));
        $users = users::where('status','user')->get();

        return view('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new users.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created users in storage.
     *
     * @param CreateusersRequest $request
     *
     * @return Response
     */
    public function store(CreateusersRequest $request)
    {
        $input = $request->except('password');
//        $real_pass = $request->password;
//        $input['real_pass'] = $real_pass;
        $password = bcrypt($request->password);
        $input['password'] = $password;
        $private = time().rand(9,99999999);
        $lastUpdated = time();
        $input1['personalKey'] = $request->personalKey;
        $input['lastUpdated'] = $lastUpdated;
        $input['status'] = "user";
        $input['user_type'] = "new";

        $users = $this->usersRepository->create($input);

        Flash::success('Users saved successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified users.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $users = $this->usersRepository->findWithoutFail($id);
        $package = packages::whereId($users->package)->first();
        if (empty($users)) {
            Flash::error('Users not found');

            return redirect(route('users.index'));
        }

        return view('users.show',compact('users','package'));
    }

    /**
     * Show the form for editing the specified users.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->usersRepository->findWithoutFail($id);
        $packages = packages::get();
        if (empty($user)) {
            Flash::error('Users not found');

            return redirect(route('users.index'));
        }

        return view('users.editUser',compact('user','packages'));
    }

    /**
     * Update the specified users in storage.
     *
     * @param  int              $id
     * @param UpdateusersRequest $request
     *
     * @return Response
     */
    public function update($id,Request $request)
    {
        $update = $request->except('password','_token','save','status','distributor_id','code','personalKey');

        $private = $request->personalKey;
        $config = array(
            "digest_alg" => $private,
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $res = openssl_pkey_new($config);

        openssl_pkey_export($res, $private_key);

        $public_key = openssl_pkey_get_details($res);
        $public_key_c = $public_key["key"];

        $usermsgs = usermessage::where('userid',$id)->get();
        $public_old = Auth::user()->public_key;
        $private_old = Auth::user()->private_key;
        foreach($usermsgs as $usermsg)
        {
            $msg = $usermsg->message;
            $encrypted = hex2bin($msg);
            openssl_private_decrypt($encrypted, $decrypted, $private_old);
            $text = $decrypted;
            openssl_public_encrypt($text, $encrypted, $public_key_c);
            $encrypted_hex = bin2hex($encrypted);
            usermessage::whereId($usermsg->id)->update(['message'=>$encrypted_hex]);
        }
        $update['private_key'] = $private_key;
        $update['public_key'] = $public_key_c;
        $update['personalKey'] = $private;

        User::whereId($id)->update($update);
        if ($request->status == 'distributor')
        {
            $update1 = $request->except('password','_token','save','status','distributor_id','name','personalKey');
            $update1['code'] = $request->code;
            $update1['distributor_name'] = $request->name;
//            $update1['real_pass'] = $real_pass;
//            $pass = bcrypt($request->password);
//            $update1['password'] = $pass;
            distributor::whereId($request->distributor_id)->update($update1);
        }

        Flash::success('Users updated successfully.');
        return redirect('/dashboard');

    }

    /**
     * Remove the specified users from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $users = $this->usersRepository->findWithoutFail($id);

        if (empty($users)) {
            Flash::error('Users not found');

            return redirect(route('users.index'));
        }

        $this->usersRepository->delete($id);

        Flash::success('Users deleted successfully.');

        return redirect(route('users.index'));
    }
    public function editProfile($id)
    {
        return view('users.edit');
    }
    public function update2($id,Request $request)
    {
        $update = $request->except('_token');
        users::whereId($id)->update($update);
        Flash::success('User Updated Successfully');
        return redirect(route('users.index'));
    }
}
