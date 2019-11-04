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

use Webmozart\Assert\Assert;

/**
 * Language binds a subset
 */ 
class Language
{
    /**
     * @var array
     */
    private $subset = [];

    /**
     * @var string
     */
    private $file;

    /**
     * Have subset data been loaded ?
     *
     * @var bool
     */
    private $loaded;

    /**
     * Loads a subset
     * 
     * @param  string $file File which contains subset data.
     */
    public function __construct($file)
    {
        Assert::string($file);

        $this->file = $file;        
    }

    /**
     * Load subset data
     *
     * @return $this
     */
    public function load()
    {
        $subset = json_decode(
            file_get_contents($this->file),
            true
        );

        Assert::keyExists($subset, 'freq');
        Assert::keyExists($subset, 'n_words');
        Assert::keyExists($subset, 'name');

        $this->subset = $subset;
        $this->loaded = true;
    }

    /**
     * Get frequencies by ngrams
     * 
     * @return array
     */
    public function getFreq()
    {
        if (!$this->loaded) {
            $this->load();
        }

        return $this->subset['freq'];
    }

    /**
     * Get total numbers of occurences by ngram sizes
     * 
     * @return array
     */
    public function getNWords()
    {
        if (!$this->loaded) {
            $this->load();
        }

        return $this->subset['n_words'];
    }
}
