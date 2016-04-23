<?php
namespace Selenia\Traits;
use Selenia\Interfaces\AssignableInterface;

/**
 * Allows a class instance to have its fields (either public or not) be mass-assigned or mass-read.
 * @implements AssignableInterface
 */
trait AssignableTrait
{
  /**
   * Creates a new instance of the class and assign's it the supplied data.
   * @param array $data
   * @return $this
   */
  static function _from (array $data)
  {
    return (new static)->import ($data);
  }

  /**
   * Loads the given data (object or array) into the object, overriding existing values.
   * > Note: this supports setting properties with any kind of visibility.
   *
   * @param array|AssignableInterface $data
   * @return $this For chaining.
   */
  function import ($data)
  {
    if ($data instanceof AssignableInterface)
      $data = $data->export ();
    foreach ($data as $k => $v)
      $this->$k = $v;
    return $this;
  }

  /**
   * Loads the given data (object or array) into the object, but only for those properties that are not already set on
   * it.
   * > Note: this supports setting properties with any kind of visibility.
   *
   * @param array|AssignableInterface $data
   * @return $this For chaining.
   */
  function setDdefaults ($data)
  {
    if ($data instanceof AssignableInterface)
      $data = $data->export ();
    foreach ($data as $k => $v)
      if (!isset($this->$k))
        $this->$k = $v;
    return $this;
  }

  /**
   * Exports all of object's properties, including private and protected ones.
   * @return array
   */
  function export ()
  {
    return get_object_vars ($this);
  }

}
