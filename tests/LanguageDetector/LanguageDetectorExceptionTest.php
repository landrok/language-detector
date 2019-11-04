<?php

namespace LanguageDetectorTest;

use LanguageDetector\LanguageDetector;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Exception;

class LanguageDetectorExceptionTest extends TestCase
{
    protected $evaluator;

    protected function setUp() : void
    {
        $this->evaluator = new LanguageDetector();
    }

    /**
     * evaluate() only accepts strings
     */
    public function testEvaluateAnUnexpectedType()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->evaluator->evaluate(array());
    }

    /**
     * evaluate() only accepts strings
     */
    public function testGetScoreBeforeEvaluating()
    {
        $this->expectException(Exception::class);

        $this->evaluator->getScores();
    }
}
