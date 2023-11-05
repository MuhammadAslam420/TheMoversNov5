<?php

namespace App\Http\Requests\Request;

use App\Http\Requests\BaseRequest;

class UpdateTripRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'request_id'  => 'required',
            'payment_opt'  => 'required',

        ];
    }
}
