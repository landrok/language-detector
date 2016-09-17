<?php

namespace LanguageDetector;

use Exception;

class LanguageDetector
{ 
  private $subsets = array();
  private $datadir;

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
      throw new Exception('Module mbstring must be loaded');
    }

    foreach (glob($this->datadir . '/*') as $file)
    {
      $this->subsets[basename($file)] = json_decode(file_get_contents($file), true);
    }
  }

  /**
   * Evaluates the probability that the sentence matches a language
   * 
   * @param string $sentence
   * 
   * @return array
   */
  public function evaluate($sentence)
  {
    $probabilities = array();
    
    $chunks = $this->chunk($sentence);

    foreach ($this->subsets as $lang => $data)
    {
      $probabilities[$lang] = $this->calculate($chunks, $data['freq']);
    }

    arsort($probabilities);

    return array(
      'probabilities' => $probabilities,
      'sentence' => $sentence,
    );
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
