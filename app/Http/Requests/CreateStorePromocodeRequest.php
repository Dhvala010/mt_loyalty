<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStorePromocodeRequest extends FormRequest
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
            'promocode_id' => [ 'nullable','exists:store_promocodes,id'],
            'store_id' => [ 'required','exists:stores,id'],
            'title' => [ 'required' ],
            'count' => [ 'required' ]
        ];
    }
}
