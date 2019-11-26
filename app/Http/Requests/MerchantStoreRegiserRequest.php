<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Zend\Diactoros\Request;
use Illuminate\Http\Request as ApiRequest;

class MerchantStoreRegiserRequest extends FormRequest
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
    public function rules(ApiRequest $request)
    {
        return [
            'store_id' => [ 'nullable','exists:stores,id'],
            'title' => ['required', 'string','unique:stores,title,'.$request->store_id, 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['required','mimes:jpeg,jpg,gif,bmp,png'],
            'phone_number' => ['required', 'integer','min:10'],
            'country_code' => ['required','exists:countries,id'],
            'email' => [ 'required','string','email','max:255'],
        ];
    }
}
