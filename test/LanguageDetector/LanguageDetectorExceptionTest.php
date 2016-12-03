<?php

namespace LanguageDetectorTest;

use PHPUnit_Framework_TestCase;
use LanguageDetector\LanguageDetector;

class LanguageDetectorExceptionTest extends PHPUnit_Framework_TestCase
{
  /**
   * evaluate() only accepts strings
   * 
   * @expectedException \InvalidArgumentException
   */
  public function testEvaluateAnUnexpectedType()
  {
    (new LanguageDetector())->evaluate(array());
  }

  /**
   * getScores() must be preceded by an evaluation
   * 
   * @expectedException \Exception
   */
  public function testGetScoresWithNoEvaluatedString()
  {
    (new LanguageDetector())->getScores();
  }

  /**
   * getLanguage() must be preceded by an evaluation
   *
   * @expectedException \Exception
   */
  public function testGetLanguageWithNoEvaluatedString()
  {
    (new LanguageDetector())->getLanguage();
  }
}
