<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class validatefamilyid extends FormRequest
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
            "family_member_id" => [ "required","exists:family_members,id,deleted_at,NULL"]
        ];
    }
}
