LanguageDetector
================

[![Build Status](https://travis-ci.org/landrok/language-detector.svg?branch=master)](https://travis-ci.org/landrok/language-detector)
[![Test Coverage](https://codeclimate.com/github/landrok/language-detector/badges/coverage.svg)](https://codeclimate.com/github/landrok/language-detector/coverage)
[![Code Climate](https://codeclimate.com/github/landrok/language-detector/badges/gpa.svg)](https://codeclimate.com/github/landrok/language-detector)

LanguageDetector is a PHP library that detects the language from strings or texts.

Features
--------

- More than 50 supported languages
- Very fast, no database needed
- Packaged with a 2MB learned dataset
- Small code, easy to modify
- N-grams algorythm


Usage
-----

### API Methods
```php

require_once 'vendor/autoload.php';

$detector = new LanguageDetector\LanguageDetector();

// Gets detected language
$lang = $detector->evaluate('My sentence is in english')->getLanguage();

// Gets all supported languages
$languages = $detector->getSupportedLanguages();

// Gets all scores
$scores = $detector->getScores();

// Gets detected language again
$lang = $detector->getLanguage();

```

### Common usage
```php
require_once 'vendor/autoload.php';

$strings = [
  'My sentence is in english',
  'My sentence number two is in english too'
];

$results = [];

$detector = new LanguageDetector\LanguageDetector();

foreach($strings as $string)
{
  $results[] = $detector->evaluate($string)->getLanguage();
}

```

### One line usage

This usage is not recommended if you want to make several consecutive evaluations

```php
require_once 'vendor/autoload.php';

// One line usage: instanciate, evaluate and get language
$lang = ( new LanguageDetector\LanguageDetector() )
          ->evaluate('My sentence is in english')
          ->getLanguage();
```
