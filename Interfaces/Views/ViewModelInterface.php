<?php

namespace Electro\Interfaces\Views;

/**
 * A kind of storage similar to an array but for exclusive use as a data source for rendering views.
 *
 * <p>The view model's content *must* be accessed via the array access syntax (i.e. `[]`).
 *
 * <p>View models behave mostly as arrays do, but they are NOT *copy-on-write*, so changes made to an instance are
 * visible to all functions that have a reference to that instance.
 *
 * ><p>You can't use view models with the standard array functions (ex: `array_merge`).
 *
 * <p>Classes that implement this interface are injectable and their constructor should be concerned **only** with
 * saving the dependencies on private properties for later retrieval. Domain logic should be relegated to the
 * {@see init} method.
 *
 */
interface ViewModelInterface extends \IteratorAggregate, \ArrayAccess, \Serializable, \Countable
{
  /**
   * Overriding this method allows a class to provide custom logic to set data on the view model instance.
   *
   * <p>This is meant to be called after the view model is created and some initial data has been copied to it (ex:
   * request data or component properties), which is usually performed by the controller or component that owns the
   * view.
   *
   * ><p>**Note:** you DO NOT need to call `parent::init()`.
   *
   * @return void
   */
  function init ();

  /**
   * Merges the provided data with the current view model's data.
   *
   * @param array|self $data
   * @return $this
   */
  function set ($data);

  /**
   * Returns the view model's data in array format.
   *
   * @return array
   */
  function toArray ();
}
