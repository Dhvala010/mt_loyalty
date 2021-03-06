<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateRedeemRequest extends FormRequest
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
            'store_id' => [ "required","numeric","exists:stores,id,deleted_at,NULL"],
            'offer_id' => [ "required","numeric","exists:store_offers,id,deleted_at,NULL"],
            'coupon_id' => [ "required","numeric","exists:store_coupons,id,deleted_at,NULL"],
        ];
    }
}
