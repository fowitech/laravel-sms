<?php

if (! function_exists('sms')) {
    /**
     * Access SmsManager through helper.
     * @return \Fowitech\Sms\Sms
     */
    function sms()
    {
        return app('sms');
    }
}
