<?php
namespace Selenia\Traits;

use Selenia\Interfaces\InheritanceInterface;

/**
 * Allows instances of the class to inherit properties at runtime from another object.
 *
 * <p>To use this trait, a class MUST also implement {@see InheritanceInterface}.
 *
 * <p>If the parent object also implements {@see InheritanceInterface}, the inheritance chain propagates to that
 * object, and so on.
 */
trait InheritanceTrait
{
  /**
   * @var object
   */
  private $_parent;

  function __debugInfo ()
  {
    return $this->getProperties ();
  }

  function __get ($name)
  {
    return $this->_parent->$name;
  }

  function __set ($name, $value)
  {
    $this->_parent->$name = $value;
  }

  function __isset ($name)
  {
    return isset($this->_parent->$name);
  }

  function __unset ($name)
  {
    unset ($this->_parent->$name);
  }

  /**
   * Sets the parent object that the instance inherits from.
   *
   * @param object $parent [optional]
   * @return null|object
   */
  function extend ($parent = null)
  {
    if ($parent)
      return $this->_parent = $parent;
    return $this->_parent;
  }

  /**
   * Gets a map of all public properties of the object, including all properties throughout the inheritance chain.
   *
   * @return array A map of string => mixed.
   */
  function getProperties ()
  {
    return array_merge ($this->_parent instanceof InheritanceInterface
      ? $this->_parent->getProperties ()
      : get_object_vars ($this->_parent),
      object_publicProps ($this));
  }

}
