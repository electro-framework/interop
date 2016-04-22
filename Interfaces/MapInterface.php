<?php
namespace Selenia\Interfaces;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Selenia\Interop\Map;
use Serializable;

interface MapInterface extends IteratorAggregate, ArrayAccess, Serializable, Countable
{

  /**
   * Retrieves the map's content as a reference to an associative array.
   *
   * <p>Using the returned reference, you can both read and write to the internal array of the Map instance.
   *
   * @return array
   */
  public function & asArray ();

  /**
   * Clears the map's content.
   *
   * @return $this For chaining.
   */
  function clear ();

  /**
   * Gets the element associated with the given key.
   *
   * <p>This is an alias of the `[ ]` indexing operator or the `->` property access operator.
   *
   * ><p>**Note:** this method provides compabibility with other interfaces, like for instance, the
   * {@see \Interop\Container\ContainerInterface}.
   *
   * @param string $key
   * @return mixed
   */
  public function get ($key);

  /**
   * Returns `true` if the map can return an entry for the given key, `false` otherwise.
   *
   * <p>This is an alias of the `isset` operator.
   *
   * ><p>**Note:** this method provides compatibility with some other interfaces, like for instance, the
   * {@see \Interop\Container\ContainerInterface}.
   *
   * @param string $key Identifier of the entry to look for.
   * @return boolean
   */
  public function has ($key);

  /**
   * Returns a list of the map's keys.
   *
   * @return string[]
   */
  public function keys ();

  /**
   * Sets data on the map.
   *
   * <p>It merges data into the existing map; existing keys are preserved, unless overwritten.
   *
   * ##### Overloads
   *
   *       $map->set ('key', $value)
   *
   *       $map->set ($data)
   *
   * @param Map|array|\IteratorAggregate|object|string $keyOrData
   * @param mixed                                      $value [optional] Only valid when $keyOrData is a string.
   * @return $this For chaining.
   */
  public function set ($keyOrData, $value = null);

}
