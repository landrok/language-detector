<?php

namespace LanguageDetectorTest;

use PHPUnit_Framework_TestCase;
use LanguageDetector\LanguageDetector;

class LanguageDetectorExceptionTest extends PHPUnit_Framework_TestCase
{
  protected $evaluator;

  protected function setUp()
  {
    $this->evaluator = new LanguageDetector();
  }

  /**
   * evaluate() only accepts strings
   * 
   * @expectedException \InvalidArgumentException
   */
  public function testEvaluateAnUnexpectedType()
  {
    $this->evaluator->evaluate(array());
  }

  /**
   * getScores() must be preceded by an evaluation
   * 
   * @expectedException \Exception
   */
  public function testGetScoresWithNoEvaluatedString()
  {
    $this->evaluator->getScores();
  }

  /**
   * getLanguage() must be preceded by an evaluation
   *
   * @expectedException \Exception
   */
  public function testGetLanguageWithNoEvaluatedString()
  {
    $this->evaluator->getLanguage();
  }
}
