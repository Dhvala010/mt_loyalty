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
            'description' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'facebook_url' => 'required',
            'location_address' => 'required',
            'title' => 'required|unique:stores,title,'.$this->id,
            'image' =>'sometime|mimes:jpeg,jpg,png,gif',
        ];
    }
}
