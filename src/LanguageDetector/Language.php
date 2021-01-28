<?php

declare(strict_types = 1);

/*
 * This file is part of the LanguageDetector package.
 *
 * Copyright (c) landrok at github.com/landrok
 *
 * For the full copyright and license information, please see
 * <https://github.com/landrok/language-detector/blob/master/LICENSE>.
 */

namespace LanguageDetector;

use Webmozart\Assert\Assert;

/**
 * Language binds a subset
 */ 
class Language
{
    /**
     * @var array
     */
    protected $subset = [];

    /**
     * @var string
     */
    protected $file;

    /**
     * Is subset data loaded ?
     *
     * @var bool
     */
    protected $loaded;

    /**
     * Config a subset file to load
     * 
     * @param  string $file File which contains subset data.
     */
    public function __construct(string $file)
    {
        $this->file = $file;        
    }

    /**
     * Load subset data
     *
     * @throws \InvalidArgumentException  if file does not exist
     */
    public function load(): self
    {
        Assert::fileExists($this->file);
        Assert::file($this->file);

        $subset = json_decode(
            file_get_contents($this->file),
            true
        );

        Assert::keyExists($subset, 'freq');
        Assert::keyExists($subset, 'n_words');
        Assert::keyExists($subset, 'name');

        $this->subset = $subset;
        $this->loaded = true;

        return $this;
    }

    /**
     * Get frequencies by ngrams
     */
    public function getFreq(): array
    {
        if (!$this->loaded) {
            $this->load();
        }

        return $this->subset['freq'];
    }

    /**
     * Get total numbers of occurences by ngram sizes
     */
    public function getNWords(): array
    {
        if (!$this->loaded) {
            $this->load();
        }

        return $this->subset['n_words'];
    }

    /**
     * Get language ISO code
     */
    public function getCode(): string
    {
        if (!$this->loaded) {
            $this->load();
        }

        return $this->subset['name'];
    }

    /**
     * Get language code
     */
    public function __toString(): string
    {
        return $this->getCode();
    }
}
