Akimimi\Strings
================================================================

## Description

This library provides some string utilities. 

`EditDistance` class calculates the edit distance between two strings. 
Wagner-Fischer algorithm is currently provided.

`PlateUtil` provides functions for plate number on vehicles.

## Installation

This library support Add require with composer CLI.
```bash
composer require akimimi/strings
```
Otherwise, add require to your `composer.json`.
```json
{
  "require": {
     "akimimi/strings": ">=1.0.0"
  }
}
```

Use Composer to install requires
```bash
composer install
```

## Usage

After installation by composer, you can declare use for PlatUtil class.
```php
<?php
use Akimimi\Strings\PlateUtil;

$plate1 = "京Q7BP06";
$plate1 = "晋7BP0A6";

$distance = PlateUtil::Distance($plate1, $plate2, 0.5); // return 2.5
```

