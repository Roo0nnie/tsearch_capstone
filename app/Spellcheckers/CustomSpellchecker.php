<?php
namespace App\Spellcheckers;

use PhpSpellcheck\Misspelling;
use PhpSpellcheck\Spellchecker\SpellcheckerInterface;
use PhpSpellcheck\Spellchecker\SpellcheckerFactory;

class CustomSpellChecker implements SpellcheckerInterface
{
    protected $spellChecker;

    public function __construct()
    {
        // Initialize the spell checker from the PhpSpellcheck library
        $this->spellChecker = SpellcheckerFactory::create('en_US');
        // $this->spellChecker = create('en_US');
    }

    public function check(string $text, array $languages, array $context): iterable
    {
        // Use the library to get suggestions for the text
        $misspellings = $this->spellChecker->check($text, $languages, $context);

        foreach ($misspellings as $misspelling) {
            yield new Misspelling(
                $misspelling->getWord(),
                $misspelling->getOffset(),
                $misspelling->getLineNumber(),
                $this->getSuggestions($misspelling->getWord())
            );
        }
    }

    public function getSupportedLanguages(): iterable
    {
        yield 'en_US'; // Support for English
    }

    private function getSuggestions(string $word): array
    {
        // Use the spell checker to get suggestions
        $suggestions = $this->spellChecker->getSuggestions($word);

        return $suggestions ?: [];
    }
}
