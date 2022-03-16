<?php
use PHPUnit\Framework\TestCase;
use Akimimi\Strings\PlateUtil;

final class PlateUtilTest extends TestCase {

  public $algorithm = null;

  public function setUp(): void {
    parent::setUp();
  }

  public function testProvince(): void {
    $plate = "京Q7BP06";
    $province = PlateUtil::Province($plate);
    $this->assertEquals('京', $province);
  }

  public function testNumber(): void {
    $plate = "京Q7BP06";
    $number = PlateUtil::Number($plate);
    $this->assertEquals('Q7BP06', $number);
  }

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