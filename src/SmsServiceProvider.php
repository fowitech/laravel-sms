<?php

namespace Fowitech\Sms;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;


class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Filesystem $filesystem
     * @return void
     */
    public function boot(Filesystem $filesystem)
    {
        if (app() instanceof \Illuminate\Foundation\Application) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('sms.php'),
            ], 'sms');
        }
    }

    public function register()
    {
        $this->app->singleton(Sms::class, function () {
            return new Sms($this->app['config']['sms.driver']);
        });
    }
}
