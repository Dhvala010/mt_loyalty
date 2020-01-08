<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEditStoreRewardRequest extends FormRequest
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
            'store_reward_id' => [ 'nullable','exists:store_rewards,id'],
            'store_id' => [ 'required','exists:stores,id,deleted_at,NULL'],
            'title' => [ 'required' ],
            'description' => [ 'required' ],
            'offer_valid' => [ 'required' ],
        ];
    }
}
