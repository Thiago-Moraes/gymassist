<?php

require 'vendor/autoload.php'; // Certifique-se de que o autoload do Composer está incluído

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

// Substitua 'SUA_CHAVE_DA_API_AQUI' pela sua chave real do Gemini API
// Em um ambiente Laravel, você usaria env('GEMINI_API_KEY')
$apiKey = getenv('GEMINI_API_KEY') ?: 'SUA_CHAVE_DA_API_AQUI';

if (empty($apiKey) || $apiKey === 'SUA_CHAVE_DA_API_AQUI') {
    die("Erro: A chave da API do Gemini não foi definida. Por favor, defina a variável de ambiente GEMINI_API_KEY ou substitua 'SUA_CHAVE_DA_API_AQUI'.\n");
}

$client = new Client([
    'base_uri' => 'https://generativelanguage.googleapis.com/v1beta/models/',
    'timeout'  => 30.0, // Tempo limite da requisição em segundos
]);

// O endpoint com o modelo e o método. O ':' é codificado para '%3A' para evitar problemas de interpretação de porta.
$endpoint = 'gemini-2.0-flash%3AgenerateContent';

$payload = [
    "contents" => [
        [
            "parts" => [
                [
                    "text" => "Explain how AI works in a few words"
                ]
            ]
        ]
    ]
];

try {
    $response = $client->post($endpoint, [
        'query' => [
            'key' => $apiKey, // A chave da API pode ir como query param
        ],
        'json' => $payload, // Guzzle irá codificar o array para JSON e definir o Content-Type
    ]);

    $statusCode = $response->getStatusCode();
    $body = json_decode($response->getBody()->getContents(), true);

    echo "Status Code: " . $statusCode . "\n";
    echo "Resposta da API do Gemini:\n";
    print_r($body);

    // Exemplo de como acessar o texto gerado
    if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
        echo "\nTexto Gerado: " . $body['candidates'][0]['content']['parts'][0]['text'] . "\n";
    } else {
        echo "\nNão foi possível encontrar o texto gerado na resposta.\n";
    }

} catch (RequestException $e) {
    echo "Erro na requisição para a API do Gemini:\n";
    echo "Mensagem: " . $e->getMessage() . "\n";
    if ($e->hasResponse()) {
        echo "Corpo da Resposta de Erro: " . $e->getResponse()->getBody()->getContents() . "\n";
    }
} catch (Exception $e) {
    echo "Ocorreu um erro inesperado: " . $e->getMessage() . "\n";
}

?>
