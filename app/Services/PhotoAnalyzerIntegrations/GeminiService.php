<?php

namespace App\Services\PhotoAnalyzerIntegrations;
use App\Contracts\PhotoAnalyzerInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Exception;
use stdClass;

class GeminiService implements PhotoAnalyzerInterface
{
    protected readonly string $apiUrl;
    protected readonly string $apiKey;
    protected const ApiRequestPrompt = 'Extract the vendor, date, total amount, and tax from this image. Return ONLY a raw JSON object. Do not include markdown code blocks, backticks, or any introductory/concluding text. Use the following schema: { "vendor": "string", "date": "YYYY-MM-DD", "total_amount": float, "tax": float }';
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
     * @param UploadedFile $photo - an UploadedFile file
     * @return array - The json decoded response from Gemini
     * @throws Exception
     */
    public function analyze($photo): array
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

        return json_decode($textResponse, true);
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
                            'text' => self::ApiRequestPrompt
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
