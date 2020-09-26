<?php

namespace LanguageDetectorTest;

use LanguageDetector\Language;
use LanguageDetector\LanguageDetector;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class LanguageSubsetTest extends TestCase
{
    /**
     * Valid scenarios provider
     */
    public function getLanguageSubsetScenarios()
    {
        // expected, string, message
        return [
            ['', InvalidArgumentException::class],
            ['wrong-code', InvalidArgumentException::class],
            ['af', ],
            ['ar', ],
            ['bg', ],
            ['cs', ],
            ['da', ],
            ['de', ],
            ['el', ],
            ['en', ],
            ['es', ],
            ['et', ],
            ['fa', ],
            ['fi', ],
            ['fr', ],
            ['gu', ],
            ['he', ],
            ['hi', ],
            ['hr', ],
            ['hu', ],
            ['id', ],
            ['it', ],
            ['i-klingon', ],
            ['ja', ],
            ['kn', ],
            ['ko', ],
            ['lt', ],
            ['lv', ],
            ['mk', ],
            ['ml', ],
            ['mr', ],
            ['ne', ],
            ['nl', ],
            ['no', ],
            ['pa', ],
            ['pl', ],
            ['pt', ],
            ['ro', ],
            ['ru', ],
            ['sk', ],
            ['sl', ],
            ['sq', ],
            ['sv', ],
            ['sw', ],
            ['ta', ],
            ['te', ],
            ['th', ],
            ['tl', ],
            ['tr', ],
            ['uk', ],
            ['ur', ],
            ['vi', ],
            ['zh-cn', ],
            ['zh-tw', ],
        ];
    }

    /**
     * Tests that subset are loaded
     *
     * @dataProvider getLanguageSubsetScenarios
     */
    public function testSubsetContents($code, $expected = null)
    {
        if (!is_null($expected)) {
            if ($expected == InvalidArgumentException::class) {
                $this->expectException(InvalidArgumentException::class);
            }
        }

        $language = new Language(
            dirname(dirname(__DIR__))
            . '/src/LanguageDetector/subsets/'
            . $code
        );

        $this->assertGreaterThan(
            0,
            array_sum($language->getNWords())
        );
    }

    /**
     * Tests that getCode return s a valid code
     *
     * @dataProvider getLanguageSubsetScenarios
     */
    public function testSubsetGetCode($code, $expected = null)
    {
        if (!is_null($expected)) {
            if ($expected == InvalidArgumentException::class) {
                $this->expectException(InvalidArgumentException::class);
            }
        }

        $language = new Language(
            dirname(dirname(__DIR__))
            . '/src/LanguageDetector/subsets/'
            . $code
        );

        $this->assertEquals(
            $code,
            $language->getCode()
        );

        $this->assertEquals(
            $code,
            (string)$language
        );
    }

    /**
     * Tests that a limited number of subsets has been loaded
     */
    public function testLimitLoadedSubsets()
    {
        $subsets = ['da', 'en', 'no', 'sv'];

        $language = new LanguageDetector(null, $subsets);

        $this->assertEquals(
            $subsets,
            $language->getLanguages()
        );

        $language = LanguageDetector::detect('ok', $subsets);

        $this->assertEquals(
            $subsets,
            $language->getLanguages()
        );
    }
}
