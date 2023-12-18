LanguageDetector
================

[![Build Status](https://travis-ci.com/landrok/language-detector.svg?branch=master)](https://travis-ci.com/landrok/language-detector)
[![Test Coverage](https://codeclimate.com/github/landrok/language-detector/badges/coverage.svg)](https://codeclimate.com/github/landrok/language-detector/coverage)
[![Code Climate](https://codeclimate.com/github/landrok/language-detector/badges/gpa.svg)](https://codeclimate.com/github/landrok/language-detector)

LanguageDetector is a PHP library that detects the language from a text
string.

Table of contents
=================
- [Features](#features)
- [Install](#install)
- [Quick usage](#quick-usage)
  - [Detect language](#detect-language)
- [API Methods](#api-methods)
  - [evaluate()](#evaluate)
  - [getLanguage()](#getlanguage)
  - [getLanguages()](#getLanguages)
  - [getScores()](#getscores)
  - [getSupportedLanguages()](#getsupportedlanguages)
  - [getText()](#gettext)
  - [options](#options)
  - [For one-liners only](#for-one-liners-only)



Features
--------

- More than 50 supported languages, including Klingon
- Very fast, no database needed
- Packaged with a 2MB dataset
- Learning steps are already done, library is ready to use
- Small code, small footprint
- N-grams algorithm
- Supports PHP 5.4+, 7+ and 8+ and HHVM
  The latest release 1.4.x only supports PHP>=7.4


Install
------------

```sh
composer require landrok/language-detector
```

________________________________________________________________________

Quick usage
-----------

### Detect language

Instanciate a detector, pass a text and get the detected language.

```php
require_once 'vendor/autoload.php';

$text = 'My tailor is rich and Alison is in the kitchen with Bob.';

$detector = new LanguageDetector\LanguageDetector();

$language = $detector->evaluate($text)->getLanguage();

echo $language; // Prints something like 'en'
```

Once it's instanciated, you can test multiple texts.

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

Additionally, you can use a _LanguageDetector_ instance as a string.

```php
require_once 'vendor/autoload.php';

$text = 'My tailor is rich and Alison is in the kitchen with Bob.';

$detector = new LanguageDetector\LanguageDetector();

echo $detector->evaluate($text); // Prints something like 'en'
echo $detector; // Prints something like 'en' after an evaluate()
```

________________________________________________________________________

API Methods
-----------

#### evaluate()

__Type__ *\LanguageDetector\LanguageDetector*

It performs an evaluation on a given text.

__Example__

After an `evaluate()`, the result is stored and available for later use.

```php
$detector->evaluate('My tailor is rich and Alison is in the kitchen with Bob.');

// Then you have access to the detected language
$detector->getLanguage(); // Returns 'en'
```

You can make a one line call.

```php
$detector->evaluate('My tailor is rich and Alison is in the kitchen with Bob.')
         ->getLanguage(); // Returns 'en'
```

It's possible to directly print `evaluate()` output.

```php
// Returns 'en'
echo $detector->evaluate('My tailor is rich and Alison is in the kitchen with Bob.');

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

#### getLanguages()

__Type__ *array*

A list of loaded models that will be evaluated.

__Example__

```php
$detector->getLanguages(); // Returns something like ['de', 'en', 'fr']
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

#### Options

__Type__ *\LanguageDetector\LanguageDetector*

For even better performance, loaded models can be specified explicitly.

__Example__

```php

$text = 'My tailor is rich and Alison is in the kitchen with Bob.';

$detector = new LanguageDetector(null, ['en', 'fr', 'de']);

$language = $detector->evaluate($text);

echo $language; // Prints something like 'en'
```
________________________________________________________________________

#### For one-liners only

__Type__ *\LanguageDetector\LanguageDetector*

With a static call on detect() method, you can perform an evaluation on
a given text, in one line.

__Example__

```php

echo LanguageDetector\LanguageDetector::detect(
    'My tailor is rich and Alison is in the kitchen with Bob.'
); // Returns 'en'
```

You can use all API methods.

```php
$detector = LanguageDetector\LanguageDetector::detect(
    'My tailor is rich and Alison is in the kitchen with Bob.'
);

// en
echo $detector;

// en
echo $detector->getLanguage();

// An array of all scores, see API method
print_r($detector->getScores());

// An array of all supported languages, see API method
print_r($detector->getSupportedLanguages());

// The last evaluated string
echo $detector->getText();

// Limit loaded languages for even better performance
echo LanguageDetector\LanguageDetector::detect(
    'My tailor is rich and Alison is in the kitchen with Bob.',
    ['en', 'de', 'fr', 'es']
); // en

```
________________________________________________________________________
