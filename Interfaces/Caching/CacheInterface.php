<?php
namespace Electro\Interfaces\Caching;

interface CacheInterface
{
  /**
   * Clears all items from the cache.
   *
   * @return void
   */
  function clear ();

  /**
   * Removes stale data from the cache.
   *
   * <p>This may take some time, so it should be called from a separate maintenance task (ex. from a cron job).
   *
   * @return void
   */
  function purge ();

  /**
   * @param string $key
   * @return mixed
   */
  function delete ($key);

  /**
   * @param string         $key
   * @param mixed|callable $value
   * @return mixed
   */
  function get ($key, $value);

  /**
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
   * Stores data under the given key.
   * @param string $key
   * @param mixed  $value
   * @return void
   */
  function set ($key, $value);

  /**
   * Stores data under the given key, only if it does not already exist.
   * @param string $key
   * @param mixed  $value
   * @return void
   */
  function add ($key, $value);

}
