<?php
namespace Selenia\Exceptions;

use Selenia\Exceptions;

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
   */
  function __construct ($title = '', $msg = '', $code = 0)
  {
    parent::__construct ($msg, $code);
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
