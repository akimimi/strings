<?php
use PHPUnit\Framework\TestCase;
use Akimimi\Strings\EditDistance;

final class WagnerFischerTest extends TestCase {

  public $algorithm = null;

  public function setUp(): void {
    $this->algorithm = EditDistance::CreateDistanceAlgorithm('WagnerFischer');
    parent::setUp();
  }

  /**
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::calculate
   * @covers \Akimimi\Strings\EditDistance::Character
   * @covers \Akimimi\Strings\EditDistance::CreateDistanceAlgorithm
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::initializeDistances
   */
  public function testAlgorithm(): void {
    $from  = "Q7BP06";
    $to = "Q3ss05";
    $distance = $this->algorithm->calculate($from, $to);
    $this->assertEquals(4, $distance);

    $to = "7BP";
    $distance = $this->algorithm->calculate($from, $to);
    $this->assertEquals(3, $distance);
  }

  /**
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::calculate
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::lastDistanceArray
   * @covers \Akimimi\Strings\EditDistance::Character
   * @covers \Akimimi\Strings\EditDistance::CreateDistanceAlgorithm
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::initializeDistances
   */
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

  /**
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::calculate
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::lastDistanceArray
   * @covers \Akimimi\Strings\EditDistance::Character
   * @covers \Akimimi\Strings\EditDistance::CreateDistanceAlgorithm
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::initializeDistances
   */
  public function testDistanceUnit() {
    $from = "Sunday";
    $to = "Saturday";
    $distance = $this->algorithm->calculate($from, $to, 0.5);
    $this->assertEquals(1.5, $distance);
    $this->assertEquals(array(
      3, 2.5, 2, 2, 2.5, 2.5, 2.5, 2, 1.5
    ), $this->algorithm->lastDistanceArray()[6]);
  }

  /**
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::calculate
   * @covers \Akimimi\Strings\BasicAlgorithm::setEncoding
   * @covers \Akimimi\Strings\EditDistance::Character
   * @covers \Akimimi\Strings\EditDistance::CreateDistanceAlgorithm
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::initializeDistances
   */
  public function testAlgorithmWithEncoding(): void {
    $from  = "北京大学信息科学技术学院";
    $to = "清华大学信息电子技术大院";
    $this->algorithm->setEncoding("UTF-8");
    $distance = $this->algorithm->calculate($from, $to);
    $this->assertEquals(5, $distance);

    $distance = $this->algorithm->calculate($from, $to, 0.5);
    $this->assertEquals(2.5, $distance);
  }

  /**
   * @covers \Akimimi\Strings\EditDistance::PrettyDistanceArray
   * @covers \Akimimi\Strings\BasicAlgorithm::setEncoding
   * @covers \Akimimi\Strings\EditDistance::Character
   * @covers \Akimimi\Strings\EditDistance::CreateDistanceAlgorithm
   * @covers \Akimimi\Strings\EditDistance::PrettyDistanceLine
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::calculate
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::initializeDistances
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::lastDistanceArray

   */
  public function testDistanceArrayDisplay(): void {
    $from  = "北京大学信息科学技术学院";
    $to = "清华大学信息电子技术大院";
    $this->algorithm->setEncoding("UTF-8");
    $distance = $this->algorithm->calculate($from, $to);
    $this->assertEquals(5, $distance);
    $str = EditDistance::PrettyDistanceArray($from, $to, $this->algorithm->lastDistanceArray());
    $this->assertGreaterThanOrEqual(mb_strlen($from) + mb_strlen($to), mb_strlen($str));
    $str = EditDistance::PrettyDistanceArray($from, $to, $this->algorithm->lastDistanceArray(), 'UTF-8');
    $this->assertGreaterThanOrEqual(mb_strlen($from) + mb_strlen($to), mb_strlen($str));
  }
}
