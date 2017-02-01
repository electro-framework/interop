<?php

namespace Electro\Interop;

use Electro\Interfaces\Views\ViewModelInterface;

class ViewModel extends \ArrayObject implements ViewModelInterface
{
  /**
   * ViewModel constructor.
   *
   * This constructor hides the inherited constructor's arguments so that subclasses may define injectable
   * dependencies on their overriden constructor.
   */
  public function __construct ()
  {
    parent::__construct ([]);
  }

  function init ()
  {
    // No operation.
  }

  function set ($data)
  {
    if (!is_array ($data)) {
      if (is_object ($data) && $data instanceof self) {
        $this->exchangeArray (array_merge ($this->getArrayCopy (), $data->getArrayCopy ()));
        return;
      }
      throw new \InvalidArgumentException ("Argument must be an array or a " . __CLASS__ . " instance");
    }
    $this->exchangeArray (array_merge ($this->getArrayCopy (), $data));
  }

  function toArray ()
  {
    return $this->getArrayCopy ();
  }

}
