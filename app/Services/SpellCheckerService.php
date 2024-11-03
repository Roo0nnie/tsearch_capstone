<?php

namespace App\Services;

class SpellCheckerService
{
    public function autoCorrectText(string $text): string
    {
        if (empty($text)) {
            return $text; // Return original if there's nothing to check
        }

        // Escape text to ensure it's safe for shell execution
        $escapedText = escapeshellarg($text);

        // Command to run Aspell in WSL
        $command = "echo $escapedText | wsl aspell -a 2>&1"; // Capture errors as well

        // Execute the command and capture the output
        $output = shell_exec($command);

        // Log the output for debugging
        \Log::info('Aspell output: ' . ($output ?? 'No output returned'));

        // Check if output is null and handle it
        if (is_null($output)) {
            return $text; // Return original text if there's no output
        }

        // Process the output to extract suggestions
        return $this->processAspellOutput($output, $text);
    }

    private function processAspellOutput(string $output, string $originalText): string
    {
      // Split output into lines
    $lines = explode("\n", $output);
    $corrections = [];

    // Create an associative array to hold suggestions for each word
    $wordCorrections = [];

    foreach ($lines as $line) {
        // Adjust regex to capture the suggestions part after the colon
        if (preg_match('/^& (\S+) .*?: (.*)$/', $line, $matches)) {
            // This line extracts the suggestions part after the colon
            $suggestions = explode(', ', $matches[2]);
            $bestSuggestion = trim($suggestions[0] ?? null); // Get the best suggestion

            if ($bestSuggestion) {
                // Clean up the suggestion
                $cleanedWord = preg_replace('/^\d+\s+\d+\s*:\s*/', '', $bestSuggestion);
                $wordCorrections[$matches[1]] = $cleanedWord; // Map original misspelled word to its correction
            }
        }
    }

    // Split the original text into words
    $originalWords = explode(' ', $originalText);
    $outputWords = [];

    foreach ($originalWords as $word) {
        // Check if there's a correction for the current word
        if (isset($wordCorrections[$word])) {
            $outputWords[] = $wordCorrections[$word]; // Use the correction
        } else {
            $outputWords[] = $word; // Fallback to the original word
        }
    }

    return implode(' ', $outputWords);
    }
}
