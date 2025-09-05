<?php

namespace App\Infrastructure\AI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Exception;
use Log;

class GeminiClient
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('GEMINI_API_URL'),
            'timeout'  => 30,
            'content_type' => 'application/json',
        ]);
        $this->apiKey = env('GEMINI_API_KEY');

        if (empty($this->apiKey)) {
            throw new Exception('GEMINI_API_KEY not set in .env file.');
        }
    }


    /**
     * @param string $prompt
     * @return string
     * @throws GuzzleException
     */
    public function getWorkoutSuggestion(string $prompt): string
    {
        try {
            // $model = 'gemini-pro:generateContent';
            // $model = 'gemini-pro%3AgenerateContent';
            // $model = 'gemini-2.0-flash:generateContent';
            $model = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
            $response = $this->client->post($model, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-goog-api-key' => $this->apiKey,
                ],
                'query' => [
                    'key' => $this->apiKey,
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            // Verifica se a resposta contém o texto gerado
            if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
                return $body['candidates'][0]['content']['parts'][0]['text'];
            } else {
                // Log da resposta completa para depuração
                Log::error('Gemini API response missing text:', $body);
                return "Erro: A API do Gemini não retornou texto válido.";
            }

        } catch (RequestException $e) {
            // Log do erro da requisição
            Log::error('Gemini API Request Error:', [
                'message' => $e->getMessage(),
                'request' => (string) $e->getRequest()->getBody(),
                'response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : 'N/A',
            ]);
            return "Erro ao comunicar com a API do Gemini: " . $e->getMessage();
        } catch (Exception $e) {
            // Log de outros erros
            Log::error('Gemini API General Error:', ['message' => $e->getMessage()]);
            return "Ocorreu um erro inesperado: " . $e->getMessage();
        }
    }
}
