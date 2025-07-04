<?php

namespace App\Controllers;

use App\Services\ClimaService;
use App\Requests\ClimaRequest;
use App\Requests\ClimaPrevisaoRequest;
use App\Exceptions\CidadeNaoEncontradaException;
use App\Exceptions\ErroComunicacaoException;
use Exception; 

class ClimaController
{
    private ClimaService $climaService;

    public function __construct()
    {
        $this->climaService = new ClimaService();
    }

    public function buscarPorCidade(string $cidade, bool $todos = false): array
    {
        
        if (!ClimaRequest::validar($cidade)) {

            return ['erro' => ErrorController::cidadeInvalida()];
        }

        try {
            $dados = $this->climaService->buscarPrevisaoPorCidade($cidade);

            if (!isset($dados['forecast'])) {
                throw new Exception("Estrutura de dados da previsão incompleta.");
            }

            $previsoes = ClimaPrevisaoRequest::gerar($dados['forecast'], $todos);

            return [
                'current' => $dados['current'],
                'location' => $dados['location'],
                'previsoes' => $previsoes
            ];
        } catch (CidadeNaoEncontradaException $e) {
            return ['erro' => ErrorController::cidadeNaoEncontrada()];
        } catch (ErroComunicacaoException $e) {

            error_log("Erro de comunicação com a API: " . $e->getMessage()); 
            return ['erro' => ErrorController::erroComunicacaoApi()];
        } catch (Exception $e) {

            error_log("Erro inesperado no ClimaController: " . $e->getMessage()); 
            return ['erro' => ErrorController::erroGenerico()];
        }
    }
}
