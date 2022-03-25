<?php
use PHPUnit\Framework\TestCase;
use Akimimi\Strings\PlateUtil;

final class PlateUtilTest extends TestCase {

  public $algorithm = null;

  public function setUp(): void {
    parent::setUp();
  }

  /**
   * @covers \Akimimi\Strings\PlateUtil::Province
   */
  public function testProvince(): void {
    $plate = "京Q7BP06";
    $province = PlateUtil::Province($plate);
    $this->assertEquals('京', $province);

    $province = PlateUtil::Province($plate, "utf-8");
    $this->assertEquals('京', $province);
  }

  /**
   * @covers \Akimimi\Strings\PlateUtil::Number
   */
  public function testNumber(): void {
    $plate = "京Q7BP06";
    $number = PlateUtil::Number($plate);
    $this->assertEquals('Q7BP06', $number);

    $number = PlateUtil::Number($plate, "utf-8");
    $this->assertEquals('Q7BP06', $number);
  }

  /**
   * @covers \Akimimi\Strings\PlateUtil::Distance
   * @covers \Akimimi\Strings\BasicAlgorithm::setEncoding
   * @covers \Akimimi\Strings\EditDistance::Calculate
   * @covers \Akimimi\Strings\EditDistance::Character
   * @covers \Akimimi\Strings\EditDistance::CreateDistanceAlgorithm
   * @covers \Akimimi\Strings\PlateUtil::Number
   * @covers \Akimimi\Strings\PlateUtil::Province
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::calculate
   * @covers \Akimimi\Strings\WagnerFischerDistanceAlgorithm::initializeDistances
   */
  public function testDistance(): void {
    $plate1 = "京Q7BP06";
    $plate2 = "京NX9V66";
    $distance = PlateUtil::Distance($plate1, $plate2);
    $this->assertEquals(5, $distance);

    $plate2 = "晋NX9V66";
    $distance = PlateUtil::Distance($plate1, $plate2, 0.5);
    $this->assertEquals(5.5, $distance);

    $plate2 = "晋7BP0A6";
    $distance = PlateUtil::Distance($plate1, $plate2, 0.5);
    $this->assertEquals(2.5, $distance);
  }

}