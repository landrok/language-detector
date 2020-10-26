<?php

namespace LanguageDetectorTest;

use LanguageDetector\LanguageDetector;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Exception;
use TypeError;

class LanguageDetectorExceptionTest extends TestCase
{
    /**
     * evaluate() only accepts strings
     */
    public function testEvaluateAnUnexpectedType()
    {
        $this->expectException(TypeError::class);

        $evaluator = new LanguageDetector();
        $evaluator->evaluate(array());
    }

    /**
     * evaluate() only accepts strings
     */
    public function testGetScoreBeforeEvaluating()
    {
        $this->expectException(Exception::class);

        $evaluator = new LanguageDetector();
        $evaluator->getScores();
    }
}
