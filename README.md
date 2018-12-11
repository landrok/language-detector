LanguageDetector
================

[![Build Status](https://travis-ci.org/landrok/language-detector.svg?branch=master)](https://travis-ci.org/landrok/language-detector)
[![Test Coverage](https://codeclimate.com/github/landrok/language-detector/badges/coverage.svg)](https://codeclimate.com/github/landrok/language-detector/coverage)
[![Code Climate](https://codeclimate.com/github/landrok/language-detector/badges/gpa.svg)](https://codeclimate.com/github/landrok/language-detector)

LanguageDetector is a PHP library that detects the language from texts.

Table of contents
=================
- [Features](#features)
- [Install](#install)
- [Quick usage](#quick-usage)
  - [Detect language](#detect-language)
  - [Other methods](#other-methods)
- [API Methods](#api-methods)
  - [evaluate()](#evaluate)
  - [getLanguage()](#getlanguage)
  - [getScores()](#getscores)
  - [getSupportedLanguages()](#getsupportedlanguages)
  - [getText()](#gettext)


Features
--------

- More than 50 supported languages
- Very fast, no database needed
- Packaged with a 2MB dataset
- Learning steps are already done, library is ready to use
- Small code, small footprint
- N-grams algorithm
- Supports PHP 5.4, 5.5, 5.6, 7.0, 7.1, 7.2, 7.3 and HHVM


Install
------------

```sh
composer require landrok/language-detector
```

________________________________________________________________________

Quick usage
-----------

### Detect language

Instanciate a detector and pass a text.

Then, you can get the detected language.

```php
require_once 'vendor/autoload.php';

$text = 'My tailor is rich and Alison is in the kitchen with Bob.';

$detector = new LanguageDetector\LanguageDetector();

$language = $detector->evaluate($text)->getLanguage();

echo $language; // Prints something like 'en'
```

Once it's instanciated, you can check for multiple texts.

```php
require_once 'vendor/autoload.php';

// An array of texts to evaluate
$texts = [
    'My tailor is rich and Alison is in the kitchen with Bob.',
    'Mon tailleur est riche et Alison est dans la cuisine avec Bob'
];

$detector = new LanguageDetector\LanguageDetector();

foreach ($texts as $key => $text) {

    $language = $detector->evaluate($text)->getLanguage();

    echo sprintf(
        "Text %d, language=%s\n",
        $key,
        $language
    );
}

```

Would output something like:

```sh
Text 0, language=en
Text 1, language=fr
```
________________________________________________________________________

### Other methods

LanguageDetector has other information methods:

```php
[...]

// Gets all supported languages
$languages = $detector->getSupportedLanguages();

// Gets all scores
$scores = $detector->getScores();

```

You can see documentation for these methods below.

________________________________________________________________________

API Methods
-----------


#### evaluate()

__Type__ *\LanguageDetector\LanguageDetector*

It performs an evaluation on a given text.

__Example__

```php
$detector->evaluate('My tailor is rich and Alison is in the kitchen with Bob.');

// Then you have access to the detected language
$detector->getLanguage(); // Returns 'en'
```
You can make a one line call

```php
$detector->evaluate('My tailor is rich and Alison is in the kitchen with Bob.')->getLanguage(); // Returns 'en'
```
________________________________________________________________________

#### getLanguage()

__Type__ *string*

The detected language

__Example__

```php
$detector->getLanguage(); // Returns 'en'
```
________________________________________________________________________
#### getScores()

__Type__ *array*

A list of scores by language, for all evaluated languages.

__Example__

```php
$detector->getScores();

// Returns something like
Array
(
    [en] => 0.43950135722745
    [nl] => 0.40898789832569
    [...]
    [ja] => 0
    [fa] => 0
)


```
________________________________________________________________________
#### getSupportedLanguages()

__Type__ *array*

A list of supported languages that will be evaluated.

__Example__

```php
$detector->getSupportedLanguages();

// Returns something like
Array
(
    [0] => af
    [1] => ar
    [...]
    [51] => zh-cn
    [52] => zh-tw

)
```
________________________________________________________________________
#### getText()

__Type__ *string*

Returns the last string which has been evaluated

__Example__

```php
$detector->getText();

// Returns 'My tailor is rich and Alison is in the kitchen with Bob.'
```
________________________________________________________________________
