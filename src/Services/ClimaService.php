<?php

namespace App\Services;

use App\Exceptions\CidadeNaoEncontradaException;
use App\Exceptions\ErroComunicacaoException;

class ClimaService
{
    private string $apiKey;
    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey = $_ENV['API_KEY'] ?? '';
        $this->apiUrl = $_ENV['API_URL'] ?? '';

        if (empty($this->apiKey) || empty($this->apiUrl)) {
            throw new \Exception("Chaves da API (API_KEY ou API_URL) não configuradas no ambiente.");
        }
    }


    public function buscarPrevisaoPorCidade(string $queryLocalizacao): array
    {

        $url = "{$this->apiUrl}/forecast.json?key={$this->apiKey}&q=" . urlencode($queryLocalizacao) . "&days=7&lang=pt";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $resposta = curl_exec($ch);
        $erro = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($erro) {
            throw new ErroComunicacaoException("Erro na comunicação cURL: " . $erro);
        }

        $dados = json_decode($resposta, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($dados)) {
            throw new ErroComunicacaoException("A resposta da API não pôde ser processada.");
        }

        if (isset($dados['error'])) {
            if (isset($dados['error']['code']) && $dados['error']['code'] == 1006) {
                throw new CidadeNaoEncontradaException();
            }
            throw new ErroComunicacaoException("Erro da API: " . ($dados['error']['message'] ?? "Erro desconhecido."));
        }

        return $dados;
    }
}
