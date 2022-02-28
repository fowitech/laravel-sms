<?php

namespace Fowitech\Sms;

class Sms
{
    public $driver;
    public $client;

    public function __construct($driver)
    {
        $this->driver = $this->setDriver($driver);
    }

    public function via($driver)
    {
        $this->driver = $this->setDriver($driver);
        return $this;
    }

    public function setDriver($driver)
    {
        $transport = config("sms.{$driver}.transport");

        if(!class_exists($transport)){
            //
        }

        return new $transport;
    }

    public function to($recipients)
    {
        $this->driver->to($recipients);
        return $this;
    }

    public function message($message)
    {
        $this->driver->message($message);
        return $this;
    }

    public function send()
    {
        return $this->driver->send();
    }
}
