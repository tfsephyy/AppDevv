<?php

namespace App\Services;

class MessageFilterService
{
    /**
     * Tagalog toxic words deny list (loaded from config)
     */
    private $tagalogDenyList = [];
    
    /**
     * Threat patterns
     */
    private $threatPatterns = [];
    
    /**
     * Harassment patterns
     */
    private $harassmentPatterns = [];
    
    /**
     * Constructor - load deny lists from config
     */
    public function __construct()
    {
        $this->tagalogDenyList = config('toxic_words.tagalog', []);
        $this->threatPatterns = config('toxic_words.threat_patterns', []);
        $this->harassmentPatterns = config('toxic_words.harassment_patterns', []);
    }
    
    /**
     * Regex patterns for toxic content detection (English and Tagalog)
     */
    private $toxicPatterns = [
        // General English profanity structure
        'profanity_en' => '/\b(f+[\W_]*u+[\W_]*c+[\W_]*k+|s+[\W_]*h+[\W_]*i+[\W_]*t+|b+[\W_]*i+[\W_]*t+[\W_]*c+[\W_]*h+)\b/i',

        // English Leetspeak / obfuscation
        'leetspeak_en' => '/\b([a@4][s$5]+h[o0]l[e3]|[fph][\W_]*[uúùu][\W_]*[kqc]+)\b/i',

        // Repeated-letter insults (works for both languages)
        'repeated_insults' => '/\b([a-z])\1{3,}[a-z]*\b/i',

        // English threats
        'threats_en' => '/\b(i[\' ]?m\s+going\s+to\s+(kill|hurt|beat)|you(?:\'re| are)\s+dead)\b/i',

        // English sexual harassment requests
        'sexual_harassment_en' => '/\b(show|send|give)\s+(me\s+)?(pics?|pictures?|body|nudes?)\b/i',

        // Hate-speech pattern (generic categories)
        'hate_speech' => '/\b(kill|eliminate|erase|remove|hate|destroy|get rid of)\s+(all\s+)?(the\s+)?(group|race|religion|orientation|community|people)\b/i',
    ];

    /**
     * Category-based deny lists (placeholders - no actual slurs)
     */
    private $denyCategories = [
        'racial_slur_category' => [
            'pattern' => '/\b(racial_placeholder_1|racial_placeholder_2|racial_placeholder_3)\b/i',
            'message' => 'Message contains inappropriate racial content.'
        ],
        'homophobic_category' => [
            'pattern' => '/\b(homophobic_placeholder_1|homophobic_placeholder_2|homophobic_placeholder_3)\b/i',
            'message' => 'Message contains inappropriate homophobic content.'
        ],
        'sexist_category' => [
            'pattern' => '/\b(sexist_placeholder_1|sexist_placeholder_2|sexist_placeholder_3)\b/i',
            'message' => 'Message contains inappropriate sexist content.'
        ],
        'general_profanity_category' => [
            'pattern' => '/\b(profanity_placeholder_1|profanity_placeholder_2|profanity_placeholder_3)\b/i',
            'message' => 'Message contains inappropriate profanity.'
        ],
    ];

    /**
     * Allow list for common false positives
     */
    private $allowList = [
        'bass', 'class', 'mass', 'pass', 'sass', 'glass', 'grass', 'brass',
        'butt', 'butts', 'but', 'butter', 'button', 'butcher', 'butler',
        'assess', 'assist', 'asset', 'assignment', 'associate',
        'hell', 'hello', 'helmet', 'help', 'helpful', 'helping',
        'damn', 'dame', 'dance', 'danger', 'dangle', 'daring',
        'pussy', 'pussycat', 'push', 'pushed', 'pushes', 'pushing',
        'cock', 'cockpit', 'cocktail', 'cockerel', 'cocksure',
        'bitch', 'bitchy', 'bitching', 'bitches', 'bitchin',
        'fucking', 'fucker', 'fucked', 'fucks', 'fuckers', // Allow as intensifiers in some contexts
    ];

    /**
     * Validate message for toxic content
     *
     * @param string $message
     * @return array Returns ['valid' => true] if clean, or ['valid' => false, 'error' => 'message'] if toxic
     */
    public function validateMessage($message)
    {
        if (empty(trim($message))) {
            return ['valid' => false, 'error' => 'Message cannot be empty.'];
        }

        $messageLower = strtolower(trim($message));

        // Check allow list first - if message contains only allowed words, skip other checks
        if ($this->isAllowedMessage($messageLower)) {
            return ['valid' => true];
        }

        // Check Tagalog deny list
        foreach ($this->tagalogDenyList as $toxicWord) {
            $pattern = '/\b' . preg_quote($toxicWord, '/') . '\b/i';
            if (preg_match($pattern, $messageLower)) {
                return [
                    'valid' => false,
                    'error' => 'Your message contains inappropriate Tagalog profanity and cannot be sent.'
                ];
            }
        }
        
        // Check threat patterns
        foreach ($this->threatPatterns as $threatWord) {
            if (stripos($messageLower, $threatWord) !== false) {
                return [
                    'valid' => false,
                    'error' => 'Your message contains threatening content and cannot be sent.'
                ];
            }
        }
        
        // Check harassment patterns
        foreach ($this->harassmentPatterns as $harassmentWord) {
            if (stripos($messageLower, $harassmentWord) !== false) {
                return [
                    'valid' => false,
                    'error' => 'Your message contains inappropriate sexual content and cannot be sent.'
                ];
            }
        }

        // Check regex patterns for English content
        foreach ($this->toxicPatterns as $type => $pattern) {
            if (preg_match($pattern, $messageLower)) {
                return [
                    'valid' => false,
                    'error' => $this->getErrorMessage($type)
                ];
            }
        }

        // Check category-based deny lists
        foreach ($this->denyCategories as $category => $config) {
            if (preg_match($config['pattern'], $messageLower)) {
                return [
                    'valid' => false,
                    'error' => $config['message']
                ];
            }
        }

        return ['valid' => true];
    }

    /**
     * Check if message contains only allowed words
     *
     * @param string $message
     * @return bool
     */
    private function isAllowedMessage($message)
    {
        $words = preg_split('/\s+/', $message);
        foreach ($words as $word) {
            $word = preg_replace('/[^\w]/', '', $word); // Remove punctuation
            if (!in_array($word, $this->allowList) && !empty($word)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get appropriate error message for toxic content type
     *
     * @param string $type
     * @return string
     */
    private function getErrorMessage($type)
    {
        $messages = [
            'profanity_en' => 'Your message contains inappropriate profanity and cannot be sent.',
            'profanity_tl' => 'Your message contains inappropriate profanity and cannot be sent.',
            'leetspeak_en' => 'Your message contains obfuscated inappropriate content and cannot be sent.',
            'leetspeak_tl' => 'Your message contains obfuscated inappropriate content and cannot be sent.',
            'repeated_insults' => 'Your message contains inappropriate repeated insults and cannot be sent.',
            'threats_en' => 'Your message contains threatening content and cannot be sent.',
            'threats_tl' => 'Your message contains threatening content and cannot be sent.',
            'sexual_harassment_en' => 'Your message contains inappropriate sexual content and cannot be sent.',
            'sexual_harassment_tl' => 'Your message contains inappropriate sexual content and cannot be sent.',
            'hate_speech' => 'Your message contains hate speech and cannot be sent.',
        ];

        return $messages[$type] ?? 'Your message contains inappropriate content and cannot be sent.';
    }

    /**
     * Get all toxic patterns for client-side validation
     *
     * @return array
     */
    public function getToxicPatterns()
    {
        return $this->toxicPatterns;
    }
    
    /**
     * Get Tagalog deny list for client-side validation
     *
     * @return array
     */
    public function getTagalogDenyList()
    {
        return $this->tagalogDenyList;
    }
    
    /**
     * Get threat patterns for client-side validation
     *
     * @return array
     */
    public function getThreatPatterns()
    {
        return $this->threatPatterns;
    }
    
    /**
     * Get harassment patterns for client-side validation
     *
     * @return array
     */
    public function getHarassmentPatterns()
    {
        return $this->harassmentPatterns;
    }

    /**
     * Get allow list for client-side validation
     *
     * @return array
     */
    public function getAllowList()
    {
        return $this->allowList;
    }
}