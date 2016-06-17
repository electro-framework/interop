<?php
namespace Electro\Exceptions\Fatal;

use Electro\Exceptions;
use Electro\Exceptions\FatalException;

class FileWriteException extends FatalException
{

  public function __construct ($filename)
  {
    parent::__construct ("File <b>$filename</b> can't be written to.\nPlease check the permissions on the file or on the containing folder.");
  }

}
