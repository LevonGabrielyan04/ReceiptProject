<?php

namespace App\Services\PhotoAnalyzerIntegrations;
use App\Contracts\PhotoAnalyzerInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Exception;

class GeminiService implements PhotoAnalyzerInterface
{
    protected readonly string $apiUrl;
    protected readonly string $apiKey;
    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->apiUrl = config('services.gemini.url');

        if (empty($this->apiKey) || empty($this->apiUrl)) {
            throw new Exception('Gemini API key is not configured');
        }
    }

    /**
     * Analyze the receipt with Gemini API
     *
     * @param UploadedFile|string $photo - Either an UploadedFile or path to image file
     * @return string - The text response from Gemini
     * @throws Exception
     */
    public function analyze($photo): string
    {
        try {
            $response = $this->sendRequest($photo);
            return $this->parseAnswer($response);
        } catch (Exception $e) {
            \Log::error('Gemini API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function parseAnswer($response)
    {
        if (!$response->successful()) {
            $error = $response->json()['error']['message'] ?? $response->body();
            throw new Exception("Gemini API error: {$error}");
        }

        $data = $response->json();

        $textResponse = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (empty($textResponse)) {
            throw new Exception('No text response received from Gemini');
        }

        return $textResponse;
    }
    private function sendRequest($photo)
    {
        if ($photo instanceof UploadedFile) {
            $imageContent = base64_encode(file_get_contents($photo->getRealPath()));
            $mimeType = $photo->getMimeType();
        } else {
            throw new Exception('Invalid image provided');
        }

        $requestBody = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => "say hi!"
                        ],
                        [
                            'inline_data' => [
                                'mime_type' => $mimeType,
                                'data' => $imageContent
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $response = Http::timeout(30)->withHeaders([
            'x-goog-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, $requestBody);

        return $response;
    }
}
