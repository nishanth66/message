<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedistributorRequest;
use App\Http\Requests\UpdatedistributorRequest;
use App\Models\packages;
use App\Models\users;
use App\Repositories\distributorRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Illuminate\Http\Request;
use App\Models\distributor;
use Flash;
use PayPal\Api\Payout;
use PayPal\Api\PayoutItem;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConfigurationException;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Exception\PayPalInvalidCredentialException;
use PayPal\Exception\PayPalMissingCredentialException;
use PayPal\Rest\ApiContext;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\DB;
use Response;

require_once public_path('TCPDF-master/examples/tcpdf_include.php');
require_once public_path('TCPDF-master/tcpdf.php');


class MYPDF extends \TCPDF {
    // Page footer
    public function Footer() {
        // Position at 25 mm from bottom
//        $this->Ln();
        // Page number
//        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
//        $this->Ln();
    }
}

class distributorController extends AppBaseController
{
    /** @var  distributorRepository */
    private $distributorRepository;

    public function __construct(distributorRepository $distributorRepo)
    {
        $this->middleware('auth');
        $this->distributorRepository = $distributorRepo;
    }

    /**
     * Display a listing of the distributor.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->distributorRepository->pushCriteria(new RequestCriteria($request));
        $distributors = $this->distributorRepository->all();

        return view('distributors.index')
            ->with('distributors', $distributors);
    }

    /**
     * Show the form for creating a new distributor.
     *
     * @return Response
     */
    public function create()
    {
        return view('distributors.create');
    }

    /**
     * Store a newly created distributor in storage.
     *
     * @param CreatedistributorRequest $request
     *
     * @return Response
     */
    public function store(CreatedistributorRequest $request)
    {
        $input = $request->except('password');
        $real_pass = $request->password;
        $input['real_pass'] = $real_pass;
        $password = bcrypt($request->password);
        $input['password'] = $password;
        $private = time().rand(9,99999999);
        $input['private_key'] = $private;
        if(distributor::where('email',$request->email)->exists())
        {
            return Redirect()->back()->withError("This email is aready exist");
        }
//        return $input;




        $input1 = $request->except('code','password','distributor_name');
        $real_pass = $request->password;
        $input1['real_pass'] = $real_pass;
        $password = bcrypt($request->password);
        $input1['password'] = $password;
        $lastUpdated = time();
        $input1['personalKey'] = $private;
        $input1['name'] = $request->distributor_name;
        $input1['lastUpdated'] = $lastUpdated;
        $input1['status'] = 'distributor';
        if(users::where('email',$request->email)->exists())
        {
            return Redirect()->back()->withError("This email is aready exist");
        }
//        return $input1;
        $d=distributor::create($input);
        $input1['distributor_id'] = $d->id;
        users::create($input1);


        Flash::success('Distributor saved successfully.');

        return redirect(route('distributors.index'));
    }


    /**
     * Display the specified distributor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $distributor = $this->distributorRepository->findWithoutFail($id);

        if (empty($distributor)) {
            Flash::error('Distributor not found');

            return redirect(route('distributors.index'));
        }

        return view('distributors.show')->with('distributor', $distributor);
    }

    /**
     * Show the form for editing the specified distributor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $distributor = $this->distributorRepository->findWithoutFail($id);

        if (empty($distributor)) {
            Flash::error('Distributor not found');

            return redirect(route('distributors.index'));
        }

        return view('distributors.edit')->with('distributor', $distributor);
    }

    /**
     * Update the specified distributor in storage.
     *
     * @param  int              $id
     * @param UpdatedistributorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedistributorRequest $request)
    {
        $input = $request->except('password','_method','_token');
        $real_pass = $request->password;
        $input['real_pass'] = $real_pass;
        $password = bcrypt($request->password);
        $input['password'] = $password;
        $private = time().rand(9,99999999);
        $lastUpdated = time();
        $input['private_key'] = $private;
        if(distributor::where('id','!=',$id)->where('email',$request->email)->exists())
        {
            return Redirect()->back()->withError("This email is aready exist");
        }
//        return $input;




        $input1 = $request->except('code','password','distributor_name','_method','_token');
        $real_pass = $request->password;
        $input1['real_pass'] = $real_pass;
        $password = bcrypt($request->password);
        $input1['password'] = $password;
        $lastUpdated = time();
        $input1['personalKey'] = $private;
        $input1['name'] = $request->distributor_name;
        $input1['lastUpdated'] = $lastUpdated;
        $input1['status'] = 'distributor';
        if(users::where('distributor_id','!=',$id)->where('email',$request->email)->exists())
        {
            return Redirect()->back()->withError("This email is aready exist");
        }
//        return $input;
        $d=distributor::whereId($id)->update($input);
        $input1['distributor_id'] = $id;
        users::where('distributor_id',$id)->update($input1);

        Flash::success('Distributor updated successfully.');

        return redirect(route('distributors.index'));
    }

    /**
     * Remove the specified distributor from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $distributor = $this->distributorRepository->findWithoutFail($id);
        $private = $distributor->private_key;
        if (empty($distributor)) {
            Flash::error('Distributor not found');

            return redirect(route('distributors.index'));
        }
        users::where('personalKey',$private)->forcedelete();
        distributor::whereId($id)->forcedelete();

        Flash::success('Distributor deleted successfully.');

        return redirect(route('distributors.index'));
    }

//    ******* functions******
    public function Updatepayment($id){
//        DB::table('distributors')
//            ->where('id', $id)
//            ->update('status ', 'paid');
        distributor::find($id)->update(['status' => 'paid']);
        return $id;
    }
    public function exportAll($id)
    {
        $distributor = distributor::whereId($id)->first();
        if(DB::table('distributor_users')->where('distributor_id',$id)->exists())
        {
            $commissions = DB::table('distributor_users')->where('distributor_id',$id)->get();
        }
        else
        {
            $commissions = "";
        }
        $date = date('m/d/Y',strtotime(time()));
        // create new PDF document
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle($id);
        $pdf->SetSubject('Invoice');
        $pdf->SetKeywords('PDF,Invoice');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+40, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set default font subsetting mode
        $pdf->setFontSubsetting(true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
// helvetica or times to reduce file size.
        $pdf->SetFont('arial', '', 12, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();
// set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        $html = <<<EOD
        <table style="width: 100%">
                <thead>
                    <tr style="height: 40px;line-height: 40px;background-color: #6193e4">
                        <th width="25%" style="width: 40%;font-family: docs-Merriweather;border: 1px solid #f3f3f3;color: white"><b>Name</b></th>
                        <th width="25%" style="width: 20%;font-family: docs-Merriweather;border: 1px solid #f3f3f3;color: white;text-align: right">Package</th>
                        <th width="25%" style="width: 20%;font-family: docs-Merriweather;border: 1px solid #f3f3f3;color: white;text-align: right">Commission</th>
                        <th width="25%" style="width: 20%;font-family: docs-Merriweather;border: 1px solid #f3f3f3;color: white;text-align: right">Paid</th>
                    </tr>
                </thead>
                <tbody>
EOD;
            foreach ($commissions as $commission) {
                $user = users::whereId($commission->userid)->first();
                $package = packages::whereId($user->package)->first();
                $html .= <<<EOD
                    <tr style="height: 30px;line-height: 30px;">
                        <td width="25%" style="color: #666666; border:1px solid #f3f3f3; width: 40%;">$user->name</td>
                        <td width="25%" style="color: #666666; border:1px solid #f3f3f3; width: 20%;text-align: right">$package->package_name</td>
                        <td width="25%" style="color: #666666; border:1px solid #f3f3f3; width: 20%;text-align: right">$$package->commission</td>
EOD;
                if ($commission->commission_paid == 0)
                {
                    $imagePath = asset('public/image/redcross.jpg');
                    $html .= <<<EOD
                        <td width="25%" style="color: #666666; border:1px solid #f3f3f3; width: 20%;text-align: right;"><img src="$imagePath" style="height: 25px;width: 25px;padding: 15px"> </td>
EOD;
                }
                else
                {
                    $imagePath = asset('public/image/greencheck.jpg');
                    $html .= <<<EOD
                    <td width="25%" style="color: #666666; border:1px solid #f3f3f3; width: 20%;text-align: right"><img src="$imagePath" style="height: 25px;width: 25px;padding: 15px"></td>
EOD;
                }
                $html .= <<<EOD
                    </tr>
EOD;

            }
            $html .= <<<EOD
                </tbody>
            </table>
EOD;
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->Output($id.'.pdf', 'D');
    }
    public function exportNew($id)
    {
        $distributor = distributor::whereId($id)->first();
        if(DB::table('distributor_users')->where('distributor_id',$id)->where('commission_paid',0)->exists())
        {
            $commissions = DB::table('distributor_users')->where('distributor_id',$id)->where('commission_paid',0)->get();
        }
        else
        {
            $commissions = "";
        }
        $date = date('m/d/Y',strtotime(time()));
        // create new PDF document
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle($id);
        $pdf->SetSubject('Invoice');
        $pdf->SetKeywords('PDF,Invoice');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+40, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set default font subsetting mode
        $pdf->setFontSubsetting(true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
// helvetica or times to reduce file size.
        $pdf->SetFont('arial', '', 12, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();
// set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        $html = <<<EOD
        <table style="width: 100%">
                <thead>
                    <tr style="height: 40px;line-height: 40px;background-color: #6193e4">
                        <th width="25%" style="width: 40%;font-family: docs-Merriweather;border: 1px solid #f3f3f3;color: white"><b>Name</b></th>
                        <th width="25%" style="width: 20%;font-family: docs-Merriweather;border: 1px solid #f3f3f3;color: white;text-align: right">Package</th>
                        <th width="25%" style="width: 20%;font-family: docs-Merriweather;border: 1px solid #f3f3f3;color: white;text-align: right">Commission</th>
                        <th width="25%" style="width: 20%;font-family: docs-Merriweather;border: 1px solid #f3f3f3;color: white;text-align: right">Paid</th>
                    </tr>
                </thead>
                <tbody>
EOD;
            foreach ($commissions as $commission) {
                $user = users::whereId($commission->userid)->first();
                $package = packages::whereId($user->package)->first();
                $html .= <<<EOD
                    <tr style="height: 30px;line-height: 30px;">
                        <td width="25%" style="color: #666666; border:1px solid #f3f3f3; width: 40%;">$user->name</td>
                        <td width="25%" style="color: #666666; border:1px solid #f3f3f3; width: 20%;text-align: right">$package->package_name</td>
                        <td width="25%" style="color: #666666; border:1px solid #f3f3f3; width: 20%;text-align: right">$$package->commission</td>
EOD;
                if ($commission->commission_paid == 0)
                {
                    $imagePath = asset('public/image/redcross.jpg');
                    $html .= <<<EOD
                        <td width="25%" style="color: #666666; border:1px solid #f3f3f3; width: 20%;text-align: right;"><img src="$imagePath" style="height: 25px;width: 25px;"> </td>
EOD;
                }
                else
                {
                    $imagePath = asset('public/image/greencheck.jpg');
                    $html .= <<<EOD
                    <td width="25%" style="color: #666666; border:1px solid #f3f3f3; width: 20%;text-align: right"><img src="$imagePath" style="height: 25px;width: 25px;"></td>
EOD;
                }
                $html .= <<<EOD
                    </tr>
EOD;

            }
            $html .= <<<EOD
                </tbody>
            </table>
EOD;
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->Output($id.'.pdf', 'D');
    }

    public function distributorPayout($id)
    {
        if (DB::table('paypal_details')->where('status',1)->exists())
        {
            $paypal = DB::table('paypal_details')->where('status',1)->first();
        }
        else
        {
            Flash::error('Please Set the Paypal Credentials Before Payout');
            return redirect()->back();
        }
        $distributor = distributor::whereId($id)->first();
        $amount = 0;
        if (DB::table('distributor_users')->where('distributor_id',$distributor->id)->where('commission_paid',0)->exists())
        {
            $commissions = DB::table('distributor_users')->where('distributor_id',$distributor->id)->where('commission_paid',0)->get();
            foreach ($commissions as $commission)
            {
                if ($commission->commission_paid == 0)
                {
                    $user = \App\User::whereId($commission->userid)->first();
                    $package = \App\Models\packages::whereId($commission->package)->first();
                    $amount +=(float)$package->commission;
                }
            }
        }
        if($distributor != '' || !empty($distributor))
        {
            $user=  User::where('distributor_id',$distributor->id)->first();
            if ($user->paypal_email != '' || !empty($user->paypal_email))
            {
                $payouts = new Payout();
                $senderBatchHeader = new PayoutSenderBatchHeader();
                $senderBatchHeader->setSenderBatchId(uniqid().microtime(true))
                    ->setEmailSubject("You have a payment");
                $senderItem = new PayoutItem();
                $senderItem->setRecipientType('Email')
                    ->setNote('Thanks you.')
                    ->setReceiver($user->paypal_email)
                    ->setSenderItemId("item_1" . uniqid().microtime('true'))
                    ->setAmount(new \PayPal\Api\Currency('{
                        "value":"'.(float)$amount.'",
                        "currency":"'.$paypal->currency.'"
                    }'));
                $payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem);
                $request = clone $payouts;
                $apiContext = new ApiContext(
                    new OAuthTokenCredential(
                        $paypal->client_id,
                        $paypal->client_secrete
                    )
                );
                try {
                    $output = $payouts->create(null, $apiContext);
                } catch (PayPalConnectionException $ex) {
                    Flash::error("Payout Error ".$ex->getMessage());
                    return redirect()->back();
                }
                catch (PayPalInvalidCredentialException $ex) {
                    Flash::error("Payout Error ".$ex->getMessage());
                    return redirect()->back();
                }
                catch (PayPalMissingCredentialException $ex) {
                    Flash::error("Payout Error ".$ex->getMessage());
                    return redirect()->back();
                }
                $update['commission_paid']=1;
                if (isset($commissions)  && $commissions != '')
                {
                    foreach ($commissions as $commission)
                    {
                        if ($commission->commission_paid == 0)
                        {
                            DB::table('distributor_users')->whereId($commission->id)->update($update);
                        }
                    }
                }
                Flash::success('Payout is Success');
                return redirect()->back();
            }
            Flash::error("Payout Error Distributor haven't setup their Paypal Email");
            return redirect()->back();
        }
        else
        {
            Flash::error("Distributor Not Found!");
            return redirect()->back();
        }
    }
    public function distributorPayoutDone($id)
    {
        if (distributor::whereId($id)->exists())
        {
            if (DB::table('distributor_users')->where('distributor_id',$id)->where('commission_paid',0)->exists())
            {
                $commissions = DB::table('distributor_users')->where('distributor_id',$id)->where('commission_paid',0)->get();
                foreach ($commissions as $commission)
                {
                    if ($commission->commission_paid == 0)
                    {
                        $update['commission_paid'] = 1;
                        DB::table('distributor_users')->whereId($commission->id)->update($update);
                    }
                }
            }
            Flash::success('Payment Marked as Done');
            return redirect()->back();
        }
        else
        {
            Flash::error('Distributor Not Found');
            return redirect()->back();
        }
    }



}
