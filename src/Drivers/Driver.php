<?php

namespace Fowitech\Sms\Drivers;

use GuzzleHttp\Client;
use Exception;

abstract class Driver
{
    protected $text;
    protected $username;
    protected $password;
    protected $recipients = [];
    private static $httpClient;
    protected $sender;
    protected $response;
    protected $client;
    protected $request;

    public static function getInstance()
    {
        if (! self::$httpClient) {
            self::$httpClient = new Client();
        }

        return self::$httpClient;
    }

    public function to($numbers)
    {
        $recipients = is_array($numbers) ? $numbers : [$numbers];

        $recipients = array_map(static function ($item) {
            return trim($item);
        }, array_merge($this->recipients, $recipients));

        $this->recipients = array_values(array_filter($recipients));

        if (count($this->recipients) < 1) {
            throw new Exception('Message recipients cannot be empty.');
        }

        return $this;
    }

    public function message(string $message): self
    {
        $message = trim($message);

        if ($message === '') {
            throw new Exception('Message text cannot be empty.');
        }

        $this->text = $message;

        return $this;
    }

    abstract public function send($options = []);
}
