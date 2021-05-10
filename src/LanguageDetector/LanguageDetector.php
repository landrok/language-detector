<?php

declare(strict_types=1);

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
final class LanguageDetector
{
    /**
     * @var array<Language>
     */
    private $languages = [];

    /**
     * @var array<string,float>
     */
    private $scores = [];

    /**
     * @var string
     */
    private $text = '';

    /**
     * @var LanguageDetector
     */
    private static $detector;

    /**
     * Configure all subset languages
     *
     * @param  string $dir A directory where subsets are.
     * @param  array<string> $languages Language codes to load models for. By default, all languages are loaded.
     */
    public function __construct(?string $dir = null, array $languages = [])
    {
        $datadir = is_null($dir)
            ? __DIR__ . '/subsets'
            : rtrim($dir, '/');

        foreach (glob($datadir . '/*') as $file) {
            if (! count($languages)
                || in_array(basename($file), $languages)
            ) {
                $this->languages[basename($file)] = new Language($file);
            }
        }
    }

    /**
     * Evaluate that a string matches a language
     *
     * @throws \TypeError if $text is not a string
     * @api
     */
    public function evaluate(string $text): self
    {
        if ($text === '') {
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
     * @param  array $languages Language codes to load models for. By
     *         default, all languages are loaded.
     * @return \LanguageDetector\LanguageDetector
     * @api
     */
    public static function detect(string $text, array $languages = []): self
    {
        // Current loaded models
        $current = ! is_null(self::$detector)
            ? self::$detector->getLanguages()
            : [];

        // Differential between currently loaded and specified models
        $diff = count($languages)
            ? array_diff($current, $languages)
            : [];

        // Specified models need to be reloaded
        if (is_null(self::$detector) || count($diff)) {
            self::$detector = new self(null, $languages);
        }

        return self::$detector->evaluate($text);
    }

    /**
     * Get the best scored language
     *
     * @return \LanguageDetector\Language A Language object related to
     *                                    ISO code or best scored one if
     *                                    $code is empty.
     * @throws \InvalidArgumentException When ISO code has no related
     *                                   Language definition.
     * @api
     */
    public function getLanguage(?string $code = null): Language
    {
        if (! count($this->scores)) {
            return new EmptyLanguage();
        }

        if (is_null($code)) {
            $code = key($this->scores);
        }

        Assert::keyExists($this->languages, $code);

        return $this->languages[$code];
    }

    /**
     * Get loaded languages
     *
     * @return array<string> An array of ISO codes
     * @api
     */
    public function getLanguages(): array
    {
        return array_keys($this->languages);
    }

    /**
     * Get all scored subsets
     *
     * @return array<string,float> An array of ISO codes => scores
     * @throws \Exception if nothing has been evaluated
     * @api
     */
    public function getScores(): array
    {
        if (! count($this->scores)) {
            throw new Exception('No string has been evaluated');
        }

        return $this->scores;
    }

    /**
     * Get all supported languages
     *
     * @return array<string> An array of ISO codes
     * @api
     */
    public function getSupportedLanguages(): array
    {
        return array_keys($this->languages);
    }

    /**
     * Get evaluated text
     * @api
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Get best result when detector is used as a string
     */
    public function __toString(): string
    {
        return (string) $this->getLanguage();
    }

    /**
     * Get a callable evaluator that will calculate probabilities
     * for one language.
     */
    private function calculate(array $chunks): callable
    {
        return function ($language, $code) use ($chunks): void {
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
     */
    private function chunk(): array
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
