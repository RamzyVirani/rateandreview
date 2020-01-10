<?php

namespace RamzyVirani\RateAndReview\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string name
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 * @property mixed user
 * @property mixed game
 * @property mixed rating
 *
 * @SWG\Definition(
 *      definition="Review",
 *      required={"user_id", "instance_id", "instance_type", "rating", "review"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="instance_id",
 *          description="instance_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="instance_type",
 *          description="instance_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="rating",
 *          description="rating",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="review",
 *          description="review",
 *          type="string"
 *      )
 * )
 */
class Review extends Model
{
    use SoftDeletes;

    public $table = 'reviews';

    public static $INSTANCE_TYPES = [];

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'instance_id',
        'instance_type',
        'rating',
        'review'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'review' => 'string'
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'user',
//        'reviewable',
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'review_html',
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'user_id',
        'instance_id',
        'instance_type',
        'rating',
        'review',
        'review_html',
        'user',
        'reviewable',
        'created_at',
        'updated_at'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'user_id'       => 'required',
        'instance_id'   => 'required',
        'instance_type' => 'required',
        'rating'        => 'required',
        'review'        => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
//        'user_id'       => 'required',
        'instance_id'   => 'required',
        'instance_type' => 'required',
        'rating'        => 'required',
        'review'        => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'instance_id'   => 'required',
        'instance_type' => 'required',
        'rating'        => 'required',
        'review'        => 'required'
    ];

    /**
     * Validation api update rules
     *
     * @var array
     */
    public static $api_update_rules = [
        'instance_id'   => 'required',
        'instance_type' => 'required',
        'rating'        => 'required',
        'review'        => 'required'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewable()
    {
        return $this->morphTo(null, 'instance_type', 'instance_id');
    }

    public function getReviewHtmlAttribute()
    {
        return nl2br($this->review);
    }

    public function getInstanceTypeTextAttribute()
    {
        return self::$INSTANCE_TYPES[$this->instance_type];
    }
}
