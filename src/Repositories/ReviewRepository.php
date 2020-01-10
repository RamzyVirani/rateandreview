<?php

namespace RamzyVirani\RateAndReview\Repositories;

use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ReviewRepository
 * @package App\Repositories\Admin
 * @version March 25, 2019, 6:56 am UTC
 *
 * @method Review findWithoutFail($id, $columns = ['*'])
 * @method Review find($id, $columns = ['*'])
 * @method Review first($columns = ['*'])
 */
class ReviewRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'game_id',
        'rating',
        'total_votes',
        'review'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return config('rateandreview.fqdn.Model');
    }

    public function saveRecord($request)
    {
        $input            = $request->only(['rating', 'review', 'instance_id', 'instance_type']);
        $input['user_id'] = $request->get('user_id', \Auth::id());
        return $this->create($input);
    }

    /**
     * @param $request
     * @param $review
     * @return mixed
     */
    public function updateRecord($request, $review)
    {
        $input  = $request->only(['rating', 'review', 'instance_id', 'instance_type']);
        $review = $this->update($input, $review->id);
        return $review;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $review = $this->delete($id);
        return $review;
    }
}
