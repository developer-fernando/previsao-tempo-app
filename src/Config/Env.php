<?php

namespace App\Config;

use Dotenv\Dotenv;

class Env
{
    public static function carregar(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
    }
}
