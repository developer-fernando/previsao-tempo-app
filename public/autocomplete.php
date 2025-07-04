<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Env;

Env::carregar();

$apiKey = $_ENV['API_KEY'];
$apiUrl = $_ENV['API_URL'];
$busca = $_GET['q'] ?? '';

if (empty($busca)) {
    echo json_encode([]);
    exit;
}

$url = "{$apiUrl}/search.json?key={$apiKey}&q=" . urlencode($busca);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resposta = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $resposta;
