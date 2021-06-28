<?php

namespace App\Http\Requests;

use App\Rules\BannedWords;
use Illuminate\Foundation\Http\FormRequest;

class CreateHotelRequest extends FormRequest
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
                'required',
                'min:10',
                'unique:hotels',
                new BannedWords()
            ],
            'rating'    => 'required|integer|between:0,5',
            'reputation'    => 'required|integer|between:0,1000',
            'price'    => 'required|integer',
            'availability'    => 'required|integer',
            'image'    => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'location.zip_code' => 'required|digits:5'
        ];
    }
}
