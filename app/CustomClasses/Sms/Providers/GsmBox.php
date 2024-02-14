<?php

namespace App\CustomClasses\Sms\Providers;

use App\Repositories\SmsLogRepository;
use App\Repositories\TokyCampaign\CampaignRepository;
use GuzzleHttp\Client;

class GsmBox
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /** Send function
     *
     * @param $input
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send($input)
    {
        $formatedData = $this->dataFormat($input);

        if (!$formatedData['company']) {
            return response()->json(['company' => [__('api.validations.company_required')]], 422);
        }

        $response = $this->gsmBoxSend($formatedData);

        $this->storeSms($response, $formatedData);

        if ($response['status'] == "ER") {
            $responseMessage = __('api.messages.sms_not_sent');
        } else {
            $responseMessage = __('api.messages.sms_sent');
        }

        return response()->json([
            'message' => $responseMessage,
            'status' => $response['status'],
            'full_status' => $response['full_status']
        ]);
    }

    private function dataFormat($data)
    {
        return [
            'sender' => $data['sender'],
            'number' => $data['number'],
            'message' => $data['message'],
            'campaign' => trim($data['campaign']),
            'company' => $this->getCompany($data),
            'provider' => $data['provider'],
            'country' => $data['country'],
            'sms_type' => $data['sms_type'],
            'contract_type' => $data['contract_type'],
            'port' => $data['port'],
            'client_ip' => $data['client_ip']
        ];
    }


    /** Get the company this campaign belongs to
     *
     * @return $company
     */
    private function getCompany($array)
    {
        $company = null;
        $campaignRepository = new CampaignRepository();
        $campaign = $campaignRepository->query()->select('company')->where('campaign', $array['campaign'])->first();
        if ($campaign) {
            $company = $campaign->company;
        }

        return $company;
    }

    /**
     * Send sms directly with text message
     * @param  string  $to
     * @param  string  $textMessage
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function gsmBoxSend($data)
    {
        $url = $this->getUrl($data);

        $guzzleResponse = $this->client->get($url)->getBody()->getContents();
        $credits = $this->calculateCredits($data['message']);

        if (preg_match("/Errors=1/i", $guzzleResponse)) {
            $status = 'ER';
        } else {
            $status = 'OK';
        }
        $response = [
            'status' => $status,
            'full_status' => $guzzleResponse,
            'credits' => $credits,
            'send_date' => now(),
            'sms_sender_user' => auth()->user()->id
        ];

        return $response;
    }

    /**
     * Serialize url with params
     * @param  string  $to
     * @param  string  $textMessage
     * @return string
     */
    public function getUrl($data)
    {
        $smsGsmBox = config('sms.providers.gsm-boxes')[$data['provider']];
        $params = [
            'username='.urlencode($smsGsmBox['username']),
            'password='.urlencode($smsGsmBox['password']),
            'port='.urlencode($data['port']),
            'recipients='.urlencode($data['number']),
            'sms='.urlencode($data['message']),
        ];

        return $smsGsmBox['url'].'?'.implode('&', $params);
    }

    /**
     * Calculate the number of credits each sms is charged
     *
     * @return $credits
     */
    private function calculateCredits($message)
    {
        return ceil(strlen($message) / 160);
    }

    /**
     * Store Sms to Sms Master
     * @return  Response
     */
    private function storeSms($response, $formatedData)
    {
        $smsLogsRepository = new SmsLogRepository();

        if ($response['status'] == 'ER') {
            $response['status'] = false;
        } else {
            $response['status'] = true;
        }

        $input = array_merge($formatedData, $response);

        return $smsLogsRepository->create($input);
    }


}
