<?php

namespace LanguageDetectorTest;

use LanguageDetector\LanguageDetector;
use PHPUnit\Framework\TestCase;

class LanguageDetectorExceptionTest extends TestCase
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
     * evaluate() only accepts strings
     * 
     * @expectedException \Exception
     */
    public function testGetScoreBeforeEvaluating()
    {
        $this->evaluator->getScores();
    }
}
