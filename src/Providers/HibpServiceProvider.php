<?php

namespace KyleMass\Hibp\Providers;

use KyleMass\Hibp\Hibp;
use Illuminate\Support\ServiceProvider;
use KyleMass\Hibp\Validator\HibpValidator;

class HibpServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('hibp.php'),
        ], 'config');

        $this->__extendValidator();
    }

    public function register()
    {
        if (!file_exists(config_path('hibp.php'))) {
            $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'hibp');
        }
        \App::singleton('hibp', function () {
            return new Hibp();
        });
    }

    private function __extendValidator()
    {
        \Validator::extend('beenpwned', HibpValidator::class, 'Your :attribute has been pwned! Please use another');
    }
}
