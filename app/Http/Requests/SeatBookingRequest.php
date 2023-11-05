<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeatBookingRequest extends FormRequest
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
        return [
            'pickup_franchise'=>'required',
            'drop_franchise'=>'required',
            'traveling_date'=>'required',
            'moving_time'=>'required'
        ];
    }
}
