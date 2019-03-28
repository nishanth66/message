<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatelandingRequest;
use App\Http\Requests\UpdatelandingRequest;
use App\Repositories\landingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Validator;
use App\Models\landing;
use App\Models\slideImage;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class landingController extends AppBaseController
{
    /** @var  landingRepository */
    private $landingRepository;

    public function __construct(landingRepository $landingRepo)
    {
        $this->middleware('auth');
        $this->landingRepository = $landingRepo;
    }

    /**
     * Display a listing of the landing.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->landingRepository->pushCriteria(new RequestCriteria($request));
        $landings = $this->landingRepository->all();

        return view('landings.index')
            ->with('landings', $landings);
    }

    /**
     * Show the form for creating a new landing.
     *
     * @return Response
     */
    public function create()
    {
        return view('landings.create');
    }

    /**
     * Store a newly created landing in storage.
     *
     * @param CreatelandingRequest $request
     *
     * @return Response
     */
    public function store(CreatelandingRequest $request)
    {
//        return $request->all();
        $input = $request->except('image');
//        return $input;
        $landing = $this->landingRepository->create($input);

        if ($request->image !='' || (!empty($request->image))) {
//            return "image";
            foreach ($request->image as $image) {
                $imageInput = [];
                $photoName = rand(1, 9999999) .time(). '.' . $image->getClientOriginalExtension();
                $image->move(public_path('avatars'), $photoName);
                $imageInput['image'] = $photoName;
                $imageInput['parent_id'] = $landing->id;
                slideImage::create($imageInput);
            }
        }
//        return "no image";


        Flash::success('Landing saved successfully.');

        return redirect(route('landings.index'));
    }

    /**
     * Display the specified landing.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $landing = $this->landingRepository->findWithoutFail($id);

        if (empty($landing)) {
            Flash::error('Landing not found');

            return redirect(route('landings.index'));
        }

        return view('landings.show')->with('landing', $landing);
    }

    /**
     * Show the form for editing the specified landing.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $landing = $this->landingRepository->findWithoutFail($id);

        if (empty($landing)) {
            Flash::error('Landing not found');

            return redirect(route('landings.index'));
        }

        return view('landings.edit')->with('landing', $landing);
    }

    /**
     * Update the specified landing in storage.
     *
     * @param  int              $id
     * @param UpdatelandingRequest $request
     *
     * @return Response
     */
    public function update(UpdatelandingRequest $request)
    {
        $landing = $this->landingRepository->findWithoutFail($request->id);

        if (empty($landing)) {
            Flash::error('Landing not found');
            return redirect(route('landings.index'));
        }
        $inputUpdate = $request->except('image','id','main_image');

        if ($request->hasFile('main_image'))
        {
            $photoName1 = rand(1,777777777).time().'.'.$request->main_image->getClientOriginalExtension();
            $request->main_image->move(public_path('avatars'), $photoName1);
            $inputUpdate['main_image']=$photoName1;
        }
        $landing = $this->landingRepository->update($inputUpdate,$request->id);
        if( $request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imageInput = [];
                $photoName = rand(1,777777777).time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('avatars'), $photoName);
                $imageInput['image'] = $photoName;
                $imageInput['parent_id'] = $landing->id;
                slideImage::create($imageInput);
            }
        }

        Flash::success('Landing updated successfully.');

        return redirect(route('landings.index'));
    }

    /**
     * Remove the specified landing from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $landing = $this->landingRepository->findWithoutFail($id);

        if (empty($landing)) {
            Flash::error('Landing not found');

            return redirect(route('landings.index'));
        }

        $this->landingRepository->delete($id);

        Flash::success('Landing deleted successfully.');

        return redirect(route('landings.index'));
    }
    public function DeleteImg($id)
    {
        slideImage::whereId($id)->forcedelete();
    }
}
