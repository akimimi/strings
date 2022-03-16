<?php
namespace Akimimi\Strings;

class WagnerFischerDistanceAlgorithm extends BasicAlgorithm implements DistanceAlgorithm {

  public $distances = array();

  public function initializeDistances(int $fromSize, int $toSize) {
    $this->distances = array();
    for ($i = 0; $i <= $fromSize; $i++) {
      $this->distances[$i] = array_fill(0, $toSize + 1, 0);
      if ($i == 0) {
        for ($j = 0; $j <= $toSize; $j++) {
          $this->distances[0][$j] = $j * $this->distanceUnit;
        }
      }
      $this->distances[$i][0] = $i * $this->distanceUnit;
    }
  }

  public function calculate(string $from, string $to, float $distanceUnit = 1): float {
    if ($this->encoding != null) {
      $fromSize = mb_strlen($from, $this->encoding);
      $toSize = mb_strlen($to, $this->encoding);
    } else {
      $fromSize = mb_strlen($from);
      $toSize = mb_strlen($to);
    }
    $this->distanceUnit = $distanceUnit;
    $this->initializeDistances($fromSize, $toSize);

    for ($i = 1; $i <= $fromSize; $i++) {
      for ($j = 1; $j <= $toSize; $j++) {
        if (EditDistance::Character($from, $i - 1, $this->encoding)
        == EditDistance::Character($to, $j - 1, $this->encoding)) {
          $subCost = 0;
        } else {
          $subCost = $distanceUnit;
        }
        $this->distances[$i][$j] = min(
          $this->distances[$i - 1][$j] + $distanceUnit, // $delDist
          $this->distances[$i][$j - 1] + $distanceUnit, // $insDist
          $this->distances[$i - 1][$j - 1] + $subCost //$subDist
        );
      }
    }

    return $this->distances[$fromSize][$toSize];
  }

  public function lastDistanceArray(): array {
    return $this->distances;
  }

}