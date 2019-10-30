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
     * Loads a subset
     * 
     * @param  string $dir A directory where subsets are.
     */
    public function __construct(array $subset)
    {
        Assert::keyExists($subset, 'freq');
        Assert::keyExists($subset, 'n_words');
        Assert::keyExists($subset, 'name');

        $this->subset = $subset;
    }

    /**
     * Get frequencies by ngrams
     * 
     * @return array
     */
    public function getFreq()
    {
        return $this->subset['freq'];
    }

    /**
     * Get total numbers of occurences by ngram sizes
     * 
     * @return array
     */
    public function getNWords()
    {
        return $this->subset['n_words'];
    }
}
