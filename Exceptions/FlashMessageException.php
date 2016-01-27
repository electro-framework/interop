<?php
namespace Selenia\Exceptions;

class FlashMessageException extends ExceptionWithTitle
{
  protected $status;

  public function __construct ($message, $status, $title = '')
  {
    parent::__construct ($title, $message, $status);
  }

}
