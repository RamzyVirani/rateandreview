<?php

namespace RamzyVirani\RateAndReview\Controllers\Api;

use App\Helper\Util;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;
use RamzyVirani\RateAndReview\Requests\Api\CreateReviewAPIRequest;
use RamzyVirani\RateAndReview\Requests\Api\UpdateReviewAPIRequest;

/**
 * Class ReviewController
 * @package App\Http\Controllers\Api
 */
class ReviewAPIController extends AppBaseController
{
    private $reviewRepository;

    public function __construct()
    {
        $this->reviewRepository = app()->make(config('rateandreview.fqdn.Repository'));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @return Response
     *
     * @SWG\Get(
     *      path="/reviews",
     *      summary="Get a listing of the Reviews.",
     *      tags={"Review"},
     *      description="Get all Reviews",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *     @SWG\Parameter(
     *          name="instance_type",
     *          description="Filter reviews record by instance type. If not found, Returns All Records in DB.",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="instance_id",
     *          description="Filter reviews record by instance id. If not found, Returns All Records in DB. This param will only work if instance_type is specified.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="user_id",
     *          description="Filter reviews record by user id. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="latest",
     *          description="Filter latest reviews, pass 1 for latest reviews. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="sort_by",
     *          description="sort reviews by: total_votes, rating, (All these will sort desc by default). If not found, Returns All Records in DB.",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="limit",
     *          description="Change the Default Record Count. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="offset",
     *          description="Change the Default Offset of the Query. If not found, 0 will be used.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Review")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $criteria = app()->make(config('rateandreview.fqdn.Criteria'));

        $reviews = $this->reviewRepository
            ->pushCriteria(new RequestCriteria($request))
            ->pushCriteria(new LimitOffsetCriteria($request))
            ->pushCriteria(new $criteria($request->only([
                'user_id',
                'latest',
                'sort_by',
                'instance_type',
                'instance_id',
            ])))
            ->all();

        return $this->sendResponse($reviews->toArray(), 'Reviews retrieved successfully');
    }

    /**
     * @param CreateReviewAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/reviews",
     *      summary="Store a newly created Review in storage",
     *      tags={"Review"},
     *      description="Store Review",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Review that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Review")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Review"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateReviewAPIRequest $request)
    {
        $reviews = $this->reviewRepository->saveRecord($request);

        // FIXME: Temporary fix to get proper casted data instead of calculated data (Game Ratings).
        $reviews = $this->reviewRepository->find($reviews->id);

        return $this->sendResponse($reviews, 'Review saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/reviews/{id}",
     *      summary="Display the specified Review",
     *      tags={"Review"},
     *      description="Get Review",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Review",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Review"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Review $review */
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            return $this->sendErrorWithData(['Review not found']);
        }

        return $this->sendResponse($review->toArray(), 'Review retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateReviewAPIRequest $request
     * @return Response
     *
     * \\@SWG\Put(
     *      path="/reviews/{id}",
     *      summary="Update the specified Review in storage",
     *      tags={"Review"},
     *      description="Update Review",
     *      produces={"application/json"},
     *      \\@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      \\@SWG\Parameter(
     *          name="id",
     *          description="id of Review",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      \\@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Review that should be updated",
     *          required=false,
     *          \\@SWG\Schema(ref="#/definitions/Review")
     *      ),
     *      \\@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          \\@SWG\Schema(
     *              type="object",
     *              \\@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              \\@SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Review"
     *              ),
     *              \\@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateReviewAPIRequest $request)
    {
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            return $this->sendErrorWithData(['Review not found']);
        }

        $review = $this->reviewRepository->updateRecord($request, $id);

        return $this->sendResponse($review->toArray(), 'Review updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * \\@SWG\Delete(
     *      path="/reviews/{id}",
     *      summary="Remove the specified Review from storage",
     *      tags={"Review"},
     *      description="Delete Review",
     *      produces={"application/json"},
     *      \\@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      \\@SWG\Parameter(
     *          name="id",
     *          description="id of Review",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      \\@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          \\@SWG\Schema(
     *              type="object",
     *              \\@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              \\@SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              \\@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        $review = $this->reviewRepository->findWithoutFail($id);

        if (empty($review)) {
            return $this->sendErrorWithData(['Review not found']);
        }

        $this->reviewRepository->deleteRecord($id);

        return $this->sendResponse($id, 'Review deleted successfully');
    }
}
