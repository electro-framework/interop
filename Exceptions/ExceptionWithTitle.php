<?php
namespace Electro\Exceptions;

use Electro\Exceptions;

class ExceptionWithTitle extends \Exception
{
  /**
   * @var string
   */
  protected $title;

  /**
   * @param string $title
   * @param string $msg
   * @param int    $code
   * @param \Exception|null $previous The exception that caused this exception.
   */
  function __construct ($title = '', $msg = '', $code = 0, $previous = null)
  {
    parent::__construct ($msg, $code, $previous);
    $this->title = $title;
  }

  /**
   * Gets the Exception title.
   * @return string
   */
  function getTitle ()
  {
    return $this->title;
  }
}
