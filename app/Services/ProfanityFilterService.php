<?php

namespace App\Services;

use Snipe\BanBuilder\CensorWords;
use App\Models\ToxicWord;

class ProfanityFilterService
{
    private $censor;
    private $customBlacklist;

    public function __construct()
    {
        $this->censor = new CensorWords();
        $this->loadCustomBlacklist();
        $this->configureCensor();
    }

    /**
     * Load custom blacklist for Tagalog and English toxic words
     */
    private function loadCustomBlacklist()
    {
        // Load from database
        $dbWords = ToxicWord::pluck('word')->toArray();
        
        // Additional Tagalog toxic words
        $tagalogWords = [
            'gago', 'tangina', 'putangina', 'puta', 'tarantado', 'tanga',
            'bobo', 'ulol', 'leche', 'peste', 'hinayupak', 'hayop',
            'buwisit', 'pokpok', 'kantot', 'tamod', 'tite', 'puki',
            'bilat', 'bayag', 'kupal', 'inutil', 'walang kwenta',
            'gunggong', 'gaguhan', 'tangahan', 'bobuhan', 'putaragis',
            'yawa', 'animal', 'punyeta', 'bwisit', 'lintik',
            'salot', 'walanghiya', 'hudas', 'bruha', 'demonyo',
            'kingina', 'lintek', 'pucha', 'putek', 'peste ka'
        ];

        // Additional English toxic words
        $englishWords = [
            'fuck', 'shit', 'bitch', 'asshole', 'dick', 'bastard',
            'damn', 'cunt', 'slut', 'whore', 'pussy', 'cock',
            'motherfucker', 'faggot', 'nigger', 'retard', 'idiot',
            'stupid', 'dumb', 'moron', 'imbecile', 'jackass',
            'douche', 'screw', 'bloody', 'bollocks', 'bugger',
            'shag', 'tosser', 'wanker', 'twat', 'prick'
        ];

        // Common variations and leetspeak
        $variations = [
            'f*ck', 'f**k', 'sh*t', 'b*tch', 'a**hole', 'fck',
            'fuk', 'sh1t', 'b1tch', 'fuc', 'fuq', 'phuck',
            'gag0', 'b0bo', 't4nga', 'p*ta', 'put@', 'g@go'
        ];

        $this->customBlacklist = array_merge($dbWords, $tagalogWords, $englishWords, $variations);
        $this->customBlacklist = array_map('strtolower', $this->customBlacklist);
        $this->customBlacklist = array_unique($this->customBlacklist);
    }

    /**
     * Configure the censor with custom settings
     */
    private function configureCensor()
    {
        // Since BanBuilder has compatibility issues, we'll rely on our custom blacklist
        // and not use the library's methods
    }

    /**
     * Check if text contains profanity
     * 
     * @param string $text
     * @return bool
     */
    public function hasProfanity($text)
    {
        if (empty($text)) {
            return false;
        }

        // Use our custom blacklist check
        $textLower = strtolower($text);
        foreach ($this->customBlacklist as $word) {
            // Check for exact word boundaries
            if (preg_match('/\b' . preg_quote($word, '/') . '\b/i', $textLower)) {
                return true;
            }
            // Also check for substring match (for phrases)
            if (stripos($textLower, $word) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get detected profane words from text
     * 
     * @param string $text
     * @return array
     */
    public function getDetectedWords($text)
    {
        $detected = [];
        $textLower = strtolower($text);

        foreach ($this->customBlacklist as $word) {
            if (preg_match('/\b' . preg_quote($word, '/') . '\b/i', $textLower) || 
                stripos($textLower, $word) !== false) {
                $detected[] = $word;
            }
        }

        return array_unique($detected);
    }

    /**
     * Clean text by replacing profanity with asterisks
     * 
     * @param string $text
     * @return string
     */
    public function clean($text)
    {
        $textLower = strtolower($text);
        $cleaned = $text;

        foreach ($this->customBlacklist as $word) {
            // Replace whole words
            $cleaned = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', str_repeat('*', strlen($word)), $cleaned);
        }

        return $cleaned;
    }

    /**
     * Validate text and return error response if contains profanity
     * 
     * @param string $text
     * @return array|null Returns array with error details if profanity found, null otherwise
     */
    public function validateText($text)
    {
        if ($this->hasProfanity($text)) {
            return [
                'success' => false,
                'error' => 'toxic_content',
                'message' => 'Your message contains toxic words and cannot be sent.',
                'detected_words' => $this->getDetectedWords($text)
            ];
        }

        return null;
    }
}
