<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateadddistributorRequest;
use App\Http\Requests\UpdateadddistributorRequest;
use App\Repositories\adddistributorRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class adddistributorController extends AppBaseController
{
    /** @var  adddistributorRepository */
    private $adddistributorRepository;

    public function __construct(adddistributorRepository $adddistributorRepo)
    {
        $this->adddistributorRepository = $adddistributorRepo;
    }

    /**
     * Display a listing of the adddistributor.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->adddistributorRepository->pushCriteria(new RequestCriteria($request));
        $adddistributors = $this->adddistributorRepository->all();

        return view('adddistributors.index')
            ->with('adddistributors', $adddistributors);
    }

    /**
     * Show the form for creating a new adddistributor.
     *
     * @return Response
     */
    public function create()
    {
        return view('adddistributors.create');
    }

    /**
     * Store a newly created adddistributor in storage.
     *
     * @param CreateadddistributorRequest $request
     *
     * @return Response
     */
    public function store(CreateadddistributorRequest $request)
    {
        $input = $request->all();

        $adddistributor = $this->adddistributorRepository->create($input);

        Flash::success('Add Distributor saved successfully.');

        return redirect(route('adddistributors.index'));
    }

    /**
     * Display the specified adddistributor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $adddistributor = $this->adddistributorRepository->findWithoutFail($id);

        if (empty($adddistributor)) {
            Flash::error('Add Distributor not found');

            return redirect(route('adddistributors.index'));
        }

        return view('adddistributors.show')->with('adddistributor', $adddistributor);
    }

    /**
     * Show the form for editing the specified adddistributor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $adddistributor = $this->adddistributorRepository->findWithoutFail($id);

        if (empty($adddistributor)) {
            Flash::error('Adddistributor not found');

            return redirect(route('adddistributors.index'));
        }

        return view('adddistributors.edit')->with('adddistributor', $adddistributor);
    }

    /**
     * Update the specified adddistributor in storage.
     *
     * @param  int $id
     * @param UpdateadddistributorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateadddistributorRequest $request)
    {
        $adddistributor = $this->adddistributorRepository->findWithoutFail($id);

        if (empty($adddistributor)) {
            Flash::error('Add Distributor not found');

            return redirect(route('adddistributors.index'));
        }

        $adddistributor = $this->adddistributorRepository->update($request->all(), $id);

        Flash::success('Add Distributor updated successfully.');

        return redirect(route('adddistributors.index'));
    }

    /**
     * Remove the specified adddistributor from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $adddistributor = $this->adddistributorRepository->findWithoutFail($id);

        if (empty($adddistributor)) {
            Flash::error('Add Distributor not found');

            return redirect(route('adddistributors.index'));
        }

        $this->adddistributorRepository->delete($id);

        Flash::success('Add Distributor deleted successfully.');

        return redirect(route('adddistributors.index'));

    }
}
