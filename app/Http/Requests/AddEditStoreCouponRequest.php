<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEditStoreCouponRequest extends FormRequest
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
            'id' => [ 'nullable','exists:store_coupons,id'],
            'store_id' => [ 'required','exists:stores,id,deleted_at,NULL'],
            'title' => [ 'required' ],
            'amount' => [ 'required' ,'numeric' ],
            'offer_valid' => [ 'required','date' ],
        ];
    }
}
