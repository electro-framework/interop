<?php
namespace Electro\Traits;

use Electro\Interfaces\OverlayInterface;

/**
 * Allows instances of the class to inherit properties at runtime from another object.
 *
 * <p>To use this trait, a class MUST also implement {@see OverlayInterface}.
 *
 * <p>If the parent object also implements {@see OverlayInterface}, the inheritance chain propagates to that
 * object, and so on.
 */
trait OverlayTrait
{
  /**
   * @var object|array
   */
  private $_parent;

  function __debugInfo ()
  {
    return $this->getAllProperties ();
  }

  function __get ($name)
  {
    return is_array ($this->_parent) ? $this->_parent[$name] : $this->_parent->$name;
  }

  function __set ($name, $value)
  {
    $this->$name = $value;
  }

  function __isset ($name)
  {
    return is_array ($this->_parent) ? isset($this->_parent[$name]) : isset($this->_parent->$name);
  }

  function __unset ($name)
  {
    if (is_array ($this->_parent))
      unset ($this->_parent[$name]);
    else unset ($this->_parent->$name);
  }

  function extend ($parent = null)
  {
    if ($parent)
      return $this->_parent = $parent;
    return $this->_parent;
  }

  function getAllProperties ()
  {
    return array_merge ($this->_parent instanceof OverlayInterface
      ? $this->_parent->getAllProperties ()
      : (is_array ($this->_parent) ? $this->_parent : get_object_vars ($this->_parent)),
      object_publicProps ($this));
  }

}
