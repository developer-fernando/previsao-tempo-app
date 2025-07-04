<?php

namespace App\Requests;

class ClimaRequest
{
    public static function validar(string $cidade): bool
    {
        return !empty(trim($cidade)) && strlen($cidade) >= 2;
    }
}
