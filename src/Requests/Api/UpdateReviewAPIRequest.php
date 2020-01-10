<?php

namespace RamzyVirani\RateAndReview\Requests\Api;

use App\Http\Requests\Api\BaseAPIRequest;

class UpdateReviewAPIRequest extends BaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return config('rateandreview.fqdn.Model')::$api_update_rules;
    }
}
