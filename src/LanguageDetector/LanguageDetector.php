<?php

namespace LanguageDetector;

use Exception;

class LanguageDetector
{ 
  private $subsets = array();
  private $datadir;
  private $scores;
  private $string;

  /**
   * Loads all subsets
   * 
   * @param string $dir A directory where subsets are.
   * 
   * @throws Exception if mbstring is not loaded
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
      $this->subsets[basename($file)] = json_decode(file_get_contents($file), true);
    }
  }

  /**
   * Evaluates that a string matches a language
   * 
   * @param string $string
   * 
   * @return LanguageDetector $this
   * 
   * @throws Exception if $string is not a string
   */
  public function evaluate($string)
  {
    if (!is_string($string))
    {
      throw new Exception('Parameter $string must be a string');
    }

    $scores = array();
    $chunks = $this->chunk($string);

    foreach ($this->subsets as $lang => $data)
    {
      $scores[$lang] = $this->calculate($chunks, $data['freq']);
    }

    arsort($scores);

    $this->scores = $scores;
    $this->string = $string;

    return $this;
  }

  /**
   * Gets the best scored language
   * 
   * @return string ISO code
   * 
   * @throws Exception if nothing has been evaluated
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
   * Gets all scored subsets
   * 
   * @return array An array of ISO codes => scores
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
   * Gets supported languages
   * 
   * @return array An array of ISO codes
   */
  public function getSupportedLanguages()
  {
    return array_keys($this->subsets);
  }

  /**
   * Evaluates the probabilities for one language
   * 
   * @param array $chunks
   * @param array $data
   * 
   * @return float The probabilities that chunks match this subset
   */
  private function calculate(array $chunks, array $data)
  {
    return array_sum(array_values(array_intersect_key($data, array_flip($chunks))))
         / array_sum(array_values($data));
  }

  /**
   * Divides sentence into chunks
   * 
   * @param string $sentence
   * 
   * @return array
   */
  private function chunk($sentence)
  {
    $chunks = array();
    $len = mb_strlen($sentence);

    for ($i=0; $i<3; $i++) // Chunk sizes 
    {
      for ($j=0; $j<$len; $j++)
      {
        if ($len > $j + $i)
        {
          array_push($chunks, mb_substr($sentence, $j, $i + 1));
        }
      }
    }

    return $chunks;
  }
}
