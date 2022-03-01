<?php

namespace Fowitech\Sms\Drivers;

use Exception;

class Vatansms extends Driver
{
    private $userno;
    private $options = [];
    private $baseUrl = 'http://panel.vatansms.com/panel/smsgonder1Npost.php';

    public function __construct($options = [])
    {
        $this->sender = config('sms.vatansms.sender');
        $this->userno = config('sms.vatansms.userno');
        $this->username = config('sms.vatansms.username');
        $this->password = config('sms.vatansms.password');
        $this->client = $this->getInstance();
        $this->options = $options;
    }

    public function send($options = [])
    {
        try {
            $numbers = implode(',', $this->recipients);
            $tur = $this->options['tur'] ?? "Normal";

            $xmlString='data=<sms>
                <kno>'. $this->userno.'</kno>
                <kulad>'. $this->username.'</kulad>
                <sifre>'.$this->password .'</sifre>
                <gonderen>'. $this->sender .'</gonderen>
                <mesaj>'. $this->text .'</mesaj>
                <numaralar>'. $numbers.'</numaralar>
                <tur>'.$tur.'</tur>
                </sms>';

            $response = $this->client->request('POST', $this->baseUrl, [
                'timeout' => 60,
                'verify' => true,
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => $xmlString
            ]);

            $content = explode(':', $response->getBody()->getContents());
            if($content[0] == 1){
                return true;
            }else{
                return false;
            }
        }catch (Exception $exception){
            return false;
        }
    }
}
