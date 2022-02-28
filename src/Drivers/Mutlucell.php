<?php

namespace Fowitech\Sms\Drivers;

class Mutlucell extends Driver
{
    private $baseUrl = 'http://sms.verimor.com.tr/v2/';

    public function __construct()
    {
        $this->username = config('sms.mutlucell.username');
        $this->password = config('sms.mutlucell.password');
        $this->client = $this->getInstance();
    }

    public function send($options = [])
    {
        // TODO: Implement send() method.
    }
}
