<?php

namespace Electro\Interfaces\Logging;

use Psr\Log\LoggerInterface;


/**
 * Allows the creation, storage and retrieval of named logger instances.
 */
interface LoggerRegistryInterface
{
  /**
   * Retrieves a logger instance by name.
   *
   * <p>If no logger is registered with the given name, a {@see NullLogger} is returned.
   *
   * @param string $name The registered logger name.
   * @return LoggerInterface
   */
  function get ($name);

  /**
   * Checks if a logger with the given name is registered.
   *
   * @param string $name The registered logger name.
   * @return bool
   */
  function has ($name);

  /**
   * Creates and registers a new blank logger with a specific name.
   *
   * @param string $name The name to associate with the new logger.
   * @return LoggerInterface $logger The new logger instance.
   */
  function make ($name);

  /**
   * Creates and registers a new channel with the given name, from the application's main logger.
   *
   * <p>The new logger instance will inherit the configuration of the main logger (handlers, processors, etc).
   *
   * @param string $name    The name to associated with the logger.
   * @param bool   $enabled [optional] Set to FALSE to create a disabled logger, which may be enabled at later time.
   * @return LoggerInterface $logger The new logger instance.
   */
  function makeChannel ($name, $enabled = true);

  /**
   * Registers a logger with a specific name.
   *
   * @param string          $name   The name to associated with the logger.
   * @param LoggerInterface $logger The logger instance to be shared.
   * @return $this
   */
  function register ($name, LoggerInterface $logger);

  /**
   * Removes a logger instance by name, if one exists.
   *
   * @param string $name The registered logger name.
   * @return $this
   */
  function unregister ($name);

}
