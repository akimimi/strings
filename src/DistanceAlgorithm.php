<?php
namespace Akimimi\Strings;

interface DistanceAlgorithm {
  public function setEncoding(?string $encoding = null);

  public function initializeDistances(int $fromSize, int $toSize);

  public function calculate(string $from, string $to, float $distanceUnit = 1): float;

  public function lastDistanceArray(): array;
}