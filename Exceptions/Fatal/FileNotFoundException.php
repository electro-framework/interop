<?php
namespace Selenia\Exceptions\Fatal;

use Selenia\Exceptions;
use Selenia\Exceptions\FatalException;

class FileNotFoundException extends FatalException
{

  public function __construct ($filename, $extra = '')
  {
    parent::__construct ("<p>File <kbd>$filename</kbd> was not found.</p>$extra");
  }

}
