<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        return [
            'user_id' => ['required', 'integer','min:1'],
            'title' => ['required', 'string','unique:stores', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['required','mimes:jpeg,jpg,gif,bmp,png'],
            'phone_number' => ['required', 'string','max:255'],
            'country_code' => ['required','exists:countries,id'],
            'email' => [ 'required','string','email','max:255'],            
        ];
    }
}
