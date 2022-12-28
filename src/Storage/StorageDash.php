<?php

namespace Eraasoft311\Mvc\Storage;

use Eraasoft311\Mvc\Contracts\Storage\StorageInterface;
use Eraasoft311\Mvc\Contracts\Storage\TypeInterface;
use Eraasoft311\Mvc\Cookies\CookiesDash;
use Eraasoft311\Mvc\Env\EnvDash;
use Eraasoft311\Mvc\Session\SessionDash;

class StorageDash extends TypeInterface implements StorageInterface {
    public static $object;

    public static function type()
    {
        return EnvDash::env("STORAGE_DRIVER");
    }

    public static function handle()
    {
        switch (self::type()) {
            case 'cookies':
                return 'CookiesDash';
                break;
            case 'session':
                return 'SessionDash';
                break;
        }
    }

    public static function set(string $key, mixed $value, int $time, $path):void
    {
        self::type();
    }

    public static function get(string $key):mixed
    {
        
    }

    public static function destroy($key):void
    {
        
    }
}

?>