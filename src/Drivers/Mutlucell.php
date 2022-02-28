<?php

namespace Fowitech\Sms\Drivers;

class Mutlucell extends Driver
{
    private $baseUrl = 'https://smsgw.mutlucell.com/smsgw-ws/sndblkex';

    public function __construct()
    {
        $this->sender = config('sms.mutlucell.sender');
        $this->username = config('sms.mutlucell.username');
        $this->password = config('sms.mutlucell.password');
        $this->client = $this->getInstance();
    }

    public function send($options = [])
    {
        $numbers = implode(',', $this->recipients);
        $xml = '<?xml version="1.0" encoding="UTF-8"?><smspack ka="'.$this->username.'" pwd="'.$this->password.'" org="'.$this->sender.'" ><mesaj><metin>'.$this->text.'</metin><nums>'.$numbers.'</nums></mesaj></smspack>';

        $response = $this->client->request('POST', $this->baseUrl, [
            'timeout' => 100,
            'verify' => false,
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8'
            ],
            'body' => $xml
        ]);

        return startsWith($response->getBody()->getContents(), '$');
    }
}
