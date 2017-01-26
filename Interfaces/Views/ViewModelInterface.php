<?php

namespace Electro\Interfaces\Views;

use Psr\Http\Message\ServerRequestInterface;

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
interface ViewModelInterface extends \IteratorAggregate, \ArrayAccess, \Serializable, \Countable
{
  /**
   * Handles an HTTP request by setting view model data that dependens on the request's data.
   *
   * @param ServerRequestInterface $request
   * @return void
   */
  function handle (ServerRequestInterface $request);

  /**
   * Merges the provided data with the current view model's data.
   *
   * @param array|self $data
   * @return void
   */
  function set ($data);
}
