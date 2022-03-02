<?php

namespace Fowitech\Sms;

use Exception;

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
        $options = config("sms.{$driver}.options");

        if (!class_exists($transport)) {
            throw new Exception('Driver not found.');
        }

        return new $transport($options);
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

    public function send($options = [])
    {
        return $this->driver->send($options);
    }
}
