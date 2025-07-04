<?php

namespace App\Exceptions;

class CidadeNaoEncontradaException extends ApiException
{
    public function __construct(string $message = "Cidade não encontrada. Verifique se digitou corretamente.")
    {
        parent::__construct($message, 404); 
    }
}
