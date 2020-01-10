<?php

namespace RamzyVirani\RateAndReview\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\UserRepository;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;
use RamzyVirani\RateAndReview\Requests\Admin\CreateReviewRequest;
use RamzyVirani\RateAndReview\Requests\Admin\UpdateReviewRequest;

class ReviewController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    private $reviewRepository;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->reviewRepository = app()->make(config('rateandreview.fqdn.Repository'));
        $this->userRepository   = $userRepo;
        $this->ModelName        = 'reviews';
        $this->BreadCrumbName   = 'Reviews';
    }

    /**
     * Display a listing of the Review.
     *
     * @return Response
     */
    public function index()
    {
        $reviewDataTable = app()->make(config('rateandreview.fqdn.DataTable'));

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $reviewDataTable->render('rateandreview::index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Review.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);

        $users = $this->userRepository->resetCriteria()->all();

        $range = range(0, 10);
        array_walk($range, function (&$value, $key) {
            $value .= " Star(s)";
        });

        $types = config('rateandreview.fqdn.Model')::$INSTANCE_TYPES;

        return view('rateandreview::create')->with([
            'title' => $this->BreadCrumbName,
            'range' => $range,
            'types' => $types,
            'users' => $users->pluck('details.full_name', 'id'),
        ]);
    }

    /**
     * Store a newly created Review in storage.
     *
     * @param CreateReviewRequest $request
     *
     * @return Response
     */
    public function store(CreateReviewRequest $request)
    {
        $review = $this->reviewRepository->saveRecord($request);
        Flash::success($this->BreadCrumbName . ' saved successfully.');

        $redirect_to = redirect(route('admin.reviews.show', $review->id));

        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Review.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.reviews.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $review);
        return view('rateandreview::show')->with(['review' => $review, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Review.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.reviews.index'));
        }

        $users = $this->userRepository->resetCriteria()->all();

        $range = range(0, 10);
        array_walk($range, function (&$value, $key) {
            $value .= " Star(s)";
        });

        $types = config('rateandreview.fqdn.Model')::$INSTANCE_TYPES;

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $review);
        return view('rateandreview::edit')->with([
            'review' => $review,
            'users'  => $users->pluck('details.full_name', 'id'),
            'range'  => $range,
            'types'  => $types,
            'title'  => $this->BreadCrumbName
        ]);
    }

    /**
     * Update the specified Review in storage.
     *
     * @param  int $id
     * @param UpdateReviewRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReviewRequest $request)
    {
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.reviews.index'));
        }

        $review = $this->reviewRepository->updateRecord($request, $review);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.reviews.create'));
        } else {
            $redirect_to = redirect(route('admin.reviews.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Review from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.reviews.index'));
        }

        $this->reviewRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.reviews.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
