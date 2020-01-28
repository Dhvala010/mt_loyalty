<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromocodeValidateRequest extends FormRequest
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
            'coupon_id' => [ 'nullable','exists:store_coupons,id,deleted_at,NULL'],
            'store_id' => [ 'nullable','exists:stores,id,deleted_at,NULL'],
        ];
    }
}
