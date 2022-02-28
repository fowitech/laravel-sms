<?php

namespace Fowitech\Sms\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notifiable, 'routeNotificationForSms')) {
            $phone = $notifiable->routeNotificationForSms($notifiable);
        } else {
            $phone = $notifiable->getKey();
        }

        $message = $notification->toSms($notifiable);

        sms()->to($phone)->message($message)->send();

        return true;
    }
}
