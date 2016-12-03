<?php

namespace LanguageDetector;

use Exception;
use InvalidArgumentException;

class LanguageDetector
{
  /** @var array */
  private $subsets = [];

  /** @var string */
  private $datadir;

  /** @var array */
  private $scores;

  /** @var string */
  private $text;

  /**
   * Loads all subsets
   * 
   * @param string $dir A directory where subsets are.
   * 
   * @throws \Exception if mbstring is not loaded
   */
  public function __construct($dir = null)
  {
    $this->datadir = null === $dir
      ? __DIR__ . '/subsets' : rtrim($dir, '/');

    if (!extension_loaded('mbstring'))
    {
      throw new Exception('Module mbstring must be loaded'); // @codeCoverageIgnore
    }

    foreach (glob($this->datadir . '/*') as $file)
    {
      $this->subsets[basename($file)] = json_decode(
          file_get_contents($file), true
      );
    }
  }

  /**
   * Evaluates that a string matches a language
   * 
   * @param string $text
   * 
   * @return \LanguageDetector\LanguageDetector
   * 
   * @throws \InvalidArgumentException if $string is not a string
   * 
   * @api
   */
  public function evaluate($text)
  {
    if (!is_string($text))
    {
      throw new InvalidArgumentException('Parameter $string must be a string');
    }

    $this->text = $text;

    $chunks = $this->chunk();

    array_walk(
      $this->subsets,
      function($data, $lang) use ($chunks) {
        $this->scores[$lang] = $this->calculate($chunks, $data['freq']);
      }
    );

    arsort($this->scores);

    return $this;
  }

  /**
   * Gets the best scored language
   * 
   * @return string ISO code
   * 
   * @throws \Exception if nothing has been evaluated
   * 
   * @api
   */
  public function getLanguage()
  {
    if (!is_array($this->scores))
    {
      throw new Exception('No string has been evaluated');
    }

    return array_keys($this->scores)[0];
  }

  /**
   * Get all scored subsets
   * 
   * @return array An array of ISO codes => scores
   * 
   * @throws \Exception if nothing has been evaluated
   * 
   * @api
   */
  public function getScores()
  {
    if (!is_array($this->scores))
    {
      throw new Exception('No string has been evaluated');
    }

    return $this->scores;
  }

  /**
   * Get all supported languages
   * 
   * @return array An array of ISO codes
   * 
   * @api
   */
  public function getSupportedLanguages()
  {
    return array_keys($this->subsets);
  }

  /**
   * Get evaluated text
   * 
   * @return string
   * 
   * @api
   */
  public function getText()
  {
    return $this->text;
  }

  /**
   * Evaluate probabilities for one language
   * 
   * @param array $chunks
   *
   * @param array $data
   * 
   * @return float Probabilities that chunks match a subset
   */
  private function calculate(array $chunks, array $data)
  {
    return array_sum(array_intersect_key($data, array_flip($chunks)))
         / array_sum(array_values($data));
  }

  /**
   * Chunk a text
   * 
   * @return array
   */
  private function chunk()
  {
    $chunks = [];
    $len = mb_strlen($this->text);

    for ($i = 0; $i < 3; $i++) // Chunk sizes 
    {
      for ($j = 0; $j < $len; $j++)
      {
        if ($len > $j + $i)
        {
          $chunks[] = mb_substr($this->text, $j, $i + 1);
        }
      }
    }

    return $chunks;
  }
}
