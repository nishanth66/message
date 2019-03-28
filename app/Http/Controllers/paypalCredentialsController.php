<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepaypalCredentialsRequest;
use App\Http\Requests\UpdatepaypalCredentialsRequest;
use App\Models\paypalCredentials;
use App\Repositories\paypalCredentialsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class paypalCredentialsController extends AppBaseController
{

    /** @var  paypalCredentialsRepository */
    private $paypalCredentialsRepository;

    public function __construct(paypalCredentialsRepository $paypalCredentialsRepo)
    {
        $this->middleware('auth');
        $this->paypalCredentialsRepository = $paypalCredentialsRepo;
    }

    /**
     * Display a listing of the paypalCredentials.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->paypalCredentialsRepository->pushCriteria(new RequestCriteria($request));
        $paypalCredentials = $this->paypalCredentialsRepository->all();

        return view('paypal_credentials.index')
            ->with('paypalCredentials', $paypalCredentials);
    }

    /**
     * Show the form for creating a new paypalCredentials.
     *
     * @return Response
     */
    public function create()
    {
        return view('paypal_credentials.create');
    }

    /**
     * Store a newly created paypalCredentials in storage.
     *
     * @param CreatepaypalCredentialsRequest $request
     *
     * @return Response
     */
    public function store(CreatepaypalCredentialsRequest $request)
    {
        $input = $request->all();

        $paypalCredentials = $this->paypalCredentialsRepository->create($input);

        Flash::success('Paypal Credentials saved successfully.');

        return redirect(route('paypalCredentials.index'));
    }

    /**
     * Display the specified paypalCredentials.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $paypalCredentials = $this->paypalCredentialsRepository->findWithoutFail($id);

        if (empty($paypalCredentials)) {
            Flash::error('Paypal Credentials not found');

            return redirect(route('paypalCredentials.index'));
        }

        return view('paypal_credentials.show')->with('paypalCredentials', $paypalCredentials);
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
        $paypalCredentials = $this->paypalCredentialsRepository->findWithoutFail($id);

        if (empty($paypalCredentials)) {
            Flash::error('Paypal Credentials not found');

            return redirect(route('paypalCredentials.index'));
        }

        return view('paypal_credentials.edit')->with('paypalCredentials', $paypalCredentials);
    }

    /**
     * Update the specified paypalCredentials in storage.
     *
     * @param  int              $id
     * @param UpdatepaypalCredentialsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepaypalCredentialsRequest $request)
    {
        $paypalCredentials = $this->paypalCredentialsRepository->findWithoutFail($id);

        if (empty($paypalCredentials)) {
            Flash::error('Paypal Credentials not found');

            return redirect(route('paypalCredentials.index'));
        }

        $paypalCredentials = $this->paypalCredentialsRepository->update($request->all(), $id);

        Flash::success('Paypal Credentials updated successfully.');

        return redirect(route('paypalCredentials.index'));
    }

    /**
     * Remove the specified paypalCredentials from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $paypalCredentials = $this->paypalCredentialsRepository->findWithoutFail($id);

        if (empty($paypalCredentials)) {
            Flash::error('Paypal Credentials not found');

            return redirect(route('paypalCredentials.index'));
        }

        $this->paypalCredentialsRepository->delete($id);

        Flash::success('Paypal Credentials deleted successfully.');

        return redirect(route('paypalCredentials.index'));
    }

    public function createIndex()
    {
        if (DB::table('default_reminder')->exists())
        {
            $reminder = DB::table('default_reminder')->first();
            return redirect(route(''))
        }
    }
}
