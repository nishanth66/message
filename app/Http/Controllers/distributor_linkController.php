<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createdistributor_linkRequest;
use App\Http\Requests\Updatedistributor_linkRequest;
use App\Models\distributor;
use App\Models\distributor_link;
use App\Models\packages;
use App\Repositories\distributor_linkRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class distributor_linkController extends AppBaseController
{
    /** @var  distributor_linkRepository */
    private $distributorLinkRepository;

    public function __construct(distributor_linkRepository $distributorLinkRepo)
    {
        $this->middleware('auth');
        $this->distributorLinkRepository = $distributorLinkRepo;
    }

    /**
     * Display a listing of the distributor_link.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->distributorLinkRepository->pushCriteria(new RequestCriteria($request));
        $distributorLinks = $this->distributorLinkRepository->all();

        return view('distributor_links.index')
            ->with('distributorLinks', $distributorLinks);
    }

    /**
     * Show the form for creating a new distributor_link.
     *
     * @return Response
     */
    public function create()
    {
        $packages = packages::get();
        return view('distributor_links.create',compact('packages'));
    }

    /**
     * Store a newly created distributor_link in storage.
     *
     * @param Createdistributor_linkRequest $request
     *
     * @return Response
     */
    public function store(Createdistributor_linkRequest $request)
    {
        $input = $request->all();
        $package = packages::whereId($request->package)->first();
        $input['price'] = (float)$package->yearly_subscribe;
        $input['commission'] = (float)$package->commission;

        $distributorLink = $this->distributorLinkRepository->create($input);

        Flash::success('Distributor Link saved successfully.');

        return redirect(route('distributorLinks.index'));
    }

    /**
     * Display the specified distributor_link.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $distributorLink = $this->distributorLinkRepository->findWithoutFail($id);

        if (empty($distributorLink)) {
            Flash::error('Distributor Link not found');

            return redirect(route('distributorLinks.index'));
        }

        return view('distributor_links.show')->with('distributorLink', $distributorLink);
    }

    /**
     * Show the form for editing the specified distributor_link.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $distributorLink = $this->distributorLinkRepository->findWithoutFail($id);

        if (empty($distributorLink)) {
            Flash::error('Distributor Link not found');

            return redirect(route('distributorLinks.index'));
        }
        $packages = packages::get();
        return view('distributor_links.edit',compact('distributorLink','packages'));
    }

    /**
     * Update the specified distributor_link in storage.
     *
     * @param  int              $id
     * @param Updatedistributor_linkRequest $request
     *
     * @return Response
     */
    public function update($id, Updatedistributor_linkRequest $request)
    {
        $distributorLink = $this->distributorLinkRepository->findWithoutFail($id);

        if (empty($distributorLink)) {
            Flash::error('Distributor Link not found');

            return redirect(route('distributorLinks.index'));
        }
        $input = $request->all();
        $package = packages::whereId($request->package)->first();
        $input['price'] = (float)$package->yearly_subscribe;
        $input['commission'] = (float)$package->commission;
        $distributorLink = $this->distributorLinkRepository->update($input, $id);

        Flash::success('Distributor Link updated successfully.');

        return redirect(route('distributorLinks.index'));
    }

    /**
     * Remove the specified distributor_link from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $distributorLink = $this->distributorLinkRepository->findWithoutFail($id);

        if (empty($distributorLink)) {
            Flash::error('Distributor Link not found');

            return redirect(route('distributorLinks.index'));
        }

        $this->distributorLinkRepository->delete($id);

        Flash::success('Distributor Link deleted successfully.');

        return redirect(route('distributorLinks.index'));
    }
    public function getPackageDetails($value)
    {
        $package = packages::whereId($value)->first();
        $result['price'] = (float)$package->yearly_subscribe;
        $result['commission'] = (float)$package->commission;
        $package_id = encrypt($package->id);
        $distributor = encrypt(Auth::user()->distributor_id);
        $result['link'] = asset('register').'/'.$package_id.'/'.$distributor;
        return $result;
    }
    public function shareLink(Request $request)
    {
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['Senderemail'] = Auth::user()->email;
        $data['Sendername'] = Auth::user()->name;
        $distLink = distributor_link::whereId($request->linkid)->first();
        $data['link'] = $distLink->link;
        Mail::send('emails.invitation', ['data' => $data], function ($message) use ($data) {
            $message->from($data['Senderemail'], $data['Sendername']);
            $message->to($data['email'], $data['name'])->subject("Invitation Link");
        });
        Flash::success('Invitation Send Successfully');
        return redirect()->back();
    }
}
