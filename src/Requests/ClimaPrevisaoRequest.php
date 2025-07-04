<?php

namespace App\Requests;

use App\Helpers\FormatacaoHelper;

class ClimaPrevisaoRequest
{
    public static function gerar(array $forecast, bool $todos = false): array
    {
        $dias = $forecast['forecastday'] ?? [];

        if (!$todos) {
            $dias = array_slice($dias, 0, 3);
        }

        $previsoes = [];

        foreach ($dias as $previsao) {
            $previsoes[] = [
                'data' => FormatacaoHelper::formatarData($previsao['date']),
                'minima' => $previsao['day']['mintemp_c'],
                'maxima' => $previsao['day']['maxtemp_c'],
                'chanceChuva' => $previsao['day']['daily_chance_of_rain']
            ];
        }

        return $previsoes;
    }
}
