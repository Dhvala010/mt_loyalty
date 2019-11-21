<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckSocialLoginRequest extends FormRequest
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
        $user_type_array = array_values(config('loyalty.user_type'));
        $user_type_string = implode(",",$user_type_array);
        return [
            'uesr_type' => [ 'required' , 'in:'.$user_type_string ],
            'social_media_id' => [ 'required' ]
        ];
    }
}
