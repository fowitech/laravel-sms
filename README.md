# Laravel SMS Gateway

![GitHub License](https://img.shields.io/github/license/fowitech/laravel-sms?style=for-the-badge)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/fowitech/laravel-sms.svg?style=for-the-badge&logo=composer)](https://packagist.org/packages/fowitech/laravel-sms)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/fowitech/laravel-sms/Tests?label=tests&style=for-the-badge&logo=github)](https://github.com/fowitech/laravel-sms/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/fowitech/laravel-sms.svg?style=for-the-badge&logo=laravel)](https://packagist.org/packages/fowitech/laravel-sms)

This is a Laravel Package for SMS Gateway Integration. Now Sending SMS is easy.

List of supported gateways:
- [Twilio](https://www.twilio.com/sms)
- [Netgsm](https://www.netgsm.com.tr/)
- [Mutlucell](https://www.mutlucell.com.tr/)
- [Verimor](https://www.verimor.com.tr/)
- [Iletimerkezi](https://www.iletimerkezi.com/)
- [Vatansms](https://www.vatansms.com/)
- [Toplusms](https://toplusmspaketleri.com/)

- Others are under way.

## :package: Install

Via Composer

``` bash
$ composer require fowitech/laravel-sms
```

## :zap: Configure

Publish the config file

```bash
$ php artisan vendor:publish --tag="sms"
```

In the config file you can set the default driver to use for all your SMS. But you can also change the driver at runtime.

Choose what gateway you would like to use for your application. Then make that as default driver so that you don't have to specify that everywhere. But, you can also use multiple gateways in a project.

```php
// Eg. if you want to use Netgsm.
 'driver' => env('SMS_DRIVER', 'netgsm'),
```

Then fill the credentials for that gateway in the drivers array.

```php
// Eg. for Netgsm.
'netgsm' => [
    'transport' => \Fowitech\Sms\Drivers\Netgsm::class,
    'sender' => env('NETGSM_SENDER', ''),
    'username' => env('NETGSM_USERNAME', ''),
    'password' => env('NETGSM_PASSWORD', ''),
    'options' => [
        // some options
    ]
],
```

## :fire: Usage

In your code just use it like this.
```php
# On the top of the file.
use Sms;

...

# In your Controller.
Sms::message("this message")->to(['Number 1', 'Number 2'])->send();

# If you want to use a different driver.
Sms::via('gateway')->message("this message")->to(['Number 1', 'Number 2'])->send();

# If you want to use options array
$options = [
    'send_date' => now()->addHour()
];
Sms::via('gateway')->message("this message")->to(['Number 1', 'Number 2'])->send($options);

# If you are not a Laravel's facade fan, you can use sms helper:
sms()->message("this message")->to(['Number 1', 'Number 2'])->send();

# If you want to use a different driver.
sms()->via('gateway')->message("this message")->to(['Number 1', 'Number 2'])->send();
```

## :heart_eyes: Channel Usage

First you have to create your notification using `php artisan make:notification` command.
then `SmsChannel::class` can be used as channel like the below:

```php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Fowitech\Sms\Channels\SmsChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoicePaid extends Notification
{
    use Queueable;

    /**
     * Get the notification channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    /**
     * Get the recipients and body of the notification.
     *
     * @param  mixed  $notifiable
     * @return Builder
     */
    public function toSms($notifiable)
    {
        return "Sms message";
    }
}
```

#### Custom Made Driver, How To:

First you have to name your driver in the drivers array and also you can specify any config params you want.

```php
'my_driver' => [
    'transport' => \App\Packages\SMSDriver\MyDriver::class,
    'sender' => env('MYDRIVER_SENDER', ''),
    'username' => env('MYDRIVER_USERNAME', ''),
    'password' => env('MYDRIVER_PASSWORD', ''),
    'options' => [
        // some options
    ]
    ... # Your Config Params here.
]
```

Ex. You created a class : `App\Packages\SMSDriver\MyDriver`.

```php

namespace App\Packages\SMSDriver;

use Fowitech\Sms\Drivers\Driver;

class MyDriver extends Driver 
{
    public function __construct($options = [])
    {
        $this->sender = config('sms.my_driver.sender');
        $this->username = config('sms.my_driver.username');
        $this->password = config('sms.my_driver.password');
        $this->client = $this->getInstance();
    }

    public function send($options = [])
    {
        # Main logic of Sending SMS.
    }
}
```

## :microscope: Testing

``` bash
composer test
```
