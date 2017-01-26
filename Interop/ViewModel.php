<?php

namespace Electro\Interop;

use Electro\Interfaces\Views\ViewModelInterface;
use Psr\Http\Message\ServerRequestInterface;

class ViewModel extends \ArrayObject implements ViewModelInterface
{
  /**
   * ViewModel constructor.
   *
   * <p>The constructor's argument is optional and may be an array or a ViewModel.
   *
   * ><p>**Note:** the constructor has none of the inherited ArrayObject's arguments so that subclasses may define
   * injectable dependencies on their constructor.
   */
  public function __construct ()
  {
    parent::__construct ([]);
  }

  public function set ($data)
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

  /**
   * Handles an HTTP request by setting view model data that dependens on the request's data.
   *
   * @param ServerRequestInterface $request
   * @return void
   */
  function handle (ServerRequestInterface $request)
  {
    // NO OP.
  }

}
