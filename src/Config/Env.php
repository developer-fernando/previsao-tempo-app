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
            return; // Já carregado
        }

        // Caminho para o diretório raiz do projeto (onde .env estaria)
        $rootPath = dirname(__DIR__); // /app

        // Construir o caminho completo para o arquivo .env
        $envFilePath = $rootPath . '/.env';

        // Verificar se o arquivo .env existe e é legível
        if (file_exists($envFilePath) && is_readable($envFilePath)) {
            try {
                // Tenta criar e carregar o Dotenv a partir do arquivo
                $dotenv = Dotenv::createImmutable($rootPath);
                $dotenv->load();
                self::$loaded = true;
            } catch (InvalidPathException $e) {
                // Esta exceção não deve ocorrer se file_exists e is_readable forem verdadeiros,
                // mas é uma boa prática para depuração.
                // Logar o erro, mas não parar a aplicação, pois as vars de ambiente podem estar no sistema.
                error_log("AVISO: Falha ao carregar .env do arquivo: " . $e->getMessage());
            }
        } else {
            // Se o arquivo .env não existe ou não é legível,
            // podemos assumir que as variáveis serão fornecidas pelo ambiente (Render, Docker, etc.).
            // Não há necessidade de chamar $dotenv->load() se o arquivo não existe,
            // pois o PHP já acessa as variáveis de ambiente do sistema via getenv() ou $_ENV.
            error_log("INFO: Arquivo .env não encontrado ou ilegível em " . $envFilePath . ". Assumindo que as variáveis serão fornecidas pelo ambiente.");
        }

        self::$loaded = true; // Marca como carregado para evitar múltiplas execuções
    }

    public static function get(string $key, $default = null)
    {
        // Garante que o método carregar() foi chamado (mesmo que não encontre o .env, ele marca como carregado)
        if (!self::$loaded) {
            self::carregar();
        }

        // Primeiro tenta obter a variável do ambiente do sistema
        $value = getenv($key);
        if ($value === false) {
            // Se não encontrado nas variáveis de ambiente do sistema, verifica $_ENV (se phpdotenv tiver carregado)
            $value = $_ENV[$key] ?? $default;
        }

        return $value;
    }
}
