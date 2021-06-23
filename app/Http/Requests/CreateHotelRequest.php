<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateHotelRequest extends FormRequest
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
            'name'    =>  'required|min:10',
            'rating'    => 'required|integer|between:1,5',
            'reputation'    => 'required|integer|between:0,1000',
            'price'    => 'required|integer',
            'availability'    => 'required|integer',
        ];
    }
}
