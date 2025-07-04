<?php

namespace App\Helpers;

class FormatacaoHelper
{
    public static function formatarData(string $data): string
    {
        return date('d/m/Y', strtotime($data));
    }

    public static function formatarCidade(string $cidade): string
    {
        return ucwords(strtolower(trim($cidade)));
    }
}
