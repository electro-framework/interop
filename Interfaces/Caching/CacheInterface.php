<?php
namespace Electro\Interfaces\Caching;

interface CacheInterface
{
  /**
   * Stores data under the given key, only if it does not already exist.
   *
   * <p>If the given value is a {@see Closure}, it is called with no arguments and its return value will be used as the
   * intended value for the key.
   * > The Closure will only be called if the key is not present on the cache.
   *
   * <p>If the cache systems supports LRU, callid this method, even if the key exists, will bump the item to the from of
   * the LRU queue.
   *
   * @param string         $key
   * @param mixed|\Closure $value A serializable value or a Closure.
   * @return bool TRUE if the item was created, FALSE if it already existed.
   */
  function add ($key, $value);

  /**
   * Clears all items from the cache, or a subset of them if filtering options have been previously set.
   *
   * <p>The available options are determined by the underlying cache driver.
   *
   * @return void
   */
  function clear ();

  /**
   * Removes the cache item with the specified key, if it exists.
   *
   * @param string $key
   * @return bool TRUE if the item was deleted, FALSE if it didn't exist.
   */
  function delete ($key);

  /**
   * Retrieves an entry from the cache referenced by the given key and, if it doesn't exist, creates a new entry with
   * the given value and returns it.
   *
   * <p>If the given value is a {@see Closure}, it is called with no arguments and its return value will be used as the
   * intended value for the key.
   *
   * @param string         $key
   * @param mixed|\Closure $value A serializable value or a Closure.
   * @return mixed The cached value or $value if one doesn't exist.
   *                              Returns NULL if the key doesn't exist and the new value couldn't be saved.
   */
  function get ($key, $value);

  /**
   * Returns the active namespace name.
   *
   * @return string
   */
  function getNamespace ();

  /**
   * Checks if a specific cache item exists without loading it.
   *
   * @param string $key
   * @return mixed
   */
  function has ($key);

  /**
   * Atomically increments/decrements the integer value with the given key by the specified amount.
   *
   * <p>If the current value is not an integer, it will be set to `0` before being incremented.
   *
   * @param string $key
   * @param int    $value
   * @return void
   */
  function inc ($key, $value = 1);

  /**
   * Removes stale data from the cache.
   *
   * <p>This may take some time, so it should be called from a separate maintenance task (ex. from a cron job).
   *
   * ><p>For some cache systems, this will have no effect.
   *
   * @return void
   */
  function prune ();

  /**
   * Stores data under the given key.
   *
   * @param string $key
   * @param mixed  $value
   * @return bool TRUE if the item was successfully persisted; FALSE if there was an error.
   */
  function set ($key, $value);

  /**
   * Sets the namespace under which all subsequent operations will take place.
   *
   * <p>Keys from one namespace will not collide with other keys with the same name on other namespaces.
   *
   * <p>If the cache driver supports tags, clearing cache entries by tag will only affect entries from the active
   * namespace.
   *
   * @param string $name
   * @return void
   */
  function setNamespace ($name);

  /**
   * Similar to {@see with}, but the options will remain set during the current script execution.
   *
   * @param array $options A map of option names to option values.
   * @return $this
   * @see with
   */
  function setOptions (array $options);

  /**
   * Sets options for the next cache operation (read, write or clear).
   *
   * <p>The available options are determined by the underlying cache driver.
   *
   * <p>Options not supported by the driver are ignored.
   *
   * <p>The options will be cleared after the next call, on the same cache instance, of one of these methods:
   *       add, clear, delete, get, inc, purge, set
   *
   * #### Example
   *       $cache->with (['ttl'=> 10, 'tags'=> ['tag1', 'tag2']])->set ('key', $value);
   *
   * @param array $options A map of option names to option values.
   * @return $this The same instance, for chaining.
   */
  function with (array $options);

}
