<?php
namespace Selenia\Interfaces;

/**
 * A class whose instances inherit properties at runtime from another object.
 *
 * <p>If the parent object also implements {@see InheritanceInterface}, the inheritance chain propagates to that
 * object, and so on.
 */
interface InheritanceInterface
{
  /**
   * Sets the parent object that the instance inherits from.
   *
   * @param object $parent [optional]
   * @return null|object
   */
  function extend ($parent = null);

  /**
   * Gets a map of all public properties of the object, including all properties throughout the inheritance chain.
   * @return array A map of string => mixed.
   */
  function getProperties ();

}
