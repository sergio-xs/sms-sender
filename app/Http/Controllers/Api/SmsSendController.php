<?php

namespace App\Http\Controllers\Api;

use App\CustomClasses\Sms\Providers\GsmBox;
use App\CustomClasses\Sms\Providers\TokyDigital;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GsmRequest;
use App\Http\Requests\Api\TokyRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SmsSendController extends Controller
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /** Send api sms toky
     * @param  Request  $request
     * @return \App\CustomClasses\Sms\Providers\Response
     */

    /**
     * @OA\Post(
     *      path="/api/send-sms/toky-digital",
     *      operationId="sendSmsTokyDigital",
     *      tags={"Send Sms"},
     *      summary="Send Sms through toky digital",
     *      summary="Send Sms",
     *      description="Routes for sending sms",
     *     @OA\Parameter(
     *         description="The one who sends sms",
     *         in="query",
     *         name="sender",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Number to whom is sms sent",
     *         in="query",
     *         name="number",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Message we want to send",
     *         in="query",
     *         name="message",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Campaign",
     *         in="query",
     *         name="campaign",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Type of sms",
     *         in="query",
     *         name="sms_type",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Type of contract",
     *         in="query",
     *         name="contract_type",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Country where we send sms, one of : IT,UK,FR,USA,DE,ZV",
     *         in="query",
     *         name="country",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Provider which sends sms : tokyDigital",
     *         in="query",
     *         name="provider",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *           @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(
     *                       type="message",
     *                       default="Successfully sent",
     *                       description="",
     *                       property="message"
     *                  ),
     *                  @OA\Property(
     *                       type="status",
     *                       default="OK",
     *                       description="",
     *                       property="status"
     *                  ),
     *                  @OA\Property(
     *                       type="full_status",
     *                       default="+OK \n Sent=1 \n Errors=0 \n Credit=1 \n ITA=0 \n FRA=48 \n GBR=32032 \n DEU=50 \n USA=50 \n.",
     *                       description="",
     *                       property="full_status"
     *                  )
     *          )
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *           @OA\JsonContent(
     *                  type="object",
     *                 @OA\Property(
     *                       type="message",
     *                       default="Message not sent",
     *                       description="",
     *                       property="message"
     *                  ),
     *                  @OA\Property(
     *                       type="status",
     *                       default="ER",
     *                       description="",
     *                       property="status"
     *                  ),
     *                  @OA\Property(
     *                       type="full_status",
     *                       default="-ER The (field name) field is required. ",
     *                       description="",
     *                       property="full_status"
     *                  )
     *          )
     *       )
     *     )
     */
    public function sendTokyDigital(TokyRequest $request)
    {
        $input = $request->validated();

        $input = array_merge($input, ['client_ip' => $request->ip()]);

        $tokyDigital = new TokyDigital($this->client);

        return $tokyDigital->send($input);
    }

    /**
     * @param  Request  $request
     * @return \http\Env\Response
     */

    /**
     * @OA\Post(
     *      path="/api/send-sms/gsm-box",
     *      operationId="sendSmsGsmBox",
     *      tags={"Send Sms"},
     *      summary="Send Sms through gsm box",
     *      description="Routes for sending sms",
     *     @OA\Parameter(
     *         description="The one who sends sms",
     *         in="query",
     *         name="sender",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Number to whom is sms sent",
     *         in="query",
     *         name="number",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Message we want to send",
     *         in="query",
     *         name="message",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Campaign",
     *         in="query",
     *         name="campaign",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Type of sms",
     *         in="query",
     *         name="sms_type",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Type of contract",
     *         in="query",
     *         name="contract_type",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Country where sms is sent",
     *         in="query",
     *         name="country",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Provider which sends sms",
     *         in="query",
     *         name="provider",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Port used to send this sms",
     *         in="query",
     *         name="port",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *           @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(
     *                       type="message",
     *                       default="Successfully sent",
     *                       description="",
     *                       property="message"
     *                  ),
     *                  @OA\Property(
     *                       type="status",
     *                       default="OK",
     *                       description="",
     *                       property="status"
     *                  ),
     *                  @OA\Property(
     *                       type="full_status",
     *                       default="{\'code\':0, \'reason\':\'OK\'}",
     *                       description="",
     *                       property="full_status"
     *                  )
     *          )
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *           @OA\JsonContent(
     *                  type="object",
     *                 @OA\Property(
     *                       type="country",
     *                       default="The selected country is invalid.",
     *                       description="",
     *                       property="country"
     *                  )
     *          )
     *       )
     *     )
     */
    public function sendGsmBox(GsmRequest $request)
    {
        $input = $request->validated();

        $input = array_merge($input, ['client_ip' => $request->ip()]);
        $gsmBox = new GsmBox($this->client);

        return $gsmBox->send($input);
    }
}
