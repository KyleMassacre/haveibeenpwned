<?php

namespace KyleMass\Hibp\Facades;

use Illuminate\Support\Facades\Facade;

class Hibp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hibp';
    }
}
