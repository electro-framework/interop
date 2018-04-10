<?php
namespace Electro\Exceptions;

class FlashMessageException extends ExceptionWithTitle
{
  protected $status;

  /**
   * FlashMessageException constructor.
   *
   * @param string $message Error message.
   * @param int    $status  One of the {@see FlashType}::XXX constants.
   * @param string $title
   */
  public function __construct ($message, $status, $title = '')
  {
    parent::__construct ($title, $message, $status);
  }

}
