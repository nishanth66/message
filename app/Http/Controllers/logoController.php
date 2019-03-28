<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatelogoRequest;
use App\Http\Requests\UpdatelogoRequest;
use App\Repositories\logoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class logoController extends AppBaseController
{
    /** @var  packagesRepository */
    private $logoRepository;

    public function __construct(logoRepository $logoRepo)
    {
        $this->middleware('auth');
        $this->logoRepository = $logoRepo;
    }


    public function store(CreatelogoRequest $request)
    {
        $input = $request->all();

        $logo = $this->logoRepository->create($input);

        Flash::success('Logo saved successfully.');

        return redirect(route('/home'));
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
        $packages = $this->logoRepository->findWithoutFail($id);

        if (empty($packages)) {
            Flash::error('Logo not found');

            return redirect(route('/home'));
        }

        return view('/home')->with('packages', $packages);
    }



    public function update($id, logoRepository $request)
    {
        $logo = $this->logoRepository->findWithoutFail($id);

        if (empty($logo)) {
            Flash::error('Logo not found');

            return redirect(route('/home'));
        }

        $packages = $this->logoRepository->update($request->all(), $id);

        Flash::success('Logo updated successfully.');

        return redirect(route('/home'));
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
