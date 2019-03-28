<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepackagesRequest;
use App\Http\Requests\UpdatepackagesRequest;
use App\Repositories\packagesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class packagesController extends AppBaseController
{
    /** @var  packagesRepository */
    private $packagesRepository;

    public function __construct(packagesRepository $packagesRepo)
    {
        $this->middleware('auth');
        $this->packagesRepository = $packagesRepo;
    }

    /**
     * Display a listing of the packages.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->packagesRepository->pushCriteria(new RequestCriteria($request));
        $packages = $this->packagesRepository->all();

        return view('packages.index')
            ->with('packages', $packages);
    }

    /**
     * Show the form for creating a new packages.
     *
     * @return Response
     */
    public function create()
    {
        return view('packages.create');
    }

    /**
     * Store a newly created packages in storage.
     *
     * @param CreatepackagesRequest $request
     *
     * @return Response
     */
    public function store(CreatepackagesRequest $request)
    {
        $input = $request->all();

        $packages = $this->packagesRepository->create($input);

        Flash::success('Packages saved successfully.');

        return redirect(route('packages.index'));
    }

    /**
     * Display the specified packages.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $packages = $this->packagesRepository->findWithoutFail($id);

        if (empty($packages)) {
            Flash::error('Packages not found');

            return redirect(route('packages.index'));
        }

        return view('packages.show')->with('packages', $packages);
    }

    /**
     * Show the form for editing the specified packages.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $packages = $this->packagesRepository->findWithoutFail($id);

        if (empty($packages)) {
            Flash::error('Packages not found');

            return redirect(route('packages.index'));
        }

        return view('packages.edit')->with('packages', $packages);
    }

    /**
     * Update the specified packages in storage.
     *
     * @param  int              $id
     * @param UpdatepackagesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepackagesRequest $request)
    {
        $packages = $this->packagesRepository->findWithoutFail($id);

        if (empty($packages)) {
            Flash::error('Packages not found');

            return redirect(route('packages.index'));
        }

        $packages = $this->packagesRepository->update($request->all(), $id);

        Flash::success('Packages updated successfully.');

        return redirect(route('packages.index'));
    }

    /**
     * Remove the specified packages from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $packages = $this->packagesRepository->findWithoutFail($id);

        if (empty($packages)) {
            Flash::error('Packages not found');

            return redirect(route('packages.index'));
        }

        $this->packagesRepository->delete($id);

        Flash::success('Packages deleted successfully.');

        return redirect(route('packages.index'));
    }
}
