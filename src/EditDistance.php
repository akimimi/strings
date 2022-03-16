<?php
namespace Akimimi\Strings;

class EditDistance {

  const DefaultAlgorithm = 'WagnerFischer';

  static public function CreateDistanceAlgorithm(?string $algorithm = self::DefaultAlgorithm): DistanceAlgorithm {
    return new WagnerFischerDistanceAlgorithm();
  }

  /**
   * Calculate distance between two strings. Default algorithm is Wagner-Fischer. If $distanceUnit is provided,
   * calculated distance value will be multiplied by $distanceUnit.
   * @param string $from A string to compare.
   * @param string $to Another string to compare with $from.
   * @param string|null $algorithm Distance algorithm for calculation. Default is Wagner-Fischer.
   * @param string|null $encoding Encoding of the compare strings.
   * @param float $distanceUnit Distance will be multiplied by $distanceUnit, default is 1.
   * @return float
   */
  static public function Calculate(string $from, string $to, ?string $algorithm, ?string $encoding, float $distanceUnit = 1): float{
    $algorithm = self::CreateDistanceAlgorithm($algorithm);
    $algorithm->setEncoding($encoding);
    return $algorithm->calculate($from, $to, $distanceUnit);
  }

  /**
   * Transfer distance array of two strings into string for observing distance values.
   * @param string $from A string to compare.
   * @param string $to Another string to compare with $from.
   * @param array $distances Distance array in (m + 1) x (n + 1) dimension. Where m is size of $from, n is size of $to.
   * @param string|null $encoding Encoding of the compare strings.
   * @return string
   */
  static public function PrettyDistanceArray(string $from, string $to, array $distances, ?string $encoding = null): string {
    if ($encoding != null) {
      $fromSize = mb_strlen($from, $encoding);
      $toSize = mb_strlen($to, $encoding);
    } else {
      $fromSize = mb_strlen($from);
      $toSize = mb_strlen($to);
    }
    $head = "";
    for ($j = 0; $j < $toSize + 2; $j++) {
      if ($j <= 1) {
        $head .= " \t";
      } else {
        $head .= self::Character($to, $j - 2, $encoding)."\t";
      }
    }
    $body = " \t".self::PrettyDistanceLine($distances[0])."\n";
    for ($i = 0; $i < $fromSize; $i++) {
      $body .= self::Character($from, $i)."\t".self::PrettyDistanceLine($distances[$i + 1])."\n";
    }
    return $head."\n".$body;
  }

  static public function PrettyDistanceLine($line): string {
    return implode("\t", $line);
  }

  /**
   * Fetch a character in the string with unicode support.
   * @param string $str String to fetch.
   * @param int $pos Character position.
   * @param string|null $encoding Encoding of the string.
   * @return string
   */
  static public function Character(string $str, int $pos, ?string $encoding = null): string {
    if ($encoding != null) {
      return mb_substr($str, $pos, 1, $encoding);
    } else {
      return mb_substr($str, $pos, 1);
    }
  }
}