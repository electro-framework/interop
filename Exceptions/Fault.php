<?php
namespace Selenia\Exceptions;

use Exception;

class Fault extends \Exception
{
  public $type;

  public function __construct ($type, ...$args)
  {
    $this->type = $type;
    parent::__construct (sprintf ($type, ...$args));
  }

}
