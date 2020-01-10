<?php

namespace RamzyVirani\RateAndReview\Criteria;

use App\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ReviewCriteria.
 *
 * @package namespace App\Criteria;
 */
class ReviewCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $user_id       = null;
    protected $latest        = null;
    protected $instance_type = null;
    protected $instance_id   = null;

    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->isset('latest')) {
            $model = $model->orderBy('created_at', 'DESC');
        }
        if ($this->isset('user_id')) {
            $model = $model->where('user_id', $this->user_id);
        }

        if ($this->isset('instance_type')) {
            // Only apply instance_id if instance type is also specified.
            if ($this->isset('instance_id')) {
                $model = $model->where('instance_id', $this->instance_id);
            }
            $model = $model->where('instance_type', $this->instance_type);
        }

        return $model;
    }
}
