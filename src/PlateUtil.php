<?php
namespace Akimimi\Strings;

class PlateUtil {

  /**
   * Calculate distance between two plate numbers.
   * @param string $plate1 Plate number 1
   * @param string $plate2 Plate number 2
   * @param float $provinceDistance Distance value added if province is different
   * @param string|null $algorithm Select a distance calculation algorithm, default is Wagner-Fischer.
   * @param string|null $encoding Encoding for plate number string
   * @return float Plate number distance
   */
  static public function Distance(string $plate1, string $plate2, float $provinceDistance = 0.5, ?string $algorithm = null, ?string $encoding = null): float {
    $province1 = self::Province($plate1, $encoding);
    $province2 = self::Province($plate2, $encoding);
    $number1 = self::Number($plate1, $encoding);
    $number2 = self::Number($plate2, $encoding);
    return EditDistance::Calculate($province1, $province2, $algorithm, $encoding, $provinceDistance)
      + EditDistance::Calculate($number1, $number2, $algorithm, $encoding);
  }

  /**
   * Fetch province part for plate number.
   * @param string $plate
   * @param string|null $encoding
   * @return string
   */
  static public function Province(string $plate, ?string $encoding = null): string {
    if ($encoding != null) {
      return mb_substr($plate, 0, 1, $encoding);
    } else {
      return mb_substr($plate, 0, 1);
    }
  }

  /**
   * Fetch number part for plate number.
   * @param string $plate
   * @param string|null $encoding
   * @return string
   */
  static public function Number(string $plate, ?string $encoding = null): string {
    if ($encoding != null) {
      return mb_substr($plate, 1, mb_strlen($plate) - 1, $encoding);
    } else {
      return mb_substr($plate, 1, mb_strlen($plate) - 1);
    }
  }

}