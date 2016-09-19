<?php

namespace LanguageDetectorTest;

use PHPUnit_Framework_TestCase;
use LanguageDetector\LanguageDetector;

class LanguageDetectorExceptionTest extends PHPUnit_Framework_TestCase
{
  /**
   * @expectedException Exception
   */
  public function testGetScoresWithNoEvaluatedString()
  {
    (new LanguageDetector())->getScores();
  }

  /**
   * @expectedException Exception
   */
  public function testGetLanguageWithNoEvaluatedString()
  {
    (new LanguageDetector())->getLanguage();
  }

  /**
   * @expectedException Exception
   */
  public function testEvaluateAnUnexpectedType()
  {
    (new LanguageDetector())->evaluate(array());
  }
}
