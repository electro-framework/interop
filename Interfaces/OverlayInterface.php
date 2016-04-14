<?php
namespace Selenia\Interfaces;

/**
 * Allows a class' instances to inherit properties at runtime from another object or from an array.
 *
 * <p>If the parent object also implements {@see OverlayInterface}, the inheritance chain propagates to that
 * object, and so on.
 */
interface OverlayInterface
{
  /**
   * Sets or gets the parent object or array that the instance inherits from.
   *
   * @param object|array $parent [optional]
   * @return object|array
   */
  function extend ($parent = null);

  /**
   * Gets a flat map of all public properties of the object, including all properties throughout the inheritance chain.
   *
   * @return array A map of string => mixed.
   */
  function getAllProperties ();

}
