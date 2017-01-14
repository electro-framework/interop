<?php
namespace Electro\Exceptions;

class HttpException extends ExceptionWithTitle
{
  /**
   * @param int             $statusCode
   * @param string          $title Error description. It should be a single line of unformatted text.
   * @param string          $msg   Additional information about the error. It may contain HTML formatting.
   * @param \Exception|null $previous The exception that caused this exception.
   */
  function __construct ($statusCode = 500, $title = '', $msg = '', $previous = null)
  {
    parent::__construct ($title, $msg, $statusCode, $previous);
  }

}
