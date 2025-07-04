<?php

namespace App\Config;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException; // Importar a exceção

class Env
{
    private static bool $loaded = false;

    public static function carregar(): void
    {
        if (self::$loaded) {
            return;
        }

        $rootPath = dirname(__DIR__);

        $envFilePath = $rootPath . '/.env';

        if (file_exists($envFilePath) && is_readable($envFilePath)) {
            try {
                $dotenv = Dotenv::createImmutable($rootPath);
                $dotenv->load();
                self::$loaded = true;
            } catch (InvalidPathException $e) {

                error_log("AVISO: Falha ao carregar .env do arquivo: " . $e->getMessage());
            }
        } else {

            error_log("INFO: Arquivo .env não encontrado ou ilegível em " . $envFilePath . ". Assumindo que as variáveis serão fornecidas pelo ambiente.");
        }

        self::$loaded = true;
    }

    public static function get(string $key, $default = null)
    {
        if (!self::$loaded) {
            self::carregar();
        }


        $value = getenv($key);
        if ($value === false) {

            $value = $_ENV[$key] ?? $default;
        }

        return $value;
    }
}
