<?php

namespace App\Controllers;

class ErrorController
{
    public static function cidadeNaoEncontrada(): string
    {
        return '❌ Cidade não encontrada. Verifique se digitou corretamente.';
    }

    public static function cidadeInvalida(): string 
    {
        return '❌ Por favor, digite um nome de cidade válido.';
    }

    public static function erroComunicacaoApi(): string
    {
        return '❌ Erro na comunicação com a API. Tente novamente mais tarde.';
    }

    public static function erroGenerico(): string
    {
        return '❌ Ocorreu um erro inesperado.';
    }
}