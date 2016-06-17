<?php
namespace Electro\Exceptions\Fatal;

use Electro\Exceptions;
use Electro\Exceptions\FatalException;

class FileNotFoundException extends FatalException
{

  public function __construct ($filename, $extra = '')
  {
    parent::__construct ("<p>File <kbd>$filename</kbd> was not found.</p>$extra");
  }

}
