<?php

/*
 * This file is part of the LanguageDetector package.
 *
 * Copyright (c) landrok at github.com/landrok
 *
 * For the full copyright and license information, please see
 * <https://github.com/landrok/language-detector/blob/master/LICENSE>.
 */

namespace LanguageDetector;

use Exception;
use Webmozart\Assert\Assert;

/**
 * LanguageDetector is the entry point for the detecting process.
 */ 
class LanguageDetector
{
    /**
     * @var \LanguageDetector\Language[]
     */
    private $languages = [];

    /**
     * @var string
     */
    private $datadir;

    /**
     * @var array
     */
    private $scores = [];

    /**
     * @var string
     */
    private $text = '';

    /**
     * @var \LanguageDetector\LanguageDetector
     */
    private static $detector;

    /**
     * Loads all subsets
     * 
     * @param  string $dir A directory where subsets are.
     */
    public function __construct($dir = null)
    {
        $this->datadir = null === $dir
            ? __DIR__ . '/subsets' : rtrim($dir, '/');

        foreach (glob($this->datadir . '/*') as $file) {
            $this->languages[basename($file)] = new Language(
                json_decode(
                    file_get_contents($file), true
                )
            );
        }
    }

    /**
     * Evaluates that a string matches a language
     * 
     * @param  string $text
     * @return \LanguageDetector\LanguageDetector
     * @throws \InvalidArgumentException if $text is not a string
     * @api
     */
    public function evaluate($text)
    {
        Assert::string(
            $text,
            'Method evaluate() expects a string. Given %s'
        );

        if (empty($text)) {
            return $this;
        }

        $this->text = $text;

        array_walk($this->languages, $this->calculate($this->chunk()));

        arsort($this->scores);

        return $this;
    }

    /**
     * Static call for oneliners
     * 
     * @param  string $text
     * @return \LanguageDetector\LanguageDetector
     * @api
     */
    public static function detect($text)
    {
        if (is_null(self::$detector)) {
            self::$detector = new self();
        }

        return self::$detector->evaluate($text);
    }

    /**
     * Gets the best scored language
     * 
     * @return string ISO code or an empty string
     *                if nothing has been evaluated
     * @api
     */
    public function getLanguage()
    {
        if (!count($this->scores)) {
            return '';
        }

        return key($this->scores);
    }

    /**
     * Get all scored subsets
     * 
     * @return array An array of ISO codes => scores
     * @throws \Exception if nothing has been evaluated
     * @api
     */
    public function getScores()
    {
        if (!count($this->scores)) {
            throw new Exception('No string has been evaluated');
        }

        return $this->scores;
    }

    /**
     * Get all supported languages
     * 
     * @return array An array of ISO codes
     * @api
     */
    public function getSupportedLanguages()
    {
        return array_keys($this->languages);
    }

    /**
     * Get evaluated text
     * 
     * @return string
     * @api
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get best result when detector is used as a string
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getLanguage();
    }

    /**
     * Evaluate probabilities for one language
     * 
     * @param  array $chunks
     * @return \Closure An evaluator
     */
    private function calculate(array $chunks)
    {
        return function($language, $code) use ($chunks) {
            $this->scores[$code] = 
                array_sum(
                    array_intersect_key(
                        $language->getFreq(),
                        array_flip($chunks)
                    )
                )
                / array_sum($language->getNWords());
        };
    }

    /**
     * Chunk a text
     * 
     * @return array
     */
    private function chunk()
    {
        $chunks = [];
        $len = mb_strlen($this->text);

        // Chunk sizes 
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < $len; $j++) {
                if ($len > $j + $i) {
                    $chunks[] = mb_substr($this->text, $j, $i + 1);
                }
            }
        }

        return $chunks;
    }
}
