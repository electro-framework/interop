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
   * <p>If the cache systems supports LRU, callid this method, even if the key exists, will bump the item to the from
   * of
   * the LRU queue.
   *
   * @param string         $key
   * @param mixed|\Closure $value A serializable value or a Closure.
   * @return bool TRUE if the item was created, FALSE if it already existed, the saving operation failed or the
   *                              effective value of $value is NULL.
   */
  function add ($key, $value);

  /**
   * Clears all items from the cache's current namespace, or a subset of them if filtering options have been previously
   * set.
   *
   * <p>The available options are determined by the underlying cache driver.
   *
   * @return void
   */
  function clear ();

  /**
   * Retrieves an entry from the cache referenced by the given key and, if it doesn't exist, creates a new entry with
   * the given value and returns it.
   *
   * <p>If the given value is a {@see Closure}, it is called with no arguments and its return value will be used as the
   * intended value for the key.
   *
   * @param string              $key
   * @param mixed|\Closure|null $value A serializable value or a Closure. If NULL, no attempt will be made to cache a
   *                                   value if the key is not on the cache.
   * @return mixed The cached value or the effective value of $value if one doesn't exist.
   *                                   Returns NULL if the key doesn't exist and either the new value couldn't be saved
   *                                   or no value to be cached has been given.
   */
  function get ($key, $value = null);

  /**
   * Returns the active namespace name.
   *
   * @return string If the cache does not support namespaces, this always returns an empty string.
   */
  function getNamespace ();

  /**
   * Gets the item's creation or last modification time.
   *
   * @param string $key
   * @return int|false A Unix timestamp, with second level granularity, or FALSE if the item does not exist.
   */
  function getTimestamp ($key);

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
   * <p>If the current value is not an integer, `inc` will fail.
   *
   * @param string $key
   * @param int    $value
   * @return bool TRUE if the item was successfully incremented; FALSE if either the item does not exist or there was
   *              an error.
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
   * Removes the cache item with the specified key, if it exists.
   *
   * @param string $key
   * @return bool TRUE if the item was removed, FALSE if it didn't exist or an error occurred.
   */
  function remove ($key);

  /**
   * Stores data under the given key.
   *
   * @param string $key
   * @param mixed  $value Unlike {@see add} or {@see get}, Closures are not invoked and, therefore, can't be
   *                      stored.<br>
   *                      If NULL, the value will not be stored.
   * @return bool TRUE if the item was successfully persisted; FALSE if there was an error, $value is a Closure or
   *                      $value is NULL.
   */
  function set ($key, $value);

  /**
   * Sets the namespace under which all subsequent operations will take place.
   *
   * <p>Namespaces are hierarchical. Path segments are delimited by the `/` character.
   *
   * <p>An empty string is a valid namespace; it refers to the root of all namespaces.
   *
   * <p>Keys from one namespace will not collide with other keys with the same name on other namespaces.
   *
   * <p>Clearing the cache will only clear items from the current namespace and from its sub-namespaces.
   *
   * <p>If the cache driver supports tags, clearing cache entries by tag will only affect entries from the active
   * namespace and from its sub-namespaces.
   *
   * @param string $name
   * @return void
   */
  function setNamespace ($name);

  /**
   * Sets configuration options that will remain set during the current script execution.
   *
   * <p>All drivers should (but may not) support, at least, the following options:
   *
   * ###### `serializer: callable`
   * A function for serializing data to a string before saving it; defaults to the `'serialize'` string.
   *
   * ###### `unserializer: callable`
   * A function for unserializing data from a string loaded from the cache; defaults to the `'unserialize'` string.
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
