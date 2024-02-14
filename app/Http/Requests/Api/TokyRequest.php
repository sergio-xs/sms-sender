<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class TokyRequest extends ApiRequest
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
            'sender' => 'required|alpha_num',
            'number' => 'required',
            'message' => 'required',
            'campaign' => 'required|exists:contratti.campaign,campaign,attiva,Y',
            'sms_type' => 'required',
            'contract_type' => 'required',
            'country' => 'nullable|in:'.implode(',',config('sms.providers.toky-digital.countries')),
            'provider' => 'required|in:tokyDigital',
        ];
    }


}
