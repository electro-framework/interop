<?php

namespace Electro\Exceptions;

class FlashType
{
  const ERROR   = 1;
  const INFO    = 3;
  const NEUTRAL = 0;
  const SUCCESS = 4;
  const WARNING = 2;

  static function getLabel ($type)
  {
    return get (
      [
        self::ERROR   => 'alert-danger',
        self::INFO    => 'alert-info',
        self::NEUTRAL => '',
        self::SUCCESS => 'alert-success',
        self::WARNING => 'alert-warning',
      ], $type, '');
  }

}
