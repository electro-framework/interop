<?php
namespace Selenia\Interfaces;

/**
 * Allows a class instance to have its fields (either public or not) be mass-assigned or mass-read.
 * > Note: the trait's static methods are absent from the interface. This is by design.
 */
interface AssignableInterface
{
  /**
   * Loads the given data (object or array) into the object, overriding existing values.
   * > Note: this supports setting properties with any kind of visibility.
   *
   * @param array|AssignableInterface $data
   * @return $this For chaining.
   */
  function _assign ($data);

  /**
   * Loads the given data (object or array) into the object, but only for those properties that are not already set on it.
   * > Note: this supports setting properties with any kind of visibility.
   *
   * @param array|AssignableInterface $data
   * @return $this For chaining.
   */
  function _defaults ($data);

  /**
   * Exports all of object's properties, including private and protected ones.
   * @return array
   */
  function _export ();

}
