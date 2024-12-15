<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SpellCheckerService
{
    protected $client;

    public function __construct()
    {
        // Initialize the Guzzle HTTP client
        $this->client = new Client([
            'base_uri' => 'https://api.languagetoolplus.com/',
        ]);
    }

    public function autoCorrectText(string $text): string
    {
        if (empty($text)) {
            return $text; // Return original if there's nothing to check
        }

        try {
            // Call the LanguageTool API for spell checking
            $response = $this->client->post('v2/check', [
                'form_params' => [
                    'text' => $text,
                    'language' => 'en-US', // Adjust the language as needed
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $this->processLanguageToolOutput($result, $text);
        } catch (RequestException $e) {
            \Log::error('LanguageTool API error: ' . $e->getMessage());
            return $text; // Return original text in case of error
        }
    }

    private function processLanguageToolOutput(array $result, string $originalText): string
    {
        // Store the corrections in an associative array
        $wordCorrections = [];
        foreach ($result['matches'] as $match) {
            // Get the incorrectly spelled word and the best suggestion
            $incorrectWord = substr($originalText, $match['offset'], $match['length']);
            $suggestions = $match['replacements'];
            $bestSuggestion = $suggestions[0]['value'] ?? null; // Get the best suggestion

            if ($bestSuggestion) {
                $wordCorrections[$incorrectWord] = $bestSuggestion; // Map incorrect word to its correction
            }
        }

        // Split the original text into words
        $originalWords = explode(' ', $originalText);
        $outputWords = [];

        foreach ($originalWords as $word) {
            // Use correction if available
            if (isset($wordCorrections[$word])) {
                $outputWords[] = $wordCorrections[$word]; // Use the correction
            } else {
                $outputWords[] = $word; // Fallback to the original word
            }
        }

        return implode(' ', $outputWords);
    }
}
