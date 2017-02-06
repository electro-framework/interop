<?php

namespace Electro\Interop;

/**
 * A registry is a container (or typed map) that holds objects of a specific classe (or its subclasses), allowing
 * access to those instances by name.
 *
 * <p>It is similar to a map or a PHP associative array, but it formalizes access to a specific type of resource.
 * <p>This class not usually used directly; instead it forms the base of specialized classes that override
 * the {@see get} method to type-hint its return type to a specific class or interface.
 * <p>As PHP does not offer generic (parameterized) types, this tries to overcome that limitation and provide static
 * typing
 * and code analysis on IDEs or linters.
 */
class Registry implements \IteratorAggregate, \Countable
{
  private $items = [];

  public function count ()
  {
    return count ($this->items);
  }

  /**
   * Retrieves an item by name.
   *
   * <p>If no item is registered with the given name, an {@see OutOfBoundsException} is thrown.
   *
   * @param string $name The registered item name.
   * @return mixed
   */
  function get ($name)
  {
    if (isset($this->items[$name]))
      return $this->items[$name];
    throw new \OutOfBoundsException (sprintf ("%s is not registered on %s.%sCurrently registered: %s", $name,
      static::class, PHP_EOL, $this->items ? implode (', ', array_keys ($this->items)) : '(empty)'));
  }

  public function getIterator ()
  {
    return new \ArrayIterator($this->items);
  }

  /**
   * Checks if an item with the given name is registered.
   *
   * @param string $name The registered item name.
   * @return bool TRUE if the item is registered.
   */
  function has ($name)
  {
    return isset($this->items[$name]);
  }

  /**
   * Registers one or more items under the specified names.
   *
   * @param string|object[] $nameOrItems The name to associated with the item, or an associative array of names to
   *                                     items.
   * @param object|null     $item        [optional] The item instance or NULL if the first argument is an array.
   * @return $this
   */
  function register ($nameOrItems, $item = null)
  {
    if (is_array ($nameOrItems))
      $this->items = array_merge ($this->items, $nameOrItems);
    else $this->items[$nameOrItems] = $item;
    return $this;
  }

  /**
   * Removes one or more items by name, if they exist.
   *
   * @param string|string[] $nameOrNames The item name, or an indexed array of item names to be shared.
   * @return $this
   */
  function unregister ($nameOrNames)
  {
    if (is_array ($nameOrNames))
      unset ($this->items[$nameOrNames]);
    else foreach ($this->items as $i)
      unset ($this->items[$i]);
    return $this;
  }

}
