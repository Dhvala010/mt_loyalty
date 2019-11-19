<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegiserRequest extends FormRequest
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
        $user_role_array = array_keys(config('loyalty.user_role'));
        $user_role_string = implode(",",$user_role_array);

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'is_agree_terms' => ['required', 'boolean'],
            'role' => ['required','in:'.$user_role_string],
            'phone_number' => [ 'required','numeric'],
            'country_code' => [ 'required','exists:countries,id' ],
        ];
    }
}
