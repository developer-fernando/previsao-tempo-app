<?php

namespace App\Exceptions;

class ErroComunicacaoException extends ApiException
{
    public function __construct(string $message = "Erro na comunicação com a API. Tente novamente mais tarde.")
    {
        parent::__construct($message, 500); 
    }
}
