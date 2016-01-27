<?php
namespace Selenia\Exceptions;

use Selenia\Exceptions;

class HttpException extends ExceptionWithTitle
{
  /**
   * @param int    $statusCode
   * @param string $title Error description. It should be a single line of unformatted text.
   * @param string $msg   Additional information about the error. It may contain HTML formatting.
   */
  function __construct ($statusCode = 500, $title = '', $msg = '')
  {
    parent::__construct ($title, $msg, $statusCode);
  }

}
