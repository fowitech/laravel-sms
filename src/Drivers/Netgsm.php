<?php

namespace Fowitech\Sms\Drivers;

use Exception;

class Netgsm extends Driver
{
    private $baseUrl = 'https://api.netgsm.com.tr';

    public function __construct($options = [])
    {
        $this->sender = config('sms.netgsm.sender');
        $this->username = config('sms.netgsm.username');
        $this->password = config('sms.netgsm.password');
        $this->client = $this->getInstance();
    }

    public function send($options = [])
    {
        $data = [
            'usercode' => $this->username,
            'password' => $this->password,
            'gsmno' => $this->recipients[0],
            'message' => $this->text,
            'msgheader' => $this->sender,
            'filter' => '0',
            'startdate' => '',
            'stopdate' => '',
        ];

        try {
            $response = $this->client->request('POST', $this->baseUrl . '/sms/send/get/', [
                'form_params' => $data
            ]);

            $contents = explode(' ', $response->getBody()->getContents());
            if ($contents[0] == 00) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            return false;
        }
    }
}
