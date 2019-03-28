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

class paypalDetailsController extends AppBaseController
{

    /** @var  paypalCredentialsRepository */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the paypalCredentials.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        $paypals = DB::table('paypal_details')->get();
        return view('paypalDetails.display',compact('paypals'));
    }

    /**
     * Show the form for creating a new paypalCredentials.
     *
     * @return Response
     */
    public function create()
    {
        $currencies = array(
            'Australian dollar' => 'AUD',
            'Brazilian real' => 'BRL',
            'Canadian dollar' => 'CAD',
            'Czech koruna' => 'CZK',
            'Danish krone' => 'DKK',
            'Euro' => 'EUR',
            'Hong Kong dollar' => 'HKD',
            'Hungarian forint' => 'HUF',
            'Indian rupee' => 'INR',
            'Israeli new shekel' => 'ILS',
            'Japanese yen' => 'JPY',
            'Malaysian ringgit' => 'MYR',
            'Mexican peso' => 'MXN',
            'New Taiwan dollar' => 'TWD',
            'New Zealand dollar' => 'NZD',
            'Norwegian krone' => 'NOK',
            'Philippine peso' => 'PHP',
            'Polish złoty'=> 'PLN',
            'Pound sterling'=> 'GBP',
            'Russian ruble'=> 'RUB',
            'Singapore dollar'=> 'SGD',
            'Swedish krona'=> 'SEK',
            'Swiss franc'=> 'CHF',
            'Thai baht'=> 'THB',
            'United States dollar'=> 'USD',
        );

        return view('paypalDetails.add',compact('currencies'));
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
        $input = $request->except('_token');
        $input['client_id'] = str_replace(' ','',$request->client_id);
        $input['client_secrete'] = str_replace(' ','',$request->client_secrete);
        if (DB::table('paypal_details')->where('status',1)->exists() == 0)
        {
            $input['status'] = 1;
        }
        else
        {
            $input['status'] = 0;
        }
        DB::table('paypal_details')->insert($input);
        Flash::success('Credential Saved Successfully');
        return redirect(route('paypalClientCredentials.index'));
    }

    /**
     * Display the specified paypalCredentials.
     *
     * @param  int $id
     *
     * @return Response
     */

    /**
     * Show the form for editing the specified paypalCredentials.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $currencies = array(
            'Australian dollar' => 'AUD',
            'Brazilian real' => 'BRL',
            'Canadian dollar' => 'CAD',
            'Czech koruna' => 'CZK',
            'Danish krone' => 'DKK',
            'Euro' => 'EUR',
            'Hong Kong dollar' => 'HKD',
            'Hungarian forint' => 'HUF',
            'Indian rupee' => 'INR',
            'Israeli new shekel' => 'ILS',
            'Japanese yen' => 'JPY',
            'Malaysian ringgit' => 'MYR',
            'Mexican peso' => 'MXN',
            'New Taiwan dollar' => 'TWD',
            'New Zealand dollar' => 'NZD',
            'Norwegian krone' => 'NOK',
            'Philippine peso' => 'PHP',
            'Polish złoty'=> 'PLN',
            'Pound sterling'=> 'GBP',
            'Russian ruble'=> 'RUB',
            'Singapore dollar'=> 'SGD',
            'Swedish krona'=> 'SEK',
            'Swiss franc'=> 'CHF',
            'Thai baht'=> 'THB',
            'United States dollar'=> 'USD',
        );
        $paypal = DB::table('paypal_details')->whereId($id)->first();
        return view('paypalDetails.update',compact('paypal','currencies'));
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
        $update = $request->except('_token','_method');
        $update['client_id'] = str_replace(' ','',$request->client_id);
        $update['client_secrete'] = str_replace(' ','',$request->client_secrete);
        DB::table('paypal_details')->whereId($id)->update($update);
        Flash::success('Credential Updated Successfully');
        return redirect(route('paypalClientCredentials.index'));
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
        DB::table('paypal_details')->whereId($id)->where('status','!=',1)->delete();
        Flash::success('Credential Deleted Successfully');
        return redirect(route('paypalClientCredentials.index'));
    }
    public function activateCard($id)
    {
        DB::table('paypal_details')->where('status',1)->update(['status'=>0]);
        DB::table('paypal_details')->whereId($id)->update(['status'=>1]);
        Flash::success("Credential Activated Successfully");
        return redirect(route('paypalClientCredentials.index'));
    }
}
