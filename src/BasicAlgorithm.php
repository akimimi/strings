<?php
namespace Akimimi\Strings;

class BasicAlgorithm {

  /**
   * @var string|null
   */
  public $encoding = null;

  /**
   * @var float
   */
  public $distanceUnit = 1;

  public function setEncoding(?string $encoding = null) {
    $this->encoding = $encoding;
  }
}
