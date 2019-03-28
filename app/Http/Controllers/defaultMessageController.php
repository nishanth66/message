<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;

class defaultMessageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (DB::table('default_reminder')->exists())
        {
            $reminder = DB::table('default_reminder')->first();
            return view('defaultMsg.edit',compact('reminder'));
        }
        else
        {
            return redirect(route('rememberMessage.create'));
        }
    }

    /**
     * Show the form for creating a new paypalCredentials.
     *
     * @return Response
     */
    public function create()
    {
        return view('defaultMsg.create');
    }

    /**
     * Store a newly created paypalCredentials in storage.
     *
     * @param CreatepaypalCredentialsRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input['message'] = $request->message;
        DB::table('default_reminder')->insert($input);
        Flash::success('Reminder stored Successfully');
        return redirect(route('rememberMessage.index'));
    }




    /**
     * Show the form for editing the specified paypalCredentials.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $reminder = DB::table('default_reminder')->whereId($id)->first();
        if (empty($reminder))
        {
            Flash::error('Reminder not Found');
            return redirect(route('rememberMessage.index'));
        }
        return view('defaultMsg.edit',compact('reminder'));
    }

    /**
     * Update the specified paypalCredentials in storage.
     *
     * @param  int              $id
     * @param UpdatepaypalCredentialsRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $reminder = DB::table('default_reminder')->whereId($id)->first();
        if (empty($reminder))
        {
            Flash::error('Reminder not Found');
            return redirect(route('rememberMessage.index'));
        }
        $input['message'] = $request->message;
        DB::table('default_reminder')->whereId($id)->update($input);
        Flash::success('Reminder Updated Successfully');
        return redirect(route('rememberMessage.index'));
    }
}
