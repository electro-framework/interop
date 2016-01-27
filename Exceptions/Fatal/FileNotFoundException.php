<?php
namespace Selenia\Exceptions\Fatal;

use Selenia\Exceptions;
use Selenia\Exceptions\FatalException;

class FileNotFoundException extends FatalException
{

  public function __construct ($filename, $extra = '')
  {
    parent::__construct ("File <b>$filename</b> was not found.$extra");
  }

}
