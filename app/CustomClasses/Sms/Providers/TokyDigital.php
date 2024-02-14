<?php

namespace App\CustomClasses\Sms\Providers;

use App\Mail\TokyDigital\AlertMail;
use App\Repositories\SmsLogRepository;
use App\Repositories\TokyCampaign\CampaignRepository;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class TokyDigital
{
    private $username;
    private $password;
    private $base_url;
    private $client;

    public function __construct(Client $client)
    {
        $this->username = config("sms.providers.toky-digital.username");
        $this->password = config('sms.providers.toky-digital.password');
        $this->base_url = config('sms.providers.toky-digital.base_url');
        $this->client = $client;
    }

    /**
     * Gather all formatted and necessary data to send sms.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send($input)
    {
        $formatedData = $this->dataFormat($input);

        if (!$formatedData['company']) {
            return response()->json(['company' => [__('api.validations.company_required')]], 422);
        }

        $response = $this->tokySend($formatedData);
        $this->storeSms($response, $formatedData);

        if ($response['status'] == "ER") {
            if (!Cache::get('toky-provider-errors')) {
                Cache::put('toky-provider-errors', 1);
            } elseif (Cache::increment('toky-provider-errors') > 50) {
                $this->sendEmail();
            }
            $responseMessage = __('Message not sent!');
        } else {
            $responseMessage = __('Successfully sent!');
            Cache::forget('toky-provider-errors');
        }

        return response()->json([
            'message' => $responseMessage,
            'status' => $response['status'],
            'full_status' => $response['full_status']
        ]);
    }

    /** Format data before sent
     *
     * @param $data
     * @return array
     */
    private function dataFormat($data)
    {
        $sender = $data['sender'];
        $country = $data['country'];
        $number = $data['number'];

        switch ($country) {
            case "IT":
                $prefix = "39";
                break;
            case "UK":
                $prefix = "44";
                break;
            case "FR":
                $prefix = "33";
                break;
            case "USA":
                $prefix = "1";
                break;
            case "DE":
                $prefix = "49";
                break;
            case "ZV":
                $prefix = "41";
                break;
            default:
                $prefix = '39';
                break;
        }

        if (is_numeric($sender)) {
            $sender = str_replace("+".$prefix, "", $sender);
            $sender = "+".$prefix.$sender;
        }

        $number = str_replace("+".$prefix, "", $number);
        $number = preg_replace('#[^0-9]#', '', $number);

        if ($country == "IT") {
            if (substr($number, 0, 1) != "3") {
                return [
                    "status" => "KO",
                    "message" => __('Wrong number!')
                ];
            }
        }
        $number = "+".$prefix.$number;
        $campaign = trim($data['campaign']);

        $company = $this->getCompany($data);

        return [
            'sender' => $sender,
            'number' => $number,
            'message' => $data['message'],
            'campaign' => $campaign,
            'company' => $company,
            'provider' => $data['provider'],
            'sms_type' => $data['sms_type'],
            'contract_type' => $data['contract_type']
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

    /** Get toky response
     * @param $data
     * @return array
     */
    private function tokySend($data)
    {
        $url = $this->setApiUrl($data);

        $httpResponse = $this->client->get($url)->getBody()->getContents();

        $credits = $this->calculateCredits($data['message']);

        if (preg_match("/Errors=1/i", $httpResponse)) {
            $status = 'ER';
        } else {
            $status = substr($httpResponse, 1, 2);
        }

        $response = [
            'status' => $status,
            'full_status' => $httpResponse,
            'credits' => $credits,
            'send_date' => now(),
            'sms_sender_user' => auth()->user()->id
        ];
        return $response;
    }

    /** Get Api Url
     * @param $data
     * @return string
     */
    private function setApiUrl($data)
    {
        return $this->base_url."?User=".$this->username.
            "&Password=".$this->password."&OAdC=".urlencode($data['sender'])."&AdCs=".urlencode($data['number'])
            ."&Message=".urlencode($data['message']);

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

        if ($response['status'] == 'ER') {
            $response['status'] = false;
        } else {
            $response['status'] = true;
        }

        $smsLogsRepository = new SmsLogRepository();
        $input = array_merge($formatedData, $response);

        return $smsLogsRepository->create($input);

    }

    /** Send email function when provider doesn't work properly
     * @param $data
     * @param $emails
     * @return void
     */
    private function sendEmail()
    {
        Mail::to('renis.isufi@ids.al, oligert.cerenishti@localweb.it')->send(new AlertMail());
    }
}
