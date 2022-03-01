<?php

namespace Fowitech\Sms\Drivers;

use Exception;

class Netgsm extends Driver
{
    private $baseUrl = 'https://api.netgsm.com.tr/';

    public function __construct($options = [])
    {
        $this->sender = config('sms.netgsm.sender');
        $this->username = config('sms.netgsm.username');
        $this->password = config('sms.netgsm.password');
        $this->client = $this->getInstance();
    }

    public function send($options = [])
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><mainbody><header><company>Netgsm</company><usercode>' . $this->username . '</usercode><password>' . $this->password . '</password><type>n:n</type><msgheader>' . $this->sender . '</msgheader></header><body>';
        $xml .= '<mp><msg><![CDATA['.$this->text.']]></msg><no>'.$this->recipients[0].'</no></mp>';
        $xml .= '</body></mainbody>';

        try {
            $response = $this->client->request('GET', $this->baseUrl.'xmlbulkhttppost.asp', [
                'timeout' => 100,
                'verify' => false,
                'headers' => [
                    'Content-Type' => 'text/xml; charset=UTF8'
                ],
                'body' => $xml
            ]);

            $contents = explode(' ', $response->getBody()->getContents());
            if($contents[0] == 00){
                return true;
            }else{
                return false;
            }
        }catch (Exception $exception){
            return false;
        }
    }
}
