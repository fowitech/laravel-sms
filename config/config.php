<?php

return [

    /**
     * The SMS service to use.
     */
    'driver' => env('SMS_DRIVER', 'netgsm'),

    /**
     * Netgsm driver settings
     */
    'netgsm' => [
        'transport' => \Fowitech\Sms\Drivers\Netgsm::class,
        'sender' => env('NETGSM_SENDER', ''),
        'username' => env('NETGSM_USERNAME', ''),
        'password' => env('NETGSM_PASSWORD', ''),
    ],

    /**
     * Verimor driver settings
     */
    'verimor' => [
        'transport' => \Fowitech\Sms\Drivers\Verimor::class,
        'sender' => env('VERIMOR_SENDER', ''),
        'username' => env('VERIMOR_USERNAME', ''),
        'password' => env('VERIMOR_PASSWORD', ''),
    ],

    /**
     * Mutlucell driver settings
     */
    'mutlucell' => [
        'transport' => \Fowitech\Sms\Drivers\Mutlucell::class,
        'sender' => env('MUTLUCELL_SENDER', ''),
        'username' => env('MUTLUCELL_USERNAME', ''),
        'password' => env('MUTLUCELL_PASSWORD', ''),
    ]
];
