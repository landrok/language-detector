LanguageDetector
================

[![Build Status](https://travis-ci.org/landrok/language-detector.svg?branch=master)](https://travis-ci.org/landrok/language-detector)
[![Test Coverage](https://codeclimate.com/github/landrok/language-detector/badges/coverage.svg)](https://codeclimate.com/github/landrok/language-detector/coverage)
[![Code Climate](https://codeclimate.com/github/landrok/language-detector/badges/gpa.svg)](https://codeclimate.com/github/landrok/language-detector)

LanguageDetector is a PHP library that detects the language from strings or texts.

Table of contents
=================
- [Features](#features)
- [Install](#install)
- [Examples](#examples)
  - [Single detection](#single-detection)
  - [Multiple detections](#multiple-detections)
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
- Packaged with a 2MB learned dataset
- Small code, easy to modify
- N-grams algorithm
- Supports PHP 5.4, 5.5, 5.6, 7.0, 7.1 and HHVM


Install
------------

```sh
composer require landrok/language-detector:1.0
```

________________________________________________________________________

Examples
--------
________________________________________________________________________

### Single detection

This usage is not recommended if you want to make several consecutive evaluations

```php
require_once 'vendor/autoload.php';

// One line usage: instanciate, evaluate and get language
$lang = ( new LanguageDetector\LanguageDetector() )
          ->evaluate('My sentence is in english')
          ->getLanguage();
```
________________________________________________________________________

### Multiple detections

If you have a list of texts to detect, a possible way is to instanciate 
once and then to translate your list.

```php
require_once 'vendor/autoload.php';

$texts = [
  'My sentence is in english',
  'My sentence number two is in english too'
];

$results = [];

$detector = new LanguageDetector\LanguageDetector();

foreach ($texts as $text)
{
  $results[] = $detector->evaluate($text)->getLanguage();
}
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

________________________________________________________________________

API Methods
-----------

________________________________________________________________________
####evaluate()

__Type__ *\LanguageDetector\LanguageDetector*

It performs an evaluation of a given text.

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

####getLanguage()

__Type__ *string*

The detected language

__Example__

```php
$detector->getLanguage(); // Returns 'en'
```
________________________________________________________________________
####getScores()

__Type__ *array*

A list of scores by languages, for all evaluated languages.

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
####getSupportedLanguages()

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
####getText()

__Type__ *string*

Returns the last string which has been evaluated

__Example__

```php
$detector->getText();

// Returns 'My tailor is rich and Alison is in the kitchen with Bob.'
```
________________________________________________________________________
