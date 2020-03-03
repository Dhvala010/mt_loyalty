<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'user_id' => 'required',
            'description' => 'required',
            'phone_number' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'facebook_url' => 'required|url',
            'location_address' => 'required',
            'title' => 'required|unique:stores,title,'.$this->id,
            'latitude' => [ 'required','regex:/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}/'],
            'longitude' => [ 'required','regex:/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}/'],
            // 'image' =>'sometime|mimes:jpeg,jpg,png,gif',
        ];
    }
}
