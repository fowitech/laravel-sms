<?php

namespace Fowitech\Sms\Drivers;

use Exception;

class Verimor extends Driver
{
    protected $options = [];
    protected $baseUrl = 'http://sms.verimor.com.tr/v2/';

    public function __construct($options = [])
    {
        $this->sender = config('sms.verimor.sender');
        $this->username = config('sms.verimor.username');
        $this->password = config('sms.verimor.password');
        $this->client = $this->getInstance();
        $this->options = $options;
    }

    public function send($options = [])
    {
        try {
            $response = $this->client->request('POST', $this->baseUrl.'send.json', [
                'timeout' => 60,
                'verify' => true,
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    "username" => $this->username,
                    "password" => $this->password,
                    "source_addr" => $this->sender,
                    "custom_id" => time(),
                    "datacoding" => isset($this->options['datacoding']) ? $this->options['datacoding'] : "0",
                    "messages" => array(
                        array(
                            "msg" => $this->text,
                            "dest" => $this->recipients
                        )
                    )
                ]
            ]);

            if($response->getStatusCode() == 200){
                return true;
            }else{
                return false;
            }
        }catch (Exception $exception){
            return false;
        }
    }
}
