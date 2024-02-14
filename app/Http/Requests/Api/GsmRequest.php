<?php

namespace App\Http\Requests\Api;


use App\Http\Requests\ApiRequest;

class GsmRequest extends ApiRequest
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
            'number' => 'required|phone:AL',
            'message' => 'required',
            'campaign' => 'required|exists:contratti.campaign,campaign,attiva,Y',
            'sms_type' => 'required',
            'contract_type' => 'required',
            'country' => 'required|in:AL',
            'provider' => 'required|in:'.implode(',', array_keys(config("sms.providers.gsm-boxes"))),
            'port' => 'required'
        ];
    }


}
