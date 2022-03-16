<?php
use PHPUnit\Framework\TestCase;
use Akimimi\Strings\EditDistance;

final class WagnerFischerTest extends TestCase {

  public $algorithm = null;

  public function setUp(): void {
    $this->algorithm = EditDistance::CreateDistanceAlgorithm('WagnerFischer');
    parent::setUp();
  }

  public function testAlgorithm(): void {
    $from  = "Q7BP06";
    $to = "Q3ss05";
    $distance = $this->algorithm->calculate($from, $to);
    $this->assertEquals(4, $distance);

    $to = "7BP";
    $distance = $this->algorithm->calculate($from, $to);
    $this->assertEquals(3, $distance);
  }

  public function testDistanceArray() {
    $from = "sitting";
    $to = "kitten";
    $distance = $this->algorithm->calculate($from, $to);
    $this->assertEquals(3, $distance);
    $this->assertEquals(array(
      7,7,6,5,4,4,3
    ), $this->algorithm->lastDistanceArray()[7]);

    $from = "Sunday";
    $to = "Saturday";
    $distance = $this->algorithm->calculate($from, $to);
    $this->assertEquals(3, $distance);
    $this->assertEquals(array(
      6,5,4,4,5,5,5,4,3
    ), $this->algorithm->lastDistanceArray()[6]);
  }

  public function testDistanceUnit() {
    $from = "Sunday";
    $to = "Saturday";
    $distance = $this->algorithm->calculate($from, $to, 0.5);
    $this->assertEquals(1.5, $distance);
    $this->assertEquals(array(
      3, 2.5, 2, 2, 2.5, 2.5, 2.5, 2, 1.5
    ), $this->algorithm->lastDistanceArray()[6]);
  }

  public function testAlgorithmWithEncoding(): void {
    $from  = "北京大学信息科学技术学院";
    $to = "清华大学信息电子技术大院";
    $this->algorithm->setEncoding("UTF-8");
    $distance = $this->algorithm->calculate($from, $to);
    $this->assertEquals(5, $distance);

    $distance = $this->algorithm->calculate($from, $to, 0.5);
    $this->assertEquals(2.5, $distance);
  }
}
