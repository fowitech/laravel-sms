<?php

namespace Fowitech\Sms\Drivers;

use Exception;

class Toplusms extends Driver
{
    private $baseUrl = 'https://api.toplusmspaketleri.com/api/v1/1toN';
    private $api_id;
    private $api_key;

    public function __construct($options = [])
    {
        $this->sender = config('sms.toplusms.sender');
        $this->api_key = config('sms.toplusms.api_key');
        $this->api_id = config('sms.toplusms.api_id');
        $this->client = $this->getInstance();
    }

    public function send($options = [])
    {
        $params = [
            'api_id' => $this->api_id,
            'api_key' => $this->api_key,
            'sender' => $this->sender,
            'message_type' => 'normal',
            'message' => $this->text,
            'phones' => $this->recipients
        ];

        try {
            $response = $this->client->request('POST', $this->baseUrl, [
                'timeout' => 100,
                'verify' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $params
            ]);

            $content = json_decode($response->getBody()->getContents(), true);
            if($content['status'] == 200){
                return true;
            }else{
                return false;
            }
        }catch (Exception $exception){
            return false;
        }
    }
}
