<?php

namespace Fowitech\Sms\Drivers;

class Iletimerkezi extends Driver
{
    private $baseUrl = 'https://api.iletimerkezi.com/v1/';

    public function __construct($message = null)
    {
        $this->sender = config('sms.iletimerkezi.sender');
        $this->username = config('sms.iletimerkezi.username');
        $this->password = config('sms.iletimerkezi.password');
        $this->client = $this->getInstance();
    }

    public function send()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><request><authentication><username>'.$this->username.'</username><password>'.$this->password.'</password></authentication>';
        $xml .= '<order><sender>'.$this->sender.'</sender><sendDateTime></sendDateTime><iys>1</iys><iysList>BIREYSEL</iysList><message><text><![CDATA['.$this->text.']]></text><receipents>';
        foreach ($this->recipients as $recipient){
            $xml .= '<number>'.$recipient.'</number>';
        }
        $xml .= '</receipents></message></order>';
        $xml .= '</request>';

        $response = $this->client->request('POST', $this->baseUrl.'send-sms', [
            'timeout' => 100,
            'verify' => false,
            'headers' => [
                ['Content-Type' => 'text/xml; charset=UTF8']
            ],
            'body' => $xml
        ]);

    }
}
