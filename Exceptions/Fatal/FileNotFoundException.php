<?php
namespace Electro\Exceptions\Fatal;

use Electro\Exceptions\FatalException;

class FileNotFoundException extends FatalException
{

  public function __construct ($filename, $extra = '')
  {
    if ($extra) $extra = "
$extra";
    parent::__construct ("File <kbd>$filename</kbd> was not found.$extra");
  }

}
