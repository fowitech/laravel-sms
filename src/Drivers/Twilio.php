<?php

namespace Fowitech\Sms\Drivers;

use Exception;

class Twilio extends Driver
{
    public $account_sid;
    public $auth_token;
    public $from;
    protected $options = [];
    protected $baseUrl = 'https://api.twilio.com/2010-04-01';

    public function __construct($options = [])
    {
        $this->account_sid = config('sms.twilio.account_sid');
        $this->auth_token = config('sms.twilio.auth_token');
        $this->from = config('sms.twilio.phone');
        $this->client = $this->getInstance();
        $this->options = $options;
    }

    public function send($options = [])
    {
        try {
            $response = $this->client->request('POST', $this->baseUrl.'/Accounts/'.$this->account_sid.'/Messages.json', [
                'timeout' => 100,
                'verify' => false,
                'auth' => [
                    $this->account_sid,
                    $this->auth_token
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'Body' => $this->text,
                    'From' => $this->from,
                    'To' => $this->recipients[0]
                ]
            ]);
            $content = json_decode($response->getBody()->getContents(), true);
            if($response->getStatusCode() == 201){
                return true;
            }else{
                \Log::error($content['message']);
                return false;
            }
        }catch (Exception $e){
            \Log::error($e->getMessage());
            return false;
        }
    }
}
