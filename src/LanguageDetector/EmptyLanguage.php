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

/**
 * Empty language
 */
final class EmptyLanguage extends Language
{
    /**
     * Emulate default values for an empty language
     */
    public function __construct()
    {
        $this->file   = null;
        $this->loaded = true;
        $this->subset = [
            'freq'    => [],
            'n_words' => [],
            'name'    => '',
        ];
    }
}
