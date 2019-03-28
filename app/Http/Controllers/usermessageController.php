<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateusermessageRequest;
use App\Http\Requests\UpdateusermessageRequest;
use App\Repositories\usermessageRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\usermessage;
use App\Models\packages;
use App\User;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class usermessageController extends AppBaseController
{
    /** @var  usermessageRepository */
    private $usermessageRepository;

    public function __construct(usermessageRepository $usermessageRepo)
    {
        $this->middleware('auth');
        $this->usermessageRepository = $usermessageRepo;
    }

    /**
     * Display a listing of the usermessage.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        $user = User::whereId(Auth::user()->id)->first();

        $public_key = $user->public_key;
        $private_key = $user->private_key;
        $totalMsg = usermessage::where('userid',Auth::user()->id)->count();

        $package = packages::whereId((int)$user->package)->first();
        $limitMsg = (int)$package->no_of_limit_messages;

        if ($totalMsg<$limitMsg)
        {
            $newMsg = 1;
        }
        else
        {
            $newMsg = 0;
        }
        $usermessages = usermessage::where('userid',Auth::user()->id)->orderby('id')->get();
//        $usermessages->message = $decrypted;

        return view('usermessages.index',compact('newMsg','usermessages','public_key','private_key'));
    }

    /**
     * Show the form for creating a new usermessage.
     *
     * @return Response
     */
    public function create()
    {
        if (usermessage::where('userid',Auth::user()->id)->exists())
        {
            $userMsg = usermessage::where('userid',Auth::user()->id)->orderby('id','desc')->first();
            $msgId = (int)$userMsg->msgid+1;
        }
        else
        {
            $msgId = 1;
        }
        return view('usermessages.create',compact('msgId'));
    }

    /**
     * Store a newly created usermessage in storage.
     *
     * @param CreateusermessageRequest $request
     *
     * @return Response
     */
    public function store(CreateusermessageRequest $request)
    {
//        return $request->all();
        $user = User::whereId(Auth::user()->id)->first();

        $public_key = $user->public_key;
        $private_key = $user->private_key;

        $text = $request->message;
        $text2= $request->emails;
        openssl_public_encrypt($text, $encrypted, $public_key);
        openssl_public_encrypt($text2, $encrypted2, $public_key);
        $encrypted_hex = bin2hex($encrypted);
        $encrypted_hex2 = bin2hex($encrypted2);

        $input['message'] = $encrypted_hex;
        $input['msgid'] = $request->msgid;
        $input['userid'] = $request->userid;
        $input['emails'] = $encrypted_hex2;

        $usermessage = $this->usermessageRepository->create($input);

        Flash::success('Message saved successfully.');

        return redirect(route('usermessages.index'));
    }

    /**
     * Display the specified usermessage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $usermessage = $this->usermessageRepository->findWithoutFail($id);
        $msg = $usermessage->message;
        $email = $usermessage->emails;
        $encrypted=hex2bin($msg);
        $encrypted2=hex2bin($email);
        openssl_private_decrypt($encrypted, $decrypted, Auth::user()->private_key);
        openssl_private_decrypt($encrypted2, $decrypted2, Auth::user()->private_key);
        $usermessage->message = $decrypted;
        $usermessage->emails = $decrypted2;
        if (empty($usermessage)) {
            Flash::error('Message not found');

            return redirect(route('usermessages.index'));
        }

        return view('usermessages.show')->with('usermessage', $usermessage);
    }

    /**
     * Show the form for editing the specified usermessage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $usermessage = $this->usermessageRepository->findWithoutFail($id);
        $msg = $usermessage->message;
        $email = $usermessage->emails;
        $encrypted=hex2bin($msg);
        $encrypted2=hex2bin($email);
        openssl_private_decrypt($encrypted, $decrypted, Auth::user()->private_key);
        openssl_private_decrypt($encrypted2, $decrypted2, Auth::user()->private_key);
        $usermessage->message = $decrypted;
        $usermessage->emails = $decrypted2;
        if (usermessage::where('userid',Auth::user()->id)->exists())
        {
            $userMsg = usermessage::where('userid',Auth::user()->id)->orderby('id','desc')->first();
            $msgId = (int)$userMsg->msgid+1;
        }
        else
        {
            $msgId = 1;
        }
        if (empty($usermessage)) {
            Flash::error('Message not found');

            return redirect(route('usermessages.index'));
        }

        return view('usermessages.edit',compact('msgId','usermessage','decrypted'));
    }

    /**
     * Update the specified usermessage in storage.
     *
     * @param  int              $id
     * @param UpdateusermessageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateusermessageRequest $request)
    {
        $maxDays = Auth::user()->days_remember_to_login+1;
        if (round($request->day )<= Auth::user()->days_remember_to_login)
        {
            Flash::error('Days should be grater than '.$maxDays.' days');
            return redirect(route('usermessages.index'));
        }
        $usermessage = $this->usermessageRepository->findWithoutFail($id);

        if (empty($usermessage)) {
            Flash::error('Message not found');

            return redirect(route('usermessages.index'));
        }

        $user = User::whereId(Auth::user()->id)->first();

        $public_key = $user->public_key;
        $private_key = $user->private_key;

        $text = $request->message;
        $text2 = $request->emails;

        openssl_public_encrypt($text, $encrypted, $public_key);
        openssl_public_encrypt($text2, $encrypted2, $public_key);
        $encrypted_hex = bin2hex($encrypted);
        $encrypted_hex2 = bin2hex($encrypted2);

        $update['message'] = $encrypted_hex;
        $update['msgid'] = $request->msgid;
        $update['userid'] = $request->userid;
        $update['day'] = round($request->day);
        $update['emails'] = $encrypted_hex2;

        usermessage::whereId($id)->update($update);

        Flash::success('Message updated successfully.');

        return redirect(route('usermessages.index'));
    }

    /**
     * Remove the specified usermessage from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $usermessage = $this->usermessageRepository->findWithoutFail($id);

        if (empty($usermessage)) {
            Flash::error('Message not found');

            return redirect(route('usermessages.index'));
        }

        $this->usermessageRepository->delete($id);

        Flash::success('Message deleted successfully.');

        return redirect(route('usermessages.index'));
    }
}
