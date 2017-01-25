<?php

namespace Electro\Interop;

/**
 * A kind of storage similar to an array but for exclusive use as a data source for rendering views.
 *
 * <p>The view model's content *must* be accessed via the array access syntax (i.e. `[]`).
 *
 * <p>View models behave mostly as arrays do, but they are not *copy-on-write*, so changes made to an instance are
 * visible to all functions that have a reference to that instance.
 *
 * ><p>You can't use view models with the standard array functions (ex: `array_merge`).
 *
 */
class ViewModel extends \ArrayObject
{
  /**
   * ViewModel constructor.
   *
   * <p>The constructor's argument is optional and may be an array or a ViewModel.
   *
   * ><p>**Note:** the constructor has none of the inherited ArrayObject's arguments to prevent incorrect configuration
   * of it and to provide a stable API.
   *
   * @param array|self $data
   */
  public function __construct ($data = null)
  {
    if (isset($data)) {
      if (!is_array ($data)) {
        if (is_object ($data) && $data instanceof self)
          $data = $data->getArrayCopy ();
        else throw new \InvalidArgumentException ("Argument must be an array or a " . __CLASS__ . " instance");
      }
    }
    else $data = [];
    parent::__construct ($data);
  }

  /**
   * Merges the provided data with the current view model's data.
   *
   * @param array|self $data
   */
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

}
