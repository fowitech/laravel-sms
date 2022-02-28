<?php

namespace Fowitech\Sms\Drivers;

use Exception;

class Iletimerkezi extends Driver
{
    private $baseUrl = 'https://api.iletimerkezi.com/v1/';

    public function __construct()
    {
        $this->sender = config('sms.iletimerkezi.sender');
        $this->username = config('sms.iletimerkezi.key');
        $this->password = config('sms.iletimerkezi.hash');
        $this->client = $this->getInstance();
    }

    public function send($options = [])
    {
        try {
            $response = $this->client->request('POST', $this->baseUrl.'send-sms/json', [
                'timeout' => 100,
                'verify' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    "request" => [
                        "authentication" => [
                            "key" => $this->username,
                            "hash" => $this->password
                        ],
                        "order" => [
                            "sender" => $this->sender,
                            "sendDateTime" => [],
                            "iys" => "1",
                            "iysList" => "BIREYSEL",
                            "message" => [
                                "text" => $this->text,
                                "receipents" => [
                                    "number" => $this->recipients
                                ]
                             ]
                        ]
                    ],
                ]
            ]);

            $content = json_decode($response->getBody()->getContents(), true);
            if($content['response']['status']['code'] == 200){
                return true;
            }else{
                return false;
            }
        }catch (Exception $exception){
            return false;
        }
    }
}
