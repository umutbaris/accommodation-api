<?php

namespace App\Http\Requests;

use App\Rules\BannedWords;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'    =>  [
                'sometimes',
                'required',
                'min:10',
                new BannedWords()
            ],
            'rating'    => 'sometimes|required|integer|between:0,5',
            'reputation'    => 'sometimes|required|integer|between:0,1000',
            'price'    => 'sometimes|required|integer',
            'availability'    => 'sometimes|required|integer',
            'image'    => 'sometimes|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        ];
    }
}
